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
    
    
    //Je ne suis pas du tout sur de cette function 
    // protected function viewUserInfo($userId)
    // {
    //     // Vérifier si l'utilisateur est connecté
    //     if (!isset($_SESSION["user"])) {
    //         // Rediriger l'utilisateur vers une page de connexion ou afficher un message d'erreur
    //         header("location: index.php?route=homepage");
    //     }
    
    //     // Vérifier si l'utilisateur connecté est le même que celui dont les informations sont demandées
    //     if ($_SESSION["user"] !== $userId) {
    //         // Rediriger l'utilisateur vers une page d'accès interdit ou afficher un message d'erreur
    //         header("location: index.php?route=403");
            
    //     }
    
    //     // Si toutes les vérifications sont passées, afficher les informations de l'utilisateur
    //     // A vérifier 
    //     header("location: index.php?route=homepage");
    // }

}
?>