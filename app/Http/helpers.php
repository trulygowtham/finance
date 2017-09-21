<?php

//function to change the date format
function dateFormat($date, $format = 1) {
    if ($date == "") {
        return $date;
    } else {
        //EST Time Format
        if ($format == 1) {
            $changed_date = date('M d, Y', strtotime($date));
        } else {
            $changed_date = date('Y-m-d', strtotime($date));
        }
        return $changed_date;
    }
}

//function to change the date time format
function dateTimeFormat($date, $format = 1) {
    if ($date == "") {
        return $date;
    } else {
        //EST Time Format
        if ($format == 1) {
            $changed_date = date('M d, Y h:i A', strtotime($date));
        } else {
            $changed_date = date('Y-m-d H:i:s', strtotime($date));
        }
        return $changed_date;
    }
}

//function to change the date time format
function dateDbFormat($date) {
    if ($date == "") {
        return $date;
    } else {
        //DB Time Format Y-m-d
        $changed_date = date('Y-m-d', strtotime($date));
         
        return $changed_date;
    }
}
/**
 * Date time helper functions
 *
 * @author Phani 28/12/2016
 * @copyright Pycube
 *
 */
function current_date_time() {
    return date('Y-m-d H:i:s');
}
