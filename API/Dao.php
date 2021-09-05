<?php


class Dao{

    private PDO $connect;
    private const DSN = 'mysql:host=localhost;dbname=projet_jeux_video;charset=utf8';
    private const USERNAME = 'root';
    private const PASSWORD = ''; 


    public function __construct()
    {
        $this->connect = new PDO(self::DSN, self::USERNAME, self::PASSWORD);
    }

    public function getJeux(){
        $requete = 'SELECT * FROM `jeux`';
        $stat = $this->connect->prepare($requete);
        $stat->execute();
        $stat->setFetchMode(PDO::FETCH_ASSOC);
        $jeux = $stat->fetchAll();
        return $jeux;
    }

    public function getJeuxById($id){
        $requete = 'SELECT * FROM jeux WHERE id = :jeuxId';
        $stat = $this->connect->prepare($requete);
        $stat->bindParam('jeuxId', $id);
        $stat->execute();
        $stat->setFetchMode(PDO::FETCH_ASSOC);
        return $stat->fetch();
    }

    public function getGenreByJeuxId($jeuxId){
        $requete = 'SELECT libelle_genre, genres.id FROM `jeux` INNER JOIN jeux_genres ON jeux.id = jeux_genres.jeux_id INNER JOIN genres on jeux_genres.genres_id = genres.id WHERE jeux.id = :jeuxId';
        $stat = $this->connect->prepare($requete);
        $stat->bindParam('jeuxId', $jeuxId);
        $stat->execute();
        $stat->setFetchMode(PDO::FETCH_ASSOC);
        return $stat->fetchAll();
    }

    public function getPlateformeByJeuxId($jeuxId){
        $requete = 'SELECT libelle_plateforme FROM `jeux` INNER JOIN jeux_plate_formes ON jeux.id = jeux_plate_formes.jeux_id INNER JOIN plate_formes on jeux_plate_formes.plate_formes_id = plate_formes.id WHERE jeux.id = :jeuxId ';
        $stat = $this->connect->prepare($requete);
        $stat->bindParam('jeuxId', $jeuxId);
        $stat->execute();
        $stat->setFetchMode(PDO::FETCH_ASSOC);
        return $stat->fetchAll();
    }

    public function getClassificationByJeuxId($jeuxId){
        $requete = 'SELECT libelle_classification FROM `jeux` INNER JOIN classifications ON jeux.classification_id = classifications.id WHERE jeux.id = :jeuxId';
        $stat = $this->connect->prepare($requete);
        $stat->bindParam('jeuxId', $jeuxId);
        $stat->execute();
        $stat->setFetchMode(PDO::FETCH_ASSOC);
        return $stat->fetch();
    }

    public function getAvisByJeuxId($jeuxId){
        $requete = 'SELECT avis.message, avis.note FROM `jeux` INNER JOIN avis ON jeux.id = avis.jeux_id WHERE jeux.id = :jeuxId ';
        $stat = $this->connect->prepare($requete);
        $stat->bindParam('jeuxId', $jeuxId);
        $stat->execute();
        $stat->setFetchMode(PDO::FETCH_ASSOC);
        return $stat->fetchAll();
    }

    public function getDevelopeurByJeuxId($jeuxId){
        $requete = 'SELECT developpeurs.libelle_developpeur FROM `jeux` INNER JOIN developpeurs ON jeux.developpeur_id = developpeurs.id WHERE jeux.id = :jeuxId';
        $stat = $this->connect->prepare($requete);
        $stat->bindParam('jeuxId', $jeuxId);
        $stat->execute();
        $stat->setFetchMode(PDO::FETCH_ASSOC);
        return $stat->fetch();
    }

    public function getJeuxByIdGenre($idGenre){
        $requete = 'SELECT jeux.id, jeux.developpeur_id, jeux.classification_id, jeux.titre, jeux.description, jeux.video_path, jeux.couverture_path, jeux.date_sortie, genres.libelle_genre, genres.id AS genre_id FROM `jeux` INNER JOIN jeux_genres ON jeux.id = jeux_genres.jeux_id INNER JOIN genres ON jeux_genres.genres_id = genres.id WHERE genres.id = :genreId ';
        $stat = $this->connect->prepare($requete);
        $stat->bindParam('genreId', $idGenre);
        $stat->execute();
        $stat->setFetchMode(PDO::FETCH_ASSOC);
        return $stat->fetchAll();
    }

    public function getAvis($idJeux){
        $requete = 'SELECT * FROM avis WHERE jeux_id = :jeuxId ORDER BY id DESC';
        $stat = $this->connect->prepare($requete);
        $stat->bindParam('jeuxId', $idJeux);
        $stat->execute();
        $stat->setFetchMode(PDO::FETCH_ASSOC);
        return $stat->fetchAll();

    }

    public function getUserByIdUser($idUser){
        $requete = 'SELECT id, username, roles, email, nom, prenom, date_naissance FROM user WHERE id = :idUser';
        $stat = $this->connect->prepare($requete);
        $stat->bindParam('idUser', $idUser);
        $stat->execute();
        $stat->setFetchMode(PDO::FETCH_ASSOC);
        return $stat->fetch();
    }

    public function getUserByUsername($username){
        $requete = 'SELECT username, roles, email, nom, prenom, date_naissance FROM user WHERE username = :username';
        $stat = $this->connect->prepare($requete);
        $stat->bindParam('username', $username);
        $stat->execute();
        $stat->setFetchMode(PDO::FETCH_ASSOC);
        return $stat->fetch();
    }

    public function getJeuxByPlatformeName($libelle_plateforme){
        $requete = 'SELECT jeux.id, developpeur_id, classification_id, titre, description, video_path, couverture_path, date_sortie FROM `jeux` INNER JOIN jeux_plate_formes ON jeux.id = jeux_id INNER JOIN plate_formes ON plate_formes_id = plate_formes.id WHERE libelle_plateforme = :libelle_plateforme';
        $stat = $this->connect->prepare($requete);
        $stat->bindParam('libelle_plateforme', $libelle_plateforme);
        $stat->execute();
        $stat->setFetchMode(PDO::FETCH_ASSOC);
        return $stat->fetchAll();
    }

    public function getJeuxByTitres($titre){
        $requete = 'SELECT * FROM `jeux` WHERE titre LIKE "%":titre"%"';
        $stat = $this->connect->prepare($requete);
        $stat->bindParam('titre', $titre);
        $stat->execute();
        $stat->setFetchMode(PDO::FETCH_ASSOC);
        return $stat->fetchAll();
    }

    public function getJeuxByTitre($titre){
        $requete = "SELECT * FROM `jeux` WHERE titre = :titre";
        $stat = $this->connect->prepare($requete);
        $stat->bindParam('titre', $titre);
        $stat->execute();
        $stat->setFetchMode(PDO::FETCH_ASSOC);
        return $stat->fetch();
    }

    public function addAvis($jeuxId, $message, $note, $userId){
        $requete = 'INSERT INTO `avis`(`jeux_id`, `message`, `note`, `user_id`) VALUES (:jeuxId, :message, :note, :userId)';
        $stat = $this->connect->prepare($requete);
        $stat->bindParam('jeuxId', $jeuxId);
        $stat->bindParam('message', $message);
        $stat->bindParam('note', $note);
        $stat->bindParam('userId', $userId);
        $stat->execute();
    }

    public function getGenres(){
        $requete = 'SELECT * from genres';
        $stat = $this->connect->prepare($requete);
        $stat->execute();
        $stat->setFetchMode(PDO::FETCH_ASSOC);
        return $stat->fetchAll();
    }

    public function getDeveloppeurs(){
        $requete ='SELECT * from developpeurs';
        $stat = $this->connect->prepare($requete);
        $stat->execute();
        $stat->setFetchMode(PDO::FETCH_ASSOC);
        return $stat->fetchAll();
    }

    public function getJeuxByPlateformeIdGenre($idGenre, $plateforme){
        $requete = 'SELECT SELECT jeux.id, developpeur_id, classification_id, titre, description, video_path, couverture_path, date_sortie, genres.libelle_genre, genres.id AS genre_id, plate_formes.id AS plateforme_id, plate_formes.libelle_plateforme FROM `jeux` INNER JOIN jeux_genres ON jeux.id = jeux_genres.jeux_id INNER JOIN genres ON jeux_genres.genres_id = genres.id INNER JOIN jeux_plate_formes ON jeux.id = jeux_plate_formes.jeux_id INNER JOIN plate_formes ON jeux_plate_formes.plate_formes_id = plate_formes.id WHERE genres.id = :idGenre AND plate_formes.libelle_plateforme = :plateforme';
        $stat = $this->connect->prepare($requete);
        
        $stat->bindParam('idGenre', $idGenre);
        $stat->bindParam('plateforme', $plateforme);
        $stat->execute();
        $stat->setFetchMode(PDO::FETCH_ASSOC);
        return $stat->fetchAll();

    }

}

?>