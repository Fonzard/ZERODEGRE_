<?php
class AlbumController extends AbstractController{
    
    private AlbumManager $am;
    private SongManager $sm;
    private MediaManager $mm;
    
    public function __construct()
    {
        $this->am = new AlbumManager();
        $this->sm = new SongManager();
        $this->mm = new MediaManager();
    }
    
    public function createAlbumWithSongs($albumData, $songsData) {
        
        $album = new Album($albumData['titre'], $albumData['year'], $albumData['media_id']);
        $createdAlbum = $this->albumManager->add($album);

        foreach ($songsData as $songData) {
            $song = new Song($songData['title'], $songData['duration'], $songData['url'], $createdAlbum->getId());
            $this->songManager->add($song);
        }

        return $createdAlbum;
    }
    
    public function getAlbumWithSongs($albumId) {
        
        $album = $this->am->getAlbumById($albumId); 
        
        if ($album) 
        {
            $songs = $this->sm->getAllSongInAlbum($albumId); 
           
            if (count($songs) === 0) 
            {
                // Aucune chanson associée à l'album, renvoyer null
                return null;
            }
            $album->setSongs($songs); 
            return $album; 
        }
        
        return null; 
    }
    
    public function AddAlbum()
    {

        if (isset($_POST["album-form"]) && $_POST["album-form"] === "submit") 
        {
            // Récupérer les données du formulaire
            $titre = $this->clean($_POST['albumTitle']);
            $year = $this->clean($_POST['albumYear']);
            $mediaUrl = $this->clean($_POST['albumMediaUrl']);
            $mediaAltText = $this->clean($_POST['albumMediaAltText']);
        
            // Créer un nouvel objet Album
            $newAlbum = new Album($titre, $year); 
        
            // Vérifier si le média existe déjà dans la base de données
            $mediaId = $this->mm->getMediaIdByUrl($mediaUrl);
            
            if (!$mediaId) {
                // Créer un nouvel objet Media
                $newMedia = new Media($mediaUrl, $mediaAltText);
                
                // Ajouter le média à la base de données
                $addedMedia = $this->mm->insertMedia($newMedia);
                
                if (!$addedMedia) {
                    //JE ne suis pas sur du rendu :/
                    $_SESSION['message'] = "Erreur lors de l'ajout du média.";
                } else {
                    // Associé le média nouvellement créé à l'album
                    $newAlbum->setMediaId($addedMedia->getId());
                }
            } else {
                // Si le média existe déjà, l'associer directement à l'album
                $newAlbum->setMediaId($mediaId);
            }
        
            // Ajouter l'album à la base de données
            $addedAlbum = $this->am->add($newAlbum);
        
            if ($addedAlbum) 
            {
                header("location: /ZERODEGRE_/admin/album");
                $_SESSION['message'] = "L'album". $name ." a bien été créé";
            } else {
                header("location: /ZERODEGRE_/admin/album/create");
                $_SESSION['message'] = "Erreur pour la création d'album, veuillez recommencer.";
            }
        }
    }
    
    public function addSong($albumId)
    {
        if (isset($_POST["song-form"]) && $_POST["song-form"] === "submit") 
        {
            // Récupérer les données du formulaire
            $title = $this->clean($_POST['songTitle']);
            $duration = $_POST['songDuration'];
            $url = $_POST['songUrl'];
            $albumId = $_POST['albumSelect'];
        
            // Créer un nouvel objet Song
            $newSong = new Song($title, $duration, $url, $albumId);
        
            // Ajouter la chanson à la base de données
            $addedSong = $this->sm->add($newSong);

            if ($addedSong) {
                $_SESSION['message'] = $title ."ajoutée avec succès!";
                // header ("location: ")
            } else {
                $_SESSION['message'] = "Erreur lors de l'ajout de la chanson.";
            }
        } else {
            $album = $this->am->getAlbumById($albumId);
            $albums = $this->am->getAllAlbum();;
            $this->render("admin/album/create_song", ["album" => $album, "albums" => $albums]);
        }
    }
    
    public function editAlbum($albumId)
    {
        if (isset($_POST["album-edit-form"]) && $_POST["album-edit-form"] === "submit") 
        {
            // Récupérer les données du formulaire
            $titre = $this->clean($_POST['albumTitle']);
            $year = $this->clean($_POST['albumYear']);
            $mediaUrl = $this->clean($_POST['albumMediaUrl']);
            $mediaAltText = $this->clean($_POST['albumMediaAltText']);
            
            $editedAlbum = new Album($titre, $year);
    
            // Set the ID of the album
            $editedAlbum->setId($albumId);
    
            if (!$mediaId) {
                // Create a new Media object
                $newMedia = new Media($mediaUrl, $mediaAltText);
                
                // Add the media to the database
                $addedMedia = $this->mm->insertMedia($newMedia);
                
                if (!$addedMedia) {
                    // I'm not sure about the rendering :/
                    $_SESSION['message'] = "Error adding the media.";
                } else {
                    // Associate the newly created media with the album
                    $editedAlbum->setMediaId($addedMedia->getId());
                }
            } else {
                // If the media already exists, associate it directly with the album
                $editedAlbum->setMediaId($mediaId);
            }
            
            // Update the album in the database
            $updatedAlbum = $this->am->edit($editedAlbum);
    
            if ($updatedAlbum) 
            {
                $_SESSION['message'] = "L'album a été modifié avec succès!";
                header("location: /ZERODEGRE_/admin/album");
            } else {
                $_SESSION['message'] = "Erreur lors de la modification de l'album.";
            }
        } else {
            $album = $this->am->getAlbumById($albumId);
            $songAlbum = $this->sm->getAllSongInAlbum($albumId);
            $mediaId = $album->getMediaId();
            $media = $this->mm->getMediaById($mediaId);
            $this->render("admin/album/edit", ["album" => $album, "media" => $media, "song" =>$songAlbum]);
        }
    }
    // A vérifier
    public function deleteAlbum()
    {
        if(isset($_GET['id']))
        {
            $album = $_GET['id'];
            $this->am->delete($productId);
            $newAlbumList = $this->pm->getAllAlbum();
            // Ne marche pas, Prendre le temps de trouver la soluce !!!!!!!!
                if (empty($newAlbumList)) {
                    echo json_encode(array("success" => false, "message" => "Aucun album disponible."));
                } else {
                    $responseData = array('success' => true, 'message' => 'Album supprimé avec succès.', 'album' => $newAlbumList);
                    echo json_encode($responseData);
                }
        } else {
            echo json_encode(array("success" => false, "message" => "L'album n'a pas été supprimé."));
        }
    }
    
    public function deleteSong($albumId)
    {
        if(isset($_POST["song-delete-form"]) && $_POST["song-delete-form"] === "submit")
        {
            $songId = $_POST["songIdList"];
            $this->sm->delete($songId);
            $newSongList = $this->sm->getAllSongInAlbum($albumId);
            
            // Ne marche pas, Prendre le temps de trouver la soluce !!!!!!!!
            if (empty($newAlbumList)) {
                echo json_encode(array("success" => false, "message" => "Aucune musique disponible."));
            } else {
                $responseData = array('success' => true, 'message' => 'Musique supprimé avec succès.', 'song' => $newSongList);
                echo json_encode($responseData);
            }
            
        } else {
            echo json_encode(array("success" => false, "message" => "La musique n'a pas été supprimé."));
        }
    }
    
}
?>