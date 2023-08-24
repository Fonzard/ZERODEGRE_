<?php
class Album implements JsonSerializable {
    private ?int $id;
    private string $titre;
    private int $year;
    private int $media_id;

    public function __construct(string $titre, int $year, int $media_id) {
        $this->id = null;
        $this->titre = $title;
        $this->year = $year;
        $this->media_id = $media_id;
    }

    ////////////  Getters ////////////
    public function getId(): ?int {
        return $this->id;
    }

    public function getTitre(): string {
        return $this->titre;
    }

    public function getYear(): int {
        return $this->year;
    }
    
    public function getMediaId(): int 
    {
        return $this->media_id;
    }
    //////////// Setters ////////////
    public function setId(?int $id) : void
    {
        $this->id =$id;
    }
    
    public function setTitre(string $title): void {
        $this->title = $title;
    }

    public function setYear(int $year): void {
        $this->year = $year;
    }
    
    public function setMediaId(Media $media_id): void {
        $this->media_id = $media_id;
    }
    
    public function jsonSerialize()
    {
        $array = [];
        $array["id"] = $this->id;
        $array["titre"] = $this->titre;
        $array["year"] = $this->year;
        $array["media_id"] = $this->media_id;

        return $array;
    }
}
?>