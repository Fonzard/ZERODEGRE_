<?php 
class Artist implements JsonSerializable {
    private ?int $id;
    private string $name;
    private string $description;
    private ?int $media_id;
    private array $albums;
    private ?int $role_id;
    private array $media;

    public function __construct(string $name, string $description, ?int $media_id, ?int $role_id) {
        $this->id = null;
        $this->name = $name;
        $this->description = $description;
        $this->media_id = $media_id;
        $this->role_id = $role_id;
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

    public function getAlbums() : array
    {
        return $this->albums;
    }
    
    public function getRoleId(): ?int 
    {
        return $this->role_id;
    }
    
    public function getMedia(): array
    {
        return $this->media;
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

    public function setAlbums( array $albums): void 
    {
        $this->albums = $albums;
    }
    
    public function setRoleId(?int $role_id) : void
    {
        $this->role_id = $role_id;
    }
    
    public function setMedia(array $media) : void
    {
        $this->media = $media;
    }
    
    public function jsonSerialize()
    {
        $array = [];
        $array["id"] = $this->id;
        $array["name"] = $this->name;
        $array["description"] = $this->description;
        $array["media_id"] = $this->media_id;
        $array["albums"] = $this->albums;
        $array["role_id"] = $this->role_id;

        return $array;
    }
}
?>