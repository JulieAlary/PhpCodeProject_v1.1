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






