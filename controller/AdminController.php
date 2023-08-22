<?php
class AdminController extends AbstractController{
    
    // private ArtistManager $artistManager;
    // private AlbumManager $albumManager;
    // private PostManager $postManager;
    private CategoryManager $categoryManager;
    private ProductManager $productManager;
    private UserManager $userManager;
    
    public function __construct()
    {
        // $this->artistManager = new ArtistManager();
        // $this->albumManager = new AlbumManager();
        $this->categoryManager = new CategoryManager();
        // $this->postManager = new PostManager();
        $this->productManager = new ProductManager();
        $this->userManager = new UserManager();
    }
    public function index() 
    {
        $template = "admin/dashboard";
        require "templates/layout.phtml";
    }
    ////// MANAGE USER //////
    public function manageUser()
    {
        $users = $this->userManager->getAllUsers();
        $this->render("admin/user/manage_user", ["users" => $users]);
    }
    
    public function deleteUser()
    {
        // if(!$this->isAdmin()){
            //redirige vers une page d'erreur ou de refus 
        // }
        if(isset($_GET['id']))
        {
                $userId = $_GET['id'];
                $this->userManager->delete($userId);
                
                // Récuperer la nouvelle liste d'user
                $newUserList = $this->userManager->getAllUsers();
              
                echo json_encode($newUserList);
        } else {
                echo json_encode(array("errors" => "L'utilisateur n'a pas été supprimé"));
        }
    }

    public function editUser()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && $_POST["edit-form"] === "edit") 
        {
            $email = $this->clean($_POST["edit-email"]);
            $firstName = $this->clean($_POST["edit-firstName"]);
            $lastName = $this->clean($_POST["edit-lastName"]);
            $password = $_POST["edit-password"];
            $confirmPassword = $_POST["edit-confirm-password"];
            $roleId = $this->clean($_POST["edit-roleId"]);
            
            $errors = [];
    
            if (strlen($email) > 50) {
                $errors[] = "L'email ne doit pas dépasser 50 caractères";
            }
    
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "L'email n'est pas écrit correctement";
            }
    
            if (strlen($firstName) > 50) {
                $errors[] = "Le prénom ne doit pas dépasser 50 caractères";
            }
    
            if (strlen($lastName) > 50) {
                $errors[] = "Le nom ne doit pas dépasser 50 caractères";
            }
    
            if ($password !== $confirmPassword) {
                $errors[] = "Les mots de passe ne correspondent pas";
            }
    
            $passwordErrors = $this->validatePassword($password);
            $errors = array_merge($errors, $passwordErrors);
    
            if (!$errors) {
                
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                
                $user = $this->userManager->getUserById($_GET["id"]);
                
                $user->setFirstName($firstName);
                $user->setLastName($lastName);
                $user->setEmail($email);
                $user->setPassword($hashedPassword);
                $user->setRoleId($roleId);
                
                $this->userManager->edit($user);
                
                // Redirect to the manage user
                $_SESSION['message'] = "L'utilisateur a bien été modifié";
                header("Location: /ZERODEGRE_/index.php?route=admin_user");

               

            } else {
                $this->render("admin/user/edit", [
                    "errors" => $errors
                ]);
            }
        } 
    }
    public function managePost()
    {
        $posts = $this->postManager->getAllPosts();
        $this->render("admin/post/manage_post", ["posts" => $posts]);
    }
    
    public function manageProduct()
    {
        $products = $this->productManager->getAllProducts();
        var_dump($products);
        $this->render("admin/product/manage_product", ["products" => $products]);
    }
    
    public function manageArtist()
    {
        $artists = $this->artistManager->getAllArtists();
        $this->render("admin/artist/manage_artist", ["artists" => $artists]);
    }
    
    public function manageAlbum()
    {
        $albums = $this->albumManager->getAllAlbums();
        $this->render("admin/album/manage_album", ["albums" => $albums]);
    }
    
    //Gestion des pages d'erreurs
    public function manageError($errorCode)
    {
        if ($errorCode === 403)
        {
            $this->render("error/403", []);
        }elseif ($errorCode === 404) {
            $this->render("error/404", []);
        }
    }
}
?>