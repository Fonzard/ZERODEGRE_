<?php
class Song {
    private ?int $id;
    private string $url;
    private Artist $artistId;
    private Media $mediaId;

    public function __construct(string $url, Artist $artistId, Media $mediaId) {
        $this->id = null;
        $this->url = $url;
        $this->artistId = $artistId;
        $this->mediaId = $mediaId;
    }

    ////////////  Getters //////////// 
    public function getId(): ?int 
    {
        return $this->id;
    }

    public function getUrl(): string 
    {
        return $this->url;
    }

    public function getArtistId(): int 
    {
        return $this->artistId;
    }

    public function getMediaId(): Media 
    {
        return $this->mediaId;
    }
    //////////// Setters ////////////
    public function setId(?int $id) : void
    {
        $this->id =$id;
    }
    
    public function setUrl(string $url) : void 
    {
        $this->url = $url;
    }

    public function setArtistId(Artist $artistId) : void
    {
        $this->artistId = $artistId;
    }
    
    public function setMediaId(Media $mediaId) : void
    {
        $this->mediaId = $mediaId;
    }
}
?>
