<!DOCTYPE html>

<html lang="fr">
<!-- Page française -->

<head>
    <!-- Nom qui apparait sur l'onglet de navigation -->
    <title> Supprimer Client </title>

    <meta charset="utf-8">

    <link rel="stylesheet" href="css/style1.css" /> <!-- lien entre html et CSS -->

</head>

<body>
    <header>
        <!-- Barre de navigation -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #5e5f5f;">
            <a class="navbar-brand" href="acceuil.html">Acceuil</a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="cl_consulter">Consulter </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cl_creer">Creer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cl_modifier">Modifier</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cl_supprimer"><span class="sr-only">(current)</span></a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <main>

        <!--PARTIE CENTRALE -->

        <div id="container1">
            <!-- zone de formulaire -->

            <form action="cl_supprimer.php" method="POST">
                <h1>Supprimer un client</h1>

                <label for="nom_client"><b>Nom:</b></label>
                <input type="text" placeholder="Entrer le nom du client à supprimer:" name="nom_client" required>


                <input type="submit" id='ButtonSupp' value='Supprimer' name="Supprimer">
            </form>

            <?php

            include "connect_sql.php";    //connexion à la BDD

            if (isset($_GET['erreur'])) {
                $err = $_GET['erreur'];
                if ($err == 1 || $err == 2)
                    echo "<p style='color:red'>Données incohérentes</p>";   //vérifie si les données entrées sont cohérentes
            } else if (isset($_POST['Supprimer'])) {
                $nom_client = $_POST["nom_client"];

                $query = "SELECT * FROM client WHERE nom_client='$nom_client'";
                if ($query != 0) {
                    echo "<p style='color:red'>Supprimé</p>";
                } else {
                    echo "<p style='color:red'>Le client n'existe pas !</p>";
                }

                $query = "SELECT id_client FROM client WHERE nom_client='$nom_client';";  //Supprime les éléments dans phone, adresse, membership, fidelité et client lié au client.
                $result = $conn->query(utf8_decode($query));
                $row_id = mysqli_fetch_array($result);

                $query = "SELECT id_adresse FROM client WHERE id_client=$row_id[0];";
                $result = $conn->query(utf8_decode($query));
                $row_adr = mysqli_fetch_array($result);

                $query = "SELECT id_phone FROM client WHERE id_client=$row_id[0];";
                $result = $conn->query(utf8_decode($query));
                $row_pho = mysqli_fetch_array($result);

                $query = "SELECT id_fidelite FROM client WHERE id_client=$row_id[0];";
                $result = $conn->query(utf8_decode($query));
                $row_fid = mysqli_fetch_array($result);

                $query = "DELETE FROM client WHERE id_client=$row_id[0]";
                $result = $conn->query(utf8_decode($query));

                $query = "DELETE FROM telephone WHERE id_phone=$row_pho[0]";
                $result = $conn->query(utf8_decode($query));

                $query = "DELETE FROM adresse WHERE id_adresse=$row_adr[0]";
                $result = $conn->query(utf8_decode($query));

                $query = "DELETE FROM fidelite WHERE id_fidelite=$row_fid[0]";
                $result = $conn->query(utf8_decode($query));
            }
            ?>
            <p id="idBarreInfo"> Entrez le nom puis cliquez sur Supprimer. </p>
        </div>

    </main>
    <!--FIN PARTIE CENTRALE-->
    <!-- Pied de page -->

</body>

</html>