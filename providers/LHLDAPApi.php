<?php

namespace LiveHelperChatExtension\lhldap\providers;

class LHLDAPApi {

    private static $connection  = null;

    public static function getConnection()
    {
        if (self::$connection !== null) {
            return self::$connection;
        }

        self::connectLDAP();

        return self::$connection;
    }

    public static function connectLDAP()
    {
        $ldap_options = \erLhcoreClassModelChatConfig::fetch('ldap_options')->data;

        if ( !isset( $ldap_options ) || !isset( $ldap_options["ldap_server"] ) ){
            throw new \Exception(\erTranslationClassLhTranslation::getInstance()->getTranslation('lhldap/module', 'LDAP Server not set!'));
        }

        self::$connection = ldap_connect( $ldap_options["ldap_server"] ) or (throw new \Exception(\erTranslationClassLhTranslation::getInstance()->getTranslation('lhldap/module', 'Could not connect to server!')));

        ldap_set_option( self::$connection, LDAP_OPT_PROTOCOL_VERSION, 3 ) ;
        ldap_set_option( self::$connection, LDAP_OPT_REFERRALS, 0 );

        $binddn = isset( $ldap_options["ldap_bind_dn"] ) ? $ldap_options["ldap_bind_dn"] : "uid={login},ou=Users,{base_dn}" ;
        $binddn = str_replace(['{login}','{base_dn}'], [$ldap_options["ldap_login"], $ldap_options["ldap_base_dn"]], $binddn);

        @ldap_bind( self::$connection, $binddn, $ldap_options["ldap_password"]) or (throw new \Exception(\erTranslationClassLhTranslation::getInstance()->getTranslation('lhldap/module', 'Invalid main LDAP password or username')));
    }

    public static function searchUsername($login, $password = null)
    {
        $ldap_options = \erLhcoreClassModelChatConfig::fetch('ldap_options')->data;

        $uid = isset( $ldap_options["ldap_uid_attr"] ) ? $ldap_options["ldap_uid_attr"] : "uid" ;

        $result = ldap_search( self::getConnection(), $ldap_options["ldap_base_dn"], $uid."=".$login ) or self::getError(\erTranslationClassLhTranslation::getInstance()->getTranslation('lhldap/module', 'Invalid username or password!'));
        $userinfo = ldap_get_entries( self::getConnection(), $result ) or self::getError(\erTranslationClassLhTranslation::getInstance()->getTranslation('lhldap/module', 'Invalid username or password!'));
        $found = ldap_count_entries( self::getConnection(), $result ) or self::getError(\erTranslationClassLhTranslation::getInstance()->getTranslation('lhldap/module', 'Invalid username or password!'));

        if ( $found > 1 ) {
            return throw new \Exception(\erTranslationClassLhTranslation::getInstance()->getTranslation('lhldap/module', 'To mane record found with username. One record is expected.'));
        } else if ( is_array( $userinfo[0] ) ) {
            if ( !$password ) {
                throw new \Exception(\erTranslationClassLhTranslation::getInstance()->getTranslation('lhldap/module', 'Password is required for authentication.'));
            } else if ( isset( $userinfo[0]['dn'] ) ) {
                $userdn = $userinfo[0]['dn'] ;
                $result = @ldap_bind( self::getConnection(), $userdn, $password );
                if ( $result ) {
                    return $userinfo[0];
                } else {
                    throw new \Exception( \erTranslationClassLhTranslation::getInstance()->getTranslation('lhldap/module', 'Invalid username or password!')) ;
                }
            } else {
                throw new \Exception( \erTranslationClassLhTranslation::getInstance()->getTranslation('lhldap/module', 'Invalid data structure was returned.')) ;
            }
        } else {
            throw new \Exception( \erTranslationClassLhTranslation::getInstance()->getTranslation('lhldap/module', 'Invalid data structure was returned.'));
        }
    }

    public static function getError($errorMessage = '')
    {
        if (self::$connection) {
            throw new \Exception($errorMessage != '' ? $errorMessage : 'LDAP Error: '.ldap_error(self::$connection));
        } else {
            throw new \Exception(\erTranslationClassLhTranslation::getInstance()->getTranslation('lhldap/module', 'Connection could not be established!'));
        }

    }
}