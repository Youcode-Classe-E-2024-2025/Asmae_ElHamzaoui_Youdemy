<?php
abstract class Cours {
    private $id_cours;
    private $titre_cours;
    private $image_cours;
    private $desc_cours;
    private $content_type;
    private $content_cours;

    // Constructeur
    public function __construct($titre_cours, $image_cours = null, $desc_cours, $content_type, $content_cours) {
        $this->titre_cours = $titre_cours;
        $this->image_cours = $image_cours;
        $this->desc_cours = $desc_cours;
        $this->content_type = $content_type;
        $this->content_cours = $content_cours;
    }

    // Getters
    public function getIdCours() {  return $this->id_cours;}
       
    public function getTitreCours() {  return $this->titre_cours; }
       
    public function getImageCours() { return $this->image_cours; }

    public function getDescCours() { return $this->desc_cours; }
        
    public function getContentType() { return $this->content_type; }

    public function getContentCours() {  return $this->content_cours; }

    // Setters
    public function setTitreCours($titre_cours) {  $this->titre_cours = $titre_cours; }
       
    public function setImageCours($image_cours) { $this->image_cours = $image_cours;  }

    public function setDescCours($desc_cours) { $this->desc_cours = $desc_cours; }
        
    public function setContentType($content_type) { $this->content_type = $content_type; }

    public function setContentCours($content_cours) { $this->content_cours = $content_cours;  }

   
     // Méthode abstraite pour ajouter un cours en fonction du type de contenu
     abstract public function ajouterCours();

     // Méthode abstraite pour afficher un cours en fonction du type de contenu
     abstract public function afficherCours();


      // Méthode pour modifier un cours existant
    public function modifierCours() {
        $stmt = $this->pdo->prepare('UPDATE cours SET titre_cours = ?, image_cours = ?, desc_cours = ?, content_type = ?, content_cours = ? WHERE id_cours = ?');
        $stmt->execute([
            $this->getTitreCours(),
            $this->getImageCours(),
            $this->getDescCours(),
            $this->getContentType(),
            $this->getContentCours(),
            $this->getIdCours()
        ]);
    }

   

  
}


class CoursMarkdown extends Cours {

    public function ajouterCours() {
        // Préparer la requête d'insertion pour le type "markdown"
        $stmt = $this->pdo->prepare('INSERT INTO cours (titre_cours, image_cours, desc_cours, content_type, content_cours) 
                                     VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([
            $this->getTitreCours(),
            $this->getImageCours(),
            $this->getDescCours(),
            'markdown',
            $this->getContentCours()
        ]);
        $this->id_cours = $this->pdo->lastInsertId(); // Récupérer l'ID généré
    }


    public function afficherCours() {
        // Afficher le contenu Markdown (ici, on suppose que le contenu est en texte brut ou formaté)
        echo "<div class='markdown-content'>" . nl2br(htmlspecialchars($this->getContentCours())) . "</div>";
    }    
}

class CoursVideo extends Cours {
    public function ajouterCours() {
        // Préparer la requête d'insertion pour le type "video"
        $stmt = $this->pdo->prepare('INSERT INTO cours (titre_cours, image_cours, desc_cours, content_type, content_cours) 
                                     VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([
            $this->getTitreCours(),
            $this->getImageCours(),
            $this->getDescCours(),
            'video',
            $this->getContentCours() // URL de la vidéo
        ]);
        $this->id_cours = $this->pdo->lastInsertId(); // Récupérer l'ID généré
    }
    
    public function afficherCours() {
        // Afficher le contenu vidéo (ici, on suppose que le contenu est une URL vers une vidéo)
        echo "<div class='video-content'>
                <video controls>
                    <source src='" . htmlspecialchars($this->getContentCours()) . "' type='video/mp4'>
                    Votre navigateur ne supporte pas la vidéo.
                </video>
              </div>";
    }
}
?>