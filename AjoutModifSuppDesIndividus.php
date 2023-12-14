<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Gestion des Individus</title>
    <link href="AjoutModifSuppDesVehicules.css" rel="stylesheet" />
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

        // Vérification si l'individu existe déjà
        $sqlCheck = "SELECT COUNT(*) FROM personne WHERE nom = :nom AND prenom = :prenom";
        $stmtCheck = $connexionALaBdD->prepare($sqlCheck);
        $stmtCheck->bindParam(':nom', $nom);
        $stmtCheck->bindParam(':prenom', $prenom);
        $stmtCheck->execute();
        $rowCount = $stmtCheck->fetchColumn();

        if ($rowCount > 0) {
            // L'individu existe déjà, afficher un message d'erreur
            echo "<div class='error-card'>
                L'individu existe déjà. 
              </div>";
            // Vous pouvez également ajouter un peu de JavaScript pour masquer l'alerte après un certain temps
            echo "<script>
            setTimeout(function() {
                document.querySelector('.error-card').style.display = 'none';
            }, 4000); // Disparaît après 3 secondes
          </script>";
        } else {
            // L'individu est unique, insérer l'individu
            $sqlInsert = "INSERT INTO personne (civilite, nom, prenom, mail) VALUES (:civilite, :nom, :prenom, :mail)";
            $stmtInsert = $connexionALaBdD->prepare($sqlInsert);
            $stmtInsert->bindParam(':civilite', $civilite);
            $stmtInsert->bindParam(':nom', $nom);
            $stmtInsert->bindParam(':prenom', $prenom);
            $stmtInsert->bindParam(':mail', $mail);

            if ($stmtInsert->execute()) {
                // Afficher un message de succès
                echo "<div class='success-alert'>
                    L'individu a été ajouté avec succès. 
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
                    Erreur lors de l'ajout de l'individu : " . $errorInfo[2] . "
                  </div>";
                // Vous pouvez également ajouter un peu de JavaScript pour masquer l'alerte après un certain temps
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
        include('db.php'); // Inclure le fichier db.php pour établir la connexion à la base de données

        // Aucune vérification des enregistrements liés, vous pouvez l'ajouter si nécessaire

        // Supprimer l'individu
        $sqlDeletePersonne = "DELETE FROM personne WHERE idPersonne = :idPersonne";
        $stmtDeletePersonne = $connexionALaBdD->prepare($sqlDeletePersonne);
        $stmtDeletePersonne->bindParam(':idPersonne', $idPersonne);

        if ($stmtDeletePersonne->execute()) {
            // Individu supprimé avec succès, afficher une alerte verte
            echo "<div class='success-alert' >";
            echo "L'individu a été supprimé avec succès.";
            echo "</div>";
            // Vous pouvez également ajouter un peu de JavaScript pour masquer l'alerte après un certain temps
            echo "<script>
                    setTimeout(function() {
                        document.querySelector('.success-alert').style.display = 'none';
                    }, 3000); // Disparaît après 3 secondes
                  </script>";
        } else {
            // Individu supprimé avec succès, afficher une alerte verte
            echo "<div class='error-card' >";
            echo "Erreur lors de la suppression de l'individu.";
            echo "</div>";
            // Vous pouvez également ajouter un peu de JavaScript pour masquer l'alerte après un certain temps
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
            <!-- Replace this with your logo -->
            <img src="logo_fac.png" alt="Description" class="fade-in" height="150px" width="300px">
            <br>
            <!-- Navigation links -->
            <a class="lien-styliseNav" href="gestionIndividus.html">Accueil</a>
            <a class="lien-styliseNav" href="ajouterIndividu.php">Ajouter un Individu</a>
            <a class="lien-styliseNav" href="modifierIndividu.php">Modifier un Individu</a>
            <a class="lien-styliseNav" href="supprimerIndividu.php">Supprimer un Individu</a>
            <a class="lien-styliseNav" href="listeIndividus.php">Liste des Individus</a><br><br><br>
            <!-- Page title -->
            <h3 class="animate-charcter">Ajouter un Individu</h3>
        </center>
        <br><br>
        <!-- Add Individu Form -->
        <!-- Add Individu Form -->
<form method="POST" action="AjoutModifSuppDesIndividus.php">
<!-- Conteneur pour les boutons radio de civilité -->
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
            <!-- Page title -->
            <h2 class="animate-charcter">Liste des Individus</h2>
        </center>
        <!-- Table to display Individus -->
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
        <!-- JavaScript functions -->
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
