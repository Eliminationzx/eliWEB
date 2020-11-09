<?php
require(__DIR__ . '/src/XF.php');

$oauth_token = 'aaec6efb54a957492a1812051da7a6f5';

if (!isset($_POST['oauth_token']) or !isset($_POST['action'])) {
	echo 'Internal error';
	die;
}

if (empty($_POST['oauth_token']) or empty($_POST['action'])) {   
	echo 'Internal error';
	die;
}

if($_POST['oauth_token'] != $oauth_token) {
	echo 'Invalid token';
	die;
}

if ($_POST['action'] == 'register') {
    XF::start(__DIR__);
    $app = XF::app();
    
    $input = array(
        'username' => $_POST['user'],
        'email' => $_POST['email'],
        'password' =>  $_POST['pass'],
        'timezone' => '',
        'location' => '',
        'dob_day' => 0,
        'dob_month' => 0,
        'dob_year' => 0,
        'custom_fields' => NULL,
        'email_choice' => 0,        
    );
    
    $registration = XF::service('XF:User\Registration');
    $registration->setFromInput($input);
    $registration->checkForSpam();

    if (!$registration->validate($errors))
    {
        echo 'something wrong...';
        die;
    }
    
    $user = $registration->save();
    echo 'Success';   
} else {
    echo 'Invalid action';
	die;
}
