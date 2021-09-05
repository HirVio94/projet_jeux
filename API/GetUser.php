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
if (filter_input(INPUT_GET, 'idUser', FILTER_SANITIZE_NUMBER_INT)) {
    $idUser = filter_input(INPUT_GET, 'idUser', FILTER_SANITIZE_NUMBER_INT);
    $user = $dao->getUserByIdUser($idUser);
}else{
    if(filter_input(INPUT_GET, 'username', FILTER_SANITIZE_STRING)){
        $username = filter_input(INPUT_GET, 'username', FILTER_SANITIZE_STRING);
        $user = $dao->getUserByUsername($username);
    }
}

http_response_code(200);
// var_dump($jeux);
echo json_encode($user);
