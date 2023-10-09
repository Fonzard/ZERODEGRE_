<?php
class Post {
    private ?int $id;
    private string $title;
    private string $content;
    private string $date;
    private string $author;
    private ?int $category_id;
    private ?int $media_id;
    private array $media = [];

    public function __construct(string $title, string $content, string $date, string $author, ?int $category_id, ?int $media_id) {
        $this->id = null;
        $this->title = $title;
        $this->content = $content;
        $this->date = $date;
        $this->author = $author;
        $this->category_id = $category_id;
        $this->media_id = $media_id; 
    }

    //////////// Getters ////////////
    public function getId(): ?int 
    {
        return $this->id;
    }

    public function getTitle(): string 
    {
        return $this->title;
    }

    public function getContent(): string 
    {
        return $this->content;
    }

    public function getDate(): string 
    {
        return $this->date;
    }

    public function getAuthor(): string 
    {
        return $this->author;
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
    
    public function setTitle(string $title) : void
    {
        $this->title = $title;
    }

    public function setContent(string $content) : void
    {
        $this->content = $content;
    }

    public function setDate(string $date) : void
    {
        $this->date = $date;
    }

    public function setAuthor(string $author) : void
    {
        $this->author = $author;
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
        $array["title"] = $this->title;
        $array["content"] = $this->content;
        $array["date"] = $this->date;
        $array["author"] = $this->author;
        $array["category_id"] = $this->category_id;
        $array["media_id"] = $this->media_id;

        return $array;
    }
}

?>