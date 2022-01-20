<!DOCTYPE html>

<html lang="fr">
<!-- Page française -->

<head>
    <!-- Nom qui apparait sur l'onglet de navigation -->
    <title> Consulter Client </title>

    <meta charset="utf-8">

    <link rel="stylesheet" href="css/style1.css" /> <!-- lien entre html et CSS -->
    <link rel="stylesheet" href="css/cl_consulter.css" />

</head>

<body>
    <header>
        <!-- Barre d'informations -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="acceuil.html">Acceuil</a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="cl_consulter"> <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cl_creer">Creer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cl_modifier">Modifier</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cl_supprimer">Supprimer</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <main>

        <!--PARTIE CENTRALE -->

        <div id="container1">
            <!-- zone de formulaire -->
            <form action="cl_consulter.php" method="POST">
                <h1>Consulter les informations d'un client</h1>
                <p id="idBarreInfo"> Donnez l'ID du client à consulter. </p>

                <label for="id_client"><b>Id:</b></label>
                <input type="text" placeholder="Entrer ID du client à consulter:" name="id_client" required>

                <input type="submit" id='ButtonAdd' value='Consulter' name="Consulter">

            </form>



            <?php

            if (isset($_GET['erreur'])) {
                $err = $_GET['erreur'];
                if ($err == 1 || $err == 2)
                    echo "<p style='color:red'>Données incohérentes</p>";
            } else if (isset($_POST['Consulter'])) {
                $id_client = $_POST["id_client"];
                echo "<p style='color:green'>Client :</p>";

                // connect to the database
                include "connect_sql.php";

                $query = "SELECT * FROM client WHERE id_client='$id_client'";
                if ($query != 0) {
                    echo "<p style='color:red'>Supprimé</p>";
                } else {
                    echo "<p style='color:red'>Le client n'existe pas !</p>";
                }

                // envoit une requête demandes les information de l'id_client demandé
                $query = "SELECT nom_client, noPhone, rue, code_postal, ville, facebook_account, instagram_account, email, nom_membership, nb_point
                        FROM client
                        
                        NATURAL JOIN telephone
                        NATURAL JOIN adresse
                        NATURAL JOIN fidelite
                        NATURAL JOIN membership
                        
                        WHERE id_client=$id_client;";

                $result = $conn->query(utf8_decode($query));


                $row = mysqli_fetch_array($result);

                //si l'id fournit n'est pas dans la base de donnée
                if ($row == NULL) {
                    echo "
                        <div class='client-details'>
                            Cet ID ne correspond à aucun client
                        </div>";
                } else {           // Affichage des caractéristiques du clien demandé
                    echo "
                            <div class='client-details'>
                                <ul>
                                    <li>Nom : " . utf8_encode($row['nom_client']) . " </li>
                                    <li>Compte Facebook : " . ($row['facebook_account'] != NULL ? $row['facebook_account'] : "Aucun") . "</li>
                                    <li>Compte Instagram : " . ($row['instagram_account'] != NULL ? $row['instagram_account'] : "Aucun") . "</li>
                                    <li>Email : " . $row['email'] . "</li>
                                    <li>Adresse : " . utf8_encode($row['rue']) . ", {$row['code_postal']}" . utf8_encode($row['ville']) . "</li>
                                    <li>Numero de téléphone : " . $row['noPhone'] . "</li>
                                    <li>Nombre de points : {$row['nb_point']} </li>
                                    <li>Statut :  " . $row['nom_membership'] . "</li>
                                    
                                </ul>
                            </div>
                        ";
                }
            }
            ?>


        </div>

    </main>
    <!--FIN PARTIE CENTRALE-->
    <!-- Pied de page -->

</body>

</html>