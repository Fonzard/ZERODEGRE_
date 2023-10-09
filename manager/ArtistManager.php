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
        $query = "SELECT id, name, description, media_id, role_id FROM artists WHERE id = :artistId";
        $parameters = array("artistId" => $artistId);
        return $this->getResult($query, $parameters, $class, true);
    }

    public function getAlbumByArtistId($artistId)
    {
        $class = "Album";
        $query = "SELECT al.id, al.titre, al.year, al.info, al.media_id
        FROM album al
        JOIN artist_album aa ON al.id = aa.album_id
        WHERE aa.artists_id = :artistId;";
        $parameters = array("artistId" => $artistId);
        $results = $this->getResult($query, $parameters, $class, false);
        return $results;
    }
    
    public function getArtistsByAlbumId($albumId)
    {
        $class = "Artist";
        $query = "SELECT artists.id, artists.name, artists.description, artists.media_id, artists.role_id
                  FROM artists
                  JOIN artist_album ON artists.id = artist_album.artists_id
                  WHERE artist_album.album_id = :albumId";
        $parameters = array("albumId" => $albumId);
        $results = $this->getResult($query, $parameters, $class, false);
        return $results;
    }
    
    public function create(Artist $artist) 
    {
        $query = "INSERT INTO artists (name, description, media_id, role_id) VALUES (:name, :description, :media_id, :role_id)";
        $parameters = array("name" => $artist->getName(), "description" => $artist->getDescription(), "media_id" => $artist->getMediaId(), "role_id" => $artist->getRoleId());
        $this->getQuery($query, $parameters, true);

        $lastInsertId = $this->connex->lastInsertId();
        $artist->setId($lastInsertId);
        return $artist;

    }

    public function editArtist(Artist $artist) 
    {
        $query = "UPDATE artists SET name = :name, description = :description, media_id = :media_id, role_id = :role_id WHERE id = :id";
        $parameters = array("name" => $artist->getName(), "description" => $artist->getDescription(), "media_id" => $artist->getMediaId(), "role_id" => $artist->getRoleId(), "id" => $artist->getId());
        $this->getQuery($query, $parameters, true);
    }

    public function deleteArtist($artistId) 
    {
        $query = "DELETE FROM artists WHERE id = :id";
        $parameters = array("id" => $artistId);
        $this->getQuery($query, $parameters, true);
    }

    public function associateArtistAlbum($artistId, $albumId)
    {
        $query = "INSERT INTO artist_album SET artists_id = :artists_id, album_id = :album_id";
        $parameters = array("artists_id" => $artistId, "album_id" => $albumId);
        $this->getQuery($query, $parameters, true);
    }
}

?>