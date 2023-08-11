<?php

class AuthController extends AbstractController{

    private UserManager $manager;
    
    public function __construct()
    {
        $this->manager = new UserManager("francisrouxel_zero_degre", "3306", "db.3wa.io", "francisrouxel", "acadbb28886b6985666cd7eff4651f1d");
    }
    
    public function register(): void
    {
        if (isset($_POST["register-form"]) && $_POST["register-form"] === "register") {
            $email = $_POST["register-email"];
            $firstName = $_POST["register-firstName"];
            $lastName = $_POST["register-lastName"];
            $password = $_POST["register-password"];
            $confirmPassword = $_POST["register-confirm-password"];
            $roleId = "1"; // À modifier pour gérer admin ou non
            
            $errors = [];
            
            if ($this->manager->getUserByEmail($email)) {
                $errors[] = "Un utilisateur avec cet email existe déjà";
            }
            
            if (strlen($email) >= 50) {
                $errors[] = "L'email ne doit pas dépasser 50 caractères";
            }
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "L'email n'est pas écrit correctement";
            }
            
            if ($this->manager->getUserByFirstName($firstName)) {
                $errors[] = "Un utilisateur avec ce prénom existe déjà";
            }
            
            if (strlen($firstName) >= 50) {
                $errors[] = "Le prénom ne doit pas dépasser 50 caractères";
            }
            
            if ($this->manager->getUserByLastName($lastName)) {
                $errors[] = "Un utilisateur avec ce nom de famille existe déjà";
            }
            
            if (strlen($lastName) >= 50) {
                $errors[] = "Le nom ne doit pas dépasser 50 caractères";
            }
            
            if ($password !== $confirmPassword) {
                $errors[] = "Les mots de passe ne correspondent pas";
            }
            
            if (strlen($password) >= 50) {
                $errors[] = "Le mot de passe ne doit pas dépasser 50 caractères";
            }
            
            if (!$errors) {
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                
                $user = new User($firstName, $lastName, $email, $hashedPassword, $roleId);
                $this->manager->createUser($user);
                
                // Manually log the user
                $_SESSION["user"] = $user->getId();
                
                // Redirect to the homepage
                $this->render("auth/login", [
                    "register" => ["Le compte a bien été créé"]
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
    
    public function login() : void 
    {
        if( isset($_POST["login-form"]) && $_POST["login-form"] === "login")
        {
            $email = $_POST["login-email"];
            $password = $_POST["login-password"];
            
            //Check if the user exist
            $user = $this->manager->getUserByEmail($email);

            if($user !== null)
            {
                //Check if the password is good 
                if(password_verify($password, $user->getPassword()))
                {
                    //Log the user    
                    $_SESSION["user"] = $user->getId();
                    
                    //Redirect to homepage
                    $this->render("partials/homepage", [
                            "loginSuccess" => ["Vous êtes bien connecté"
                            ]
                        ]);
                } else {
                    
                    $this->render("auth/login", [
                            "errors" => [
                                    "Mot de passe incorrects"
                                ]
                        ]);
                }
            } else {
                // and you get an error
                $this->render("auth/login", [
                    "errors" => [
                        "Aucun compte avec cet email"
                    ]
                ]);
            }
        } else {
            
            $this->render("auth/login", [ 
                "errors" => [
                        "bug firstStep"
                        ]
                    ]);
        }
    }
    
    public function logout()
    {
        //Se renseigner sur le fonctionnement 
        session_destroy();
        header("location: index.php?route=homepage");
        // $this->render("partials/homepage", [
        //     "logoutSuccess" => ["Vous êtes bien deconnecté"
        //             ]
        //         ]);
    }
}
?>