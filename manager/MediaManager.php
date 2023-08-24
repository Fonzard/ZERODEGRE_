<?php

class MediaManager extends AbstractManager {
    
    // A tester 
    // PRODUCTS \\
    public function getMediaIdByUrl($url)
    {
        $class = "Media";
        $query = ("SELECT id FROM medias WHERE url = :url");
        $parameters = array("url" => $url);
        
        $result = $this->getResult($query, $parameters, $class, true);
        
    }
    
    public function getMediaDescription($mediaId)
    {
        $query = "SELECT medias.alt_text FROM medias WHERE medias.id = :mediaId";
        $parameters = array("mediaId" => $mediaId);
        
        $result = $this->getQuery($query, $parameters, true);
        return $result;
    }
    
    //Générale 
    public function insertMedia($media)
    {
        $query =("INSERT INTO medias (url, alt_text) VALUES (:url, :alt_text)");
        $parameters = array(":url" => $media->getUrl(), ":alt_text" => $media->getAltText());
        
        $this->getQuery($query, $parameters, true);
        
        $lastInsertId = $this->connex->lastInsertId();
        
        $media->setId($lastInsertId);
        return $media;
    }
    public function editMedia($mediaId)
    {
        
    }
    
 
}