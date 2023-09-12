<?php
class Router {
    
    private AdminController $adminController;
    private AlbumController $albumController;
    private ArtistController $artistController;
    private AuthController $authController;
    private CategoryController $categoryController;
    private HomeController $homeController;
    private PostController $postController;
    private ProductController $productController;
    
    public function __construct()
    {   
        $this->adminController = new AdminController();
        $this->albumController = new AlbumController();
        $this->artistController = new ArtistController();
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
        $routeAndParams["albumId"] = null;
        $routeAndParams["artistId"] = null;
        $routeAndParams["postId"] = null;
      
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
                
            } else if($tab[0] === "post") {
                $routeAndParams["route"] = "post";
            }
            
            else if (isset($_SESSION["role"]) && $_SESSION["role"] === "Admin")  //////////ADMIN USER
            {
                if ($tab[1] === "dashboard" && !isset($tab[2]))
                {
                    $routeAndParams["route"] = "admin/dashboard";
                }
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
                    
                } elseif ($tab[1] === "product" && !isset($tab[2]))  //////////PRODUCT
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
                    
                } elseif ($tab[1] === "album" && !isset($tab[2]))   //////////ALBUM
                {
                    $routeAndParams["route"] = "admin/album";
                    
                } elseif ($tab[1] === "album" && $tab[2] === "create") 
                {
                    $routeAndParams["route"] = "admin/album/create";
                    
                } elseif ($tab[1] === "album" && $tab[2] === "addSong" && isset($_GET["id"])) 
                {
                    $routeAndParams["route"] = "admin/album/addSong";
                    $routeAndParams["albumId"] = $_GET["id"];
                    
                } elseif ($tab[1] === "album" && $tab[2] === "deleteSong" && isset($_GET["id"])) 
                {
                    $routeAndParams["route"] = "admin/album/deleteSong";
                    $routeAndParams["albumId"] = $_GET["id"];
                } elseif ($tab[1] === "album" && $tab[2] === "edit" && isset($_GET["id"])) 
                {
                    $routeAndParams["route"] = "admin/album/edit";
                    $routeAndParams["albumId"] = $_GET["id"];
                } elseif ($tab[1] === "album" && $tab[2] === "delete" && isset($_GET["id"])) 
                {
                    $routeAndParams["route"] = "admin/album/delete";
                    $routeAndParams["albumId"] = $_GET["id"];
                } elseif ($tab[1] === "artist" && !isset($tab[2])) // Penser à faire des condition plus précise
                {
                    $routeAndParams["route"] = "admin/artist";
                } elseif ($tab[1] === "artist" && $tab[2] === "create") 
                {
                    $routeAndParams["route"] = "admin/artist/create";
                } elseif ($tab[1] === "artist" && $tab[2] === "edit" && isset($_GET["id"])) 
                {
                    $routeAndParams["route"] = "admin/artist/edit";
                    $routeAndParams["artistId"] = $_GET["id"];
                } elseif ($tab[1] === "artist" && $tab[2] === "delete" && isset($_GET["id"])) 
                {
                    $routeAndParams["route"] = "admin/artist/delete";
                    $routeAndParams["artistId"] = $_GET["id"];
                } elseif ($tab[1] === "post" && !isset($tab[2]))  //////////POST
                {
                    $routeAndParams["route"] = "admin/post";
                } elseif ($tab[1] === "post" && $tab[2] === "create") 
                {
                    $routeAndParams["route"] = "admin/post/create";
                } elseif ($tab[1] === "post" && $tab[2] === "edit" && isset($_GET["id"])) 
                {
                    $routeAndParams["route"] = "admin/post/edit";
                    $routeAndParams["artistId"] = $_GET["id"];
                } elseif ($tab[1] === "post" && $tab[2] === "delete" && isset($_GET["id"])) 
                {
                    $routeAndParams["route"] = "admin/post/delete";
                    $routeAndParams["postId"] = $_GET["id"];
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
            // var_dump($routeAndParams);
            // die();
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
            } elseif ($routeAndParams["route"] === "post") {
                $this->postController->postIndex();
            }
            
            else if (isset($_SESSION["role"]) && $_SESSION["role"] === "Admin") 
            {
                if($routeAndParams["route"] === "admin/dashboard")
                {
                    $this->adminController->dashboard();
                }
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
                    $this->productController->createProduct();
                } elseif ($routeAndParams["route"] === "admin/product/edit" && isset($_GET['id'])) 
                {
                    $this->productController->editProduct($_GET['id']);
                } elseif ($routeAndParams["route"] === "admin/product/delete" && isset($_GET['id'])) 
                {
                    $this->productController->deleteProduct($_GET['id']);
                }
                // ADMIN | ALBUM \\
                elseif ($routeAndParams["route"] === "admin/album") 
                {
                    $this->adminController->manageAlbum();
                } elseif ($routeAndParams["route"] === "admin/album/create") 
                {
                    $this->albumController->addAlbum();   
                } elseif ($routeAndParams["route"] === "admin/album/addSong" && isset($_GET['id'])) 
                {
                    $this->albumController->addSong($_GET['id']);   
                } elseif ($routeAndParams["route"] === "admin/album/deleteSong" && isset($_POST['id'])) 
                {
                    $this->albumController->deleteSong($_POST['id']);
                } elseif ($routeAndParams["route"] === "admin/album/edit" && isset($_GET['id'])) 
                {
                    $this->albumController->editAlbum($_GET['id']);
                } elseif ($routeAndParams["route"] === "admin/album/delete" && isset($_GET['id'])) 
                {
                    $this->albumController->deleteAlbum($_GET['id']);
                }
                // ADMIN | ARTIST \\
                elseif ($routeAndParams["route"] === "admin/artist" && !isset($_GET['id'])) 
                {   
                    $this->adminController->manageArtist();
                } elseif ($routeAndParams["route"] === "admin/artist/create") 
                {
                    $this->artistController->createArtist();
                } elseif ($routeAndParams["route"] === "admin/artist/edit" && isset($_GET['id'])) 
                {
                    $this->artistController->editArtist($_GET['id']);
                    
                } elseif ($routeAndParams["route"] === "admin/artist/delete" && isset($_GET['id'])) 
                {
                    $this->artistController->deleteArtist($_GET['id']);
                }
                // ADMIN | POST \\
                elseif ($routeAndParams["route"] === "admin/post" && !isset($_GET['id'])) 
                {   
                    $this->adminController->managePost();
                } elseif ($routeAndParams["route"] === "admin/post/create") 
                {
                    $this->postController->createPost();
                } elseif ($routeAndParams["route"] === "admin/post/edit" && isset($_GET['id'])) 
                {
                    $this->postController->editPost($_GET['id']);
                    
                } elseif ($routeAndParams["route"] === "admin/post/delete" && isset($_GET['id'])) 
                {
                    $this->postController->deletePost($_GET['id']);
                }
                
            }
        }
    }
    
    
    
}
?>