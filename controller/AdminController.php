<?php
class AdminController extends AbstractController{
    
    // private ArtistManager $artistManager;
    // private AlbumManager $albumManager;
    // private PostManager $postManager;
    // private ProductManager $productManager;
    private UserManager $userManager;
    
    public function __construct()
    {
        // $this->artistManager = new ArtistManager();
        // $this->albumManager = new AlbumManager();
        // $this->postManager = new PostManager();
        // $this->productManager = new ProductManager();
        $this->userManager = new UserManager("francisrouxel_zero_degre", "3306", "db.3wa.io", "francisrouxel", "acadbb28886b6985666cd7eff4651f1d");
    }
    public function index() 
    {
        $template = "admin/dashboard";
        require "templates/layout.phtml";
    }
    ////// MANAGE USER
    public function manageUser()
    {
        $users = $this->userManager->getAllUsers();
        $this->render("admin/user/manage_user", ["users" => $users]);
    }
    
    public function deleteUser(int $userId)
    {
        // if(!$this->isAdmin()){
            //redirige vers une page d'erreur ou de refus 
        // }
        
        $this->userManager->delete($userId);
        $_SESSION['message'] = "L'utilisateur a bien été supprimé";
                header("Location: /ZERODEGRE_/index.php?route=admin_user_manage_user");
        // $this->render("admin/user/manage_user", ["deleteUserSuccess" => ["L'utilisateur à bien été supprimé"]]);
    }
    
    public function editUser()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && $_POST["edit-form"] === "edit") {
            $email = $_POST["edit-email"];
            $firstName = $_POST["edit-firstName"];
            $lastName = $_POST["edit-lastName"];
            $password = $_POST["edit-password"];
            $confirmPassword = $_POST["edit-confirm-password"];
            $roleId = $_POST["edit-roleId"];
            
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
    
            if (strlen($password) > 50) {
                $errors[] = "Le mot de passe ne doit pas dépasser 50 caractères";
            }
    
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
                $_SESSION['editUserSuccess'] = "L'utilisateur a bien été modifié";
                header("Location: /ZERODEGRE_/index.php?route=admin_user_manage_user");

               

            } else {
                $this->render("admin/user/edit", [
                    "errors" => $errors
                ]);
            }
        } else {
            $this->render("admin/user/edit", []);
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
}
?>