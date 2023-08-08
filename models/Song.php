<?php
class Song {
    private ?int $id;
    private string $title;
    private string $duration;
    private string $url;
    private Album $albumId;

    public function __construct(string $title, string $duration, string $url, Album $albumId) {
        $this->id = null;
        $this->title = $title;
        $this->duration = $duration;
        $this->url = $url;
        $this->albumId = $albumId;
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

    public function getAlbumId(): Album 
    {
        return $this->albumId;
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
}

?>
