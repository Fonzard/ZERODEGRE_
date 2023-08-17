<?php 

class UserManager extends AbstractManager {
    
    public function getAllUsers() : ? array
    {
        $class = "User";
        $query = ("SELECT * FROM users");
        $parameters = null;
        
        $results = $this->getResult($query, $parameters, $class, false);
        var_dump($results);
        
        return $results;
    }
    public function getUserByEmail(string $email) : ? User
    {
        $class = "User";
        $query = ("SELECT * FROM users WHERE users.email = :email");
        $parameters = array(":email" => $email);
        
        $result = $this->getResult($query, $parameters, $class, true);
        var_dump($result);
        return $result;
    }
    public function getUserById(int $id) : ?User
    {
        $class = "User";
        $query = ("SELECT * FROM users WHERE users.id = :id");
        $parameters = array(":id" => $id);
        
        $result = $this->getResult($query, $parameters, $class, true);
        var_dump($result);
        // if($result !== null){
        //     $result->setId($result->getId());
        // }
        
        return $result;
    }
    public function getUserByFirstName(string $firstName) : ?User 
    {
        $class = "User";
        $query = ("SELECT * FROM users WHERE users.first_name = :first_name");
        $parameters = array(":first_name" => $firstName);
        
        $result = array();
        $result = $this->getResult($query, $parameters, $class,true);
        if($result !== null){
            $result->setId($result["id"]);
        }
        return $result;
    }
    public function getUserByLastName(string $lastName) : ?User 
    {
        $class = "User";
        $query = ("SELECT * FROM users WHERE users.last_name = :last_name");
        $parameters = array(":last_name" => $lastName);
        
        $result = array();
        $result = $this->getResult($query, $parameters, $class, true);
        if($result !== null){
            $result->setId($result["id"]);
        }
        return $result;
    }
    //Je suis pas sur du fonctionnement de cette fonction 
    public function createUser(User $user) : ?User
    {
        $query = ("INSERT INTO users(first_name, last_name, email, password, role_id) VALUES (:first_name, :last_name, :email, :password, :role_id)");
        $parameters = array("first_name" => $user->getLastName(), "last_name" => $user->getFirstName(), "email" => $user->getEmail(), "password" => $user->getPassword(), "role_id" => $user->getRoleId());
        
        $this->getQuery($query, $parameters);
        
        // Obtenez l'ID inséré
        $lastInsertId = $this->connex->lastInsertId();
        
        // A vérifier !!!
        $user->setId($lastInsertId);
        return $user;
    }
    
    public function delete(int $userId): void
    {
        $query = "DELETE FROM users WHERE id = :id";
        $parameters = array("id" => $userId);
        
        $this->getQuery($query, $parameters, true);
    }
    
    public function edit(User $user) : void
    {
        
        $query =("UPDATE users SET first_name = :first_name, last_name = :last_name, email = :email, password = :password, role_id = :role_id WHERE users.id = :id");
        $parameters = array("first_name" => $user->getFirstName(), "last_name" => $user->getLastName(), "email" => $user->getEmail(), "password" => $user->getPassword(), "role_id" => $user->getRoleId(), "id" => $user->getId());
        
        $this->getQuery($query, $parameters);
    }
} 
?>