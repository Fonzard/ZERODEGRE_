<?php
class AlbumManager extends AbstractManager {
 
 
    public function getAllAlbum() : array
    {
        $class = "Album";
        $query = "SELECT id, titre, year, info, media_id FROM album";
        $results = $this->getResult($query, null, $class, false);
        return $results;
    }
    
    public function getAlbumById($albumId) : ? ALbum
    {
        $class = "Album";
        $query = "SELECT id, titre, year, info, media_id FROM album WHERE id = :id";
        $parameters = array("id" => $albumId);
        $result = $this->getResult($query, $parameters, $class, true);
        return $result;
    }

    public function getAllAlbumOfArtist($artistId) 
    {
        $class = "Album";
        $query = "SELECT al.id, al.titre, al.year, al.info, al.media_id
        FROM album al
        JOIN artist_album aa ON al.id = aa.album_id
        WHERE aa.artists_id = :artistId";
        
        $parameters = array("artistId" => $artistId);
        $albums = $this->getResult($query, $parameters, $class, false);
        return $albums;
    }
    
    public function add(Album $album) : ?Album
    {  
        $query = "INSERT INTO album (titre, year, info, media_id) VALUES (:titre, :year, :info, :media_id)";
        $parameters = array("titre" => $album->getTitre(), "year" => $album->getYear(), "info" => $album->getInfo(), "media_id" => $album->getMediaId());
        
        $this->getQuery($query, $parameters, true);
        
        $lastInsertId = $this->connex->lastInsertId();
        
        $album->setId($lastInsertId);
        return $album;
    }
    
    public function delete(int $albumId): void
    {
        $query = "DELETE FROM album WHERE id = :id";
        $parameters = array("id" => $albumId);
        
        $this->getQuery($query, $parameters, true);
    }
    
    public function deleteArtistAssociate($albumId): void
    {
        $query = "DELETE FROM artist_album WHERE album_id = :albumId";
        $parameters = array("albumId" => $albumId);
        
        $this->getQuery($query, $parameters, true);
    }
    
    public function edit(Album $album) : void
    {
        $query ="UPDATE album SET titre = :titre, year = :year, info =:info, media_id = :media_id WHERE id = :id";
        $parameters = array("titre" => $album->getTitre(), "year" => $album->getYear(), "info" => $album->getInfo(), "media_id" => $album->getMediaId(), "id" => $album->getId());
        
        $this->getQuery($query, $parameters);
    } 
 
   
}
?>