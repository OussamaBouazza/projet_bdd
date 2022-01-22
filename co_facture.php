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
                <h1>Générer la facture d'une commande</h1>

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

                /*
                $query = "SELECT * FROM commande WHERE id_order='$id_order'";
                $result = $conn->query(utf8_decode($query));
                $row = mysqli_fetch_array($result);
                */

                $query = "SELECT nom_client, prix, date, rue, ville, code_postal FROM commande 
                NATURAL JOIN client
                NATURAL JOIN adresse
                WHERE id_order = $id_order;";

                $result = $conn->query(utf8_decode($query));
                if($result->num_rows == 0){
                    echo "<h2>Erreur : le numéro de commande saisi est incorrect</h2>";
                }

                else
                {
                    $data = mysqli_fetch_array($result);
                    $nom_client = $data["nom_client"];
                    $prix_commande = $data["prix"];
                    $date_commande = $data["date"];
                    $rue=$data["rue"];
                    $ville=$data["ville"];
                    $code_postal=$data["code_postal"];

                    //construction du tableau contenant les détails de la commande
                    $tableau = "
                    Nom client:  $nom_client
                    Prix commande: $prix_commande
                    Date commande: $date_commande 
                    
                    Rue: $rue
                    Ville: $ville
                    Code Postal: $code_postal             
                    ";

                    $query = "SELECT nom_item, item_price, quantite, prix_total, date_expedition, date_livraison FROM order_content
                        NATURAL JOIN item
                        WHERE id_order=$id_order;";

                    //echo($query);
                    $result = $conn->query(utf8_decode($query));
                    //var_dump($result);

                    while($row = mysqli_fetch_assoc($result)){
                        $tableau .= "

                                Nom item: $row[nom_item]
                                Prix item: $row[item_price]
                                Quantite item: $row[quantite]
                                Prix total: $row[prix_total]
                                Date expedition: ". date("d/m/Y", strtotime($row["date_expedition"])) ."
                                Date livraision: ". date("d/m/Y", strtotime($row["date_livraison"])) ."
                        ";
                    }
                    file_put_contents('Facture.txt', $tableau);

                    echo "<p style='color:green'>Facture générée</p>";
                }
            }
        
            ?>
            <p id="idBarreInfo"> Donnez l'ID de la commande pour générer sa facture. </p>
        </div>

    </main>
    <!--FIN PARTIE CENTRALE-->
    <!-- Pied de page -->

</body>

</html>