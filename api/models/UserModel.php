<?php

class UserModel extends Model{
 
    public function getUser($user) {    
        $query = $this->db->prepare("SELECT * FROM usuario WHERE user = ?");
        $query->execute([$user]);
    
        $user = $query->fetch(PDO::FETCH_OBJ);
    
        return $user;
    }
}
