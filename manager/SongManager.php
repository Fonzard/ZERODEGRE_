<?php
class SongManager extends AbstractManager {
    
    public function getAllSong() : array
    {
        $class = "Song";
        $query = ("SELECT * FROM song");
        $results = $this->getResult($query, null, $class, false);
        return $results;
    }
    
    public function getAllSongInAlbum($albumId)
    {
        $class = "Song";
        $query = "SELECT * FROM song WHERE album.id = :album_id";
        $parameters = array("album_id" => $albumId);
        $results = $this->getResult($query,$parameters, $class, false);
        return $results;
    }
    
    public function add(Song $song) : ?Song
    {
        $query = "INSERT INTO song(title, duration, url, album_id) VALUES (:title, :duration, :url, :album_id)";
        $parameters = array("title" => $song->getTitle(), "duration" => $song->getDuration(), "url" => $song->getUrl(), "album_id" => $song->getAlbumId());
        
        $this->getQuery($query, $parameters);
        
        $lastInsertId = $this->connex->lastInsertId();
        
        $song->setId($lastInsertId);
        return $song;
    }
    
    //Voir si il est possible de suprimer directement un album avec tous les sons qui le compose
    public function delete(int $songId): void
    {
        $query = "DELETE FROM song WHERE id = :id";
        $parameters = array("id" => $songId);
        
        $this->getQuery($query, $parameters, true);
    }
    
    public function edit(Product $song) : void
    {
        $query ="UPDATE song SET title = :title, duration = :duration, url = :url, album_id = :album_id WHERE song.id = :id";
        $parameters = array("title" => $song->getTitle(), "duration" => $song->getDuration(), "url" => $song->getUrl(), "album_id" => $song->getAlbumId(), "id" => $song->getId());
        
        $this->getQuery($query, $parameters);
    }

}
?>