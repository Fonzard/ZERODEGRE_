<?php
class ArtistManager extends AbstractManager {

    public function getAllArtists() {
        $class = "Artist";
        $query = "SELECT * FROM artists";
        return $this->getResult($query, null, $class);
    }

    public function getArtistById($artistId) {
        $class = "Artist";
        $query = "SELECT * FROM artists WHERE id = ?";
        $parameters = array("artistId" => $artistId);
        return $this->getResult($query, $parameters, $class, true);
    }

    public function createArtist(Artist $artist) 
    {
        $class = "Artist";
        $query = "INSERT INTO artists (name, description, media_id) VALUES (:name, :description, :media_id)";
        $parameters = array("name" => $artist->getName(), "description" => $artist->getDescription(), "media_id" => $artist->getMediaId());
        $this->getQuery($query, $parameters);

        $lastInsertId = $this->connex->lastInsertId();
        
        // A vérifier !!!
        $artist->setId($lastInsertId);
        return $artist;
    }

    public function editArtist(Artist $artist) {
        $query = "UPDATE artists SET name = ?, description = ?, media_id = ? WHERE id = ?";
        $parameters = [$artist->getName(), $artist->getDescription(), $artist->getMediaId(), $artist->getId()];
        return $this->executeQuery($query, $parameters);
    }

    public function deleteArtist($artistId) {
        $query = "DELETE FROM artists WHERE id = ?";
        return $this->executeQuery($query, [$artistId]);
    }
}

?>