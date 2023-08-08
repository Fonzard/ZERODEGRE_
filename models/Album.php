<?php
class Album {
    private ?int $id;
    private string $title;
    private int $year;
    private Artist $artistId;
    private Media $mediaId;

    public function __construct(string $title, string $artist, int $year, Artist $artistId, Media $mediaId) {
        $this->id = null;
        $this->title = $title;
        $this->artist = $artist;
        $this->year = $year;
        $this->artistId = $artistId;
        $this->mediaId = $mediaId;
    }

    ////////////  Getters ////////////
    public function getId(): ?int {
        return $this->id;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getYear(): int {
        return $this->year;
    }
    
    public function getArtistId(): Artist 
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
    
    public function setTitle(string $title): void {
        $this->title = $title;
    }

    public function setYear(int $year): void {
        $this->year = $year;
    }
    
    public function setArtistId(Artist $artistId): void {
        $this->artistId = $artistId;
    }
    
    public function setMediaId(Media $mediaId): void {
        $this->mediaId = $mediaId;
    }
}
?>