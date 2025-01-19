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
     private $status;

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

    public function getStatus() { return $this->status; }



   //  setters pour la classe user
   public function setNomUser($nom_user){$this->nom_user = $nom_user;}

   public function setEmailUser($email_user){$this->email_user = $email_user;}

   public function setPasswordUser($passWord_user){$this->passWord_user = $passWord_user ;}

   public function setRoleUser($role_user){$this->role_user = $role_user;}

   public function setIsValid($is_valid) { $this->is_valid = $is_valid; }

   public function setStatus($status) { $this->status = $status; }



  // Méthode pour hasher le mot de passe
  public function hashPassword() {
    return password_hash($this->passWord_user, PASSWORD_DEFAULT);
}
// Méthode pour vérifier le mot de passe
public function verifyPassword($inputPassword, $hashedPassword) {
    return password_verify($inputPassword, $hashedPassword);
}

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

    // Si la propriété status n'est pas définie, on lui attribue la valeur par défaut 'désactiver'
    if (empty($this->status)) {
        $this->status = 'activer'; // Valeur par défaut pour la colonne status
    }

    // Requête d'insertion de l'utilisateur
    $query = "INSERT INTO user (user_name, user_email, user_password, user_role, is_valid, status) 
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->execute([$this->nom_user, $this->email_user, $hashedPassword, $this->role_user, $this->is_valid, $this->status]);

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
    $userdb = $stmt->fetch();
    var_dump($userdb) ;
    if ($userdb) {
        // Vérifier le mot de passe avec la méthode verifyPassword
        if (password_verify($inputPassword, $userdb['user_password'])) {
            // Vérifier si l'utilisateur est validé
            if ($userdb['is_valid'] == 1) {
                return "Connexion réussie.";
            } else if ($userdb['is_valid'] == 0 && $userdb['user_role'] == 'enseignant') {
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
    // Vérifier l'état actuel de l'utilisateur
    $query = "SELECT is_valid, status FROM user WHERE id_user = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$this->id_user]);
    $user = $stmt->fetch();

    // Si l'utilisateur est actuellement activé (is_valid = 1 et status = 'activer')
    if ($user && $user['is_valid'] == 1 && $user['status'] == 'activer') {
        // Désactiver l'utilisateur
        $query = "UPDATE user SET is_valid = 0, status = 'désactiver' WHERE id_user = ?";
    } else {
        // Sinon, activer l'utilisateur
        $query = "UPDATE user SET is_valid = 1, status = 'activer' WHERE id_user = ?";
    }

    // Exécuter la mise à jour
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