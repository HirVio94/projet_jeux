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
$idJeux = filter_input(INPUT_GET, 'idJeux', FILTER_SANITIZE_NUMBER_INT);
$avis = $dao->getAvis($idJeux);
$listeAvis = [];
if(count($avis) > 0){
    foreach($avis as $avi){
        $user = $dao->getUserByIdUser($avi['user_id']);
        $avi['user'] = $user['username'];
        $listeAvis[] = $avi;
    }
}
http_response_code(200);
// var_dump($jeux);
echo json_encode($listeAvis);

?>