<?php
class Post {
    private ?int $id;
    private string $title;
    private string $content;
    private string $date;
    private string $author;
    private Category $categoryId;
    private Media $mediaId;

    public function __construct(string $title, string $content, string $date, string $author, Category $categoryId, Media $mediaId) {
        $this->id = null;
        $this->title = $title;
        $this->content = $content;
        $this->date = $date;
        $this->author = $author;
        $this->categoryId = $categoryId;
        $this->mediaId = $mediaId; 
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
    
    public function getCategoryId(): Category 
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