# user-bundle


## Overview
This bundle provides a user framework for an ui.

## Installation
Add this repository to your `composer.json` until it is available at packagist:
```json
{
    "repositories": [{
            "type": "vcs",
            "url": "git@github.com:bywulf/user-bundle.git"
        }
    ]
}
```

After that, install the package via composer:
```bash
composer install bywulf/user-bundle:dev-master
```

As long as we can't add a recipe for this bundle, you have to register the routes manually in your `config/routes.yaml`:
```yaml
bywulf_user:
    resource: '@BywulfUserBundle/Resources/config/routes.yaml'
```

Adjust your `config/packages/security.yaml` to use this bundle's functionality:
```yaml
security:
    providers:
        our_db_provider:
            entity:
                class: Bywulf\UserBundle\Entity\User
                property: email

    encoders:
        Bywulf\UserBundle\Entity\User:
            algorithm: bcrypt
            cost: 14

    firewalls:
        main:
            pattern: ^/
            user_checker: bywulf_user_security_user_checker

            anonymous: ~

            form_login:
                login_path: bywulf_user_login
                check_path: bywulf_user_login
```

(WIP) To be able to edit users in your easy admin installation, add this to you `config/packages/easy_admin.yaml`:
```yaml
easy_admin:
    entities:
        User:
            class: Bywulf\UserBundle\Entity\User
            list:
                fields:
                    - id
                    - username
                    - { property: 'email', type: 'email' }
                    - { property: 'roles', type: 'array', sortable: false }
                    - active
            form:
                fields:
                    - { type: 'group', label: 'Basic information', icon: 'shield',
                                                            help: 'infos about the user', css_class: 'warning' }
                    - username
                    - { property: 'email', type: 'email' }

                    - active

                    - { type: 'group', label: 'Roles', icon: 'shield',
                                            help: 'Roles of the User', css_class: 'danger' }
                    - { property: 'roles', type: 'choice', type_options: {choices: {'User':'ROLE_USER', 'Admin':'ROLE_ADMIN'}, multiple: true, expanded: true}}

            new:
                fields:
                    - { property: 'plainPassword', type: 'password', type_options: {required: true}}

            edit:
                fields:
                    - { property: 'plainPassword', type: 'password', type_options: {required: false}}
```