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
    
    private function splitRouteAndParameters(string $route) : array  
    {  
        $routeAndParams = [];  
        $routeAndParams["route"] = null;  
        $routeAndParams["userId"] = null;  
        $routeAndParams["productId"] = null;  
      
        if(strlen($route) > 0) // si la chaine de la route n'est pas vide (donc si ça n'est pas la home)  
        {  
            $tab = explode("/", $route);  
      
            if($tab[0] === "register") 
            {  
                $routeAndParams["route"] = "register";
                 
            }  else if($tab[0] === "login")
            {
                $routeAndParams["route"] = "login";  
                
            } else if($tab[0] === "logout")
            {
                $routeAndParams["route"] = "logout";  
                
            } else if (isset($_SESSION["role"]) && $_SESSION["role"] === "Admin") 
            { 
                if ($tab[1] === "user" && !isset($tab[2])) 
                {
                    $routeAndParams["route"] = "admin/user";
                    
                } elseif ($tab[1] === "user" && $tab[2] === "edit" && isset($_GET["id"])) 
                {
                    $routeAndParams["route"] = "admin/user/edit";
                    $routeAndParams["userId"] = $_GET["id"];
                    
                } elseif ($tab[1] === "user" && $tab[2] === "delete" && isset($_GET["id"])) 
                {
                    $routeAndParams["route"] = "admin/user/delete";
                    $routeAndParams["userId"] = $_GET["id"];
                    
                } elseif ($tab[1] === "product" && !isset($tab[2])) 
                {
                    $routeAndParams["route"] = "admin/product";
                    
                } elseif ($tab[1] === "product" && $tab[2] === "create") 
                {
                    $routeAndParams["route"] = "admin/product/create";
                    
                } elseif ($tab[1] === "product" && $tab[2] === "edit" && isset($_GET['id'])) 
                {
                    $routeAndParams["route"] = "admin/product/edit";
                    $routeAndParams["productId"] = $_GET["id"];
                    
                } elseif ($tab[1] === "product" && $tab[2] === "delete" && isset($_GET["id"])) 
                {
                    $routeAndParams["route"] = "admin/product/delete";
                    $routeAndParams["productId"] = $_GET["id"];
                    
                }
            }
        }  
        else  
        {  
            $routeAndParams["route"] = "";  
        }  
      
        return $routeAndParams;  
    }
    
    public function checkRoute() : void
    {
        if (isset($_GET["path"])) 
        {
            $routeAndParams = $this->splitRouteAndParameters($_GET["path"]);
            
            if(empty($routeAndParams["route"]))
            {
                $this->homeController->index();
            }
            if ($routeAndParams["route"] === "homepage") 
            {
                $this->homeController->index();
            } else if ($routeAndParams["route"] === "register") 
            {
                $this->authController->register();
            } else if ($routeAndParams["route"] === "login") 
            {
                $this->authController->login();
            } else if ($routeAndParams["route"] === "logout") 
            {
                $this->authController->logout();
            } else if (isset($_SESSION["role"]) && $_SESSION["role"] === "Admin") 
            {
                // ADMIN / USER \\
                if ($routeAndParams["route"] === "admin/user") 
                {
                    $this->adminController->manageUser();
                } elseif ($routeAndParams["route"] === "admin/user/edit" && isset($_GET["id"])) 
                {
                    $this->adminController->editUser($_GET['id']);
                } elseif ($routeAndParams["route"] === "admin/user/delete" && isset($_GET["id"])) 
                {
                    $this->adminController->deleteUser($_GET['id']);
                }
                // ADMIN / PRODUCT \\
                elseif ($routeAndParams["route"] === "admin/product") 
                {
                    $this->adminController->manageProduct();
                } elseif ($routeAndParams["route"] === "admin/product/create") 
                {
                    $this->categoryController->manageCategoryProduct(true);
                    $this->productController->createProduct();
                } elseif ($routeAndParams["route"] === "admin/product/edit" && isset($_GET['id'])) 
                {
                    $this->categoryController->manageCategoryProduct(false);
                    $this->productController->editProduct($_GET['id']);
                } elseif ($routeAndParams["route"] === "admin/product/delete" && isset($_GET['id'])) 
                {
                    $this->productController->deleteProduct($_GET['id']);
                }
            }
        }
    }
    
    
    
}
?>