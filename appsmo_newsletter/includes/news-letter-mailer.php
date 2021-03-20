<?php

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $recipient = $_POST['recipient'];
    $subject = $_POST['subject'];

    //validate
    $validate = validateInput($name, $email);
    if($validate){
          //send response    
        http_response_code(400);
        echo  'Please enter '.$validate;
        exit;
    }

    //send mail
    $mail = sendMailToSubscriber($name,$email, $recipient, $subject);
    echo $mail;

}else{
    http_response_code(403);
    echo "Wrong request method";
}

/**
 * Validates name and email
 *
 * @param [type] $name
 * @param [type] $email
 * @return string
 */
function validateInput($name, $email){
    
        //validation
        if($name == ""){           
            return 'name';
        }
    
        if($email == ""){
            return 'email';          
        }

}

/**
 * sends email to subsciber
 *
 * @param [type] $name
 * @param [type] $email
 * @param [type] $recipient
 * @param [type] $subject
 * @return void
 */
function sendMailToSubscriber($name,$email, $recipient, $subject){
    $message = "Name: $name\n";
    $message .= "Email: $email\n\n";

    //build Headers
    $headers = "From: $name <$email>";

    if(mail($recipient, $subject, $message, $headers)){
        http_response_code(200); 
        return "You are now subscribed";
    }else{
        http_response_code(500);
        return "An error occurred";
    }

}