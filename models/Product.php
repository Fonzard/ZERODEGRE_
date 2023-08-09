<?php
class Product {
    private ?int $id;
    private string $name;
    private float $price;
    private string $description;
    private int $quantity;
    private Category $categoryId;
    private Media $mediaId;

    public function __construct(string $name, float $price, string $description, int $quantity, Category $categoryId, Media $mediaId) {
        $this->id = null;
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
        $this->quantity = $quantity;
        $this->categoryId = $categoryId;
        $this->mediaId = $mediaId;
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

    public function getCategoryId(): int 
    {
        return $this->categoryId;
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

    public function setCategoryId(Category $categoryId) : void
    {
        $this->categoryId = $categoryId;
    }
    
    public function setMediaId(Media $mediaId) : void
    {
        $this->mediaId = $mediaId;
    }
}

?>