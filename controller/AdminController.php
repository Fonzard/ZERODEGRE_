<?php
class AdminController extends AbstractController{
    
    private ArtistManager $artistManager;
    private ArtistController $artistController;
    private AlbumManager $albumManager;
    private AlbumController $albumController;
    private PostManager $postManager;
    private CategoryManager $categoryManager;
    private MediaManager $mediaManager;
    private ProductManager $productManager;
    private UserManager $userManager;
    private SongManager $songManager;
    
    public function __construct()
    {
        $this->artistManager = new ArtistManager();
        $this->artistController = new ArtistController();
        $this->albumManager = new AlbumManager();
        $this->albumController = new AlbumController();
        $this->categoryManager = new CategoryManager();
        $this->postManager = new PostManager();
        $this->mediaManager = new MediaManager();
        $this->productManager = new ProductManager();
        $this->songManager = new SongManager();
        $this->userManager = new UserManager();
    }
    public function dashboard() 
    {
        $this->render("admin/dashboard", []);
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
                        echo json_encode($responseData);
                    }
        } else {
                echo json_encode(array("success" => false, "message" => "L'utilisateur n'a pas été supprimé"));
        }
    }

    public function editUser($userId)
    {
        if ($_POST["edit-form"] === "edit") 
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
            $user = $this->userManager->getUserById($userId);
            $this->render("admin/user/edit", ["user" => $user]);
        }
    }
    
    public function managePost()
    {
        $categories = $this->categoryManager->getAllCategoriesPost();
        $posts = $this->postManager->getAllPost();
        foreach ($posts as $post){
            $categoryId = $post->getCategoryId();
            $categoryName = $this->categoryManager->getCategoriesPostName($categoryId);
            $categoriesNames[] = $categoryName;
        }
        $mediasDesc = [];
        foreach ($posts as $post){
            $mediaId = $post->getMediaId();
            if ($mediaId !== null) {
                $mediaDesc = $this->mediaManager->getMediaDescription($mediaId);
                $mediasDesc[] = $mediaDesc;
            }
        }
        $this->render("admin/post/manage_post", ["posts" => $posts, "categoriesNames" => $categoriesNames, "mediasDesc" => $mediasDesc, "categories" => $categories]);
    }
    
    public function manageProduct()
    {
        $products = $this->productManager->getAllProducts();
        //Récupère le nom des catégories pour l'afficher
        $categoriesNames = [];
        foreach ($products as $product){
            $categoryId = $product->getCategoryId();
            $categoryName = $this->categoryManager->getCategoriesProductsName($categoryId);
            $categoriesNames[] = $categoryName;
        }
        $mediasDesc = [];
        foreach ($products as $product){
            $mediaId = $product->getMediaId();
            if ($mediaId !== null) {
                $mediaDesc = $this->mediaManager->getMediaDescription($mediaId);
                $mediasDesc[] = $mediaDesc;
            }
        }
        $this->render("admin/product/manage_product", ["products" => $products, "categoriesNames" => $categoriesNames, "mediasDesc" => $mediasDesc]);
    }
    
    public function manageArtist()
    {
        $artists = $this->artistManager->getAllArtists();
        $mediasDesc = [];
        $artistAlbum = [];
        foreach ($artists as $artist) {
            $mediaId = $artist->getMediaId();
            $mediaDesc = $this->mediaManager->getMediaDescription($mediaId);
            $mediasDesc[] = $mediaDesc;
            
            $artistId = $artist->getId();
            $artistWithAlbum = $this->artistController->getArtistWithAlbums($artistId);
            
            if (!empty($artistWithAlbum))
            {
                $artistAlbum[] = $artistWithAlbum;
            }

        }
        $this->render("admin/artist/manage_artist", ["artistWithAlbum" => $artistAlbum, "mediaDesc" => $mediasDesc]);
    }
    
    public function manageAlbum()
    {
        $songs = $this->songManager->getAllSong();
        
        $albums = $this->albumManager->getAllAlbum();
        $albumsWithSongs = [];
        
        foreach ($albums as $album) {
            
            $albumWithSongs = $this->albumController->getAlbumWithSongs($album->getId());
            if ($albumWithSongs === null) 
            {
                // Aucune chanson associée à cet album, gérer l'erreur ici
                $_SESSIONS['message'] = "Aucune chanson n'est associée à cette album en base de données.";
                header("location: /ZERODEGRE_/admin/album");
            } else {
                $albumsWithSongs[] = $albumWithSongs;
            }
        }
        $this->render("admin/album/manage_album", ["albumsWithSongs" => $albumsWithSongs, "songs" => $songs, "albums" => $albums]);
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