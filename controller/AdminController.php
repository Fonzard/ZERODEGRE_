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
        $this->mediaManager = new MediaManager();
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
        if(isset($_GET['id']))
        {
            $userId = $_GET['id'];
            $this->userManager->delete($userId);
            $newUserList = $this->userManager->getAllUsers();
            
                    if (empty($newUserList)) {
                        echo json_encode(array("success" => false, "message" => "Aucun Utilisateur disponible."));
                    } else {
                        $responseData = array('success' => true, 'message' => 'Utilisateurs supprimé avec succès.', 'users' => $newUserList);
                        var_dump($responseData);
                        echo json_encode($responseData);
                    }
        } else {
                echo json_encode(array("success" => false, "message" => "L'utilisateur n'a pas été supprimé"));
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
                header("Location: /ZERODEGRE_/admin/user");

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
        //Récupère le nom des catégories pour l'afficher
        $categoriesNames = [];
        foreach ($products as $product){
            $categoryId = $product->getCategoryId();
            $categoryName = $this->categoryManager->getCategoriesName($categoryId);
            $categoriesNames[] = $categoryName;
        }
        
        //Récupère la description des médias pourl'afficher
        $mediasNames = [];
        foreach ($products as $product){
            $mediaId = $product->getMediaId();
            $mediaDesc = $this->mediaManager->getMediaDescription($mediaId);
            $mediasDesc[] = $mediaDesc;
        }
        $this->render("admin/product/manage_product", ["products" => $products, "categoriesNames" => $categoriesNames, "mediasDesc" => $mediasDesc]);
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
        } elseif ($errorCode === 404) {
            $this->render("error/404", []);
        }
    }
}
?>