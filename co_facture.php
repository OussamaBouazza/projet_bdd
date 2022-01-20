<!DOCTYPE html>

<html lang="fr">
<!-- Page française -->

<head>
    <!-- Nom qui apparait sur l'onglet de navigation -->
    <title> Générer Facture </title>

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
                        <a class="nav-link" href="co_liste">Liste</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="co_facture"><span class="sr-only">(current)</span></a>
                    </li>

                </ul>
            </div>
        </nav>

    </header>

    <main>

        <!--PARTIE CENTRALE -->

        <div id="container1">
            <!-- zone de formulaire -->
            <form action="co_facture.php" method="POST">
                <h1>Consulter les informations d'une commande</h1>

                <label for="id_client"><b>Id:</b></label>
                <input type="text" placeholder="Entrer ID de la commande pour générer sa facture:" name="id_order" required>

                <input type="submit" id='ButtonAdd' value='Générer' name="Générer">

            </form>

            <?php

            if (isset($_GET['erreur'])) {
                $err = $_GET['erreur'];
                if ($err == 1 || $err == 2)
                    echo "<p style='color:red'>Données incohérentes</p>";
            
                    
            } else if (isset($_POST['Générer'])) {
                $id_order = $_POST["id_order"];

                include "connect_sql.php";

                $query = "SELECT * FROM commande WHERE id_order='$id_order'";
                if ($query != 0) {
                    echo "<p style='color:red'>Facture généré</p>";
                } else {
                    echo "<p style='color:red'>La commande n'existe pas !</p>";
                }

                $query = "SELECT id_order FROM commande WHERE id_order=$id_order;";
                $result = $conn->query(utf8_decode($query));
                $row_id = mysqli_fetch_array($result);

                $query = "SELECT id_order FROM order_content WHERE id_order=$row_id[0];";
                $result = $conn->query(utf8_decode($query));
                $row_content = mysqli_fetch_array($result);

                $query = "SELECT id_order, date, prix, id_client, nom_client, nom_item FROM commande
                                NATURAL JOIN client 
                                NATURAL JOIN order_content
                                NATURAL JOIN item 
                                WHERE 1; ";
                $result = $conn->query(utf8_decode($query));
                $row = mysqli_fetch_assoc($result);
                file_put_contents('Facture.txt', $result);
            }

            ?>
            <p id="idBarreInfo"> Donnez l'ID de la commande pour générer sa facture. </p>
        </div>

    </main>
    <!--FIN PARTIE CENTRALE-->
    <!-- Pied de page -->

</body>

</html>