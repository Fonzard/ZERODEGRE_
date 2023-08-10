<?php 

class PostManager extends AbstractManager {
    
    public function getPostById(int $id) : ?Post
    {
        $class = "Post";
        $query = ("SELECT * FROM post WHERE post.id = :id");
        $parameters = array(":id" => $id);
        
        $result = $this->getResult($query, $parameters, $class, true);
        
        if($result !== null){
            $result->setId($result["id"]);
        }
        
        return $result;
    }
    public function getPostByTitle(string $title) : ?Post 
    {
        $class = "Post";
        $query = ("SELECT * FROM post WHERE post.title = :title");
        $parameters = array(":title" => $title);
        
        $result = array();
        $result = $this->getResult($query, $parameters, $class,true);
        if($result !== null){
            $result->setId($result["id"]);
        }
        return $result;
    }
    public function getPostByAuthor(string $author) : ?Post 
    {
        $class = "Post";
        $query = ("SELECT * FROM post WHERE post.id = :last_name");
        $parameters = array(":author" => $author);
        
        $result = array();
        $result = $this->getResult($query, $parameters, $class, true);
        if($result !== null){
            $result->setId($result["id"]);
        }
        return $result;
    }
    public function getPostByAuthor(string $author) : ?Post 
    {
        $class = "Post";
        $query = ("SELECT * FROM post WHERE post.id = :last_name");
        $parameters = array(":author" => $author);
        
        $result = array();
        $result = $this->getResult($query, $parameters, $class, true);
        if($result !== null){
            $result->setId($result["id"]);
        }
        return $result;
    }
    
    
    //Quoi faire avec category_id et media_id et date  ??????
    public function createPost(Post $post) : ?Post
    {
        $query = ("INSERT INTO post(title, content, date, author, category_id, media_id) VALUES (:title, :content, :date, :author, :category_id, :media_id)");
        $parameters = array("title" => $post->getTitle(), "content" => $post->getContent(), "date" => $post->getDate(), "author" => $post->getAuthor(), "category_id" => $post->getRoleId());
        
        $this->getQuery($query, $parameters);
        
        // Obtenez l'ID inséré
        $lastInsertId = $this->connectToDatabase()->lastInsertId();
        
        // A vérifier !!!
        $user->setId($lastInsertId);
        return $user;
    }
} 
?>