<?php
abstract class AbstractController {

    protected function render(string $view, array $values) : void
    {
        $template = $view;
        $data = $values;
        
        require "./templates/layout.phtml";
    }
    
    protected function clean(string $string)
    {
        $clearCode = htmlspecialchars($string);
        return $clearCode;
    }
    
    protected function validatePassword($password): array
    {
        
        $passwordErrors = [];
        
        if (strlen($password) < 12) {
            $passwordErrors[] = "Le mot de passe doit avoir au moins 12 caractères";
        }
        
        if (!preg_match("/[0-9]/", $password)) {
            $passwordErrors[] = "Le mot de passe doit contenir au moins un chiffre";
        }
        
        if (!preg_match("/[A-Z]/", $password)) {
            $passwordErrors[] = "Le mot de passe doit contenir au moins une majuscule";
        }
        
        if (!preg_match("/[a-z]/", $password)) {
            $passwordErrors[] = "Le mot de passe doit contenir au moins une minuscule";
        }
        
        if (!preg_match("/[!@#$%^&*()_+{}\[\]:;<>,.?~\\-=]/", $password)) {
            $passwordErrors[] = "Le mot de passe doit contenir au moins un caractère spécial";
        }
        
        return $passwordErrors;
    }
    // Voir comment faire appelle au Manager ????
    // protected function checkEntityExistence($entityId, $entityType) 
    // {
    //     if ($entityType === 'album') {
    //         $existingEntity = $albumManager->getAlbumById($entityId);
    //     } elseif ($entityType === 'product') {
    //         $existingEntity = $productManager->getProductById($entityId);
    //     } elseif ($entityType === 'user') {
    //         $existingEntity = $userManager->getUserById($entityId);
    //     } else {
    //         $existingEntity = null;
    //     }

    //     if (!$existingEntity) {
    //         $_SESSION['message'] = "L'$entityType que vous souhaitez éditer n'existe pas.";
    //         // A Remplacer par page d'accueil ADMIN
    //         header("location : /ZERODEGRE_/admin/album");
    //     }
    // }

}
?>