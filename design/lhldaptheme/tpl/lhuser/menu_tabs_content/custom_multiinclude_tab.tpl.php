<?php if ($user->id > 0 && erLhcoreClassUser::instance()->hasAccessTo('lhldap','setup')) : ?>
<div role="tabpanel" class="tab-pane <?php if ($tab == 'tab_ldap') : ?>active<?php endif;?>" id="ldap">
    <div class="form-group">
        <label><input type="checkbox" <?php if (erLhcoreClassModelUserSetting::getSetting('ldap_use','0',$user->id,true,true) == 1) : ?>checked="checked"<?php endif;?> id="id_ldap_verify"> <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('lhldap/module', 'Use LDAP logins. Login will be possible only using LDAP login and username.')?></label>
    </div>
    <div class="form-group">
        <input class="form-control form-control-sm" placeholder="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('lhldap/module', 'Enter LDAP Username')?>" type="text" name="ldap_username" value="<?php echo htmlspecialchars(erLhcoreClassModelUserSetting::getSetting('ldap_user','',$user->id,true,true))?>" id="id_ldap_username">
    </div>
    <button id="id_verify_ldap"  class="btn btn-sm btn-secondary" type="button"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('system/buttons', 'Save')?></button>
    <div id="ldap-search-status"></div>
</div>
<script>
    $( document ).ready(function() {
        function searchUsername(){
            if ($('#id_ldap_username').val() == '') {
                return;
            }
            $('#ldap-search-status').html('<div><span class="material-icons">sync</span> '+<?php echo json_encode(erTranslationClassLhTranslation::getInstance()->getTranslation('system/buttons', 'Loading'))?> +'...</div>');
            $.postJSON(WWW_DIR_JAVASCRIPT + 'ldap/searchusername', {"username":$('#id_ldap_username').val()}, function(data) {
                $('#ldap-search-status').html(data.message);
            });
        }
        $('#id_verify_ldap').click(function(){
            $.postJSON(WWW_DIR_JAVASCRIPT + 'ldap/verifysettings', {'user_id' : "<?php echo $user->id?>","username":$('#id_ldap_username').val(), 'use_ldap' : $('#id_ldap_verify').is(':checked')}, function(data) {
                $('#ldap-search-status').html(data.message);
            });
        });
        $('#id_ldap_username').on( "keyup", function(){
            searchUsername();
        });
        searchUsername();
    });
</script>
<?php endif;?>