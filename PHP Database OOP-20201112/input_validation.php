<?php

class validation
{
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }


    function input_validation($input,$reg_msg, $empty_msg, $error_msg){
        if (empty($input)) {
            $ErrMSG = $empty_msg;
            $flag=false;
            return array($ErrMSG,$flag);
        } else if (!preg_match($reg_msg,$input)) {
            // check if name only contains letters and whitespace
            $ErrMSG = $error_msg;
            $flag=false;
            return array($ErrMSG,$flag);
        }
        else {
            $ErrMSG ='';
            $flag=true;
        }
        return array($ErrMSG,$flag);
    }

    function filter_validation($input,$filter_msg, $empty_msg, $error_msg){
        if (empty($input)) {
            $ErrMSG = $empty_msg;
            $flag=false;
            return array($ErrMSG,$flag);
        } else if (!filter_var($filter_msg,$input)) {
            // check if name only contains letters and whitespace
            $ErrMSG = $error_msg;
            $flag=false;
            return array($ErrMSG,$flag);
        }
        else {
            $ErrMSG ='';
            $flag=true;
        }
        return array($ErrMSG,$flag);
    }

    function selection_validation($input,$empty_msg){

        if(empty($input)){
             $ErrMSG = $empty_msg;
             $flag=false;
             return array($ErrMSG,$flag);
        }
        else {
             $ErrMSG ='';
             $flag=true;
            }
        return array($ErrMSG,$flag);

    }


}