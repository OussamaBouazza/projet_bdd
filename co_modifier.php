<!DOCTYPE html>

<html lang="fr">
<!-- Page française -->

<head>
    <!-- Nom qui apparait sur l'onglet de navigation -->
    <title> Modifier Commande </title>

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
                        <a class="nav-link" href="co_modifier"><span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="co_supprimer">Supprimer</a>
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

            <form action="co_modifier.php" method="POST">
                <h1>Modifier une commande</h1>

                <label for="id_commande">ID de la commande :</label>
                <input type="number" name="id_commande" min="1" required>

                <input type="submit" id='ButtonMod' value='Valider' name="valider">
            </form>

        </div>



            <!-- affichage du contenu de la commande -->
            <?php

            if (isset($_GET['erreur'])) {
                $err = $_GET['erreur'];
                if ($err == 1 || $err == 2)
                    echo "<p style='color:red'>Données incohérentes</p>";
            } else if (isset($_POST['valider'])) {
                include "connect_sql.php";
                $id_order = $_POST["id_commande"];

                $query = "SELECT id_item, nom_item, item_price, quantite, prix_total, date_expedition, date_livraison FROM order_content
    NATURAL JOIN item
    WHERE id_order=$id_order;";
                $result = $conn->query(utf8_decode($query));

                if ($result->num_rows == 0) {
                    echo "<h3>Erreur : ID de la commande envoyé n'est pas dans la base de donnée</h2>";
                } else {
                    //construction du tableau avec les détail de chaque item de la commande
                    $tableau = " <form action='co_modifier.php' method='POST'>
        <table>
            <thead>
                <th>Article</th>
                <th>Prix unitaire</th>
                <th>Quantité</th>
                <th>Prix total</th>
                <th>Date d'expédition</th>
                <th>Date de livraison</th>
            </thead>
            <tbody>
            ";


                    //transmet id_order et le nombre d'item pour mettre à jour par la méthode POST
                    $tableau .= "<input type='hidden' name='nb_items' value='$result->num_rows'>
                    <input type='hidden' name='id_order' value='$id_order'>";


                    $i = 0;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $tableau .= "
                <tr>
                    <th>$row[nom_item]</th>
                    <input type='hidden' name='id_item_$i' value='$row[id_item]'>
                    <th>$row[item_price]</th>
                    <th><input type='number' min='1' placeholder='Quantité' value='$row[quantite]' name='quantite_$i' required></th>
                    <th>$row[prix_total]</th>
            ";


                        $tableau .= "<th><input type='date' name='date_expedition_$i' value='$row[date_expedition]'</th>";
                        $tableau .= "<th><input type='date' name='date_livraison_$i' value='$row[date_livraison]'</th>";
                        $tableau .= "</tr>";
                        $i++;
                    }

                    $tableau .= "</tbody></table><input type='submit' id='ButtonAdd' value='Valider modification' name='valider_modif'> </form>";

                    echo $tableau;
                }
            }

            //traitement des modifications + message de confirmation
            else if (isset($_POST['valider_modif'])) {
                include "connect_sql.php";

                $id_order = $_POST["id_order"];
                $nb_items = $_POST["nb_items"];


                for ($i = 0; $i < $nb_items; $i++) {
                    $query = "SELECT quantite FROM order_content WHERE id_item = " . $_POST["id_item_" . $i] . " AND id_order=$id_order;";
                    $result = $conn->query(utf8_decode($query));
                    $stock_before = mysqli_fetch_array($result)[0]; //stock avant la modification

                    //différence entre l'ancien stock et le nouveau modifié
                    $difference =  $_POST["quantite_" . $i] - $stock_before;

                    $query = "UPDATE item SET stock = stock + $difference WHERE id_item =" . $_POST["id_item_" . $i] . ";";
                    $result = $conn->query(utf8_decode($query));


                    //mettre à jour la nouvelle quantité dans order_content
                    $query = "UPDATE order_content SET quantite=" . $_POST["quantite_" . $i];

                    //vérifier si les dates son NULL
                    $_POST["date_expedition_" . $i] != '' ? $query .= ", date_expedition='" . $_POST["date_expedition_" . $i] . "'," : $query .= ", date_expedition=NULL,";
                    $_POST["date_livraison_" . $i] != '' ? $query .= "date_livraison='" . $_POST["date_livraison_" . $i] . "'" : $query .= "date_livraison=NULL";

                    $query .= " WHERE id_order = $id_order AND id_item=" . $_POST["id_item_" . $i] . ";";
                    $conn->query(utf8_decode($query));
                }

                echo "<h2>La commande a été modifiée</h2>";
            }
            ?>
            <p id="idBarreInfo"> Donnez l'ID de la commande pour générer sa facture. </p>
        
    </main>

    <!--FIN PARTIE CENTRALE-->
    <!-- Pied de page -->

</body>


</html>