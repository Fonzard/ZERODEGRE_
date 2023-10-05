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
        $this->mc = new MediaController();
    }

    public function artistIndex()
    {
        $artists = $this->am->getAllArtists();
        $artistsWithInfo = [];
    
        foreach ($artists as $artist) {
            
            $artistId = $artist->getId();
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
                $albums = $this->alm->getAllAlbumOfArtist($artistId);
                
                if ($albums === null) 
                {
                    // Aucun album associé à l'artiste, renvoie un tableau vide
                    $artist->setAlbums([]);
                } else {
                    // Ajoutez chaque album au tableau des albums de l'artiste
                    $artist->setAlbums($albums); 
                }
                $artistsWithInfo[] = $artist;
            }
        }
    
        $this->render("artist/index", ["artistsWithInfo" => $artistsWithInfo]);
    }


    
    public function getArtistWithAlbums($artistId) 
    {
        $artist = $this->am->getArtistById($artistId); 
    
        if ($artist) 
        {
            $albums = $this->alm->getAllAlbumOfArtist($artistId);
            if ($albums === null) 
            {
                // Aucun album associé à l'artiste, renvoie un tableau vide
                $artist->setAlbums([]);
            } else {
                // Ajoutez chaque album au tableau des albums de l'artiste
                $artist->setAlbums($albums); 
            }
            return $artist; 
        }
        return $artist; 
    }

    // GOOOOOOOOD
    public function editArtist($artistId)
    {
        if (isset($_POST["artist-edit-form"]) && $_POST["artist-edit-form"] === "submit") 
        {
            // Récupérer les données du formulaire
            $name = $this->clean($_POST['artist-name']);
            $description = $this->clean($_POST['artist-description']);
            $roleId = $this->clean($_POST["artist-roleId"]);
            $mediaUrl = $this->clean($_POST['artist-url']);
            $mediaAltText = $this->clean($_POST['artist-altText']);
    
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
            
            $editedArtist = new Artist($name, $description, $mediaId, $roleId);
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
            $name = $this->clean($_POST['name']);
            $description = $this->clean( $_POST['description']);
            $roleId = $this->clean( $_POST['roleId']);
            $mediaUrl = $this->clean($_POST['url']);
            $mediaAltText = $this->clean($_POST['altText']);

            $media = new Media($mediaUrl, $mediaAltText);
            $this->mm->insertMedia($media);
            
            $mediaId = $media->getId();
            
            $newArtist = new Artist($name, $description, $mediaId, $roleId);
            $this->am->create($newArtist);
            
            $_SESSION['message'] = "L'artiste ". $name ." créé avec succès.";
            header("location: /ZERODEGRE_/admin/artist");
        } else {
            
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
            $_SESSION["message"] = "Le produit a été supprimé avec succès.";
            header("location:/ZERODEGRE_/admin/artist");
        } else {
            $_SESSION["message"] = "Le produit n'a pas été supprimé.";
            header("location:/ZERODEGRE_/admin/artist");
        }
    }
}
?>