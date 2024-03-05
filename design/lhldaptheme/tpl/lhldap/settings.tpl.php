<h1 class="attr-header"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('lhldap/module', 'LDAP Options') ?></h1>

<form action="" method="post" ng-non-bindable autocomplete="off" >

    <?php include(erLhcoreClassDesign::designtpl('lhkernel/csfr_token.tpl.php'));?>

    <?php if (isset($updated) && $updated == 'done') : $msg = erTranslationClassLhTranslation::getInstance()->getTranslation('chat/onlineusers','Settings updated'); ?>
        <?php include(erLhcoreClassDesign::designtpl('lhkernel/alert_success.tpl.php'));?>
    <?php endif; ?>

    <div class="form-group">
        <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('lhldap/module', 'Server') ?></label>
        <input type="text" class="form-control form-control-sm" name="ldap_server" placeholder="E.g ldap://192.168.1.2" value="<?php isset($ldap_options['ldap_server']) ? print $ldap_options['ldap_server'] : ''?>" />
    </div>

    <div class="form-group">
        <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('lhldap/module', 'Base DN (ORG DN)') ?></label>
        <input type="text" class="form-control form-control-sm" name="ldap_base_dn" placeholder="E.g DC=livehelperchat,DC=local" value="<?php isset($ldap_options['ldap_base_dn']) ? print $ldap_options['ldap_base_dn'] : ''?>" />
    </div>

    <div class="form-group">
        <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('lhldap/module', 'Login (UID)') ?></label>
        <input autocomplete="new-password" type="text" class="form-control form-control-sm" name="ldap_login" value="<?php isset($ldap_options['ldap_login']) ? print $ldap_options['ldap_login'] : ''?>" />
    </div>

    <div class="form-group">
        <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('lhldap/module', 'Password') ?></label>
        <input autocomplete="new-password" type="password" class="form-control form-control-sm" name="ldap_password" value="" />
    </div>

    <div class="form-group">
        <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('lhldap/module', 'Bind DN. You can use {login}, {base_dn}') ?></label>
        <input type="password form-control-sm" class="form-control" name="ldap_bind_dn" value="<?php isset($ldap_options['ldap_bind_dn']) ? print $ldap_options['ldap_bind_dn'] : ''?>" />
    </div>

    <div class="form-group">
        <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('lhldap/module', 'UID') ?></label>
        <input type="text" class="form-control form-control-sm" name="ldap_uid_attr" placeholder="E.g sAMAAccountName" value="<?php isset($ldap_options['ldap_uid_attr']) ? print $ldap_options['ldap_uid_attr'] : ''?>" />
    </div>

    <input type="submit" class="btn btn-sm btn-primary" name="StoreOptions" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('system/buttons','Save'); ?>" />

    <hr>
    <p><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('lhldap/module', 'After you have saved your LDAP configuration. You can try to find user by username.') ?></p>

    <?php if (isset($ldap_options['ldap_server']) && $ldap_options['ldap_server'] != '' && isset($ldap_options['ldap_login']) && $ldap_options['ldap_login'] != '') : ?>

        <?php if (isset($error)) : ?>
            <div><?php echo htmlspecialchars($error);?></div>
        <?php endif; ?>

        <div class="form-group">
            <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('lhldap/module', 'Search by username')?></label>
            <input type="text" value="" name="ldap_test_username" id="test-ldap-username" class="form-control form-control-sm">
        </div>
        <button type="submit" name="TestLDAP" class="btn btn-secondary btn-sm" value="Test"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('lhldap/module', 'Test')?></button>

        <?php if (isset($user_info) && is_array($user_info) && !empty($user_info)) : ?>
            <ul>
                <?php foreach ($user_info as $attr => $attrValue) : if (!is_numeric($attr) && isset($attrValue[0]) && (is_string($attrValue[0]) || is_numeric($attrValue[1]))) : ?>
                    <li><?php echo htmlspecialchars($attr); ?>: <?php echo htmlspecialchars($attrValue[0])?></li>
                <?php endif; endforeach; ?>
            </ul>
        <?php endif; ?>

    <?php endif; ?>

</form>
