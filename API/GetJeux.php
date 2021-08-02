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
$jeux;
if(filter_input(INPUT_GET, 'idGenre')){
    $genre = filter_input(INPUT_GET, 'idGenre');
    $jeux = $dao->getJeuxByIdGenre($genre);
}else{
    $jeux = $dao->getJeux();
}

$jeuxListe = [];
foreach($jeux as $jeu){
    $genres = $dao->getGenreByJeuxId($jeu['id']);
    $plateformes = $dao->getPlateformeByJeuxId($jeu['id']);
    $classification = $dao->getClassificationByJeuxId($jeu['id']);
    $avis = $dao->getAvisByJeuxId($jeu['id']);
    $noteMoyenne = null;

    if(count($avis) > 0){
        $noteMoyenne = 0;
        foreach($avis as $avi){
            $noteMoyenne += $avi['note'];
        }
        $noteMoyenne = number_format($noteMoyenne / count($avis), 2);
    }

    $jeu['noteMoyenne'] = $noteMoyenne;
    $jeu['genres'] = $genres;
    $jeu['plateformes'] = $plateformes;
    $jeu['classification'] = $classification;
    $jeu['avis'] = $avis;
    $jeuxListe[] = $jeu;    
}

if(filter_input(INPUT_GET,'sortBy')){
    $sortBy = filter_input(INPUT_GET, 'sortBy');

    switch($sortBy){
        case 'note': 
            usort($jeuxListe, 'trieParNote');
            break;
    }
}


// $jeux = json_encode($jeux);
http_response_code(200);
// var_dump($jeux);
echo json_encode($jeuxListe);





function trieParNote($a, $b){
    $aNote = $a['noteMoyenne'];
    $bNote = $b['noteMoyenne'];

    if($aNote == $bNote){
        return 0;
    }else{
        if($aNote > $bNote){
            return -1;
        }else{
            return 1;
        }
    }
}
?>