<?php

session_write_close();

$tpl = erLhcoreClassTemplate::getInstance('lhldap/settings.tpl.php');

$ldapOptions = erLhcoreClassModelChatConfig::fetch('ldap_options');
$data = (array)$ldapOptions->data;

if ( isset($_POST['StoreOptions']) ) {

    $definition = array(
        'ldap_server' => new ezcInputFormDefinitionElement(
            ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
        ),
        'ldap_base_dn' => new ezcInputFormDefinitionElement(
            ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
        ),
        'ldap_login' => new ezcInputFormDefinitionElement(
            ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
        ),
        'ldap_password' => new ezcInputFormDefinitionElement(
            ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
        ),
        'ldap_bind_dn' => new ezcInputFormDefinitionElement(
            ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
        ),
        'ldap_uid_attr' => new ezcInputFormDefinitionElement(
            ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
        ),
    );

    $form = new ezcInputForm( INPUT_POST, $definition );
    $Errors = array();

    if ( $form->hasValidData( 'ldap_server' )) {
        $data['ldap_server'] = $form->ldap_server ;
    } else {
        $data['ldap_server'] = '';
    }

    if ( $form->hasValidData( 'ldap_base_dn' )) {
        $data['ldap_base_dn'] = $form->ldap_base_dn ;
    } else {
        $data['ldap_base_dn'] = '';
    }

    if ( $form->hasValidData( 'ldap_login' )) {
        $data['ldap_login'] = $form->ldap_login ;
    } else {
        $data['ldap_login'] = '';
    }

    if ( $form->hasValidData( 'ldap_password' ) && $form->ldap_password != '') {
        $data['ldap_password'] = $form->ldap_password ;
    }

    if ( $form->hasValidData( 'ldap_bind_dn' )) {
        $data['ldap_bind_dn'] = $form->ldap_bind_dn ;
    } else {
        $data['ldap_bind_dn'] = '';
    }

    if ( $form->hasValidData( 'ldap_uid_attr' )) {
        $data['ldap_uid_attr'] = $form->ldap_uid_attr ;
    } else {
        $data['ldap_uid_attr'] = '';
    }

    $ldapOptions->explain = '';
    $ldapOptions->type = 0;
    $ldapOptions->hidden = 1;
    $ldapOptions->identifier = 'ldap_options';
    $ldapOptions->value = serialize($data);
    $ldapOptions->saveThis();

    $tpl->set('updated','done');
}

if (isset($_POST['TestLDAP'])) {
    try {
        $userInfo = \LiveHelperChatExtension\lhldap\providers\LHLDAPApi::searchUsername($_POST['ldap_test_username']);
        $tpl->set('user_info',$userInfo);
    } catch (Exception $e) {
        $tpl->set('error',$e->getMessage());
    }
}

$tpl->set('ldap_options',$data);

$Result['content'] = $tpl->fetch();

$Result['path'] = array(
    array(
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('lhldap/module', 'LDAP Options')
    )
);

?>