<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Prise en charge d'un véhicule</title>
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

    <br>
    <a class="lien-styliseNav" href="gestionVehicule.html">Accueil</a>
    <a class="lien-styliseNav" href="prendreUnVehiculeEtape1.php">Prendre un véhicule</a>
    <a class="lien-styliseNav" href="rendreUnVehiculeEtape1.php">Rendre un véhicule</a>


  <div class="container">
    <h1>Prise en charge d'un véhicule</h1>
    <p>Bonjour, vous souhaitez prendre un véhicule.<br>Merci de sélectionner la personne qui souhaite utiliser le véhicule :</p>

    <?php
    include 'db.php';
   
    $requete = 'SELECT idPersonne, civilite, nom, prenom FROM personne';
    $reponse = $connexionALaBdD->prepare($requete);
    $reponse->execute();
     
    while ($donnees = $reponse->fetch()) {
      echo '<div class="personne">';
      echo '<a class="lien-stylise" href="prendreUnVehiculeEtape2.php?idPersonne=' . $donnees['idPersonne'] . '">' . $donnees['civilite'] .'  '. $donnees['nom'] .'  '. $donnees['prenom'] .' </a>';
      echo '</div>';
      
    }
    $reponse->closeCursor();
    ?>
<center>
  <br><br>
    <a class="lien-styliseBack" href="gestionVehicule.html"  class="btnRed">Précédent</a>
  </div>
  </center>
  <div class="footer">
    <p >Projet Réalisé Par IMINE Laeticia</p>
  </div>

</body>
</html>
