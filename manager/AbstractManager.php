<?php 
abstract class AbstractManager {
    
    protected PDO $connex;

    
    public function __construct(){
       
        $dbInfo = $this->getDatabaseInfo();
        
        $connexionString = "mysql:host=".$dbInfo['host'].";port=3306;dbname=".$dbInfo['db_name'];
        
        try {
            $this->connex = new PDO($connexionString, $dbInfo['username'], $dbInfo['password']);
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
       
    }

    public function getDatabaseInfo() : array 
    {
        $info = array();
        
        //Lis le contenu du document ligne par ligne
        $lines = file("./config/database.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        //Parcours les lignes 
        foreach($lines as $line)
        {
            //Sépare la ligne en deux parties : la clé et la valeur
            list($key, $value) = explode('=', $line);
            
            //Stock la clé et la valeur dans le tableau $info
            $info[$key] = $value;
        }
        
        return $info;
    }
    
    // Faut il en faire deux fetch / fetchAll ????
    // Normalement singleResult résout le problème 
    public function getQuery($query, $parameters = array(), $singleResult = false) {
        
        
        try {
            
            // Préparation de la requête 
            $stmt = $this->connex->prepare($query);
            
            // Execution de la requête avec les paramètres
            $stmt->execute($parameters);
           
            //Vérifie si il y a besoin de fetch ou fetchAll
            if ($singleResult){
                
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                
            } else {
                
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
            }
            
            return $result;
            
        } catch (PDOException $e) {
            
            // En cas d'erreur, afficher le message d'erreur
            echo "Erreur : " . $e->getMessage();
            return null;
        }
    }

    public function getResult($query, $parameters = null, $class, $isSingleResult = false) {
    
        // Récupérer les résultats de la requête à partir de la base de données
        $results = $this->getQuery($query, $parameters);
        $resultsTab = array();
        
        //Si il n'y aucune résultat renvoyer null
        if (empty($results)) {
            return null;
        }
        
        // Créer une instance de ReflectionClass pour la classe donnée
        $reflectionClass = new ReflectionClass($class); // Mieux se renseigner sur ReflectionClass !!!!!!!!!
        $constructor = $reflectionClass->getConstructor(); // Obtenir le constructeur de la classe
    
        // Parcourir les résultats de la requête
        foreach ($results as $result) {
            
            $constructorParams = $constructor->getParameters(); // Obtenir les paramètres du constructeur
            $constructorArguments = array();
    
            // Parcourir les paramètres du constructeur
            foreach ($constructorParams as $param) {
                
                $paramName = $param->getName(); // Nom du paramètre du constructeur
                
                if (isset($result[$paramName])) {
                    
                    // Si la colonne correspondante existe dans le résultat, l'ajouter aux arguments du     constructeur
                    $constructorArguments[] = $result[$paramName];

                } else {
                    
                    // Sinon, ajouter null comme argument du constructeur
                    $constructorArguments[] = null;
                    
                }
            }
    
            // Créer une instance de la classe en utilisant les arguments du constructeur
            $resultInstance = $reflectionClass->newInstanceArgs($constructorArguments);
            $resultInstance->setId($result['id']);
            
            if ($isSingleResult)
            {
                return $resultInstance; //Si on traite le résultat seul, le return direct
            }
            
            $resultsTab[] = $resultInstance;
        }
        
        if ($isSingleResult) {
            return null; // Retourner null si aucun résultat trouvé pour le cas de traitement unique
        }
        
        return $resultsTab;
    }

}   

    
?>    