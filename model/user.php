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


// Méthode pour enregistrer un utilisateur dans la base de données
public function registerUser($db) {
    // Hash du mot de passe
    $hashedPassword = $this->hashPassword();

    // Si l'utilisateur est un enseignant, on laisse is_valid = 0 (en attente de validation)
    if ($this->role_user == 'enseignant') {
        $this->is_valid = 0; // L'utilisateur enseignant est en attente de validation
    } else {
        // Si c'est un étudiant, le compte est directement validé
        $this->is_valid = 1; // L'utilisateur étudiant est validé automatiquement
    }

    // Requête d'insertion de l'utilisateur
    $query = "INSERT INTO utilisateurs (nom_user, email_user, passWord_user, role_user, is_valid) 
              VALUES (?, ?, ?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->execute([$this->nom_user, $this->email_user, $hashedPassword, $this->role_user, $this->is_valid]);

    // Retourner l'ID de l'utilisateur
    return $db->lastInsertId();
}


// Méthode pour se connecter
public function loginUser($db, $inputPassword) {
    // Requête pour récupérer l'utilisateur par email
    $query = "SELECT * FROM utilisateurs WHERE email_user = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$this->email_user]);

    // Vérifier si l'utilisateur existe
    $user = $stmt->fetch();
    if ($user) {
        // Vérifier le mot de passe
        if ($this->verifyPassword($inputPassword)) {
            // Vérifier si l'utilisateur est validé
            if ($user['is_valid'] == 1) {
                return "Connexion réussie.";
            } else if ($user['is_valid'] == 0 && $user['role_user'] == 'enseignant') {
                return "Votre compte est en cours de traitement. Veuillez patienter que l'admin le valide.";
            } else {
                return "Votre compte est désactivé pour le moment.";
            }
        } else {
            return "Mot de passe incorrect.";
        }
    } else {
        return "Utilisateur non trouvé.";
    }
}


}
?>