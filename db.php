<?php
try {
    // Paramètres pour se connecter à la base de données :
    $hoteBdD = 'localhost';
    $nomBdD = 'exo';
    $port = '3306';
    $nomUtilisateur = 'root';
    $motDePasse = '';
    
    // $connexionALaBdD est un objet de type PDO
    $connexionALaBdD = new PDO('mysql:host='.$hoteBdD.';port='.$port.';dbname='.$nomBdD.';charset=utf8', $nomUtilisateur, $motDePasse);
} catch (Exception $e) {
    // $e est un objet de type PDOException
    die('Erreur : ' . $e->getMessage());
}