<?php
class Featuring {
    
    private ?int $artist_id;
    private ?int $album_id;

    public function __construct(?int $artist_id, ?int $album_id) {
        $this->artist_id = $artist_id;
        $this->album_id = $album_id;
    }

    public function getArtistId() : int
    { 
        return $this->artist_id;
    }

    public function getAlbumId() : int
    {
        return $this->album_id;
    }

    public function setArtistId($artist_id) : void
    {
        $this->artist_id = $artist_id;
    }

    public function setAlbumId($album_id) : void
    {
        $this->album_id = $album_id;
    }
}
?>