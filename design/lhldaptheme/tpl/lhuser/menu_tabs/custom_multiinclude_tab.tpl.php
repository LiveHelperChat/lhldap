<?php if ($user->id > 0 && erLhcoreClassUser::instance()->hasAccessTo('lhldap','setup')) : ?>
<li role="presentation" class="nav-item"><a href="#ldap" class="nav-link<?php if ($tab == 'tab_ldap') : ?> active<?php endif;?>" aria-controls="ldap" role="tab" data-bs-toggle="tab"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('lhldap/module','LDAP');?></a></li>
<?php endif;?>
