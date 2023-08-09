<?php

class UserController extends AbstractController{

    private UserManager $manager;
    
    public function __construct()
    {
        $this->manager = new UserManager("francisrouxel_phpj8", "3306", "db.3wa.io", "francisrouxel", "acadbb28886b6985666cd7eff4651f1d");
    }
    
    public function register() : void
    {
        if(isset($_POST["form-name"]) && $_POST["form-name"] === "register")
        {
            // check if the email already exists
            if($this->manager->getUserByEmail($_POST["register-email"]) === null)
            {
                // check if the firstname already exists
                if($this->manager->getUserByFirstName($_POST["register-firstName"]) === null)
                {
                    // check if the lastname already exists
                    if($this->manager->getUserByLastName($_POST["register-lastName"]) === null)
                    {
                        // check if the passwords match
                        if($_POST["register-password"] === $_POST["register-confirm-password"])
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
                            header("Location:/");
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
                                    "Un utilisateur avec ce nom de famille existe déjà"
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
                    header("location:/");
                } else {
                    //Voir avec Kevin pour ajouter msg dans le layout 
                    $this->render("auth/login", [
                            "errors" => [
                                    "Identifiants incorrects"
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
            
            $this->render("auth/login", []);
        }
    }
    
    public function logout()
    {
        //Se renseigner sur le fonctionnement 
        session_destroy();
        header("location:/");
    }
}
?>