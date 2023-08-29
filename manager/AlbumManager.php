<?php
class AlbumManager extends AbstractManager {
 
 
    public function getAllAlbum() : array
    {
        $class = "Album";
        $query = "SELECT * FROM album";
        $results = $this->getResult($query, null, $class, false);
        return $results;
    }
    
    public function getAlbumById($albumId)
    {
        $class = "Album";
        $query = "SELECT * FROM album WHERE id = :id";
        $parameters = array("id" => $albumId);
        $result = $this->getResult($query, $parameters, $class, true);
        return $result;
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