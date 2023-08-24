<?php
class Product {
    private ?int $id;
    private string $name;
    private float $price;
    private string $description;
    private int $quantity;
    private ?int $category_id;
    private ?int $media_id;

    public function __construct(string $name, float $price, string $description, int $quantity, ?int $category_id, ?int $media_id) {
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

    public function setCategoryId(Category $category_id) : void
    {
        $this->category_id = $category_id;
    }
    public function setMediaId(Media $media_id) : void
    {
        $this->media_id = $media_id;
    }
}

?>