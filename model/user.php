<?php
require_once '../config/db.php';

class user{
     
    //  propriétes de la classe user
     private $id_user;
     private $nom_user;
     private $email_user;
     private $passWord_user;
     private $role_user;
     private $is_valid;

     // constructeur de la classe user
     public function __construct($id_user, $nom_user, $email_user, $passWord_user, $role_user){
        $this->id_user = $id_user;
        $this->nom_user = $nom_user;
        $this->email_user = $email_user;
        $this->passWord_user = $passWord_user;
        $this->role_user = $role_user;
     }
    
    //  getters pour la classe user
    public function getIdUser(){ return $this->id_user ;}

    public function getNomUser(){return $this->nom_user ;}

    public function getEmailUser(){return $this->email_user ;}

    public function getRoleUser(){return $this->role_user ;}

    public function getIsValid() { return $this->is_valid; }


   //  setters pour la classe user
   public function setNomUser($nom_user){$this->nom_user = $nom_user;}

   public function setEmailUser($email_user){$this->email_user = $email_user;}

   public function setPasswordUser($passWord_user){$this->passWord_user = $passWord_user ;}

   public function setRoleUser($role_user){$this->role_user = $role_user;}

   public function setIsValid($is_valid) { $this->is_valid = $is_valid; }


  // Méthode pour hasher le mot de passe
  public function hashPassword() {
    return password_hash($this->passWord_user, PASSWORD_BCRYPT);
}

 // Méthode pour vérifier si le mot de passe est correct
 public function verifyPassword($inputPassword) {
    return password_verify($inputPassword, $this->passWord_user);
}



}
?>