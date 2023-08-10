<?php
class HomeController extends AbstractController
{
    // private AlbumManager $albumManager;
    // private PostManager $postManager;
    // private ProductManager $productManager;

    public function __construct()
    {
        // $this->albumManager = new AlbumManager();
        // $this->productManager = new ProductManager();
        // $this->postManager = new PostManager();
        
    }

    public function index()
    {
        
        $template = "partials/homepage";
        require "templates/layout.phtml";
        // if(isset($_SESSION["user"]))
        // {
        //     $this->render("/");
        // }
        // else
        // {
        //     header("Location:/login");
        // }
    }
}
?>