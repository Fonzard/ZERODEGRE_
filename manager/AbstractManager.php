<?php 
abstract class AbstractManager {
    
    protected PDO $db;
    private string $dbName;
    private string $port;
    private string $host;
    private string $username;
    private string $password;
    
    public function __construct(string $dbName, string $port, string $host, string $username, string $password){
       
        $this->dbName = $dbName;
        $this->port = $port;
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        
    }

    public function connectToDatabase(){
        
        try {
            
            $connexionString = "mysql:host=$this->host;port=$this->port;dbname=$this->dbName";
            $connex = new PDO($connexionString, $this->username, $this->password);
            $query = $connex;
            return $connex;
        
        
        } catch (PDOException $e) {
            echo "Erreur de connexion à la base de données : " . $e->getMessage();// Comprendre cette ligne A Revoir
            return null;
        }
        
        
    }
    
    // Faut il en faire deux fetch / fetchAll ????
    public function getQuery($query, $parameters = array()) {
        
        $connex = $this->connectToDatabase();
        
        try {
            
            // Préparation de la requête 
            $stmt = $connex->prepare($query);
            
            // Execution de la requête avec les paramètres
            $stmt->execute($parameters);
            
            //Coupure de la connexion 
            $connex = null;
            
            return $results;
            
        } catch (PDOException $e) {
            
        // En cas d'erreur, afficher le message d'erreur
        echo "Erreur : " . $e->getMessage();
        return null;
        }
    }
    
    public function getResult($query, $parameters = null, $class) {
    
        // Récupérer les résultats de la requête à partir de la base de données
        $results = $this->getQuery($query, $parameters);
        $resultsTab = array();
    
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
            
            // Ajouter l'instance à la liste des résultats
            $resultsTab[] = $resultInstance;
        }
    
        // Afficher le tableau final des résultats
        var_dump($resultsTab);
        
        // Retourner le tableau des instances créées
        return $resultsTab;
    }

}   

    
?>    