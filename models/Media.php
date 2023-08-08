<?php
class Media {
    private ?int $id;
    private string $url;
    private string $altText;

    public function __construct(string $url, string $altText) {
        $this->id = null;
        $this->url = $url;
        $this->altText = $altText;
    }   

    //////////// Getters ////////////
    public function getId(): ?int 
    {
        return $this->id;
    }

    public function getUrl(): string 
    {
        return $this->url;
    }
    
    public function getAltText(): string 
    {
        return $this->altText;
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
    
    public function setAltText(string $altText) : void
    {
        $this->altText = $altText;
    }
}

?>