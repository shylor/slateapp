<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//////////////////////////////////////////////////////
// Project Name
//
// This will be used around the site such as email.
//////////////////////////////////////////////////////
$config['project_name'] = 'Slate Project';

/////////////////////////////////////////////////////
// Email Settings
//
// These will be used when sending out emails, such as
// email activations, and password resets.
////////////////////////////////////////////////////
$config['email_address'] = 'admin@slate.com';
$config['email_name']    = 'Slate Admin';
$config['email_team']    = 'The Slate Team';

//////////////////////////////////////////////////////
// Password Codes
// 
// DO NOT GIVE THESE OUT!
// Passwords are salted with these codes. If you change
// them after you have started taking passwords. Users
// will have to reset their password. It is best to make
// these long. Do not use the default codes as it will
// make it easier for someone to build a rainbow table.
/////////////////////////////////////////////////////
$config['password_code_1'] = 'Wfmdq2Sps7MRjUcn';
$config['password_code_2'] = '82apVq8PgN3g9TSq';
$config['password_code_3'] = 'qhpAVwx662YBhczC';
$config['password_code_4'] = '5RQM3gDPUguVyh6n';

/////////////////////////////////////////////////////
// Login Redirect
//
// This is where the user will go after they have
// logged in successfully.
/////////////////////////////////////////////////////
$config['login_redirect'] = '/dashboard';