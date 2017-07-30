<?php

class User
{
    private $id;
    private $name;
    private $surname;
    private $email;
    private $hashedPassword;
    private $address;
    
    public function __construct(){
        $this->id = -1;
        $this->name = '';
        $this->surname = '';
        $this->email = '';
        $this->password = '';
        $this->address = '';
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function setName($name){
        if(!(preg_match('/\A\w{5,30}\z/', $name))){
            return false;
            }
        else{
            $this->name = $name;
            return $this;
            }
    }
    
    public function getName(){
        return $this->name;
    }
    
    public function setSurname($surname){
        if(!(preg_match('/\A\w{5,30}\z/', $surname))){
            return false;
            }
        else{
            $this->surname = $surname;
            return $this;
            }
    }
    
    public function getSurname(){
        return $this->surname;
    }
    
    public function setEmail($email){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $this->email = $email;
            return $this;
        }
        else{
            return false;
        }
    }
    
    public function getEmail(){
        return $this->email;
    }
    
    public function setHashedPassword($password){
        if(!preg_match('/\A\w{8,22}\z/', $password)){
                return false;
            }
            elseif(!preg_match('/\d+/', $password)){
                return false;
            }
            elseif(!preg_match('/[a-zA-Z]/', $password)){
                return false;
            }
            else{
                $options = [ 'cost' => 8];
                $newHashedPassword = password_hash($password, PASSWORD_BCRYPT, $options);
                $this->hashedPassword = $newHashedPassword;
                return $this;
            }
    }
    
    public function getHashedPassword(){
        return $this->hashedPassword;
    }
    
    public function setAddress($address){
        if($address == '' || is_null($address)){
            return false;
            }
        else{
            $this->address = $address;
            return $this;
            }
    }
    
    public function getAddress(){
        return $this->address;
    }
    
    public function saveToDB(mysqli $conn){
        if($this->id === -1){
            $sql = 'INSERT INTO User(name, surname, email, hashedPassword, address) values ("'.$this->name.'", "'.$this->surname.'", "'.$this->email.'", "'.$this->hashedPassword.'", "'.$this->address.'");';
            
            $result = $conn->query($sql);
            if($result === true){
                $this->id = $conn->insert_id;
                return true;
            }
            else{
                return false;
            }   
        }
        else{
            $sql = 'UPDATE User SET name="'.$this->name.'", surname="'.$this->surname.'", email="'.$this->email.'", hashedPassword="'.$this->hashedPassword.'", address="'.$this->address.'" WHERE id='.$this->id.';';
        
            $result = $conn->query($sql);
            if($result === true){
                return true;
            }
            else{
                return false;
            }
        }
    }
    
    private function assignValues($id, $name, $surname, $email, $hashedPassword, $address){
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->hashedPassword = $hashedPassword;
        $this->address = $address;
    }
    
    static public function loadUserById(mysqli $conn, $id){
        $sql = 'SELECT * FROM User WHERE id = '.$id;
        $result = $conn->query($sql);
        
        if($result == true && $result->num_rows === 1){
            $row = $result->fetch_assoc();
            $loadedUser = new User();
            $loadedUser->assignValues($row['id'], $row['name'], $row['surname'], $row['email'], $row['hashedPassword'], $row['address']);
            
            return $loadedUser;
        }
        
        else{
            return null;
        }
    }
    
    static public function loadAllUsers(mysqli $conn){
        $sql = 'SELECT * FROM User';
        $allUsers = [];
        $result = $conn->query($sql);
        
        if($result == true && $result->num_rows !== 0){
            foreach ($result as $row){
                $loadedUser = new User();
                $loadedUser->assignValues($row['id'], $row['name'], $row['surname'], $row['email'], $row['hashedPassword'], $row['address']);
                
                array_push($allUsers, $loadedUser);
            }
        }
        
        return $allUsers;
    }
    
    public function remove(mysqli $conn){
        if($this->id !== -1){
            $sql = 'DELETE FROM User WHERE id='.$this->id;
            $result=$conn->query($sql);
            if($result === true){
                $this->id = -1;
                return true;
            }
            else{
                return false;
            }
        }
        return true;
    }

    /**
     * TODO: Show shopping history
     */
}