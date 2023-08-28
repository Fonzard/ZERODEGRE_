<?php 
class Artist {
    private ?int $id;
    private string $name;
    private string $description;
    private ?int $media_id;
    
    public function __construct(string $name, string $description, ?int $media_id) {
        $this->id = null;
        $this->name = $name;
        $this->description = $description;
        $this->media_id = $media_id;
    }

    //////////// Getters ////////////
    public function getId(): ?int 
    {
        return $this->id;
    }

    public function getName(): string 
    {
        return $this->name;
    }

    public function getDescription(): string 
    {
        return $this->description;
    }

    public function getMediaId(): ?int 
    {
        return $this->media_id;
    }
    //////////// Setters ////////////
    public function setId(?int $id) : void
    {
        $this->id =$id;
    }
    
    public function setName(string $name) : void
    {
        $this->name = $name;
    }

    public function setDescription(string $description) :void
    {
        $this->description = $description;
    }
    
    public function setMediaId(?int $media_id) : void
    {
        $this->media_id = $media_id;
    }
}
?>