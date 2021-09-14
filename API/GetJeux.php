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
    if(filter_input(INPUT_GET, 'plateforme')){
        $plateforme = filter_input(INPUT_GET, 'plateforme');
        if($plateforme == 'Tous les jeux'){
            $jeux = $dao->getJeux();
        }else{
            $jeux = $dao->getJeuxByPlatformeName($plateforme);
        }
    }else{
        if(filter_input(INPUT_GET, 'titre')){
            $titre = filter_input(INPUT_GET, 'titre');
            $jeux = $dao->getJeuxByTitres($titre);
        }else{
            $jeux = $dao->getJeux();
        }
        
    }
    
}

$jeuxListe = [];
foreach($jeux as $jeu){
    $genres = $dao->getGenreByJeuxId($jeu['id']);
    $plateformes = $dao->getPlateformeByJeuxId($jeu['id']);
    $classification = $dao->getClassificationByJeuxId($jeu['id']);
    $avis = $dao->getAvisByJeuxId($jeu['id']);
    $developpeur = $dao->getDevelopeurByJeuxId($jeu['id']);
    $noteMoyenne = null;

    if(count($avis) > 0){
        $noteMoyenne = 0;
        foreach($avis as $avi){
            $noteMoyenne += $avi['note'];
        }
        $noteMoyenne = number_format($noteMoyenne / count($avis), 2);
    }

    $jeu['developpeur'] = $developpeur;
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
        case 'recent':
            usort($jeuxListe, 'trieRecent');
            break;
    }
}
if(filter_input(INPUT_GET,'limit')){
    $limit = filter_input(INPUT_GET,'limit', FILTER_SANITIZE_NUMBER_INT);
    array_splice($jeuxListe, $limit);
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

function trieRecent($a, $b){
    $aId = $a['id'];
    $bId = $b['id'];

    if($aId > $bId){
        return -1;
    }else{
        return 1;
    }
}
?>