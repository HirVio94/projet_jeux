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


}

?>