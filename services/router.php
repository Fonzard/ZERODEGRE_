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
        
        $this->categoryController = new CategoryController();
        $this->homeController = new HomeController();
        $this->postController = new PostController();
        $this->productController = new ProductController();
    }
    
    public function checkRoute() : void
    {
        
        if(isset($_GET["route"])) 
        {
            
                // ADMIN / Ajouter Contrôle d'accès ADMIN
                if($_GET["route"] === "admin_user")
                {
                    $this->adminController->manageUser();
                }

                if ($_GET["route"] === "admin_user_delete" && isset($_GET['id']))
                {
                    $this->adminController->deleteUser($_GET['id']);
                }
                if($_GET["route"] === "admin_user_edit" && isset($_GET['id']))
                {
                    $this->adminController->editUser($_GET['id']);
                }
                if($_GET["route"] === "admin_product")
                {
                    $this->adminController->manageProduct();
                }
                if($_GET["route"] === "admin_product_create")
                {
                    $this->categoryController->manageCategoryProduct();
                    $this->productController->createProduct();
                }
                if($_GET["route"] === "admin_product_edit" && isset($_GET["id"]))
                {
                    $this->categoryController->manageCategoryProduct();
                    $this->productController->editProduct($_GET['id']);
                }
                
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
                // if($_GET["route"] === "post")
                // {
                //     $this->postController->index();
                //     $routeFound = true;
                // }
                // if($_GET["route"] === "post/show")
                // {
                //     $this->postController->showPost($_GET);
                //     $routeFound = true;
                // }
                
                //ERREUR
                if($_GET["route"] === "403")
                {
                    $this->adminController->manageError(403);
                }
        } else {
            $this->homeController->index();
        }
    }
}
?>