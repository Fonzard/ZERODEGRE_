<?php
class Song implements JsonSerializable {
    private ?int $id;
    private string $title;
    private string $duration;
    private string $url;
    private int $albumId;

    public function __construct(string $title, string $duration, string $url, int $albumId) {
        $this->id = null;
        $this->title = $title;
        $this->duration = $duration;
        $this->url = $url;
        $this->album_id = $album_id;
    }

    ////////////  Getters ////////////
    public function getId(): ?int 
    {
        return $this->id;
    }

    public function getTitle(): string 
    {
        return $this->title;
    }

    public function getDuration(): string 
    {
        return $this->duration;
    }

    public function getUrl(): string 
    {
        return $this->url;
    }

    public function getAlbum_id(): int 
    {
        return $this->album_id;
    }

    //////////// Setters ////////////
    public function setId(?int $id) : void
    {
        $this->id =$id;
    }
    
    public function setTitle(string $title): void 
    {
        $this->title = $title;
    }

    public function setDuration(string $duration): void 
    {
        $this->duration = $duration;
    }

    public function setUrl(string $url): void 
    {
        $this->url = $url;
    }

    public function setAlbumId(int $albumId): void 
    {
        $this->albumId = $albumId;
    }
    
    public function jsonSerialize()
    {
        $array = [];
        $array["id"] = $this->id;
        $array["title"] = $this->title;
        $array["duration"] = $this->duration;
        $array["url"] = $this->url;
        $array["album_id"] = $this->album_id;

        return $array;
    }
}

?>
