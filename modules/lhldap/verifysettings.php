<?php

erLhcoreClassRestAPIHandler::setHeaders();

try {
    if ($_POST['use_ldap'] === 'true') {
        $userData = \LiveHelperChatExtension\lhldap\providers\LHLDAPApi::searchUsername($_POST['username']);
        erLhcoreClassModelUserSetting::setSetting('ldap_use',1, $_POST['user_id'],true);
        erLhcoreClassModelUserSetting::setSetting('ldap_user',$_POST['username'], $_POST['user_id'],true);
    } else {
        erLhcoreClassModelUserSetting::setSetting('ldap_use',0, $_POST['user_id'], true );
        erLhcoreClassModelUserSetting::setSetting('ldap_user',$_POST['username'], $_POST['user_id'], true );
    }

    echo json_encode(['found' => true,'message' => '<span class="material-icons text-success">done_outline</span> ' . erTranslationClassLhTranslation::getInstance()->getTranslation('lhldap/module', 'Updated!')]);
} catch (Exception $e) {
    echo json_encode(['found' => false, 'message' =>  '<span class="material-icons text-danger">error</span> ' . $e->getMessage()]);
}

exit;

?>