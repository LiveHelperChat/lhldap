<?php

class erLhcoreClassExtensionLhldap
{

    public function __construct()
    {
        $dispatcher = erLhcoreClassChatEventDispatcher::getInstance();

        $dispatcher->listen('user.third_party_login', array(
            $this,
            'loginLDAP'
        ));
    }

    public function loginLDAP($params)
    {
        $user = erLhcoreClassModelUser::findOne(array(
            'filterlor' => array(
                'username' => array($params['username']),
                'email' => array($params['username'])
            )
        ));

        if (!($user instanceof erLhcoreClassModelUser) || erLhcoreClassModelUserSetting::getSetting('ldap_use','0',$user->id,true,true) == 0) {
            return;
        }

        try {
            // If this calls succeeds, we can login user
            \LiveHelperChatExtension\lhldap\providers\LHLDAPApi::searchUsername(erLhcoreClassModelUserSetting::getSetting('ldap_user','',$user->id,true,true), $params['password']);

            // Logged using third party login provider
            $params['is_third_party_login'] = true;

            // Login user
            erLhcoreClassUser::instance()->setLoggedUser($user->id);

        } catch (Exception $e) {
            $params['error'] = $e->getMessage();
        }
    }

    public function run()
    {

    }

    private $configData = false;

    private $instanceManual = false;
}


