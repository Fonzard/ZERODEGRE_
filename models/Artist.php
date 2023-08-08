<?php 
class Artist {
    private ?int $id;
    private string $name;
    private string $description;
    private Media $mediaId;
    
    public function __construct(string $name, string $description, Media $mediaId) {
        $this->id = null;
        $this->name = $name;
        $this->description = $description;
        $this->mediaId = $mediaId;
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

    public function getMediaId(): Media 
    {
        return $this->mediaId;
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
    
    public function setMediaId(Media $mediaId) : void
    {
        $this->mediaId = $mediaId;
    }
}
?>