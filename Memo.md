 /--------------FOSUSERBUNDLE------------------/

- Pour récupérer le service UserManager du bundle
 $userManager = $this->get('fos_user.user_manager');
 
- Pour charger un utilisateur
 $user = $userManager->findUserBy(array('username' => 'julie'));
 
- Pour modifier un utilisateur
 $user->setEmail('cetemail@nexiste.pas');
 $userManager->updateUser($user); // Pas besoin de faire un flush avec l'EntityManager, cette méthode le fait toute seule !
 
- Pour supprimer un utilisateur
 $userManager->deleteUser($user);
 
- Pour récupérer la liste de tous les utilisateurs
 $users = $userManager->findUsers();
 
 /--------------TWIG-------------------/
 - Pour couper a l'affichage des strings
          "| striptags | truncate(40)"
 
 
 /--------------CONSOLE------------------/
 
 - COMPOSER UPDATE :
 
 _php ../composer.phar update_
 
 _php composer.phar update_
  
 - GENERER LES FIXTURES
 
 _php bin/console doctrine:fixtures:load_
 
 - GENERER LA CREATION D UN FORMULAIRE
 
 _php bin/console doctrine:generate:form CMSBlogBundle:Article_
  
 - role user bdd
 a:1:{i:0;s:16:"ROLE_SUPER_ADMIN";}
 
 - COMMANDE POUR ROUTE PRECREE FOSUSER
 
 _php bin/console debug:router_
 
- POUR CONNAITRE LES SERVICES IMPLEMENTANT UN TAG**
 
 _php bin/console debug:container --tag=twig.extension_
 
- METTRE AJOUR LES TRANSLATIONS
 
 _php bin/console translation:update --force fr CMSBlogBundle_
 
- INSTALLER LES ASSETS
 
 _php bin/console assets:install --symlink_
 
 /----------CONSOLE EN LIGNE----------------/ 
 
 - ROUTE POUR LA CORESPHERE CONSOLE
 
 _http://localhost/PhpCodeProject_v1.1/web/app_dev.php/_console_
 
 /-----------------------------------------/
 
 a:1:{i:0;s:16:"ROLE_SUPER_ADMIN";}