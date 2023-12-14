<?php

if (isset($_POST['ajouter'])) {
    $immatriculation = $_POST['immatriculation'];
    $marque = $_POST['marque'];
    $type = $_POST['type'];

    include('db.php');

    // Vérification si l'immatriculation existe déjà
    $sqlCheck = "SELECT COUNT(*) FROM vehicule WHERE immatriculation = :immatriculation";
    $stmtCheck = $connexionALaBdD->prepare($sqlCheck);
    $stmtCheck->bindParam(':immatriculation', $immatriculation);
    $stmtCheck->execute();
    $rowCount = $stmtCheck->fetchColumn();

    if ($rowCount > 0) {
        // L'immatriculation existe déjà, afficher un message d'erreur
        echo "<div class='error-card'>
                L'immatriculation existe déjà. 
              </div>";
        // Vous pouvez également ajouter un peu de JavaScript pour masquer l'alerte après un certain temps
        echo "<script>
            setTimeout(function() {
                document.querySelector('.error-card').style.display = 'none';
            }, 4000); // Disparaît après 3 secondes
          </script>";
    } else {
        // L'immatriculation est unique, insérer le véhicule
        $sqlInsert = "INSERT INTO vehicule (immatriculation, marque, type) VALUES (:immatriculation, :marque, :type)";
        $stmtInsert = $connexionALaBdD->prepare($sqlInsert);
        $stmtInsert->bindParam(':immatriculation', $immatriculation);
        $stmtInsert->bindParam(':marque', $marque);
        $stmtInsert->bindParam(':type', $type);

        if ($stmtInsert->execute()) {
            // Afficher un message de succès
            echo "<div class='success-alert'>
                    Le véhicule a été ajouté avec succès. 
                  </div>";
            // Vous pouvez également ajouter un peu de JavaScript pour masquer l'alerte après un certain temps
            echo "<script>
            setTimeout(function() {
                document.querySelector('.success-alert').style.display = 'none';
            }, 3000); // Disparaît après 3 secondes
          </script>";
        } else {
            // Afficher un message d'erreur en cas d'échec de l'insertion
            $errorInfo = $stmtInsert->errorInfo();
            echo "<div class='error-card'>
                    Erreur lors de l'ajout du véhicule : " . $errorInfo[2] . "
                  </div>";
            // Vous pouvez également ajouter un peu de JavaScript pour masquer l'alerte après un certain temps
            echo "<script>
            setTimeout(function() {
                document.querySelector('.error-card').style.display = 'none';
            }, 4000); // Disparaît après 3 secondes
          </script>";
        }
    }
}



if (isset($_GET['delete'])) {
    $idVehicule = $_GET['delete'];
    include('db.php'); // Inclure le fichier db.php pour établir la connexion à la base de données

    // Vérifier d'abord s'il existe des enregistrements liés dans la table "trajet"
    $sqlCheckTrajets = "SELECT COUNT(*) FROM trajet WHERE idVehicule = :idVehicule";
    $stmtCheckTrajets = $connexionALaBdD->prepare($sqlCheckTrajets);
    $stmtCheckTrajets->bindParam(':idVehicule', $idVehicule);
    $stmtCheckTrajets->execute();
    $rowCount = $stmtCheckTrajets->fetchColumn();

    if ($rowCount > 0) {
        // Il existe des enregistrements liés dans la table "trajet", afficher un message d'erreur dans une carte rouge
        echo "<div class='error-card'> ";
        echo "Impossible de supprimer ce véhicule car il est déjà utilisé dans un trajet.";
        echo "</div>";
        // Vous pouvez également ajouter un peu de JavaScript pour masquer l'alerte après un certain temps
        echo "<script>
                    setTimeout(function() {
                        document.querySelector('.error-card').style.display = 'none';
                    }, 4000); // Disparaît après 3 secondes
                  </script>";
    } else {
        // Aucun enregistrement lié, vous pouvez supprimer le véhicule
        $sqlDeleteVehicule = "DELETE FROM vehicule WHERE idVehicule = :idVehicule";
        $stmtDeleteVehicule = $connexionALaBdD->prepare($sqlDeleteVehicule);
        $stmtDeleteVehicule->bindParam(':idVehicule', $idVehicule);

        if ($stmtDeleteVehicule->execute()) {
            // Véhicule supprimé avec succès, afficher une alerte verte
            echo "<div class='success-alert' >";
            echo "Le véhicule a été supprimé avec succès.";
            echo "</div>";
            // Vous pouvez également ajouter un peu de JavaScript pour masquer l'alerte après un certain temps
            echo "<script>
                    setTimeout(function() {
                        document.querySelector('.success-alert').style.display = 'none';
                    }, 3000); // Disparaît après 3 secondes
                  </script>";
        } else {
            echo "Erreur lors de la suppression du véhicule.";
        }
    }
}


?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Prise en charge d'un véhicule</title>
    <link href="AjoutModifSuppDesVehicules.css" rel="stylesheet" />
    <script>
        window.addEventListener('load', function () {
            document.querySelector('.fade-in').style.opacity = 1;
        });

    </script>
<style>
        /* Add your CSS styles for this page here */
        .error-card {
    background-color: #ffcccc;
    /* Couleur de fond pour les messages d'erreur */
    color: #ff0000;
    /* Couleur du texte pour les messages d'erreur */
    padding: 10px;
    margin: 10px;
    border-radius: 5px;
    display: none;
    /* Masquer initialement l'alerte */
}

.success-alert {
    background-color: #ccffcc;
    /* Couleur de fond pour les messages de succès */
    color: #009900;
    /* Couleur du texte pour les messages de succès */
    padding: 10px;
    margin: 10px;
    border-radius: 5px;
    display: none;
    /* Masquer initialement l'alerte */
}
    </style>
</head>
<body>

    <div>
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
    </div>
    <div class="container">

        <center>
            <img src="logo_fac.png" alt="Description" class="fade-in" height="150px" width="300px">


            <br>
            <a class="lien-styliseNav" href="gestionVehicule.html">Accueil</a>
            <a class="lien-styliseNav" href="prendreUnVehiculeEtape1.php">Prendre un véhicule</a>
            <a class="lien-styliseNav" href="rendreUnVehiculeEtape1.php">Rendre un véhicule</a>
            <a class="lien-styliseNav" href="AjoutModifSuppDesIndividus.php">Gérer les Individus</a>
            <a class="lien-styliseNav" href="AjoutModifSuppDesVehicules.php">Gérer les Véhicules</a><br><br><br>

            <h3 class="animate-charcter"> Ajouter un véhicule</h3>
        </center>
        <br><br>

        <form method="POST" action="AjoutModifSuppDesVehicules.php">
            <input type="text" name="immatriculation" placeholder="Immatriculation">
            <input type="text" name="marque" placeholder="Marque" required>
            <input type="text" name="type" placeholder="type" required>
            <button class="button" type="submit" name="ajouter">
                <span class="span">Ajouter</span>
            </button>
            
        </form>
        <br>
        <hr><br><br>
        <center>
            <h2 class="animate-charcter">Liste des véhicules</h2>
        </center>
        <table>
            <tr>
                <th>ID</th>
                <th>Immatriculation</th>
                <th>Marque</th>
                <th>Type</th>
                <th>Action</th>
            </tr>
            <?php
            include('db.php');

            $sql = "SELECT * FROM vehicule";
            $resultat = $connexionALaBdD->query($sql);

            while ($row = $resultat->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr >";
                echo "<td>" . $row['idVehicule'] . "</td>";
                echo "<td>" . $row['immatriculation'] . "</td>";
                echo "<td>" . $row['marque'] . "</td>";
                echo "<td>" . $row['type'] . "</td>";
                echo "<td><a href='AjoutModifSuppDesVehicules.php?delete=" . $row['idVehicule'] . "' onclick='return confirmDelete()' class='delete-button'>Supprimer</a></td>";
                echo "</tr>";
            }
            ?>
        </table>


        <script>

            function confirmDelete(idVehicule) {
                if (confirm("Êtes-vous sûr de vouloir supprimer ce véhicule ?")) {
                    window.location.href = "AjoutModifSuppDesVehicules.php?delete=" + idVehicule;
                }
            }

            const tableRows = document.querySelectorAll('table tr');
            tableRows.forEach((row, index) => {
                if (index > 0) {
                    row.style.animation = `fadeIn 1s ${index * 0.2}s ease-out`;
                }
            });

            function closeAlert(button) {
                var alert = button.parentElement;
                alert.style.display = 'none';
            }
        </script>

    </div>

</body>


</html>