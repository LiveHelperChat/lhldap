<?php

$Module = array( "name" => "LDAP Integration",
    'variable_params' => true );

$ViewList = array();

$ViewList['searchusername'] = array(
    'params' => array(),
    'functions' => array('setup'),
);

$ViewList['verifysettings'] = array(
    'params' => array(),
    'functions' => array('setup'),
);

$ViewList['settings'] = array(
    'params' => array(),
    'functions' => array('settings'),
);

$FunctionList['setup'] = array('explain' => 'Allow operator to setup LDAP for an operator');
$FunctionList['settings'] = array('explain' => 'LDAP Settings');
