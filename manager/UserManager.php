<?php 
require"AbstractManager.php";

class UserManager extends AbstractManager {
    
    public function getUserByEmail(string $email) : ?User
    {
        $class = "User";
        $query = ("SELECT * FROM users WHERE users.email = :email");
        $parameters = array(":email" => $email);
        
        $result = array();
        $result = $this->getResult($query, $parameters, $class);
        $result->setId($result["id"]);
        return $result;
    }
    public function getUserById(int $id) : ?User
    {
        $class = "User";
        $query = ("SELECT * FROM users WHERE users.id = :id");
        $parameters = array(":id" => $id);
        
        
        $result = array();
        $result = $this->getResult($query, $parameters, $class);
        $result->setId($result["id"]);
        return $result;
    }
    public function getUserByFirstName(User $firstName) : ?User 
    {
        $class = "User";
        $query = ("SELECT * FROM users WHERE users.id = :first_name");
        $parameters = array(":first_name" => $firstName);
        
        $result = array();
        $result = $this->getResult($query, $parameters, $class);
        $result->setId($result["id"]);
        return $result;
    }
    public function getUserByLastName(User $lastName) : ?User 
    {
        $class = "User";
        $query = ("SELECT * FROM users WHERE users.id = :last_name");
        $parameters = array(":last_name" => $lastName);
        
        $result = array();
        $result = $this->getResult($query, $parameters, $class);
        $result->setId($result["id"]);
        return $result;
    }
    //Je suis pas sur du fonctionnement de cette fonction 
    public function createUser(User $user) : ?User
    {
        $query = ("INSERT INTO users(id, first_name, last_name, email, password) VALUES (null, :first_name, :last_name, :email, :password), :roleId");
        $parameters = array("first_name" => $user->getLastName(), "last_name" => $user->getFirstName(), "email" => $user->getEmail(), "password" => $user->getPassword(), "roleId" => $user->getRoleId);
        
        $this->getQuery($query, $parameters);
        
        // A vérifier !!!
        $user->setId($this->connectToDatabase()->lastInsertId());
        return $user;
    }
} 
?>