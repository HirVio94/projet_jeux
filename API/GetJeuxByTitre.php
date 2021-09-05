<?php

include_once 'Dao.php';

// Headers requis
// Accès depuis n'importe quel site ou appareil (*)
header("Access-Control-Allow-Origin: *");

// Format des données envoyées
header("Content-Type: application/json");

// Méthode autorisée
header("Access-Control-Allow-Methods: GET");

// Durée de vie de la requête
header("Access-Control-Max-Age: 3600");

// Entêtes autorisées
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Origin, Authorization, X-Requested-With");

$dao = new Dao();
$titre = filter_input(INPUT_GET, 'titre', FILTER_SANITIZE_SPECIAL_CHARS);
$jeu = $dao->getJeuxByTitre($titre);

$genres = $dao->getGenreByJeuxId($jeu['id']);
$plateformes = $dao->getPlateformeByJeuxId($jeu['id']);
$classification = $dao->getClassificationByJeuxId($jeu['id']);
$avis = $dao->getAvisByJeuxId($jeu['id']);
$developpeur = $dao->getDevelopeurByJeuxId($jeu['id']);
$noteMoyenne = null;

if (count($avis) > 0) {
    $noteMoyenne = 0;
    foreach ($avis as $avi) {
        $noteMoyenne += $avi['note'];
    }
    $noteMoyenne = number_format($noteMoyenne / count($avis), 2);
}

$jeu['noteMoyenne'] = $noteMoyenne;
$jeu['genres'] = $genres;
$jeu['plateformes'] = $plateformes;
$jeu['classification'] = $classification;
$jeu['avis'] = $avis;
$jeu['developpeur'] = $developpeur;




// $jeux = json_encode($jeux);
http_response_code(200);
// var_dump($jeux);
echo json_encode($jeu);
