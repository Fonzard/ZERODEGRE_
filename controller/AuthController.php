<?php

class AuthController extends AbstractController{

    private UserManager $manager;
    
    public function __construct()
    {
        $this->manager = new UserManager("francisrouxel_zero_degre", "3306", "db.3wa.io", "francisrouxel", "acadbb28886b6985666cd7eff4651f1d");
    }
    
    public function register() : void
    {
        if(isset($_POST["register-form"]) && $_POST["register-form"] === "register")
        {
            // check if the email already exists
            if($this->manager->getUserByEmail($_POST["register-email"]) === null)
            {
                //Check if the email is not too characterful
                if(strlen($_POST["register-email"]) < 50)
                {
                    // check if the firstname already exists
                    if($this->manager->getUserByFirstName($_POST["register-firstName"]) === null)
                    {
                        //Check if the firstname is not too characterful
                        if(strlen($_POST["register-firstName"]) < 50)
                        {
                            // check if the lastname already exists
                            if($this->manager->getUserByLastName($_POST["register-lastName"]) === null)
                            {
                                //Check if the lastname is not too characterful
                                if(strlen($_POST["register-lastName"]) < 50)
                                {
                                    // check if the passwords match
                                    if($_POST["register-password"] === $_POST["register-confirm-password"])
                                    {
                                        //Check if the password is not too characterful
                                        if(strlen($_POST["register-password"]) < 50)
                                        {
                                            $password = password_hash($_POST["register-password"], PASSWORD_BCRYPT);
                                            $email = $_POST["register-email"];
                                            $firstName = $_POST["register-firstName"];
                                            $lastName = $_POST["register-lastName"];
                                            
                                            //A modifier pour gérer admin ou non
                                            $roleId = "1";
                    
                                            $user = $this->manager->createUser(new User($firstName, $lastName, $email, $password, $roleId));
                                            
                                            // manually log the user
                                            $_SESSION["user"] = $user->getId();
                    
                                            // redirect to the homepage
                                            $this->render("auth/login", [
                                                    "register" => ["Le compte à bien été créé"
                                                    ]
                                                ]);
                                        } else {
                                            $this->render("auth/register", [
                                                "errors" => [
                                                    "Le mot de passe ne de doit pas dépasser 50 caractères"
                                                ]
                                            ]);   
                                        }
                                    } else {
                                        $this->render("auth/register", [
                                            "errors" => [
                                                "les mots de passe ne correspondent pas"
                                            ]
                                        ]);
                                    }
                                } else {
                                    $this->render("auth/register", [
                                            "errors" => [
                                                "Le nom ne de doit pas dépasser 50 caractères"
                                            ]
                                        ]);
                                }   
                            } else {
                                $this->render("auth/register", [
                                        "errors" => [
                                            "Un utilisateur avec ce nom de famille existe déjà"
                                        ]
                                    ]);
                            }
                        } else {
                            $this->render("auth/register", [
                                "errors" => [
                                    "Le prénom ne doit pas dépasser 50 caractères"
                                ]
                            ]);
                        }
                    } else {
                        $this->render("auth/register", [
                            "errors" => [
                                "un utilisateur avec ce prénom existe déjà"
                            ]
                        ]);
                    }
                } else {
                    $this->render("auth/register", [
                        "errors" => [
                            "L'email ne doit pas dépasser 50 caractères"
                        ]
                    ]);
                }    
            } else {
                $this->render("auth/register", [
                    "errors" => [
                        "un utilisateur avec cet email existe déjà"
                    ]
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