A Symfony project created on January 20, 2017, 5:58 pm.

/-----------------------------------------/

**COMPOSER UPDATE :** 

_php ../composer.phar update_

_php composer.phar update_

/-----------------------------------------/

**GENERER LES FIXTURES**

_php bin/console doctrine:fixtures:load_

/-----------------------------------------/

**GENERER LA CREATION D UN FORMULAIRE**

_php bin/console doctrine:generate:form CMSBlogBundle:Article_

/-----------------------------------------/

role user bdd
a:1:{i:0;s:16:"ROLE_SUPER_ADMIN";}

/-----------------------------------------/

**COMMANDE POUR ROUTE PRECREE FOSUSER**

_php bin/console debug:router_

/-----------------------------------------/

**POUR CONNAITRE LES SERVICES IMPLEMENTANT UN TAG**

_php bin/console debug:container --tag=twig.extension_
/-----------------------------------------/


**METTRE AJOUR LES TRANSLATIONS**

_php bin/console translation:update --force fr CMSBlogBundle_
/-----------------------------------------/

**INSTALLER LES ASSETS**

_php bin/console assets:install --symlink_

/-----------------------------------------/

**ROUTE POUR LA CORESPHERE CONSOLE**

_http://localhost/PhpCodeProject_v1.1/web/app_dev.php/_console_

/-----------------------------------------/





