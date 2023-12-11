<?php
try {
    
    $hoteBdD = 'localhost';
    $nomBdD = 'exo';
    $port = '3306';
    $nomUtilisateur = 'root';
    $motDePasse = '';
    
    $connexionALaBdD = new PDO('mysql:host='.$hoteBdD.';port='.$port.';dbname='.$nomBdD.';charset=utf8', $nomUtilisateur, $motDePasse);
} catch (Exception $e) {
    
    die('Erreur : ' . $e->getMessage());
}