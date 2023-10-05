<?php 
class MediaController extends AbstractController{
    
    private AlbumManager $am;
    private ArtistManager $artistM;
    private CategoryManager $cm;
    private PostManager $postM;
    private ProductManager $pm;
    private MediaManager $mm;
    
    public function __construct()
    {
        $this->am = new AlbumManager();
        $this->artistM = new ArtistManager();
        $this->cm = new CategoryManager();
        $this->postM = new PostManager();
        $this->pm = new ProductManager();
        $this->mm = new MediaManager();
    }
    
    public function getArtistWithMedia($artistId) 
    {
        
        $artist = $this->artistM->getArtistById($artistId); 
        $mediaId = $artist->getMediaId();
        if ($artist) 
        {
            $medias = $this->mm->getAllMediaInArtist($mediaId); 
            if ($medias === null) 
            {
                // Aucune chanson associée à l'album, renvoyer null
                $artist->setMedia([]);
            } else {
                $artist->setMedia($medias); 
            }
            return $artist; 
        }
        return $artist; 
    }
    
    public function getAlbumWithMedia($albumId) 
    {
        
        $album = $this->am->getAlbumById($albumId); 
        $mediaId = $album->getMediaId();
        if ($album) 
        {
            $medias = $this->mm->getAllMediaInPost($mediaId); 
            if ($medias === null) 
            {
                // Aucune chanson associée à l'album, renvoyer null
                $album->setMedia([]);
            } else {
                $album->setMedia($medias); 
            }
            return $album; 
        }
        return $album; 
    }
    
    public function getPostWithMedia($postId) 
    {
        $post = $this->postM->getPostById($postId); 
        $mediaId = $post->getMediaId();
        if ($post) 
        {
            $medias = $this->mm->getAllMediaInPost($mediaId); 
            if ($medias === null) 
            {
                // Aucune chanson associée à l'album, renvoyer null
                $post->setMedia([]);
            } else {
                $post->setMedia($medias); 
            }
            return $post; 
        }
        return $post; 
    }
    
    public function getProductWithMedia($productId) 
    {
        
        $product = $this->pm->getProductById($productId); 
        $mediaId = $product->getMediaId();
        if ($product) 
        {
            $medias = $this->mm->getAllMediaInPost($mediaId); 
            if ($medias === null) 
            {
                // Aucune chanson associée à l'album, renvoyer null
                $product->setMedia([]);
            } else {
                $product->setMedia($medias); 
            }
            return $product; 
        }
        return $product; 
    }
    
    
}
?>