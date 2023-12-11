<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Rendre un Véhicule</title>
  <link href="rendre.css" rel="stylesheet" />
  <script>
    window.addEventListener('load', function() {
    document.querySelector('.fade-in').style.opacity = 1;
});

  </script>
</head>

<body>

  <center>
  <img src="logo_fac.png" alt="Description" class="fade-in" height="150px" width="300px"></center>
  <h1>Rendre un Véhicule</h1>
  
  <?php
      // Connexion à la base de données
      include 'db.php';
      

      // Requête pour récupérer les véhicules actuellement utilisés
      $requete = "SELECT t.idTrajet, p.nom, p.prenom, v.marque, v.type, v.immatriculation 
            FROM trajet t
            JOIN personne p ON t.idPersonne = p.idPersonne
            JOIN vehicule v ON t.idVehicule = v.idVehicule
            WHERE t.dateArrivee = '0000-00-00' OR t.heureArrivee = '00:00:00'";


      $reponse = $connexionALaBdD->query($requete);

      // Affichage des résultats
      while ($ligne = $reponse->fetch()) {
        echo "<div class='vehicule-info'>";
        echo "<strong>Nom Prénom :</strong> " . htmlspecialchars($ligne['nom']) .' '. htmlspecialchars($ligne['prenom']) . "<br>";  
        echo "<strong>Marque:</strong> " . htmlspecialchars($ligne['marque']) . "<br> ";
        echo "<strong>Type:</strong> " . htmlspecialchars($ligne['type']) . "<br> ";
        echo "<strong>Immatriculation:</strong> " . htmlspecialchars($ligne['immatriculation']) . "<br>";
        echo "<a href='rendreUnVehiculeEtape2.php?idTrajet=" . htmlspecialchars($ligne['idTrajet']) . "' class='lien-stylise'>Rendre ce véhicule</a>";
        echo "</div>";
        
    }
    echo "<a href='gestionVehicule.html' class='lien-styliseBack'>Précedent</a>";
    $reponse->closeCursor();
  ?>
</body>
</html>
