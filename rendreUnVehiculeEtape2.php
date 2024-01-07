<!doctype html>
<html lang="fr">
  
<head>
    <meta charset="utf-8">
    <title>Formulaire de Retour de Véhicule</title>
    <link href="rendre.css" rel="stylesheet" />
    <script>
        window.addEventListener('load', function() {
            document.querySelector('.fade-in').style.opacity = 1;
        });

        function validerFormulaire() {
            var kilometrageDepart = <?php echo $kilometrageDepart; ?>;
            var kilometrageRetour = document.getElementById('kilometrageRetour').value;

            if (parseInt(kilometrageRetour) <= parseInt(kilometrageDepart)) {
                alert("Le kilométrage de retour doit être supérieur au kilométrage de départ.");
                return false;
            }

            return true;
        }
    </script>
</head>

<body>
    <center>
        <img src="logo_fac.png" alt="Description" class="fade-in" height="150px" width="300px">
    </center>
    <h1>Formulaire de Retour de Véhicule</h1>
    <a class="lien-styliseNav" href="gestionVehicule.html">Accueil</a>
    <a class="lien-styliseNav" href="prendreUnVehiculeEtape1.php">Prendre un véhicule</a>
    <a class="lien-styliseNav" href="rendreUnVehiculeEtape1.php">Rendre un véhicule</a>
    <a class="lien-styliseNav" href="AjoutModifSuppDesIndividus.php">Gérer les Individus</a>
    <a class="lien-styliseNav" href="AjoutModifSuppDesVehicules.php">Gérer les Véhicules</a><br><br><br>

    <?php
    include 'db.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $idTrajet = $_POST['idTrajet'];
        $kilometrageRetour = $_POST['kilometrageRetour'];
        $dateArrivee = $_POST['dateArrivee'];
        $heureArrivee = $_POST['heureArrivee'];

        $requeteKmDepart = "SELECT kilometrageDepart FROM trajet WHERE idTrajet = ?";
        $stmtKm = $connexionALaBdD->prepare($requeteKmDepart);
        $stmtKm->execute([$idTrajet]);
        $trajet = $stmtKm->fetch();
        $kilometrageDepart = $trajet['kilometrageDepart'];

        if ($kilometrageRetour > $kilometrageDepart) {
            $sql = "UPDATE trajet SET kilometrageRetour = ?, dateArrivee = ?, heureArrivee = ? WHERE idTrajet = ?";
            $stmt = $connexionALaBdD->prepare($sql);
            if ($stmt->execute([$kilometrageRetour, $dateArrivee, $heureArrivee, $idTrajet])) {
                echo "<div class='success-message'>Le véhicule a été retourné avec succès.</div>";
                echo "<br><a href='gestionVehicule.html' class='lien-styliseBack'>Accueil</a>";
            } else {
                echo "<div class='error-message'>Erreur lors de l'enregistrement.</div>";
                echo "<br><a href='gestionVehicule.html' class='lien-styliseBack'>Accueil</a>";
            }
        } else {
            echo "<div class='error-message'>Le kilométrage de retour doit être supérieur au kilométrage de départ.</div>";
            echo "<br><a href='javascript:history.back()' class='lien-styliseBack'>Retour</a><br>";
            echo "<br><a href='gestionVehicule.html' class='lien-styliseBack'>Accueil</a>";
        }
    } else {
        $idTrajet = isset($_GET['idTrajet']) ? intval($_GET['idTrajet']) : 0;

        $sqlImmatriculation = "SELECT immatriculation FROM vehicule WHERE idVehicule = (SELECT idVehicule FROM trajet WHERE idTrajet = :idTrajet)";
        $stmtImmatriculation = $connexionALaBdD->prepare($sqlImmatriculation);
        $stmtImmatriculation->execute([':idTrajet' => $idTrajet]);
        $resultImmatriculation = $stmtImmatriculation->fetch();

        $requeteKmDepart = "SELECT kilometrageDepart FROM trajet WHERE idTrajet = :idTrajet";
        $stmtKm = $connexionALaBdD->prepare($requeteKmDepart);
        $stmtKm->execute([':idTrajet' => $idTrajet]);
        $trajet = $stmtKm->fetch();
        $kilometrageDepart = $trajet['kilometrageDepart'];

        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?idTrajet=<?php echo $idTrajet; ?>" method="post" onsubmit="return validerFormulaire()">

            <input type="hidden" name="idTrajet" value="<?php echo $idTrajet; ?>">

            <?php
            if (empty($resultImmatriculation['immatriculation'])) {
                echo '<input type="hidden" name="kilometrageRetour" value="1">';
            } else {
                echo '<label for="kilometrageRetour">Kilométrage de retour:</label>';
                echo '<input type="number" name="kilometrageRetour" id="kilometrageRetour" required><br><br>';
            }
            ?>

            <label for="dateArrivee">Date d'arrivée:</label>
            <input type="date" name="dateArrivee" id="dateArrivee" required><br><br>

            <label for="heureArrivee">Heure d'arrivée:</label>
            <input type="time" name="heureArrivee" id="heureArrivee" required><br><br>

            <input type="submit" value="Rendre le Véhicule">
            <center>
                <br><br>
                <a class="lien-styliseBack" href="rendreUnVehiculeEtape1.php">Précédent</a>
            </center>
        </form>

    <?php
    }
    ?>

</body>
</html>