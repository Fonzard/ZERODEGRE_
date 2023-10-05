<?php

class AuthController extends AbstractController{

    private UserManager $um;
    
    public function __construct()
    {
        $this->um = new UserManager();
    }
    
    public function register(): void
    {
        // Voir si je peux envoyer le formulaire sans avoir remplit toutes les cases
        if (isset($_POST["register-form"]) && $_POST["register-form"] === "register") 
        {
            $email = $this->clean($_POST["register-email"]);
            $firstName = $this->clean($_POST["register-firstName"]);
            $lastName = $this->clean($_POST["register-lastName"]);
            $password = $_POST["register-password"];
            $confirmPassword = $_POST["register-confirm-password"];
            $roleId = "1"; 
            $errors = [];
            
            if (empty($email)) {
                $errors[] = "Veuillez saisir votre Email";
            }
            
            if (empty($firstName)) {
                $errors[] = "Veuillez saisir votre Prénom";
            }
            
            if (empty($lastName)){
                $errors[] = "Veuillez saisir votre Nom de famille";
            }
            
            if (strlen($email) >= 50) {
                $errors[] = "L'email ne doit pas dépasser 50 caractères";
            }
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "L'email n'est pas écrit correctement";
            }
            
            if ($this->um->getUserByEmail($email) !== null) {
                $errors[] = "L'email existe déjà";
            }
            
            if (strlen($firstName) >= 50) {
                $errors[] = "Le prénom ne doit pas dépasser 50 caractères";
            }
            
            if (strlen($lastName) >= 50) {
                $errors[] = "Le nom ne doit pas dépasser 50 caractères";
            }
            
            if ($password !== $confirmPassword) {
                $errors[] = "Les mots de passe ne correspondent pas";
            }
            
            
            $passwordErrors = $this->validatePassword($password);
            
            //Merge the two error arrays
            $errors = array_merge($errors, $passwordErrors);
            
            if (!$errors) {
               
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $user = new User($firstName, $lastName, $email, $hashedPassword, $roleId);
                $this->um->createUser($user);
                
                // Manually log the user
                $_SESSION["user"] = $user->getId();
                
                // Redirect to the homepage
                $this->render("auth/login", [
                    "message" => ["Le compte a bien été créé"]
                ]);
            } else {
                $this->render("auth/register", [
                    "errors" => $errors
                ]);
            }
        } else {
            $this->render("auth/register", []);
        }
    }
    
    public function login(): void 
    {
        $errors = []; // Créer un tableau pour stocker les erreurs
    
        if (isset($_POST["login-form"]) && $_POST["login-form"] === "login") 
        {
            $email = $this->clean($_POST["login-email"]);
            $password = $_POST["login-password"];
    
            //Check if the user exists
            $user = $this->um->getUserByEmail($email);
    
            if ($user !== null) 
            {
                //Check if the password is correct 
                if (password_verify($password, $user->getPassword())) 
                {
                    //Log the user    
                    $_SESSION["user"] = $user->getId();
                    $roleName = $this->um->getUserRoleName($user->getRoleId());
                    $_SESSION["role"] = $roleName['name'];
                    
                    if(isset($_SESSION) && $_SESSION["role"] === "Admin")
                    {
                        //Rajouter un élément pour qu'admin sois montré actif
                        header("location: /ZERODEGRE_/admin/dashboard");
                    } else {
                        $this->render("partials/homepage", [
                        "message" => ["Vous êtes bien connecté"]
                    ]);
                    }
                } 
                else 
                {
                    $errors[] = "Mot de passe incorrect";
                }
            } 
            else 
            {
                $errors[] = "Aucun compte avec cet email";
            }
        } 
        else 
        {
            $errors[] = "";
        }
    
        // Render the view with errors array
        $this->render("auth/login", [
            "errors" => $errors
        ]);
    }

    
    public function logout()
    {
        session_destroy();
        header("location:/ZERODEGRE_/homepage");
    }
}
?>