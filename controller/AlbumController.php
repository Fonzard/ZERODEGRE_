<?php
class AlbumController extends AbstractController{
    
    private AlbumManager $am;
    private ArtistManager $artistManager;
    private SongManager $sm;
    private MediaManager $mm;
    
    public function __construct()
    {
        $this->am = new AlbumManager();
        $this->artistManager = new ArtistManager();
        $this->sm = new SongManager();
        $this->mm = new MediaManager();
    }
    
    public function createAlbumWithSongs($albumData, $songsData) {
        
        $album = new Album($albumData['titre'], $albumData['year'], $albumData['media_id']);
        $createdAlbum = $this->am->add($album);

        foreach ($songsData as $songData) {
            $song = new Song($songData['title'], $songData['duration'], $songData['url'], $createdAlbum->getId());
            $this->sm->add($song);
        }

        return $createdAlbum;
    }
    
    public function getAlbumWithSongs($albumId) 
    {
        
        $album = $this->am->getAlbumById($albumId); 
        
        if ($album) 
        {
            $songs = $this->sm->getAllSongInAlbum($albumId); 
            if ($songs === null) 
            {
                // Aucune chanson associée à l'album, renvoyer null
                $album->setSongs([]);
            } else {
                $album->setSongs($songs); 
            }
            
            return $album; 
        }
        return $album; 
    }
    
    public function AddAlbum()
    {

        if (isset($_POST["album-form"]) && $_POST["album-form"] === "submit") 
        {
            // Récupérer les données du formulaire
            $titre = $this->clean($_POST['album-title']);
            $year = $this->clean($_POST['album-year']);
            $artistId = $this->clean($_POST['associated-artist']);
            $mediaUrl = $this->clean($_POST['album-url']);
            $mediaAltText = $this->clean($_POST['album-altText']);
        
            // Vérifier si le média existe déjà dans la base de données
            $mediaId = $this->mm->getMediaIdByUrl($mediaUrl);
            if ($mediaId === false) {
                // Créer un nouvel objet Media
                $media = new Media($mediaUrl, $mediaAltText);
                $this->mm->insertMedia($media);
                $mediaId = $media->getid();
                $editedMedia = $this->mm->getMediaById($mediaId);
            } else {
                $media = $this->mm->getMediaById($mediaId);
                $media->setUrl($mediaUrl);
                $media->setAltText($mediaAltText);
                $this->mm->editMedia($media);
                $editedMedia = $this->mm->getMediaById($media->getId());
            }
            
            $newAlbum = new Album($titre, $year, $editedMedia->getId()); 
            // Ajouter l'album à la base de données
            $addedAlbum = $this->am->add($newAlbum);

            $this->artistManager->associateArtistAlbum($artistId, $addedAlbum->getId());

            if ($addedAlbum) 
            {
                header("location: /ZERODEGRE_/admin/album");
                $_SESSION['message'] = "L'album". $titre ." a bien été créé";
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
                $_SESSION['message'] = $title ." ajoutée avec succès!";
                header ("location: /ZERODEGRE_/admin/album");
            } else {
                $_SESSION['message'] = "Erreur lors de l'ajout de la chanson.";
            }
        } else {
            $album = $this->am->getAlbumById($albumId);
            $albums = $this->am->getAllAlbum();;
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
                $album->setMediaId($editedMedia->getId());
                $this->am->edit($album);
                
                // Redirect to the manage album
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
    // A vérifier
    public function deleteAlbum()
    {
        if(isset($_GET['id']))
        {
            $albumId = $_GET['id'];
            $this->am->delete($albumId);
            $newAlbumList = $this->am->getAllAlbum();
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
    // A vérifier ET réfléchir à l'utilité du fetch pour un musique
    public function deleteSong()
    {

        if(isset($_GET['id']))
        {
            $songId = $_GET['id'];
            $this->sm->delete($songId);
            $newSongList = $this->sm->getAllSong();
            
            // Ne marche pas, Prendre le temps de trouver la soluce !!!!!!!!
                if (empty($newSongList)) {
                    echo json_encode(array("success" => false, "message" => "Aucun produit disponible."));
                } else {
                    $responseData = array('success' => true, 'message' => 'Produit supprimé avec succès.', 'song' => $newSongList);
                    echo json_encode($responseData);
                }
        } else {
            echo json_encode(array("success" => false, "message" => "Le produit n'a pas été supprimé."));
        }
    }
    
}
?>