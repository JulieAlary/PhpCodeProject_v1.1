**TODO**

_Mise en place de divers outils sans utiliser_



- Fonction sluggable en place: reste à l'utiliser.
- fonction isFlood a utiliser pour les services commentaire + a rajouter les ip en bdd pour faire fonctionner le service

- pb mofication et ajout d'image sous chrome est obligatoire alors que nedevrait pas : solution définir une image par défault??


- page de gestion des utils : 

 . diverses commandes a voir : 
 
 // Pour récupérer le service UserManager du bundle
 $userManager = $this->get('fos_user.user_manager');
 
 // Pour charger un utilisateur
 $user = $userManager->findUserBy(array('username' => 'julie'));
 
 // Pour modifier un utilisateur
 $user->setEmail('cetemail@nexiste.pas');
 $userManager->updateUser($user); // Pas besoin de faire un flush avec l'EntityManager, cette méthode le fait toute seule !
 
 // Pour supprimer un utilisateur
 $userManager->deleteUser($user);
 
 // Pour récupérer la liste de tous les utilisateurs
 $users = $userManager->findUsers();
 
 - module antispam
 
 - module ckeditor
 
 - gestionnaire d'évenment , bigbrother ...
 
 - finir les translations
 
 - creer d'autres pages d'erreur en plus de la 404 et personnaliser


