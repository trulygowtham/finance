<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
//Custom loading
use App\Http\Controllers\MYController;
use App\Http\Requests\CategoryPostRequest;
use App\Model\Category;
use App\Model\Auditlogs;
use Auth;
use DB;
//use Datatables;
use Session;
//For Datatables
use yajra\Datatables\Datatables;

class CategoryController extends MYController {

    public function __construct() {
        $this->is_logged_in();
    }

    public function index() {
        $session_data = Session::all(); 
        $created_by = $session_data['admin_id']; 
        $id = $session_data['user'][0]['id']; 
        $data['users'] = $users = Category::getCatList($created_by,$id);
        $content_page = 'category/index'; // Middle page where content needs to be displayed
        $this->generate_default_view($content_page, $data);
        //return view('category/index', compact('users'));
    }

    public function anyData() {
        $session_data = Session::all(); 
        $created_by = $session_data['admin_id']; 
        $id = $session_data['user'][0]['id']; 
        return Datatables::of(Category::getCatList($created_by,$id))
                        ->addColumn('action', function($query) {
                            $buttons = "";
                            $buttons.="<div class='input-group-btn'>";
                            $buttons.='<a href="' . route("category.edit", base64_encode($query->id)) . '"  ><div class="pull-right btn btnIcon bgYellow btnEdit"> &nbsp; </div></a>';
                            $buttons.=' <a href="' . route("category.view", base64_encode($query->id)) . '"  ><div class="pull-right btn btnIcon bgBlue btnDetails mrzR5"> &nbsp; </div></a>';
                            $buttons.='<a href="' . route("category.delete", base64_encode($query->id)) . '"   onclick="return confirm(' . "'Are you sure to delete this category?'" . ')" >';
                            $buttons.='<div class="pull-right btn btnIcon bgRed btnCancel mrzR5"> &nbsp; </div>  </a>';
                            $buttons.='</div>';
                            return $buttons;
                        })->make(true);
    }

    public function create() {
        $data = array();
        $content_page = 'category/create'; // Middle page where content needs to be displayed
        $this->generate_default_view($content_page, $data);
    }

    public function store(CategoryPostRequest $request) {
        $inputArr = $request->all();
        
        $session_data = Session::all();
        $inputArr['created_by'] = $session_data['user'][0]['id'];
        $inputArr['admin_id'] = $session_data['admin_id'];
        $page = Category::create($inputArr);
        $catName = $inputArr['name'];
        if($page!=''){
             //category tab type  auditlogs added
            $message = "Category #$catName  created successfully!";
            Auditlogs::addAuditlogs($message, $tabtype = '2');
        }
        
        return redirect()->route('category')->with('success-status', "Category #$catName  created successfully!");
    }

    public function edit($id) {
        $data['categories'] = $categories = Category::whereId(base64_decode($id))->first();
        $content_page = 'category/edit'; // Middle page where content needs to be displayed
        $this->generate_default_view($content_page, $data);
        //return view('users/edit', compact('users'));
    }

    public function update(CategoryPostRequest $request, $id) {
        $inputs = $request->except('_token', '_method');
        $page = Category::where('id', base64_decode($id))->update($inputs);
         $catName = $inputs['name'];
        if($page!=''){
             //category tab type  auditlogs added
            $message = "Category #$catName  updated successfully!";
            Auditlogs::addAuditlogs($message, $tabtype = '2');
        }
       
        return redirect()->route('category')->with('success-status', "Category #$catName updated successfully!");
    }

    public function view($id) {
        $data['categories'] = $categories = Category::whereId(base64_decode($id))->first();
        $content_page = 'category/view'; // Middle page where content needs to be displayed
        $this->generate_default_view($content_page, $data);
        //return view('users/edit', compact('users'));
    }

    public function destroy($id) {
        $inputs['record_status'] = 0;
        $page = Category::where('id', base64_decode($id))->update($inputs);
         if($page!=''){
             //category tab type  auditlogs added
            $message = "Category deleted successfully!";
            Auditlogs::addAuditlogs($message, $tabtype = '2');
        }
        return redirect()->route('category')->with('success-status', 'Category deleted successfully!');
    }

    /* public function edit($id)
      {
      $users = Users::whereId($id)->first();
      return view('users/edit', compact('users'));
      }
      public function update(UserPostRequest $request,$id)
      {
      if($request['photo']!=''){
      $imageName = 'user_'.time().'.'.$request['photo']->getClientOriginalExtension();
      $request['photo']->move(public_path('images'), $imageName);
      $inputs = $request->except('_token','_method','photo');
      $inputs['profile_avatar'] = $imageName;
      }else{
      $inputs = $request->except('_token','_method','photo');

      }

      $page = Users::where('id', $id)->update($inputs);
      return redirect()->route('users')->with('status', "User#$id updated successfully!");
      }

      public function create()
      {
      return view('users/create');
      }


      public function store(UserPostRequest $request)
      {
      $page = Users::create($request->all());
      return redirect()->route('user.edit', $page->id)->with('status', "User # $page->id created successfully!");
      }
      public function destroy($id)
      {
      Users::destroy($id);
      return redirect()->route('users')->with('status', 'User deleted successfully!');
      } */
}
