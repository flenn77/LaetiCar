<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>Mon premier formulaire</title>

    <link href="prendre.css" rel="stylesheet" />

    <script>
    window.addEventListener('load', function() {
        document.querySelector('.fade-in').style.opacity = 1;
    });
    </script>
</head>

<body>

    <center>
        <img src="logo_fac.png" alt="Description" class="fade-in" height="150px" width="300px">
    </center>
    <br>
    <a class="lien-styliseNav" href="gestionVehicule.html">Accueil</a>
    <a class="lien-styliseNav" href="prendreUnVehiculeEtape1.php">Prendre un véhicule</a>
    <a class="lien-styliseNav" href="rendreUnVehiculeEtape1.php">Rendre un véhicule</a>
    <br><br>
    <div class="personne">
        <p>
            <?php
include 'db.php';

$idPersonne = isset($_GET['idPersonne']) ? intval($_GET['idPersonne']) : 0;
$idVehicule = isset($_GET['idVehicule']) ? intval($_GET['idVehicule']) : 0;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['nature'])) {
        echo "Le champ Nature est obligatoire.";
    } else {
        $nature = $_POST['nature'];
    }

    if (empty($_POST['dateDepart'])) {
        echo "Le champ Date de départ est obligatoire.";
    } else {
        $dateDepart = $_POST['dateDepart'];
    }

    if (empty($_POST['heureDepart'])) {
        echo "Le champ Heure de départ est obligatoire.";
    } else {
        $heureDepart = $_POST['heureDepart'];
    }

    if (empty($_POST['lieuDepart'])) {
        echo "Le champ Lieu de départ est obligatoire.";
    } else {
        $lieuDepart = $_POST['lieuDepart'];
    }

    if (empty($_POST['destination'])) {
        echo "Le champ Destination est obligatoire.";
    } else {
        $destination = $_POST['destination'];
    }


    $kilometrageDepart = 0;

    $sql = "INSERT INTO trajet (nature, dateDepart, heureDepart, lieuDepart, destination, kilometrageDepart, dateArrivee, heureArrivee, idPersonne, idVehicule) 
    VALUES (:nature, :dateDepart, :heureDepart, :lieuDepart, :destination, :kilometrageDepart, :dateArrivee, :heureArrivee, :idPersonne, :idVehicule)";

    $stmt = $connexionALaBdD->prepare($sql);

    if ($stmt->execute([
        ':nature' => $nature,
        ':dateDepart' => $dateDepart,
        ':heureDepart' => $heureDepart,
        ':lieuDepart' => $lieuDepart,
        ':destination' => $destination,
        ':kilometrageDepart' => $_POST['kilometrageDepart'],
        ':dateArrivee' => $_POST['dateArrivee'],
        ':heureArrivee' => $_POST['heureArrivee'],
        ':idPersonne' => $idPersonne,
        ':idVehicule' => $idVehicule,
    ])) {

        echo "<br><br><div class='success-container'><br><br>";
        echo "<h1 class='success-message'>Trajet enregistré avec succès</h1>";
        echo "<br><br></div><br><br>";
        echo "<a href='gestionVehicule.html' class='lien-styliseBack'>Retour à l'accueil</a>"; 
        $traitementEffectue = true; 
    } else {
        echo "<p class='error-message'>Erreur lors de l'enregistrement: " . htmlspecialchars($stmt->errorInfo()[2]) . "</p>";
    }

    $stmt->closeCursor();
}

if (!$traitementEffectue):
?>
        </p>
        <form
            action="prendreUnVehiculeEtape3-v1.php?idPersonne=<?php echo $idPersonne; ?>&idVehicule=<?php echo $idVehicule; ?>"
            method="post" onsubmit="return testerSaisie();" name="enregistrerDonnees" class="personne">
            <label for="nature">Nature du trajet:</label>
            <input type="text" id="nature" name="nature" required><br><br>

            <label for="dateDepart">Date de départ:</label>
            <input type="date" id="dateDepart" name="dateDepart" required><br><br>

            <label for="heureDepart">Heure de départ:</label>
            <input type="time" id="heureDepart" name="heureDepart" required><br><br>

            <label for="lieuDepart">Lieu de départ:</label>
            <input type="text" id="lieuDepart" name="lieuDepart" required><br><br>

            <label for="destination">Destination:</label>
            <input type="text" id="destination" name="destination" required><br><br>

            <?php
    $sqlImmatriculation = "SELECT immatriculation FROM vehicule WHERE idVehicule = :idVehicule";
    $stmtImmatriculation = $connexionALaBdD->prepare($sqlImmatriculation);
    $stmtImmatriculation->execute([':idVehicule' => $idVehicule]);
    $resultImmatriculation = $stmtImmatriculation->fetch();

    if (empty($resultImmatriculation['immatriculation'])) {
        echo '<input type="hidden" name="kilometrageDepart" value="0">';
    } else {
        echo '<label for="kilometrageDepart">Kilométrage de départ:</label>';
        echo '<input type="number" id="kilometrageDepart" name="kilometrageDepart" required><br><br>';

    }
    ?>
            <input type="hidden" name="dateArrivee" value="0000-00-00">
            <input type="hidden" name="heureArrivee" value="00:00:00">

            <input type="submit" value="Enregistrer le trajet">
            <a class="lien-styliseBack"
                href="prendreUnVehiculeEtape2.php?idPersonne=<?php echo $idPersonne; ?>">Précédent</a>
        </form>

        <?php endif; ?>

    </div>





    <script type="text/javascript">
    function testerSaisie() {
        var kilometrageDepart = document.forms["enregistrerDonnees"]["kilometrageDepart"].value;
        var kilometrageArrivee = document.forms["enregistrerDonnees"]["kilometrageArrivee"].value;

        if (parseInt(kilometrageDepart, 10) > parseInt(kilometrageArrivee, 10)) {
            alert("Le kilométrage de départ doit être inférieur au kilométrage d'arrivée.");
            return false;
        }
        return true;
    }
    </script>

</body>

</html>