<?php
class FeaturingManager extends AbstractManager {
 
    public function getAllFeatInAlbum($albumId)
    {
        $query = "SELECT artist_id, album_id FROM featurings WHERE album_id = :album_id";
        $stmt = $this->connex->prepare($query);
        $stmt->bindParam(":album_id", $albumId, PDO::PARAM_INT);
        $stmt->execute();
    
        $featurings = [];
    
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $featurings[] = new Featuring($row['artist_id'], $row['album_id']);
        }
    
        return $featurings;
    }

    
}
?>