<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests;
//use App\Http\Requests\FormPostRequest;
use App\Model\Form;
use App\Model\api\UserForm;
use App\Model\api\UserFormQuestions;
use App\Model\api\UserFormAnswers;

use App\Model\api\UserFormHistory;
//use App\Model\Category;
use App\Model\Auditlogs;
use App\Users;
use App\Model\Questions;
use App\Model\api\UserFormUsers;
use App\Model\api\UserFormGroups;
use App\Model\LinkFormGroups;
use App\Model\LinkFormUsers;
use App\Model\LinkUserGroups;
use App\Model\Notifications;
use App\Model\NotificationsReceiver;
//use App\Model\Group;
//use App\Model\LinkFormGroups;
//use Auth;
use DB;
use Session;
use \Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class FormController extends Controller {

    public function __construct() {
        // $this->is_logged_in();
    }

    public function getTemplates(Request $request) {
        $validator = Validator::make($request->all(), [
                    'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            $result = array('error' => true, 'list' => array(), 'message' => $validator->messages());
        } else {
            $userFormArr = array();
            $post_data = $request->all();
            $userInfo = LinkFormUsers::select('*')->where(array('user_id' => $post_data['user_id'], 'record_status' => 1))->get();
            if (!EMPTY($userInfo) && count($userInfo) > 0) {
                foreach ($userInfo as $key => $userRow) {
                    $userFormArr[] = $userRow->form_id;
                }
            }
            $groupInfo = LinkFormGroups::join('link_user_groups', 'link_user_groups.group_id', '=', 'link_form_groups.group_id')
                            ->select('link_form_groups.*')->where(array('link_user_groups.user_id' => $post_data['user_id'], 'link_form_groups.record_status' => 1))->get();
            if (!EMPTY($groupInfo) && count($groupInfo) > 0) {
                foreach ($groupInfo as $key => $groupRow) {
                    $userFormArr[] = $groupRow->form_id;
                }
            }

            if (count($userFormArr) > 0) {
                $formInfo = Form::getTemplateInfo($userFormArr);
            } else {
                $formInfo = array();
            }


            $result = array('error' => false, 'list' => $formInfo, 'message' => "Form data successfully fetched.");
        }
        return Response::json($result, 200);
    }

    public function getTemplateInfo(Request $request) {
        $post_data = $request->all();
        $id = isset($post_data['id']) ? $post_data['id'] : 0;
        $data = array();
        if ($id > 0) {
            $form_data = Form::whereId($id)->first();
            if (!EMPTY($form_data) && count($form_data) > 0) {
                $form_data->questions = unserialize($form_data->questions);
                $question_arr = ($form_data->questions);

                $question_ids = array_unique(call_user_func_array('array_merge', $question_arr));
                $question = Questions::getQuestionsByIds($question_ids);
                $data['questions'] = array();
                $data['category'] = array();
                foreach ($question as $iKey => $iVal) {
                    $data['category'][$iVal->category_id] = $iVal->category_name;
                    $data['questions'][$iVal->id] = array();
                    $data['questions'][$iVal->id]['name'] = $iVal->name;
                    $data['questions'][$iVal->id]['options'] = unserialize($iVal->options);
                }
                $data['form_data'] = $form_data;

                $result = array('error' => false, 'list' => $data, 'message' => "Template Info successfully fetched.");
            } else {
                $result = array('error' => true, 'list' => $data, 'message' => "Template id doesn't exist.");
            }
        } else {
            $result = array('error' => true, 'list' => $data, 'message' => "Template id doesn't exist.");
        }
        return Response::json($result, 200);
    }

    public function scanTemplate(Request $request) {
        $post_data = $request->all();
        $template_id = isset($post_data['template_id']) ? $post_data['template_id'] : '';
        $scanned_id = isset($post_data['scanned_id']) ? $post_data['scanned_id'] : '';
        $data = array();
        if ($scanned_id != '' || $template_id != '') {
            $id = 0;
            if ($scanned_id != '') {
                try {
                    $id = Crypt::decrypt($scanned_id);
                } catch (DecryptException $e) {
                    //
                }
            }
            if ($template_id != '') {
                $formInfo = Form::select('*')->where(array('template_id' => $template_id, 'record_status' => 1))->get()->first();

                if (!EMPTY($formInfo) && count($formInfo) > 0) {
                    $id = $formInfo->id;
                }
            }
            if ($id > 0) {
                $userFormArr = array($id);
                $formInfo = Form::getTemplateInfo($userFormArr);
                if (!EMPTY($formInfo) && count($formInfo) > 0) {

                    $result = array('error' => false, 'list' => $formInfo, 'message' => "Template Info successfully fetched.");
                } else {
                    $result = array('error' => true, 'list' => $data, 'message' => "Template id doesn't exist.");
                }
            } else {
                $result = array('error' => true, 'list' => $data, 'message' => "Template id doesn't exist.");
            }
        } else {
            $result = array('error' => true, 'list' => $data, 'message' => "Template id doesn't exist.");
        }
        return Response::json($result, 200);
    }

    public function addUserForm(Request $request) {
        $validator = Validator::make($request->all(), [
                    'date' => 'required',
                    'user_id' => 'required',
                    'form_id' => 'required',
                    'description' => 'required|min:3',
        ]);
        if ($validator->fails()) {
            $result = array('error' => true, 'list' => array(), 'message' => $validator->messages());
        } else {
            $post_data = $request->all();
            $post_data['date'] = str_replace('T', ' ', substr($post_data['date'], 0, -5));

            $form_id = isset($post_data['form_id']) ? $post_data['form_id'] : 0;
            $data = array();
            if ($form_id > 0) {
                $form_data = Form::whereId($form_id)->first();
                if (!EMPTY($form_data) && count($form_data) > 0) {
                    $form_data->questions = unserialize($form_data->questions);
                    $question_arr = ($form_data->questions);

                    $question_ids = array_unique(call_user_func_array('array_merge', $question_arr));
                    $question = Questions::getQuestionsByIds($question_ids);
                    foreach ($question as $iKey => $iVal) {
                        $data[$iVal->category_id]['cat_name'] = $iVal->category_name;
                        $questions = array();
                        $answers = 0;

                        $questions['name'] = $iVal->name;
                        $questions['options'] = unserialize($iVal->options);
                        $questions['answers'] = array();

                        if (count($questions['answers']) > 0) {
                            $answers = 1;
                        }
                        $data[$iVal->category_id]['questions'][$iVal->id] = $questions;
                        $answerdat[$iVal->category_id]['answers'][$iVal->id] = $answers;
                        $data[$iVal->category_id]['percentage'] = (array_sum($answerdat[$iVal->category_id]['answers']) / count($data[$iVal->category_id]['questions'])) * 100;
                        // $data[$iVal->category_id]['answered_qstns'] = array_sum($answerdat[$iVal->category_id]['answers']);
                    }
                    $post_data['form_info'] = serialize($data);
                    $userFormId = UserForm :: addUserForm($post_data);
                    if ($userFormId > 0) {
                        $formInfo = UserForm::getUserFormInfo($userFormId);
                        $form_number = isset($formInfo->form_number) ? $formInfo->form_number : '';
                        $form_name = isset($formInfo->form_name) ? $formInfo->form_name : '';
                        //add notifications 
                        $sessionInfo = Session::all();
                        $created_by = $sessionInfo['user'][0]['id'];
                        $created_name = $sessionInfo['user'][0]['name'];
                        $user_admin = $sessionInfo['user'][0]['created_by'];
                        $created_at = date('Y-m-d H:i:s');
                        $link_arr = array('notification_type_id' => 2, 'notification_text' => "User Form# $form_number ($form_name) created", 'notification_links' => $userFormId, 'created_at' => $created_at, 'created_by' => $created_by, 'created_name' => $created_name);
                        $notifications = Notifications::createNotifications($link_arr);
                        $note_id = isset($notifications->id) ? $notifications->id : 0;
                        if ($note_id > 0) {
                            $link_arr = array('receiver_id' => $user_admin, 'notification_id' => $note_id, 'created_at' => $created_at);
                            NotificationsReceiver::createNotificationsReceiver($link_arr);
                        }
                        //end notifications
                        //login tab type  auditlogs added 
                        $message = "User Form# $form_number added successfully.";
                        Auditlogs::addAuditlogs($message, $tabtype = '7', $user_admin);


                        $formInfo->form_info = ''; //unserialize($formInfo->form_info);
                        $result = array('error' => false, 'list' => $formInfo, 'message' => "Userform added successfully.");
                    } else {
                        $result = array('error' => true, 'list' => array(), 'message' => "Userform adding failed.");
                    }
                } else {
                    $result = array('error' => true, 'list' => $data, 'message' => "Template id doesn't exist.");
                }
            } else {
                $result = array('error' => true, 'list' => $data, 'message' => "Template id doesn't exist.");
            }
        }
        return Response::json($result, 200);
    }

    public function getUserCategoryInfo(Request $request) {
        $validator = Validator::make($request->all(), [
                    'id' => 'required',
        ]);
        if ($validator->fails()) {
            $result = array('error' => true, 'list' => array(), 'message' => $validator->messages());
        } else {
            $post_data = $request->all();


            $userFormId = isset($post_data['id']) ? $post_data['id'] : 0;
            $data = array();
            if ($userFormId > 0) {
                $form_data = UserForm::getUserFormInfo($userFormId);

                if (!EMPTY($form_data) && count($form_data) > 0) {
                    $form_data->form_info = unserialize($form_data->form_info);
                    foreach ($form_data->form_info as $category_id => $catArr) {
                        $data[$category_id]['cat_id'] = $category_id;
                        $data[$category_id]['cat_name'] = $catArr['cat_name'];
                        $questions = array();
                        $answers = 0;
                        /* foreach ($catArr['questions'] as $question_id => $questionRow) {
                          $questions[$question_id]['name'] = $questionRow['name'];
                          $questions[$question_id]['options'] = $questionRow['options'];
                          $questions[$question_id]['answers'] = $questionRow['answers'];

                          if (count($questions[$question_id]['answers']) > 0) {
                          $answers++;
                          }
                          }
                          $data[$category_id]['questions'] = $questions; */
                        $data[$category_id]['percentage'] = $catArr['percentage'];
                    }

                    $form_data->form_info = $data;
                    $result = array('error' => false, 'list' => $form_data, 'message' => "User category form feteched succssfully.");
                } else {
                    $result = array('error' => true, 'list' => $data, 'message' => "Template id doesn't exist.");
                }
            } else {
                $result = array('error' => true, 'list' => $data, 'message' => "Userform id doesn't exist.");
            }
        }
        return Response::json($result, 200);
    }

    public function getUserCatFormInfo(Request $request) {
        $validator = Validator::make($request->all(), [
                    'id' => 'required',
                    'cat_id' => 'required',
        ]);
        if ($validator->fails()) {
            $result = array('error' => true, 'list' => array(), 'message' => $validator->messages());
        } else {
            $post_data = $request->all();


            $userFormId = isset($post_data['id']) ? $post_data['id'] : 0;
            $cat_id = isset($post_data['cat_id']) ? $post_data['cat_id'] : 0;
            $data = array();
            if ($userFormId > 0) {
                $form_data = UserForm::getUserFormInfo($userFormId);
                if (!EMPTY($form_data) && count($form_data) > 0) {
                    $form_data->form_info = unserialize($form_data->form_info);

                    $categoryInfo = isset($form_data->form_info[$cat_id]) ? $form_data->form_info[$cat_id] : array();

                    $category_id = $cat_id;
                    $data[$category_id]['cat_id'] = $category_id;
                    $data[$category_id]['cat_name'] = $categoryInfo['cat_name'];
                    $questions = array();
                    $answers = 0;
                    foreach ($categoryInfo['questions'] as $question_id => $questionRow) {
                        $questions[$question_id]['name'] = $questionRow['name'];
                        $questions[$question_id]['options'] = $questionRow['options'];
                        $questions[$question_id]['answers'] = $questionRow['answers'];
                    }
                    $data[$category_id]['questions'] = $questions;
                    $data[$category_id]['percentage'] = $categoryInfo['percentage'];


                    $form_data->form_info = $data;
                    $result = array('error' => false, 'list' => $form_data, 'message' => "User form feteched succssfully.");
                } else {
                    $result = array('error' => true, 'list' => $data, 'message' => "user form id doesn't exist.");
                }
            } else {
                $result = array('error' => true, 'list' => $data, 'message' => "Userform id doesn't exist.");
            }
        }
        return Response::json($result, 200);
    }

    public function updateUserCatForm(Request $request) {
        $validator = Validator::make($request->all(), [
                    'id' => 'required',
                    'form_info' => 'required',
                    'cat_id' => 'required',
        ]);
        if ($validator->fails()) {
            $result = array('error' => true, 'list' => array(), 'message' => $validator->messages());
        } else {
            $post_data = $request->all();
            $id = isset($post_data['id']) ? $post_data['id'] : 0;
            $cat_id = isset($post_data['cat_id']) ? $post_data['cat_id'] : 0;
            $form_info = isset($post_data['form_info']) ? $post_data['form_info'] : array();
            $data = array();
            $isMandatoryChecked = 1;
            if ($id > 0) {
                if (!EMPTY($form_info) && count($form_info) > 0) {
                    $form_data = UserForm::getUserFormInfo($id);

                    $form_data->form_info = unserialize($form_data->form_info);

                    foreach ($form_data->form_info as $category_id => $catArr) {
                        $data[$category_id]['cat_id'] = $category_id;
                        $data[$category_id]['cat_name'] = $catArr['cat_name'];
                        //print_r($form_info[$cat_id]);die();
                        if ($category_id == $cat_id && isset($form_info[$cat_id]['questions'])) {
                            $questions = array();
                            $answers = 0;
                            foreach ($form_info[$cat_id]['questions'] as $question_id => $questionRow) {
                                $questions[$question_id]['name'] = $questionRow['name'];
                                $questions[$question_id]['options'] = $questionRow['options'];
                                $questions[$question_id]['answers'] = $questionRow['answers'];

                                if (count($questions[$question_id]['answers']) > 0) {
                                    $chkAnsCnt = 0;
                                    if ($questionRow['options']['option_type'] == 'checkbox') {
                                        foreach ($questionRow['answers'] as $anskey => $ansRow) {
                                            if ($ansRow == 'true') {
                                                $chkAnsCnt++;
                                            }
                                        }
                                        if (isset($questionRow['mandatory']) && count($questionRow['mandatory']) > 0) {
                                            foreach ($questionRow['options'] as $optKey => $optRow) {
                                                $isAnswer = isset($questionRow['answers'][$optKey]) ? $questionRow['answers'][$optKey] : '';
                                                $isMandatory = isset($questionRow['mandatory'][$optKey]) ? $questionRow['mandatory'][$optKey] : 0;
                                                if ($isMandatory == 1 && $isAnswer != 'true') {
                                                    $isMandatoryChecked = 0;
                                                }
                                            }
                                        }
                                    } else {
                                        foreach ($questionRow['answers'] as $anskey => $ansRow) {
                                            if ($ansRow != '' && $ansRow != null) {
                                                $chkAnsCnt++;
                                            }
                                        }
                                    }
                                    if ($chkAnsCnt > 0) {
                                        $answers++;
                                    }
                                }
                            }
                            $data[$category_id]['questions'] = $questions;
                            $data[$category_id]['percentage'] = round((($answers / count($questions)) * 100), 1);
                        } else {
                            $questions = array();
                            $answers = 0;
                            foreach ($catArr['questions'] as $question_id => $questionRow) {
                                $questions[$question_id]['name'] = $questionRow['name'];
                                $questions[$question_id]['options'] = $questionRow['options'];
                                $questions[$question_id]['answers'] = $questionRow['answers'];
                            }
                            $data[$category_id]['questions'] = $questions;
                            $data[$category_id]['percentage'] = $catArr['percentage'];
                        }
                    }
                    //check if manadatory option selected or not
                    if ($isMandatoryChecked == 1) {
                        $post_data['form_info'] = serialize($data);
                        $userFormId = UserForm :: updateUserForm($post_data);
                        if ($userFormId > 0) {
                            $post_data['status'] = 1;
                            UserFormHistory :: addUserFormHistory($post_data);
                            //user form tab type  auditlogs added 
                            $form_number = isset($form_data->form_number) ? $form_data->form_number : '';
                            $message = "User Form# $form_number updated successfully.";
                            $sessionInfo = Session::all();
                            $created_by = $sessionInfo['user'][0]['id'];
                            $created_name = $sessionInfo['user'][0]['name'];
                            $user_admin = $sessionInfo['user'][0]['created_by'];
                            Auditlogs::addAuditlogs($message, $tabtype = '7', $user_admin);

                            /* $formInfo = UserForm::getUserFormInfo($userFormId);
                              $formInfo->form_info = unserialize($formInfo->form_info); */
                            $result = array('error' => false, 'list' => array('id' => $id), 'message' => "Userform updated successfully.");
                        } else {
                            $result = array('error' => true, 'list' => array(), 'message' => "Userform updating failed.");
                        }
                    } else {
                        $result = array('error' => true, 'list' => array(), 'message' => "Manadatory options not selected.");
                    }
                } else {
                    $result = array('error' => true, 'list' => $data, 'message' => "User form doesn't exist.");
                }
            } else {
                $result = array('error' => true, 'list' => $data, 'message' => "User form doesn't exist.");
            }
        }
        return Response::json($result, 200);
    }

    public function updateFormStatus(Request $request) {
        $validator = Validator::make($request->all(), [
                    'id' => 'required',
                    'status' => 'required'
        ]);
        if ($validator->fails()) {
            $result = array('error' => true, 'list' => array(), 'message' => $validator->messages());
        } else {
            $post_data = $request->all();
            $id = isset($post_data['id']) ? $post_data['id'] : 0;
            $data = array();
            if ($id > 0) {

                $userFormId = UserForm :: updateUserFormStatus($post_data);
                if ($userFormId > 0) {
                    $form_data = UserForm::getUserFormInfo($userFormId);
                    $status = isset($post_data['status']) ? $post_data['status'] : 0;
                    //completed
                    if($status==2){
                         $form_info = unserialize($form_data->form_info);
                         //created table for reports 
                        $sessionInfo = Session::all(); 
                        foreach ($form_info as $catRow) {
                            $cat_id = $catRow['cat_id'];
                            $cat_name = $catRow['cat_name'];
                            foreach ($catRow['questions'] as $question_id => $questionRow) { 
                                $postArr = array(
                                    'user_form_id' => $userFormId,
                                    'cat_id' => $cat_id,
                                    'cat_name' => $cat_name,
                                    'question_id' => $question_id,
                                    'question_name' => $questionRow['name'],
                                    'option_type' => $questionRow['options']['option_type'],
                                    'no_of_options' => $questionRow['options']['no_of_options'],
                                    'created_at' => date("Y-m-d H:i:s"),
                                    'created_by' => $sessionInfo['user'][0]['id']); 
                                $formQstId = UserFormQuestions ::addFormQuestions($postArr);
                                if(count($questionRow['options']['options'])>0){
                                    foreach ($questionRow['options']['options'] as $optKey => $optRow) {
                                        $answer = (isset($questionRow['answers'][$optKey]) && $questionRow['answers'][$optKey]!='')?$questionRow['answers'][$optKey]:'';
                                        $expected_answer = isset($questionRow['options']['mandatory'][$optKey])?$questionRow['options']['mandatory'][$optKey]:'';
                                        $postArr1 = array(
                                            'user_form_qst_id' => $formQstId,
                                            'options' => $optRow,
                                            'answer' => $answer,
                                            'expected_answer' => $expected_answer, 
                                            'created_at' => date("Y-m-d H:i:s"),
                                            'created_by' => $sessionInfo['user'][0]['id']); 
                                        $formQstId1 = UserFormAnswers ::addFormAnswers($postArr1);
                                    }
                                }

                            }
                        }
                         
                         
                         
                         
                    }
                    
                    //user form tab type  auditlogs added 
                    $form_number = isset($form_data->form_number) ? $form_data->form_number : '';

                    $message = "User Form# $form_number status updated successfully.";
                    $sessionInfo = Session::all();
                    $created_by = $sessionInfo['user'][0]['id'];
                    $created_name = $sessionInfo['user'][0]['name'];
                    $user_admin = $sessionInfo['user'][0]['created_by'];
                    Auditlogs::addAuditlogs($message, $tabtype = '7', $user_admin);
                    $result = array('error' => false, 'list' => array(), 'message' => "Userform status updated successfully.");
                } else {
                    $result = array('error' => true, 'list' => array(), 'message' => "Userform status updating failed.");
                }
            } else {
                $result = array('error' => true, 'list' => $data, 'message' => "User form doesn't exist.");
            }
        }
        return Response::json($result, 200);
    }

    public function updateUserForm(Request $request) {
        $validator = Validator::make($request->all(), [
                    'id' => 'required',
                    'form_info' => 'required',
                    'room_no' => 'required',
        ]);
        if ($validator->fails()) {
            $result = array('error' => true, 'list' => array(), 'message' => $validator->messages());
        } else {
            $post_data = $request->all();
            $id = isset($post_data['id']) ? $post_data['id'] : 0;
            $form_info = isset($post_data['form_info']) ? $post_data['form_info'] : array();
            $data = array();
            if ($id > 0) {
                if (!EMPTY($form_info) && count($form_info) > 0) {
                    /* $form_info = UserForm::getUserFormInfo($id);
                      $form_info->form_info = unserialize($form_info->form_info); */
                    foreach ($form_info as $category_id => $catArr) {
                        $data[$category_id]['cat_name'] = $catArr['cat_name'];
                        $questions = array();
                        $answers = 0;
                        foreach ($catArr['questions'] as $question_id => $questionRow) {
                            $questions[$question_id]['name'] = $questionRow['name'];
                            $questions[$question_id]['options'] = $questionRow['options'];
                            $questions[$question_id]['answers'] = $questionRow['answers'];

                            if (count($questions[$question_id]['answers']) > 0) {
                                $answers++;
                            }
                        }

                        $data[$category_id]['questions'] = $questions;
                        $data[$category_id]['percentage'] = ($answers / count($questions)) * 100;
                    }

                    $post_data['form_info'] = serialize($data);
                    $userFormId = UserForm :: updateUserForm($post_data);
                    if ($userFormId > 0) {
                        UserHistoryForm :: addUserHistoryForm($post_data);
                        $formInfo = UserForm::getUserFormInfo($userFormId);
                        $formInfo->form_info = unserialize($formInfo->form_info);
                        $result = array('error' => false, 'list' => $formInfo, 'message' => "Userform updated successfully.");
                    } else {
                        $result = array('error' => true, 'list' => array(), 'message' => "Userform updating failed.");
                    }
                } else {
                    $result = array('error' => true, 'list' => $data, 'message' => "User form doesn't exist.");
                }
            } else {
                $result = array('error' => true, 'list' => $data, 'message' => "User form doesn't exist.");
            }
        }
        return Response::json($result, 200);
    }

    //function to get user info
    public function getUserFormInfo(Request $request) {
        $validator = Validator::make($request->all(), [
                    'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            $result = array('error' => true, 'list' => array(), 'message' => $validator->messages());
        } else {
            $post_data = $request->all();


            $user_id = isset($post_data['user_id']) ? $post_data['user_id'] : 0;
            $data = array();
            if ($user_id > 0) {
                $userFormArr = array();
                $userInfo = UserFormUsers::select('*')->where(array('user_id' => $post_data['user_id'], 'record_status' => 1))->get();
                if (!EMPTY($userInfo) && count($userInfo) > 0) {
                    foreach ($userInfo as $key => $userRow) {
                        $userFormArr[] = $userRow->user_form_id;
                    }
                }
                $groupInfo = UserFormGroups::join('link_user_groups', 'link_user_groups.group_id', '=', 'user_form_groups.group_id')
                                ->select('user_form_groups.*')->where(array('link_user_groups.user_id' => $post_data['user_id'], 'user_form_groups.record_status' => 1))->get();
                if (!EMPTY($groupInfo) && count($groupInfo) > 0) {
                    foreach ($groupInfo as $key => $groupRow) {
                        $userFormArr[] = $groupRow->user_form_id;
                    }
                }
                //DB::enableQueryLog();
                $form_data = UserForm::getUserFormLists($user_id, $userFormArr);
                //$query = DB::getQueryLog(); 
                // print_r($query);die();
                if (!EMPTY($form_data) && count($form_data) > 0) {

                    $result = array('error' => false, 'list' => $form_data, 'message' => "User form feteched succssfully.");
                } else {
                    $result = array('error' => true, 'list' => $data, 'message' => "user forms doesn't exist.");
                }
            } else {
                $result = array('error' => true, 'list' => $data, 'message' => "User id doesn't exist.");
            }
        }
        return Response::json($result, 200);
    }

    //function to get user count
    public function getUserFormCount(Request $request) {
        $validator = Validator::make($request->all(), [
                    'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            $result = array('error' => true, 'list' => array(), 'message' => $validator->messages());
        } else {
            $post_data = $request->all();


            $user_id = isset($post_data['user_id']) ? $post_data['user_id'] : 0;
            $data = array();
            if ($user_id > 0) {
                $form_data = UserForm::getUserFormList($user_id);
                if (!EMPTY($form_data) && count($form_data) > 0) {

                    $pendingCnt = 0;
                    $completedCnt = 0;
                    $cancelledCnt = 0;
                    foreach ($form_data as $key => $formRow) {
                        if ($formRow['status'] == 1) {
                            $pendingCnt++;
                        }
                        if ($formRow['status'] == 2) {
                            $completedCnt++;
                        }
                        if ($formRow['status'] == 3) {
                            $cancelledCnt++;
                        }
                    }
                    $formCntArr = array('1' => $pendingCnt, '2' => $completedCnt, '3' => $cancelledCnt);
                    $result = array('error' => false, 'list' => $formCntArr, 'message' => "User form count feteched succssfully.");
                } else {
                    $result = array('error' => true, 'list' => $data, 'message' => "user forms doesn't exist.");
                }
            } else {
                $result = array('error' => true, 'list' => $data, 'message' => "User id doesn't exist.");
            }
        }
        return Response::json($result, 200);
    }

    public function assignUserForm(Request $request) {
        $validator = Validator::make($request->all(), [
                    'user_form_id' => 'required'
        ]);
        if ($validator->fails()) {
            $result = array('error' => true, 'list' => array(), 'message' => $validator->messages());
        } else {
            $post_data = $request->all();
            $id = isset($post_data['user_form_id']) ? $post_data['user_form_id'] : 0;
            $users = isset($post_data['users']) ? $post_data['users'] : array();
            $groups = isset($post_data['groups']) ? $post_data['groups'] : array();
            $data = array();
            if (count($users) > 0 || count($groups) > 0) {

                if (count($users) > 0) {
                    $form_user_id = UserFormUsers :: assignFormUsers($post_data);
                    if ($form_user_id) {
                        $form_data = UserForm::getUserFormInfo($id);
                        //user form tab type  auditlogs added 
                        $form_number = isset($form_data->form_number) ? $form_data->form_number : '';
                        $form_name = isset($form_data->form_name) ? $form_data->form_name : '';
                        //add notifications 
                        $sessionInfo = Session::all();
                        $created_by = $sessionInfo['user'][0]['id'];
                        $created_name = $sessionInfo['user'][0]['name'];
                        $user_admin = $sessionInfo['user'][0]['created_by'];
                        $created_at = date('Y-m-d H:i:s');
                        $link_arr = array('notification_type_id' => 2, 'notification_text' => "User Form# $form_number ($form_name) assigned to you", 'notification_links' => $id, 'created_at' => $created_at, 'created_by' => $created_by, 'created_name' => $created_name);
                        $notifications = Notifications::createNotifications($link_arr);
                        $note_id = isset($notifications->id) ? $notifications->id : 0;

                        foreach ($users as $user_id) {
                            if ($note_id > 0) {
                                $link_arr = array('receiver_id' => $user_id, 'notification_id' => $note_id, 'created_at' => $created_at);
                                NotificationsReceiver::createNotificationsReceiver($link_arr);
                            }
                        }
                        //end notifications
                        $message = "User Form# $form_number assigned to users successfully.";

                        Auditlogs::addAuditlogs($message, $tabtype = '7', $user_admin);
                        $result = array('error' => false, 'list' => array('id' => $form_user_id), 'message' => "Form assigned to user successfully.");
                    } else {
                        $result = array('error' => true, 'list' => $data, 'message' => "Form assigning failed.");
                    }
                }
                if (count($groups) > 0) {
                    $form_group_id = UserFormGroups :: assignFormGroups($post_data);
                    if ($form_group_id) {
                        $form_data = UserForm::getUserFormInfo($id);
                        //user form tab type  auditlogs added 
                        $form_number = isset($form_data->form_number) ? $form_data->form_number : '';
                        $form_name = isset($form_data->form_name) ? $form_data->form_name : '';
                        //add notifications 
                        $sessionInfo = Session::all();
                        $created_by = $sessionInfo['user'][0]['id'];
                        $created_name = $sessionInfo['user'][0]['name'];
                        $user_admin = $sessionInfo['user'][0]['created_by'];
                        $created_at = date('Y-m-d H:i:s');
                        $link_arr = array('notification_type_id' => 2, 'notification_text' => "User Form# $form_number ($form_name) assigned to your group", 'notification_links' => $id, 'created_at' => $created_at, 'created_by' => $created_by, 'created_name' => $created_name);
                        $notifications = Notifications::createNotifications($link_arr);
                        $note_id = isset($notifications->id) ? $notifications->id : 0;
                        $groupArr = array();
                        foreach ($groups as $group_id) {
                            $groupArr[] = $group_id;
                        }
                        if (count($groupArr) > 0 && $note_id > 0) {
                            $user_groups = LinkUserGroups::select('user_id')->whereIn('group_id', $groupArr)->groupBy('user_id')->get();
                            foreach ($user_groups as $grpkey => $grpRow) {

                                $link_arr = array('receiver_id' => $grpRow->user_id, 'notification_id' => $note_id, 'created_at' => $created_at);
                                NotificationsReceiver::createNotificationsReceiver($link_arr);
                            }
                        }
                        //end notifications

                        $message = "User Form# $form_number assigned to groups successfully.";
                        $sessionInfo = Session::all();
                        $created_by = $sessionInfo['user'][0]['id'];
                        $created_name = $sessionInfo['user'][0]['name'];
                        $user_admin = $sessionInfo['user'][0]['created_by'];
                        Auditlogs::addAuditlogs($message, $tabtype = '7', $user_admin);
                        $result = array('error' => false, 'list' => array('id' => $form_group_id), 'message' => "Form assigned to group successfully.");
                    } else {
                        $result = array('error' => true, 'list' => $data, 'message' => "Form assigning failed.");
                    }
                }
            } else {
                $result = array('error' => true, 'list' => $data, 'message' => "User/Group  doesn't exist.");
            }
        }
        return Response::json($result, 200);
    }

    public function acceptUserForm(Request $request) {
        $validator = Validator::make($request->all(), [
                    'user_form_id' => 'required',
                    'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            $result = array('error' => true, 'list' => array(), 'message' => $validator->messages());
        } else {
            $post_data = $request->all();
            $id = isset($post_data['user_form_id']) ? $post_data['user_form_id'] : 0;
            $user_id = isset($post_data['user_id']) ? $post_data['user_id'] : 0;
            $data = array();
            if ($id > 0) {
                $form_data = UserForm::getUserFormInfo($id);
                if (!EMPTY($form_data) && count($form_data) > 0) {
                    if ($form_data->accepted_user == 0) {
                        //update assigned user in user forms
                        $logdata = array(
                            'accepted_user' => ($post_data['user_id']),
                            'updated_at' => date('Y-m-d H:i:s'));

                        $userFormId = $post_data['user_form_id'];
                        $isUpdated = UserForm::where('id', $userFormId)->update($logdata);
                        if ($isUpdated) {
                            //update users and group assigned forms
                            $logdata = array(
                                'record_status' => 0,
                                'updated_at' => date('Y-m-d H:i:s'));

                            $userFormId = $post_data['user_form_id'];
                            $isUpdated = UserFormGroups::where(array('user_form_id' => $userFormId, 'record_status' => 1))->update($logdata);
                            $isUpdated = UserFormUsers::where(array('user_form_id' => $userFormId, 'record_status' => 1))->update($logdata);
                            $form_data = UserForm::getUserFormInfo($id);
                            //user form tab type  auditlogs added 
                            $form_number = isset($form_data->form_number) ? $form_data->form_number : '';
                            $form_name = isset($form_data->form_name) ? $form_data->form_name : '';
                            $form_owner_id = isset($form_data->user_id) ? $form_data->user_id : 0;
                            //add notifications 
                            $sessionInfo = Session::all();
                            $created_by = $sessionInfo['user'][0]['id'];
                            $created_name = $sessionInfo['user'][0]['name'];
                            $user_admin = $sessionInfo['user'][0]['created_by'];
                            $created_at = date('Y-m-d H:i:s');
                            $link_arr = array('notification_type_id' => 2, 'notification_text' => "User Form# $form_number ($form_name) has been accepted", 'notification_links' => $userFormId, 'created_at' => $created_at, 'created_by' => $created_by, 'created_name' => $created_name);
                            $notifications = Notifications::createNotifications($link_arr);
                            $note_id = isset($notifications->id) ? $notifications->id : 0;

                            if ($note_id > 0) {
                                $link_arr = array('receiver_id' => $form_owner_id, 'notification_id' => $note_id, 'created_at' => $created_at);
                                NotificationsReceiver::createNotificationsReceiver($link_arr);
                            }

                            //end notifications

                            $user_name = '';
                            $userInfo = users::select('users.*')->where(array('id' => $post_data['user_id']))->get()->first();
                            if (!EMPTY($userInfo) && count($userInfo) > 0) {
                                $user_name = $userInfo->name . ' ' . $userInfo->last_name;
                            }
                            $message = "User Form# $form_number accepted by user# $user_name.";
                            $sessionInfo = Session::all();
                            $created_by = $sessionInfo['user'][0]['id'];
                            $created_name = $sessionInfo['user'][0]['name'];
                            $user_admin = $sessionInfo['user'][0]['created_by'];
                            Auditlogs::addAuditlogs($message, $tabtype = '7', $user_admin);

                            //add to history
                            $post_data['id'] = $id;
                            $post_data['status'] = 2;
                            $post_data['form_info'] = serialize(array('user_id' => $post_data['user_id'], 'status' => 'Accepted'));
                            UserFormHistory :: addUserFormHistory($post_data);
                        }

                        $result = array('error' => false, 'list' => array('id' => $userFormId), 'message' => "Form accepted by user successfully.");
                    } else {
                        $user_name = '';
                        $userInfo = users::select('users.*')->where(array('id' => $form_data->accepted_user))->get()->first();
                        if (!EMPTY($userInfo) && count($userInfo) > 0) {
                            $user_name = $userInfo->name . ' ' . $userInfo->last_name;
                        }
                        $result = array('error' => true, 'list' => $data, 'message' => "User form already accepted by $user_name .");
                    }
                } else {
                    $result = array('error' => true, 'list' => $data, 'message' => "User form doesn't exist.");
                }
            } else {
                $result = array('error' => true, 'list' => $data, 'message' => "User  doesn't exist.");
            }
        }
        return Response::json($result, 200);
    }

    public function returnUserForm(Request $request) {
        $validator = Validator::make($request->all(), [
                    'user_form_id' => 'required',
                    'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            $result = array('error' => true, 'list' => array(), 'message' => $validator->messages());
        } else {
            $post_data = $request->all();
            $id = isset($post_data['user_form_id']) ? $post_data['user_form_id'] : 0;
            $user_id = isset($post_data['user_id']) ? $post_data['user_id'] : 0;
            $data = array();
            if ($id > 0) {
                $form_data = UserForm::getUserFormInfo($id);
                if (!EMPTY($form_data) && count($form_data) > 0) {
                    if ($form_data->accepted_user > 0) {
                        //update assigned user in user forms
                        $logdata = array(
                            'accepted_user' => 0,
                            'updated_at' => date('Y-m-d H:i:s'));

                        $userFormId = $post_data['user_form_id'];
                        $isUpdated = UserForm::where('id', $userFormId)->update($logdata);
                        if ($isUpdated) {
                            //update users and group assigned forms
                            $logdata = array(
                                'record_status' => 0,
                                'updated_at' => date('Y-m-d H:i:s'));

                            $userFormId = $post_data['user_form_id'];
                            $isUpdated = UserFormGroups::where(array('user_form_id' => $userFormId, 'record_status' => 1))->update($logdata);
                            $isUpdated = UserFormUsers::where(array('user_form_id' => $userFormId, 'record_status' => 1))->update($logdata);
                            $form_data = UserForm::getUserFormInfo($id);
                            //user form tab type  auditlogs added 
                            $form_number = isset($form_data->form_number) ? $form_data->form_number : '';
                            $form_name = isset($form_data->form_name) ? $form_data->form_name : '';
                            $form_owner_id = isset($form_data->user_id) ? $form_data->user_id : 0;
                            //add notifications 
                            $sessionInfo = Session::all();
                            $created_by = $sessionInfo['user'][0]['id'];
                            $created_name = $sessionInfo['user'][0]['name'];
                            $user_admin = $sessionInfo['user'][0]['created_by'];
                            $created_at = date('Y-m-d H:i:s');
                            $link_arr = array('notification_type_id' => 2, 'notification_text' => "User Form# $form_number ($form_name) has been returned", 'notification_links' => $userFormId, 'created_at' => $created_at, 'created_by' => $created_by, 'created_name' => $created_name);
                            $notifications = Notifications::createNotifications($link_arr);
                            $note_id = isset($notifications->id) ? $notifications->id : 0;

                            if ($note_id > 0) {
                                $link_arr = array('receiver_id' => $form_owner_id, 'notification_id' => $note_id, 'created_at' => $created_at);
                                NotificationsReceiver::createNotificationsReceiver($link_arr);
                            }

                            //end notifications

                            $user_name = '';
                            $userInfo = users::select('users.*')->where(array('id' => $post_data['user_id']))->get()->first();
                            if (!EMPTY($userInfo) && count($userInfo) > 0) {
                                $user_name = $userInfo->name . ' ' . $userInfo->last_name;
                            }
                            $message = "User Form# $form_number return to user# $user_name.";
                            $sessionInfo = Session::all();
                            $created_by = $sessionInfo['user'][0]['id'];
                            $created_name = $sessionInfo['user'][0]['name'];
                            $user_admin = $sessionInfo['user'][0]['created_by'];
                            Auditlogs::addAuditlogs($message, $tabtype = '7', $user_admin);

                            //add to history
                            $post_data['id'] = $id;
                            $post_data['status'] = 2;
                            $post_data['form_info'] = serialize(array('user_id' => $post_data['user_id'], 'status' => 'Accepted'));
                            UserFormHistory :: addUserFormHistory($post_data);
                        }

                        $result = array('error' => false, 'list' => array('id' => $userFormId), 'message' => "Form returned to owner successfully.");
                    } else {

                        $result = array('error' => true, 'list' => $data, 'message' => "Accepted user doesn't exist .");
                    }
                } else {
                    $result = array('error' => true, 'list' => $data, 'message' => "User form doesn't exist.");
                }
            } else {
                $result = array('error' => true, 'list' => $data, 'message' => "User  doesn't exist.");
            }
        }
        return Response::json($result, 200);
    }

}
