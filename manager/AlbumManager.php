<?php
class AlbumManager extends AbstractManager {
 
 
    public function getAllAlbum() : array
    {
        $class = "Album";
        $query = "SELECT * FROM album";
        $results = $this->getResult($query, null, $class, false);
        return $results;
    }
    
    public function getAlbumById($albumId) : ? ALbum
    {
        $class = "Album";
        $query = "SELECT * FROM album WHERE id = :id";
        $parameters = array("id" => $albumId);
        $result = $this->getResult($query, $parameters, $class, true);
        return $result;
    }

    public function getArtistByAlbumId($albumId)
    {
        $class = "Artist";
        $query = "SELECT * FROM Artist WHERE id = :albumId";
        $parameters = array ("id" => $albumId);
        $results = $this->getResult($query,$parameters, $class, false);
        return $results;
    }

    public function getAllAlbumOfArtist($artistId) 
    {
        $class = "Album";
        $query = "SELECT al.id, al.titre, al.year, al.media_id
        FROM album al
        JOIN artist_album aa ON al.id = aa.album_id
        WHERE aa.artists_id = :artistId";
        
        $parameters = array("artistId" => $artistId);
        $albums = [];
        $albums[] = $this->getResult($query, $parameters, $class, "Album", false);
        return $albums;
    }
    public function add(Album $album) : ?Album
    {
        $query = "INSERT INTO album(titre, year, media_id) VALUES (:titre, :year, :media_id)";
        $parameters = array("titre" => $album->getTitre(), "year" => $album->getYear(), "media_id" => $album->getMediaId());
        
        $this->getQuery($query, $parameters);
        
        $lastInsertId = $this->connex->lastInsertId();
        
        $album->setId($lastInsertId);
        return $album;
    }
    
    //Voir si il est possible de suprimer directement un album avec tous les sons qui le compose
    public function delete(int $albumId): void
    {
        $query = "DELETE FROM album WHERE id = :id";
        $parameters = array("id" => $albumId);
        
        $this->getQuery($query, $parameters, true);
    }
    
    public function edit(Album $album) : void
    {
        $query ="UPDATE album SET titre = :titre, year = :year, media_id = :media_id WHERE id = :id";
        $parameters = array("titre" => $album->getTitre(), "year" => $album->getYear(), "media_id" => $album->getMediaId(), "id" => $album->getId());
        
        $this->getQuery($query, $parameters);
    } 
 
   
}
?>