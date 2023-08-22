<?php

class ProductController extends AbstractController{

    private UserManager $manager;
    
    public function __construct()
    {
        $this->manager = new UserManager();
    }
 
    public function createProduct() : void 
    {
        if (isset($_POST["register-form"]) && $_POST["register-form"] === "register") 
        {
            $name = $this->clean($_POST["product-name"]);
            $price = $this->clean($_POST["product-price"]);
            $description = $this->clean($_POST["product-description"]);
            $quantity = $_POST["product-quantity"];
            $categotyId = $_POST["product-categoryId"];
            $mediaId = $_POST["product-mediaId"];
            
            $errors = [];
        
            
            if (strlen($email) >= 50) {
                $errors[] = "L'email ne doit pas dépasser 50 caractères";
            }
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "L'email n'est pas écrit correctement";
            }
            
            if ($this->manager->getUserByEmail($email) !== null) {
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
                $this->manager->createUser($user);
                
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
    
}