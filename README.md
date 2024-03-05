# LDAP Support for operator authentication workflow

LDAP Support for operator login workflow. Once activated operator will be able to login only using LDAP username and password.

LDAP username has to match with account username.

## Requirements

 * PHP Min 8.1
 * PHP LDAP extension https://www.php.net/manual/en/book.ldap.php

## Installation

Clone repo to `lhc_web/extension/lhldap` and activate in `settings/settings.ini.php` file

```
    ...
    'extensions' => array('lhldap)
    ...
```

Don't forget to clear cache from back office.

## Main LDAP Settings

There you have to setup main LDAP settings before be able to setup LDAP settings for the operator account.

![See image](https://raw.githubusercontent.com/LiveHelperChat/lhldap/main/doc/ldap-main.png)

## User account settings

In user account you can activate LDAP for a specific operator.

![See image](https://raw.githubusercontent.com/LiveHelperChat/lhldap/main/doc/ldap-operator.png)

## Permissions

> `lhldap,setup` - allow operator to setup LDAP login settings for the operator
> `lhldap,settings` - allow operator to configure LDAP main settings.