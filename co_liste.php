<!DOCTYPE html>

<html lang="fr">
<!-- Page française -->

<head>
    <!-- Nom qui apparait sur l'onglet de navigation -->
    <title> Générer liste commande </title>

    <meta charset="utf-8">

    <link rel="stylesheet" href="css/style1.css" /> <!-- lien entre html et CSS -->

</head>

<body>
    <header>
        <!-- Barre de navigation -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <nav class="navbar navbar-expand-lg navbar-dark" style="background-color:black;">
            <a class="navbar-brand" href="acceuil.html">Acceuil</a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="co_consulter">Consulter</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="co_creer">Creer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="co_modifier">Modifier</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="co_supprimer">Supprimer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="co_liste"><span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="co_facture">Facture</a>
                    </li>

                </ul>
            </div>
        </nav>

    </header>

    <main>

        <!--PARTIE CENTRALE -->

        <div id="container1">
            <!-- zone de formulaire -->
            <form action="co_liste.php" method="POST">
                <h1>Générer la liste des commandes</h1>


                <input type="submit" id='ButtonAdd' value='Générer' name="Générer">

            </form>

            <?php

            if (isset($_POST['Générer'])) {
                echo "<p style='color:green'>Fichier excel généré</p>";

                include "connect_sql.php";

                $query = "SELECT id_order, date, prix, id_client, nom_client, nom_item FROM commande
                                    NATURAL JOIN client 
                                    NATURAL JOIN order_content
                                    NATURAL JOIN item 
                                    WHERE 1;";
                $result = $conn->query(utf8_decode($query));

                $tableau = [];

                while ($row = mysqli_fetch_assoc($result)) {
                    array_push($tableau, $row);
                }
                //var_dump($tableau);

                $fp = fopen('Liste_commandes.csv', 'w');
                foreach ($tableau as $data) {
                    fputcsv($fp, $data, ";");
                }

                fclose($fp);
            }

            ?>

        </div>

    </main>
    <!--FIN PARTIE CENTRALE-->
    <!-- Pied de page -->

</body>

</html>