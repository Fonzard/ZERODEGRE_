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
        $this->authController = new AuthController();
        
        $this->homeController = new HomeController();
        $this->postController = new PostController();
    }
    
    public function checkRoute() : void
    {
        
        if(isset($_GET["route"])) {
            
            if($_GET["route"] === "homepage")
            {
                $this->homeController->index();
            }
            if($_GET["route"] === "register")
            {
                $this->authController->register();
            }
            if($_GET["route"] === "login")
            {
                $this->authController->login();
            }
            if($_GET["route"] === "logout")
            {
                $this->authController->logout();
            }
            if($_GET["route"] === "post")
            {
                $this->postController->index();
            }
            if($_GET["route"] === "post/show")
            {
                $this->postController->showPost();
            }
        } else {
            $this->homeController->index();
        }
    }
}
?>