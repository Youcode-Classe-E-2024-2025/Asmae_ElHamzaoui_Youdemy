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
    $query = "INSERT INTO user (user_name, user_email, user_password, user_role, is_valid) 
              VALUES (?, ?, ?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->execute([$this->nom_user, $this->email_user, $hashedPassword, $this->role_user, $this->is_valid]);

    // Retourner l'ID de l'utilisateur
    return $db->lastInsertId();
}


// Méthode pour se connecter
public function loginUser($db, $inputPassword) {
    // Requête pour récupérer l'utilisateur par email
    $query = "SELECT * FROM user WHERE user_email = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$this->email_user]);

    // Vérifier si l'utilisateur existe
    $user = $stmt->fetch();
    if ($user){
        // Vérifier le mot de passe
        if ($this->verifyPassword($inputPassword)) {
            // Vérifier si l'utilisateur est validé
            if ($user['is_valid'] == 1) {
                return "Connexion réussie.";
            } else if ($user['is_valid'] == 0 && $user['user_role'] == 'enseignant') {
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

 // Méthode pour valider un utilisateur (par l'administrateur)
 public function validateUser($db) {
    // Requête pour mettre à jour l'utilisateur et valider son compte
    $query = "UPDATE user SET is_valid = 1 WHERE id_user = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$this->id_user]);
}

// Méthode pour activer ou désactiver un utilisateur
public function toggleUserActivation($db) {
    // Requête pour alterner le statut d'activation de l'utilisateur
    $query = "UPDATE user SET is_valid = NOT is_valid WHERE id_user = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$this->id_user]);
}


// Méthode pour récupérer un utilisateur par son ID
public static function getUserById($db, $userId) {
    $query = "SELECT * FROM user WHERE id_user = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$userId]);
    return $stmt->fetch();
}

 // Méthode pour récupérer un utilisateur par son email
 public static function getUserByEmail($db, $email) {
    $query = "SELECT * FROM user WHERE user_email = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$email]);
    return $stmt->fetch();
}

// Méthode pour supprimer un utilisateur
public function deleteUser($db) {
    // Requête pour supprimer l'utilisateur par son ID
    $query = "DELETE FROM user WHERE id_user = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$this->id_user]);

    // Vérifier si l'utilisateur a été supprimé avec succès
    if ($stmt->rowCount() > 0) {
        return "Utilisateur supprimé avec succès.";
    } else {
        return "Erreur lors de la suppression de l'utilisateur.";
    }
}

// Méthode pour récupérer les professeurs
public static function getProfesseurs($db) {
    $query = "SELECT * FROM user WHERE user_role = 'enseignant'";
    $stmt = $db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(); // Retourne un tableau de tous les enseignants

}


// Méthode pour récupérer tous les utilisateurs
public static function getAllUsers($db) {
    $query = "SELECT * FROM user";
    $stmt = $db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(); // Retourne un tableau de tous les utilisateurs
}


}
?>