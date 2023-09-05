<?php 

class PostManager extends AbstractManager {
    
    public function getAllPost()
    {
        $class = "Post";
        $query = "SELECT * FROM post";
        $results = $this->getResult($query, null, $class, false);
        return $results;
    }

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
        $query = ("SELECT * FROM post WHERE post.author = :author");
        $parameters = array(":author" => $author);
        
        $result = array();
        $result = $this->getResult($query, $parameters, $class, true);
        if($result !== null){
            $result->setId($result["id"]);
        }
        return $result;
    }
    
    //Je suis pas sur que ça fonctionne :/
    public function getPostsByCategory(Category $category): array
    {
        $class = "Post";
        $query = "
            SELECT p.*
            FROM posts AS p
            INNER JOIN categories_post AS cp ON p.category_id = cp.id
            WHERE cp.name = :category_name
        ";
        $parameters = [":category_name" => $category->getName()]; 
    
        return $this->getResult($query, $parameters, $class);
    }

    
    //Quoi faire avec category_id et media_id et date  ??????
    public function createPost(Post $post) : ?Post
    {
        $query = ("INSERT INTO post(title, content, date, author, category_id, media_id) VALUES (:title, :content, :date, :author, :category_id, :media_id)");
        $parameters = array("title" => $post->getTitle(), "content" => $post->getContent(), "date" => $post->getDate(), "author" => $post->getAuthor(), "category_id" => $post->getCategoryId(), "media_id" => $post->getMediaId());
        
        $this->getQuery($query, $parameters);
        
        // Obtenez l'ID inséré
        $lastInsertId = $this->connex->lastInsertId();
        
        // A vérifier !!!
        $post->setId($lastInsertId);
        return $post;
    }
} 
?>