<?php
class HomeController extends AbstractController
{
    private AlbumManager $am;
    private PostManager $postManager;
    private MediaController $mediaController;
    private ProductManager $pm;

    public function __construct()
    {
         $this->am = new AlbumManager();
         $this->postManager = new PostManager();
         $this->mc = new MediaController();
         $this->pm = new ProductManager();
        
    }

    public function index()
    {   
        $albums = $this->am->getAllAlbum();
        $albumsWithMedias = [];
        foreach($albums as $album)
        {
            $albumWithMedias = $this->mc->getAlbumWithMedia($album->getId());
            $albumsWithMedias[] = $albumWithMedias;
        }
        
        $posts = $this->postManager->getAllPost();
        $postsWithMedias = [];
        foreach ($posts as $post) 
        {
            $postWithMedias = $this->mc->getPostWithMedia($post->getId());
            $postsWithMedias[] = $postWithMedias;
            
        }
        
        $otherProducts = $this->pm->getAllProducts();
        
        foreach($otherProducts as $otherProduct)
        {
            $productWithMedias = $this->mc->getProductWithMedia($otherProduct->getId());
            $productsWithMedias[] = $productWithMedias;
        }
        
        $this->render("partials/homepage", ["albumsWithMedias" => $albumsWithMedias, "postsWithMedias" => $postsWithMedias, "productsWithMedias" => $productsWithMedias]);
    }
    public function legalNotice()
    {
        $this->render("partials/legal_notice", []);
    }
}
?>