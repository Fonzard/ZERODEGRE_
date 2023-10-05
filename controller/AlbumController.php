<?php
class AlbumController extends AbstractController{
    
    private AlbumManager $am;
    private ArtistManager $artistManager;
    private FeaturingManager $fm;
    private MediaController $mc;
    private MediaManager $mm;
    private SongManager $sm;
    
    public function __construct()
    {
        $this->am = new AlbumManager();
        $this->artistManager = new ArtistManager();
        $this->fm = new FeaturingManager();
        $this->mc = new MediaController();
        $this->mm = new MediaManager();
        $this->sm = new SongManager();
    }
    
    public function createAlbumWithSongs($albumData, $songsData) {
        
        $album = new Album($albumData['titre'], $albumData['year'], $albumData['info'], $albumData['media_id']);
        $createdAlbum = $this->am->add($album);

        foreach ($songsData as $songData) {
            $song = new Song($songData['title'], $songData['duration'], $songData['url'], $createdAlbum->getId());
            $this->sm->add($song);
        }

        return $createdAlbum;
    }
    
    public function getAlbumWithSongs($albumId) 
    {
        // Je récupère les informations de l'album 
        $album = $this->am->getAlbumById($albumId); 
    
        if ($album) 
        {
            // Si l'album existe, je tente de récupérer toutes les chansons associées à cet album
            $songs = $this->sm->getAllSongInAlbum($albumId); 
    
            if ($songs === null) 
            {
                // Si aucune chanson n'est associée à l'album, je définis la liste des chansons de l'album comme vide
                $album->setSongs([]);
            } else {
                // Sinon, j'attribue la liste des chansons à l'album
                $album->setSongs($songs); 
            }
    
            // Je renvoie l'objet album avec ou sans chansons, en fonction des résultats de la recherche
            return $album; 
        }
        // Si l'album n'existe pas, je renvoie null
        return $album; 
    }


    // Fonction pour récupérer un album avec ses featuring
    public function getAlbumWithFeat($albumId)
    {
        // Je récupère les informations de l'album 
        $album = $this->am->getAlbumById($albumId);
    
        if ($album) 
        {
            // Je tente de récupérer tous les featurings de l'album
            $feats = $this->fm->getAllFeatInAlbum($albumId);
            $featName = [];
    
            foreach ($feats as $feat) 
            {
                // Pour chaque artiste invité, je récupère son nom en utilisant son id
                $artistId = $feat->getArtistId();
                $featName[] = $this->artistManager->getArtistById($artistId);
            }
    
            if ($feats === null) 
            {
                // Si aucun artiste invité n'est trouvé, j'initialise la liste des feats de l'album comme vide
                $album->setFeats([]);
            } else {
                // Sinon, j'attribue la liste des feats à l'album
                $album->setFeats($featName); 
            }
    
            // Je renvoie l'objet album avec la liste des feats
            return $album;
        }
        // Si l'album n'existe pas, je renvoie null
        return $album;
    }
    
    // Fonction pour récupérer un album avec ses chansons et ses feauturing
    public function getAlbumWithSongsAndFeats($albumId) 
    {
        // Je récupère les informations de l'album 
        $album = $this->am->getAlbumById($albumId);
    
        if ($album) 
        {
            // Je tente de récupérer toutes les chansons de l'album.
            $songs = $this->sm->getAllSongInAlbum($albumId);
            $feats = $this->fm->getAllFeatInAlbum($albumId);
    
            if ($songs === null) 
            {
                // Si aucune chanson n'est trouvée, j'initialise la liste des chansons de l'album comme vide.
                $album->setSongs([]);
            } else {
                // Sinon, j'attribue la liste des chansons à l'album.
                $album->setSongs($songs); 
            }
    
            $featName = [];
    
            foreach ($feats as $feat) 
            {
                // Pour chaque artiste invité, je récupère son nom en utilisant son id
                $artistId = $feat->getArtistId();
                $featName[] = $this->artistManager->getArtistById($artistId);
            }
    
            if ($feats === null) 
            {
                // Si aucun artiste invité n'est trouvé, j'initialise la liste des feats de l'album comme vide.
                $album->setFeats([]);
            } else {
                // Sinon, j'attribue la liste des feats à l'album
                $album->setFeats($featName); 
            }
    
            // Je renvoie l'objet album avec la liste des chansons et des feats
            return $album; 
        }
    
        // Si l'album n'existe pas, je renvoie null.
        return $album; 
    }

    public function albumIndex()
    {
        $albums = $this->am->getAllAlbum();
        if (empty($albums)) {
        
            $_SESSION['message'] = "Aucun album n'a été trouvé en base de données.";
            header("location: /ZERODEGRE_/album");
            return;
        }
        $albumsWithMedias = [];
        
        foreach($albums as $album)
        {
            $albumWithMedias = $this->mc->getAlbumWithMedia($album->getId());
            if ($albumWithMedias === null) {
                
                $_SESSION['message'] = "Aucun média n'est associé à cet album en base de données.";
                header("location: /ZERODEGRE_/post");
                return;
            } else {
                $albumsWithMedias[] = $albumWithMedias;
            }
        }
        $this->render("album/index", ["albumWithMedia" => $albumsWithMedias]);
    }
    
    public function show($albumId)
    {
        $albumWithSongs = $this->getAlbumWithSongs($albumId);
        if ($albumWithSongs === null) 
        {
            $_SESSIONS['message'] = "Aucune chanson n'est associée à cette album en base de données.";
            header("location: /ZERODEGRE_/album");
        }
        
        $albumWithMedias = $this->mc->getAlbumWithMedia($albumId);
        if ($albumWithMedias === null) 
        {
            $_SESSION['message'] = "Aucun média n'est associé à cet album en base de données.";
            header("location: /ZERODEGRE_/album");
            return;
        } 
        
        $artistInAlbum = $this->artistManager->getArtistsByAlbumId($albumId);
        if ($artistInAlbum === null) 
        {
            $_SESSION['message'] = "Aucun artiste n'est associé à cet album en base de données.";
            header("location: /ZERODEGRE_/album");
            return;
        } 
        
        $featInAlbum = $this->getAlbumWithFeat($albumId);
        $feats = $featInAlbum->getFeats();
        
        $this->render("album/show", ["albumWithSongs" => $albumWithSongs, "albumWithMedias" => $albumWithMedias, "artistInAlbum" => $artistInAlbum, "feats" => $feats]);
    }

    public function AddAlbum()
    {

        if (isset($_POST["album-form"]) && $_POST["album-form"] === "submit") 
        {
            // Récupérer les données du formulaire
            $titre = $this->clean($_POST['album-title']);
            $year = $this->clean($_POST['album-year']);
            $info = $this->clean($_POST['album-info']);
            $artistId = $this->clean($_POST['associated-artist']);
            $mediaUrl = $this->clean($_POST['album-url']);
            $mediaAltText = $this->clean($_POST['album-altText']);
        
            $media = new Media($mediaUrl, $mediaAltText);
            $this->mm->insertMedia($media);
            $mediaId = $media->getid();
            
                
            $newAlbum = new Album($titre, $year, $info, $mediaId); 
            // Ajouter l'album à la base de données
            $addedAlbum = $this->am->add($newAlbum);

            $this->artistManager->associateArtistAlbum($artistId, $addedAlbum->getId());

            if ($addedAlbum) 
            {
                header("location: /ZERODEGRE_/admin/album");
                $_SESSION['message'] = "L'album ". $titre ." a bien été créé";
            } else {
                header("location: /ZERODEGRE_/admin/album/create");
                $_SESSION['message'] = "Erreur pour la création d'album, veuillez recommencer.";
            }
        } else {
            $artists =$this->artistManager->getAllArtists();
            $this->render("admin/album/create_album", ["artist" => $artists]);
        }
    }
    // GOOOOOOOOOOOOOD
    public function addSong($albumId)
    {
        if (isset($_POST["song-form"]) && $_POST["song-form"] === "submit") 
        {
            // Je récupère les données du formulaire
            $title = $this->clean($_POST['songTitle']);
            $duration = $this->clean($_POST['songDuration']);
            $url = $this->clean($_POST['songUrl']);
            $albumId = $this->clean($_POST['albumId']);
        
            // Je créer un nouvel objet Song
            $newSong = new Song ($title, $duration, $url, $albumId);
        
            // J'ajouter la chanson à la base de données
            $addedSong = $this->sm->add($newSong);

            if ($addedSong) {
                $_SESSION['message'] = $title ." ajoutée avec succès!";
                header ("location: /ZERODEGRE_/admin/album");
            } else {
                $_SESSION['message'] = "Erreur lors de l'ajout de la chanson.";
            }
        } else {
            $album = $this->am->getAlbumById($albumId);
            $albums = $this->am->getAllAlbum();
            $this->render("admin/album/create_song", ["album" => $album, "albums" => $albums]);
        }
    }
    //GOOOOOOOOOOOOOOOOOD Album et Média
    public function editAlbum($albumId)
    {
        
        if (isset($_POST["album-edit-form"]) && $_POST["album-edit-form"] === "edit") 
        {
            $titre = $this->clean($_POST['album-title']);
            $year = $this->clean($_POST['album-year']);
            $info = $this->clean($_POST['album-info']);
            $mediaUrl = $this->clean($_POST['album-url']);
            $mediaAltText = $this->clean($_POST['album-altText']);
            $errors = [];
    
            if (!isset($titre))
            {
                $errors[] = "Veuillez saisir votre titre.";
            }
            if (!isset($year))
            {
                $errors[] = "Veuillez choisir une date";
            }
   
            if (!$errors) {

                    if (isset($_POST['albumMediaId'])) 
                    {
                        $mediaId = $_POST['albumMediaId'];
                        $media = $this->mm->getMediaById($mediaId);
                        
                        $media->setUrl($mediaUrl);
                        $media->setAltText($mediaAltText);
                        $this->mm->editMedia($media);
                        $editedMedia = $this->mm->getMediaById($media->getId());

                    } else {
                        $media = new Media($mediaUrl, $mediaAltText);
                        $this->mm->insertMedia($media);
                        $mediaId = $media->getid();
                        $editedMedia = $this->mm->getMediaById($mediaId);
                        
                    }
                
                $album = $this->am->getAlbumById($albumId);
                
                $album->setTitre($titre);
                $album->setYear($year);
                $album->setInfo($info);
                $album->setMediaId($editedMedia->getId());
                $this->am->edit($album);
                
                $_SESSION['message'] = "L'album a bien été modifié";
                header("Location: /ZERODEGRE_/admin/album");

            } else {
                 $this->render("admin/album/edit", [
                     "errors" => $errors
                     ]);
            }
            
        } else {
            $album = $this->am->getAlbumById($albumId);
            $songAlbum = $this->sm->getAllSongInAlbum($albumId);
            $mediaId = $album->getMediaId();
            $media = $this->mm->getMediaById($mediaId);
            $this->render("admin/album/edit", ["album" => $album, "media" => $media, "song" =>$songAlbum]);
        }
    }

    public function deleteAlbum()
    {
        if(isset($_GET['id']))
        {
            $albumId = $_GET['id'];
            // Permet de supprimer le lien entre l'artist et l'album en BDD
            $this->am->deleteArtistAssociate($albumId);
            $this->am->delete($albumId);
            $_SESSION["message"] = "L'album a été supprimé avec succès.";
            header('location: /ZERODEGRE_/admin/album');
        } else {
            $_SESSION["message"] = "L'album n'a pas été supprimé.";
            header('location: /ZERODEGRE_/admin/album');
        }
    }
    
    public function deleteSong()
    {
        if(isset($_GET['id']))
        {
            $songId = $_GET['id'];
            $this->sm->delete($songId);
            $_SESSION["message"] = "La musique a été supprimé avec succès.";
            header('location: /ZERODEGRE_/admin/album');
        } else {
            $_SESSION["message"] = "Le son n'a pas été supprimé.";
            header('location: /ZERODEGRE_/admin/album');
        }
    }
    
}
?>