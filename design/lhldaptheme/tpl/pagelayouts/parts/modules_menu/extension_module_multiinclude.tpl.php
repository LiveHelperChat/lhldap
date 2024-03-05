<?php if (erLhcoreClassUser::instance()->hasAccessTo('lhldap','settings')) : ?>
<li class="nav-item"><a class="nav-link" href="<?php echo erLhcoreClassDesign::baseurl('ldap/settings')?>"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('lhldap/module','LDAP');?></a></li>
<?php endif; ?>