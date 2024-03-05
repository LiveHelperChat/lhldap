<?php

erLhcoreClassRestAPIHandler::setHeaders();

try {
    if (empty($_POST['username'])) {
        throw new Exception(erTranslationClassLhTranslation::getInstance()->getTranslation('lhldap/module', 'Please enter a username'));
    }
    $userData = \LiveHelperChatExtension\lhldap\providers\LHLDAPApi::searchUsername($_POST['username']);
    echo json_encode(['found' => true,'message' => '<span class="material-icons text-success">done_outline</span> '. erTranslationClassLhTranslation::getInstance()->getTranslation('lhldap/module', 'User was found! You now can save LDAP settings.')]);
} catch (Exception $e) {
    echo json_encode(['found' => false, 'message' =>  '<span class="material-icons text-danger">error</span> ' . $e->getMessage()]);
}



exit;

?>