<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Gestion des Individus</title>
    <link href="Gestion.css" rel="stylesheet" />
    <script>
        window.addEventListener('load', function () {
            document.querySelector('.fade-in').style.opacity = 1;
        });
    </script>

    <?php
    if (isset($_POST['ajouter'])) {
        $civilite = $_POST['civilite'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $mail = $_POST['mail'];

        include('db.php');

        $sqlCheck = "SELECT COUNT(*) FROM personne WHERE nom = :nom AND prenom = :prenom";
        $stmtCheck = $connexionALaBdD->prepare($sqlCheck);
        $stmtCheck->bindParam(':nom', $nom);
        $stmtCheck->bindParam(':prenom', $prenom);
        $stmtCheck->execute();
        $rowCount = $stmtCheck->fetchColumn();

        if ($rowCount > 0) {
            echo "<div class='error-card'>
                L'individu existe déjà. 
              </div>";
            echo "<script>
            setTimeout(function() {
                document.querySelector('.error-card').style.display = 'none';
            }, 4000); // Disparaît après 3 secondes
          </script>";
        } else {
            $sqlInsert = "INSERT INTO personne (civilite, nom, prenom, mail) VALUES (:civilite, :nom, :prenom, :mail)";
            $stmtInsert = $connexionALaBdD->prepare($sqlInsert);
            $stmtInsert->bindParam(':civilite', $civilite);
            $stmtInsert->bindParam(':nom', $nom);
            $stmtInsert->bindParam(':prenom', $prenom);
            $stmtInsert->bindParam(':mail', $mail);

            if ($stmtInsert->execute()) {
                echo "<div class='success-alert'>
                    L'individu a été ajouté avec succès. 
                  </div>";
                echo "<script>
                setTimeout(function() {
                    document.querySelector('.success-alert').style.display = 'none';
                }, 3000); // Disparaît après 3 secondes
              </script>";
            } else {
                $errorInfo = $stmtInsert->errorInfo();
                echo "<div class='error-card'>
                    Erreur lors de l'ajout de l'individu : " . $errorInfo[2] . "
                  </div>";
                echo "<script>
                setTimeout(function() {
                    document.querySelector('.success-alert').style.display = 'none';
                }, 4000); // Disparaît après 3 secondes
              </script>";
            }
        }
    }

    if (isset($_GET['delete'])) {
        $idPersonne = $_GET['delete'];
        include('db.php'); 
    
    
        $sqlDeletePersonne = "DELETE FROM personne WHERE idPersonne = :idPersonne";
        $stmtDeletePersonne = $connexionALaBdD->prepare($sqlDeletePersonne);
        $stmtDeletePersonne->bindParam(':idPersonne', $idPersonne);

        if ($stmtDeletePersonne->execute()) {
            echo "<div class='success-alert' >";
            echo "L'individu a été supprimé avec succès.";
            echo "</div>";
            echo "<script>
                    setTimeout(function() {
                        document.querySelector('.success-alert').style.display = 'none';
                    }, 3000); // Disparaît après 3 secondes
                  </script>";
        } else {
            echo "<div class='error-card' >";
            echo "Erreur lors de la suppression de l'individu.";
            echo "</div>";
            echo "<script>
                    setTimeout(function() {
                        document.querySelector('.success-alert').style.display = 'none';
                    }, 3000); // Disparaît après 3 secondes
                  </script>";
        }
    }
    ?>
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

            <h3>Ajouter un Individu</h3>
        </center>
        <br><br>
 
        <form method="POST" action="AjoutModifSuppDesIndividus.php">
            <div class="custom-radio-container">
                <input type="radio" name="civilite" value="Monsieur" id="monsieur" class="custom-radio">
                <label for="monsieur" class="custom-radio-label">Monsieur</label>

                <input type="radio" name="civilite" value="Madame" id="madame" class="custom-radio">
                <label for="madame" class="custom-radio-label">Madame</label>

                <input type="radio" name="civilite" value="Autre" id="autre" class="custom-radio">
                <label for="autre" class="custom-radio-label">Autre</label>
            </div>

            <br>
            <input type="text" name="nom" placeholder="Nom" required>
            <input type="text" name="prenom" placeholder="Prénom" required>
            <input type="email" name="mail" placeholder="Mail" required>

            <button class="button" type="submit" name="ajouter">
                <span class="span">Ajouter</span>
            </button>
        </form>

        <br>
        <hr><br><br>
        <center>
            <h2>Liste des Individus</h2>
        </center>
        <table>
            <tr>
                <th>ID</th>
                <th>Civilité</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Mail</th>
                <th>Action</th>
            </tr>
            <?php
            include('db.php');
            $sql = "SELECT * FROM personne";
            $resultat = $connexionALaBdD->query($sql);
            while ($row = $resultat->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr >";
                echo "<td>" . $row['idPersonne'] . "</td>";
                echo "<td>" . $row['civilite'] . "</td>";
                echo "<td>" . $row['nom'] . "</td>";
                echo "<td>" . $row['prenom'] . "</td>";
                echo "<td>" . $row['mail'] . "</td>";
                echo "<td><a href='AjoutModifSuppDesIndividus.php?delete=" . $row['idPersonne'] . "' onclick='return confirmDelete()' class='delete-button'>Supprimer</a></td>";
                echo "</tr>";
            }
            ?>
        </table>
        <script>
            function confirmDelete(idPersonne) {
                if (confirm("Êtes-vous sûr de vouloir supprimer cet individu ?")) {
                    window.location.href = "AjoutModifSuppDesIndividus.php?delete=" + idPersonne;
                }
            }
            const tableRows = document.querySelectorAll('table tr');
            tableRows.forEach((row, index) => {
                if (index > 0) {
                    row.style.animation = `fadeIn 1s ${index * 0.2}s ease-out`;
                }
            });
        </script>
    </div>
</body>

</html>