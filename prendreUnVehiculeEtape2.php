<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Gestion des véhicules</title>
  <link href="prendre.css" rel="stylesheet" />
  <script>
    window.addEventListener('load', function() {
    document.querySelector('.fade-in').style.opacity = 1;
});

  </script>
</head>

<body>

  <center>
  <img src="logo_fac.png" alt="Description" class="fade-in" height="150px" width="300px"></center>
<div class="navbar ">
    <br>
    <a class="lien-styliseNav" href="gestionVehicule.html">Accueil</a>
    <a class="lien-styliseNav" href="prendreUnVehiculeEtape1.php">Prendre un véhicule</a>
    <a class="lien-styliseNav" href="rendreUnVehiculeEtape1.php">Rendre un véhicule</a>
  </div>
  <br><br><br><br>
<div class="container">
  Bonjour

  <strong>
  <?php 
    $idPersonne=$_GET['idPersonne'];
    include 'db.php';

    $requete = "SELECT prenom from personne WHERE idPersonne= $idPersonne";
    $reponse = $connexionALaBdD->prepare($requete);
    $reponse->execute();
    while ($donnees = $reponse->fetch()) {
      echo $donnees['prenom'];
    }
  ?>
  </strong>
  
  , vous souhaitez prendre un véhicule.<br>
  Merci de sélectionner le véhicule que vous souhaitez utiliser<br><br><br>

  <?php
    $requetes = 'SELECT idVehicule, type, marque, immatriculation FROM vehicule';
    $reponses = $connexionALaBdD->prepare($requetes);
    $reponses->execute();

    while ($donnees = $reponses->fetch()) {
      echo '<div class="personne">';
      echo '<a class="lien-stylise"  href="prendreUnVehiculeEtape3-v1.php?idPersonne=' . $idPersonne . '&idVehicule=' . $donnees['idVehicule'] . '">' . $donnees['type'] .' '. $donnees['marque'] .' '. $donnees['immatriculation']. '</a> ';
      echo '</div>';
    }




    $reponses->closeCursor();
  ?>

<center>
  <br><br>
    <a class="lien-styliseBack" href="prendreUnVehiculeEtape1.php"  class="btnRed">Précédent</a>
  </div>
  </center>


</div>

<div class="footer">
  <p>Projet Réalisé Par IMINE Laeticia</p>
</div>

</body>
</html>
