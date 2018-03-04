<?php
    // Return true or false, if false return error msg
    function validate_username($userName, & $errorMsgUser){
        $pattern = '/^[a-z|A-Z|0-9]{1,15}$/i'; // Username pattern
        if(preg_match($pattern, $userName)!== 1){
            $isValid = false;
            $errorMsgUser = '<p class="text-warning">
            <strong>Username: </strong>Please enter 1-15 [alphanumeric,-,_] characters</p>';

        }
        else{
            $isValid = true;
        }
        return $isValid;
    }

    function validate_password($password, & $errorMsgPass){
        $pattern = '/^[a-z0-9\-\_\$\#\!\%\&]{1,20}$/'; // Password pattern
        if(preg_match($pattern, $password)!== 1){
            $isValid = false;
            $errorMsgPass = '<p class="text-warning">
            <strong>Password: </strong>Please enter 1-20 [alphanumeric,-,_,$,#,!,%,&] characters</p>';
        }
        else{
            $isValid = true;
        }
        return $isValid;
    }

    function validate_email($email, & $errorMsgEmail){
        $pattern = '/^[a-z0-9\_\.]{1,15}@[a-z0-9\_\.]{1,15}$/i'; // Email pattern
        if(preg_match($pattern, $email)!== 1){
            $isValid = false;
            $errorMsgEmail = '<p class="text-warning">
            <strong>Email: </strong>Please enter 3-31 [alphanumeric,.,@] characters</p>';
        }
        else{
            $isValid = true;
        }
        return $isValid;
    }
?>
