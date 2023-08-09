<?php
class User {
    private ?int $id;
    private sting $firstName;
    private string $lastName;
    private string $email;
    private string $password;
    private Roles $roleId; // Est ce que je dois pas plutôt le déclarer en Roles au lieu de int

    public function __construct(string $firstName, string $lastName, string $email, string $password, Roles $roleId) {
        $this->id = null;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->roleId = $roleId; 
    }

    ////////////  Getters //////////// 
    public function getId() : ?int
    {
        return $this->id;
    }

    public function getFirstName() : string
    {
        return $this->firstName;
    }

    public function getLastName() : string
    {
        return $this->lastName;
    }

    public function getEmail() : string
    {
        return $this->email;
    }

    public function getPassword() : string
    {
        return $this->password;
    }

    public function getRoleId() : int
    {
        return $this->roleId;
    }

    //////////// Setters ////////////
    public function setId(?int $id) : void
    {
        $this->id =$id;
    }
    
    public function setFirstName(string $firstName) : void 
    {
        $this->firstName = $firstName;
    }

    public function setLastName(string $lastName) : void
    {
        $this->lastName = $lastName;
    }

    public function setEmail(string $email) : void
    {
        $this->email = $email;
    }

    public function setPassword(string $password) : void
    {
        $this->password = $password;
    }

    public function setRoleId(Roles $roleId) : void
    {
        $this->roleId = $roleId;
    }

}
?>