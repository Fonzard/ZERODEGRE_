<?php
class Media {
    private ?int $id;
    private string $url;
    private string $alt_text;

    public function __construct(string $url, string $alt_text) {
        $this->id = null;
        $this->url = $url;
        $this->alt_text = $alt_text;
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
        return $this->alt_text;
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
    
    public function setAltText(string $alt_text) : void
    {
        $this->alt_text = $alt_text;
    }
}

?>