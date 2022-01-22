<!DOCTYPE html>

<html lang="fr">
<!-- Page française -->

<head>
    <!-- Nom qui apparait sur l'onglet de navigation -->
    <title> Supprimer Commande </title>

    <meta charset="utf-8">

    <link rel="stylesheet" href="css/style1.css" /> <!-- lien entre html et CSS -->

</head>

<body>
    <header>
        <!-- Barre d'informations -->
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
                        <a class="nav-link" href="co_supprimer"><span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="co_liste">Liste</a>
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

            <form action="co_supprimer.php" method="POST">
                <h1>Supprimer une commande</h1>

                <label for="id_client"><b>Id:</b></label>
                <input type="text" placeholder="Entrer ID de la commande à supprimer:" name="id_order" required>


                <input type="submit" id='ButtonSupp' value='Supprimer' name="Supprimer">
            </form>

            <?php

            include "connect_sql.php";

            if (isset($_GET['erreur'])) {
                $err = $_GET['erreur'];
                if ($err == 1 || $err == 2)
                    echo "<p style='color:red'>Données incohérentes</p>";

            } else if (isset($_POST['Supprimer'])) {
                $id_order = $_POST["id_order"];

                $query = "SELECT * FROM commande WHERE id_order=$id_order";
                $result = $conn->query(utf8_decode($query));
                $row = mysqli_fetch_array($result);

                if ($row == NULL) {
                    echo "
                        <div class='client-details'>
                            Cet ID ne correspond à aucune commande.
                        </div>";
                } else {


                    //Supprime les éléments d'une commande

                    /*
                $query = "SELECT id_order_status FROM order_status WHERE id_order=$id_order;";
                $result = $conn->query(utf8_decode($query));
                $row_status = mysqli_fetch_array($result);
                */

                    $id_item_list = [];
                    $quantite_item_list = [];

                    $query = "SELECT id_item,quantite FROM order_content WHERE id_order=$id_order;";
                    $result = $conn->query(utf8_decode($query));
                    $row = mysqli_fetch_assoc($result);

                    while ($row = mysqli_fetch_assoc($result)) {
                        array_push($id_item_list, $row["id_item"]);
                        array_push($quantite_item_list, $row["quantite"]);
                    }

                    $query = "DELETE FROM commande WHERE id_order=$id_order";
                    $result = $conn->query(utf8_decode($query));

                    /*
                     $query = "DELETE FROM order_status WHERE id_order_status=$row_status[0]";
                    $result = $conn->query(utf8_decode($query));
                    */

                    $query = "DELETE FROM order_content WHERE id_order=$id_order";
                    $result = $conn->query(utf8_decode($query));
                    

                    for($i=0;$i<sizeof($id_item_list);$i++) {
                        $query = "UPDATE `item` SET `stock` = stock + $quantite_item_list[$i] WHERE id_item= $id_item_list[0];";
                        //$result = $conn->query(utf8_decode($query));
                        echo "<p> $query </p>";
                    }
                    
        



                    echo "<p style='color:red'>Supprimé</p>";
                }
            }

            ?>
            <p id="idBarreInfo"> Entrez l'id puis cliquez sur Supprimer. </p>
        </div>

    </main>
    <!--FIN PARTIE CENTRALE-->
    <!-- Pied de page -->

</body>

</html>