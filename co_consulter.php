<!DOCTYPE html>

<html lang="fr"> 					<!-- Page française -->
    <head>					<!-- Nom qui apparait sur l'onglet de navigation -->
        <title> Créer Client </title>

        <meta charset="utf-8">

		<link rel="stylesheet" href="css/style1.css" />		<!-- lien entre html et CSS -->

    </head>
    <body>
        <header>					<!-- Barre d'informations -->

        </header>

        <main>            

                <!--PARTIE CENTRALE -->

        <div id="container1">
            <!-- zone de formulaire --> <form action="co_consulter.php" method="POST">
                <h1>Consulter les informations d'une commande</h1>
				
				<label for="id_client"><b>Id:</b></label>
                <input type="text" placeholder="Entrer ID de la commande à consulter:" name="id_commande" required>
                
                <input type="submit" id='ButtonAdd' value='Consulter' name="Consulter">
        
            </form>
            <p id="idBarreInfo"> Donnez l'ID de la commande à consulter. </p>

            <?php

            if(isset($_GET['erreur'])){
                $err = $_GET['erreur'];
                if($err==1 || $err==2) 
                    echo "<p style='color:red'>Données incohérentes</p>";
                    }
            
            else if(isset($_POST['Consulter'])){
                $id_commande=$_POST["id_commande"];
                    echo "<p style='color:green'>Commande :</p>";

                    include "connect_sql.php";
                    
                    //requête pour afficher le clien, la date et le montant de la commande
                    $query = "SELECT nom_client, prix, date FROM commande 
                    NATURAL JOIN client
                    WHERE id_order = $id_commande;";

                    $result = $conn->query(utf8_decode($query));

                    //vérifier si le numéro de commande saisi est dans la bdd
                    if($result->num_rows == 0){
                        echo "<h2>Erreur : le numéro de commande saisi est incorrect</h2>";
                    }
                    else
                    {
                        $data = mysqli_fetch_array($result);
                        
                        $nom_client = $data["nom_client"];
                        $prix_commande = $data["prix"];
                        $date_commande = $data["date"];
    
                        echo "
                            <ul>
                                <li>Client : $nom_client</li>
                                <li>Date de la commande : ". date("d/m/Y", strtotime($date_commande)) ."</li>
                                <li>Prix total de la commande : $prix_commande €</li>
                            </ul>";
    
                        //construction du tableau contenant les détails de la commande
                        $tableau = "<table>
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
    
                        $query = "SELECT nom_item, item_price, quantite, prix_total, date_expedition, date_livraison FROM order_content
                            NATURAL JOIN item
                            WHERE id_order=$id_commande;";
    
                        $result = $conn->query(utf8_decode($query));
                        
                        while($row = mysqli_fetch_assoc($result)){
                            $tableau .= "
                                <tr>
                                    <th>$row[nom_item]</th>
                                    <th>$row[item_price]</th>
                                    <th>$row[quantite]</th>
                                    <th>$row[prix_total]</th>
                                    <th>". date("d/m/Y", strtotime($row["date_expedition"])) ."</th>
                                    <th>". date("d/m/Y", strtotime($row["date_livraison"])) ."</th>
                                </tr>
                            ";
                        }
    
                        $tableau .= "</tbody></table>";
                        echo $tableau;               

                    }
                }

            ?>
        </div> 
        
        
            
        </main>                       
		    <!--FIN PARTIE CENTRALE-->
        <!-- Pied de page -->
        
    </body>
</html>

