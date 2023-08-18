<?php
class Router {
    
    private AdminController $adminController;
    private AlbumController $albumController;
    private ArtistController $artistController;
    private AuthController $authController;
    private CategoryController $categoryController;
    private HomeController $homeController;
    private MediaController $mediaController;
    private PostController $postController;
    private ProductController $productController;
    private SongController $songController; // Est utile si je déclare déja albumController ??
    
    public function __construct()
    {   
        $this->adminController = new AdminController();
        $this->authController = new AuthController();
        
        $this->homeController = new HomeController();
        $this->postController = new PostController();
    }
    
    public function checkRoute() : void
    {
        $routeFound = false;
        
        if(isset($_GET["route"])) 
        {
            
                // ADMIN / Ajouter Contrôle d'accès ADMIN
                if($_GET["route"] === "admin_user_manage_user")
                {
                    $this->adminController->manageUser();
                    $routeFound = true;
                }

                if ($_GET["route"] === "admin_user_delete" && isset($_GET['id']))
                {
                    $this->adminController->deleteUser($_GET['id']);
                    $routeFound = true;
                }
                if($_GET["route"] === "admin_user_edit" && isset($_GET['id']))
                {
                    $this->adminController->editUser($_GET['id']);
                    $routeFound = true;
                }
                    
                if($_GET["route"] === "homepage")
                {
                    $this->homeController->index();
                    $routeFound = true;
                }
                if($_GET["route"] === "register")
                {
                    $this->authController->register();
                    $routeFound = true;
                }
                if($_GET["route"] === "login")
                {
                    $this->authController->login();
                    $routeFound = true;
                }
                if($_GET["route"] === "logout")
                {
                    $this->authController->logout();
                    $routeFound = true;
                }
                if($_GET["route"] === "post")
                {
                    $this->postController->index();
                    $routeFound = true;
                }
                if($_GET["route"] === "post/show")
                {
                    $this->postController->showPost($_GET);
                    $routeFound = true;
                }
                
                //ERREUR
                if($_GET["route"] === "403")
                {
                    $this->adminController->manageError(403);
                    $routeFound = true;
                }
        }
        
        if (!$routeFound)
        {
            $this->homeController->index();
        }
    }
}
?>