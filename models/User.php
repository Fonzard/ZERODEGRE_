<?php
class User implements JsonSerializable {
    private ?int $id;
    private string $first_name;
    private string $last_name;
    private string $email;
    private string $password;
    private ?int $role_id; // Est ce que je dois pas plutôt le déclarer en Roles au lieu de int

    public function __construct(string $first_name, string $last_name, string $email, string $password, ?int $role_id) {
        $this->id = null;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->password = $password;
        $this->role_id = $role_id; 
    }

    ////////////  Getters //////////// 
    public function getId() : ?int
    {
        return $this->id;
    }

    public function getFirstName() : string
    {
        return $this->first_name;
    }

    public function getLastName() : string
    {
        return $this->last_name;
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
        return $this->role_id;
    }

    //////////// Setters ////////////
    public function setId(?int $id) : void
    {
        $this->id =$id;
    }
    
    public function setFirstName(string $first_name) : void 
    {
        $this->first_name = $first_name;
    }

    public function setLastName(string $last_name) : void
    {
        $this->last_name = $last_name;
    }

    public function setEmail(string $email) : void
    {
        $this->email = $email;
    }

    public function setPassword(string $password) : void
    {
        $this->password = $password;
    }

    public function setRoleId(int $role_id) : void
    {
        $this->role_id = $role_id;
    }
    
    public function jsonSerialize()
    {
        $array = [];
        $array["id"] = $this->id;
        $array["firstName"] = $this->first_name;
        $array["lastName"] = $this->last_name;
        $array["email"] = $this->email;
        $array["roleId"] = $this->role_id;

        return $array;
    }

}
?>