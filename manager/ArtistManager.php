<?php
class ArtistManager extends AbstractManager {

    public function getAllArtists() : array
    {
        $class = "Artist";
        $query = "SELECT * FROM artists";
        $parameters = null;
        $results = $this->getResult($query, $parameters, $class, false);
        return $results;
    }

    public function getArtistById($artistId) : ? Artist
    {
        $class = "Artist";
        $query = "SELECT * FROM artists WHERE id = :artistId";
        $parameters = array("artistId" => $artistId);
        return $this->getResult($query, $parameters, $class, true);
    }

    public function create(Artist $artist) 
    {
        $class = "Artist";
        $query = "INSERT INTO artists (name, description, media_id) VALUES (:name, :description, :media_id)";
        $parameters = array("name" => $artist->getName(), "description" => $artist->getDescription(), "media_id" => $artist->getMediaId());
        $this->getQuery($query, $parameters, true);

        $lastInsertId = $this->connex->lastInsertId();
        $artist->setId($lastInsertId);
        return $artist;
        var_dump($artist);
    }

    public function editArtist(Artist $artist) {
        
        $query = "UPDATE artists SET name = :name, description = :description, media_id = :media_id WHERE id = :id";
        $parameters = array("name" => $artist->getName(), "description" => $artist->getDescription(), "media_id" => $artist->getMediaId(),"id" => $artist->getId());
        $this->getQuery($query, $parameters, true);
    }

    public function deleteArtist($artistId) {
        $query = "DELETE FROM artists WHERE id = :id";
        $parameters = array("id" => $artistId);
        $this->getQuery($query, $parameters, true);
    }
}

?>