<?php
class Product implements JsonSerializable {
    private ?int $id;
    private string $name;
    private ?float $price;
    private string $description;
    private int $quantity;
    private ?int $category_id;
    private ?int $media_id;
    private array $media = [];
    public function __construct(string $name, ?float $price, string $description, int $quantity, ?int $category_id, ?int $media_id) {
        $this->id = null;
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
        $this->quantity = $quantity;
        $this->category_id = $category_id;
        $this->media_id = $media_id;
    }

    ////////////  Getters ////////////
    public function getId(): ?int 
    {
        return $this->id;
    }

    public function getName(): string 
    {
        return $this->name;
    }

    public function getPrice(): float 
    {
        return $this->price;
    }

    public function getDescription(): string 
    {
        return $this->description;
    }

    public function getQuantity(): int 
    {
        return $this->quantity;
    }

    public function getCategoryId(): ?int 
    {
        return $this->category_id;
    }
    
    public function getMediaId(): ?int 
    {
        return $this->media_id;
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

    public function setPrice(float $price) : void
    {
        $this->price = $price;
    }

    public function setDescription(string $description) : void
    {
        $this->description = $description;
    }

    public function setQuantity(int $quantity) : void
    {
        $this->quantity = $quantity;
    }

    public function setCategoryId(?int $category_id) : void
    {
        $this->category_id = $category_id;
    }
    public function setMediaId(?int $media_id) : void
    {
        $this->media_id = $media_id;
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
        $array["price"] = $this->price;
        $array["description"] = $this->description;
        $array["quantity"] = $this->quantity;
        $array["category_id"] = $this->category_id;
        $array["media_id"] = $this->media_id;

        return $array;
    }
}

?>