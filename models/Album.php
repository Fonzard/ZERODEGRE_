<?php
class Album implements JsonSerializable {
    private ?int $id;
    private string $titre;
    private int $year;
    private string $info;
    private int $media_id;
    private array $songs = [];
    private array $media = [];
    private array $feats = [];

    public function __construct(string $titre, int $year, string $info, int $media_id) {
        $this->id = null;
        $this->titre = $titre;
        $this->year = $year;
        $this->info = $info;
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

    public function getInfo(): string {
        return $this->info;
    }
    
    public function getMediaId(): int 
    {
        return $this->media_id;
    }
    
    public function getSongs(): array 
    {
        return $this->songs;
    }
    
    public function getMedia(): array
    {
        return $this->media;
    }
    
    public function getFeats(): array
    {
        return $this->feats;
    }
    //////////// Setters ////////////
    public function setId(?int $id) : void
    {
        $this->id = $id;
    }
    
    public function setTitre(string $titre): void {
        $this->titre = $titre;
    }

    public function setYear(int $year): void {
        $this->year = $year;
    }

    public function setInfo(string $info): void {
        $this->info = $info;
    }
    
    public function setMediaId(int $media_id): void {
        $this->media_id = $media_id;
    }
    
    public function setSongs(array $songs): void 
    {
        $this->songs = $songs;
    }
    
    public function setMedia(array $media) : void
    {
        $this->media = $media;
    }
    
    public function setFeats(array $feats) : void
    {
        $this->feats = $feats;
    }
    
    public function jsonSerialize()
    {
        $array = [];
        $array["id"] = $this->id;
        $array["titre"] = $this->titre;
        $array["year"] = $this->year;
        $array["info"] = $this->info;
        $array["media_id"] = $this->media_id;
        $array["songs"] = $this->songs;
        $array["media"] = $this->media;
        $array ["feats"] =$this->feats;

        return $array;
    }
    
}
?>