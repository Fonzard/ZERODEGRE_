<?php

class MediaManager extends AbstractManager {
    
    // A tester 
    // Products
    public function getMediaByProductId($productId)
    {
        $class = "Media";
                //REVOIR la requête !!!!!!
        $query = ("SELECT p.name AS name, m.url AS url, m.alt_text AS alt_text
                FROM products 
                JOIN medias ON p.mediaId = m.id
                WHERE p.id = :product_id");
        $parameters = array(":product_id" => $productId);
        
        $result = $this->getResult($query, $parameters, $class, true);
        return $result;
    }
    
    public function getMediaWithProduct($mediaId, $productId)
    {
        $query = ("UPDATE products SET media_id = :media_id WHERE id = :product_id");
        $parameters = array("media_id" => $mediaId, "product_id" => $productId);
        
        $this->getQuery($query, $parameters, true);
    }
    
    //Générale 
    public function insertMedia($media)
    {
        $query =("INSERT INTO media (url, alt_text) VALUES (:url, :alt_text)");
        $parameters = array(":url" => $media->getUrl(), ":alt_text" => $media->getAltText());
        
        $this->getQuery($query, $parameters, true);
        
        $lastInsertId = $this->connex->lastInsertId();
        
        $media->setId($lastInsertId);
        return $media;
    }
    
 
}