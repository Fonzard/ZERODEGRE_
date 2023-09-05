<?php
class ArtistController extends AbstractController {
    
    private ArtistManager $am;
    private AlbumManager $alm;
    private MediaManager $mm;
    
    public function __construct ()
    {
        $this->am = new ArtistManager();
        $this->alm = new AlbumManager();
        $this->mm = new MediaManager();
    }

    public function getArtistWithAlbums($artistId) 
    {
        
        $artist = $this->am->getArtistById($artistId); 
        
        if ($artist) 
        {
            $albums = $this->alm->getAllAlbumOfArtist($artistId); 
            if ($albums === null) 
            {
                // Aucun album associée à l'artiste, renvoit tableau vide
                $artist->setAlbums(null);
            } else {
                $artistWithAlbum = $artist;
                var_dump($artistWithAlbum);

                foreach($albums as $album)
                {
                    
                    echo "wessh";
                    $artistWithAlbum->setAlbums($album); 
                }
                
            }
            var_dump($artistWithAlbum);
            
            return $artistWithAlbum; 
        }
        
        return $artist; 
    }
    // GOOOOOOOOD
    public function editArtist($artistId)
    {
        if (isset($_POST["artist-edit-form"]) && $_POST["artist-edit-form"] === "submit") 
        {
            // Récupérer les données du formulaire
            $name = $this->clean($_POST['artistName']);
            $description = $this->clean($_POST['artistDescription']);
            $mediaUrl = $this->clean($_POST['artistMediaUrl']);
            $mediaAltText = $this->clean($_POST['artistMediaAltText']);
    
            if (isset($_POST['artistMediaId'])) 
            {
                $mediaId = $_POST['artistMediaId'];
                $media = $this->mm->getMediaById($mediaId);
                
                $media->setUrl($mediaUrl);
                $media->setAltText($mediaAltText);
                $this->mm->editMedia($media);
                $editedMedia = $this->mm->getMediaById($media->getId());
                
            } else {
                $media = new Media($mediaUrl, $mediaAltText);
                $this->mm->insertMedia($media);
                $mediaId = $media->getid();
                $editedArtist = $this->mm->getMediaById($mediaId);
            }
            
            $editedArtist = new Artist($name, $description, $mediaId);
            // Set the ID of the album
            $editedArtist->setId($artistId);
            // Update the album in the database
            $updatedArtist = $this->am->editArtist($editedArtist);

            $_SESSION['message'] = "L'artiste a été modifié avec succès!";
            header("location: /ZERODEGRE_/admin/artist");

        } else {
            $artist = $this->am->getArtistById($artistId);
            $mediaId = $artist->getMediaId();
            $media = $this->mm->getMediaById($mediaId);
            $this->render("admin/artist/edit", ["artist" => $artist, "media" => $media]);
        }
    }

    public function createArtist()
    {    
        if (isset($_POST["artist-form"]) && $_POST["artist-form"] === "submit") {
            var_dump("yooooo");
            $name = $this->clean($_POST['name']);
            $description =$this->clean( $_POST['description']);
            $mediaUrl = $this->clean($_POST['mediaUrl']);
            $mediaAltText = $this->clean($_POST['mediaAltText']);
            
            $media = new Media($mediaUrl, $mediaAltText);
            $this->mm->insertMedia($media);
            
            $mediaId = $media->getId();
            
            var_dump($media);
            $newArtist = new Artist($name, $description, $mediaId);
            var_dump($newArtist);
            $this->am->create($newArtist);
            
            $_SESSION['message'] = "L'artiste ". $name ." créé avec succès.";
            header("location: /ZERODEGRE_/admin/artist");
        } else {
            var_dump("wesshhhh");
            $this->render("admin/artist/create", []);
        }
    }
    // A vérifier 
    public function deleteArtist()
    {
        if(isset($_GET['id']))
        {
            $artistId = $_GET['id'];
            $this->am->deleteArtist($artistId);
            $newArtistList = $this->am->getAllArtists();
            
            // Ne marche pas, Prendre le temps de trouver la soluce !!!!!!!!
                if (empty($newArtistList)) {
                    echo json_encode(array("success" => false, "message" => "Aucun produit disponible."));
                } else {
                    $responseData = array('success' => true, 'message' => 'Produit supprimé avec succès.', 'artists' => $newArtistList);
                    echo json_encode($responseData);
                }
        } else {
            echo json_encode(array("success" => false, "message" => "Le produit n'a pas été supprimé."));
        }
    }
}
?>