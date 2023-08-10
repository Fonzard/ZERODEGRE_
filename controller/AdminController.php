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
    
    public function manageUser()
    {
        $users = $this->userManager->getAllUsers();
        $this->render("admin/user/manage_user", ["users" => $users]);
    }
    
    public function deleteUser($userId)
    {
        // if(!$this->isAdmin()){
            //redirige vers une page d'erreur ou de refus 
        // }
        
        $userManager->delete($userId);
        $this->render("admin/user/manage_user", ["users" => $users,
                                                "deleteUserSuccess" => ["L'user à bien été supprimé"]]);
    
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