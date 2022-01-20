<!DOCTYPE html>

<html lang="fr"> 					<!-- Page française -->
    <head>					<!-- Nom qui apparait sur l'onglet de navigation -->
        <title> Créer Commande </title>

        <meta charset="utf-8">

		<link rel="stylesheet" href="css/style1.css" />		<!-- lien entre html et CSS -->
		<link rel="stylesheet" href="css/co_creer.css" />		
        <script src="script/co_cree.js"></script>

    </head>
    <body>
        <header>					<!-- Barre d'informations -->

        </header>

        <main>            

                <!--PARTIE CENTRALE -->

        <div id="container1">
            <!-- zone de formulaire -->

            <form action="co_creer.php" method="POST">
                <h1>Creer une commande</h1>
				
				<label for="id_client"><b>ID du client:</b></label>
                <input type="number" placeholder="Entrez le nom du client qui commande" name="id_client" required>

                
                <div id="item-inputs">
                    <div class="field">
                        <label for="nom-item-1"><b>Nom de l'article :</b></label>
                        <input type="text" placeholder="Entrez le nom de l'objet à commander" name="nom_item_1" required>
                        
                        <label for="quantite-1"><b>Quantité :</b></label>
                        <input type="number" min="1" placeholder="Entrez la quantité voulue" name="quantite_1" required>
                    </div>            

                </div>

                <input type="button" value="Ajouter item" onClick="addField()"> 
                
                <input type="submit" id='ButtonAdd' value='Commander' name="Commander" onClick="setNbItemsCookie()">
        
            </form>

            <p id="idBarreInfo"> Remplissez toutes les cases pour créer une commande. </p>

            <?php

                if(isset($_GET['erreur'])){
                    $err = $_GET['erreur'];
                    if($err==1 || $err==2) 
                        echo "<p style='color:red'>Données incohérentes</p>";
                        }
                
                else if(isset($_POST['Commander'])){
                    include "connect_sql.php";      //connection à la base de donnée

                    $id_client = $_POST["id_client"];


                    //vérifie si l'id du client est dans la base de donnée
                    $query="SELECT COUNT(*) FROM client WHERE id_client=$id_client"; 
                    $result = $conn->query(utf8_decode($query));
                    $id_client_query = mysqli_fetch_array($result)[0];

                    if($id_client_query=="1"){
                        $nbItem =  $_COOKIE["nbItems"];     //nombre d'objets dans la commande
                        $item_list = [];    //liste des objets commandé avec leur quantité
                        
                        for($i=1; $i<=$nbItem; $i++){
                            $name = $_POST["nom_item_".$i];     
                            $quantite = $_POST["quantite_".$i];
    
                            //créer un objet standart stockant l'item et la quantité commandée et les ajouter dans item_list
                            $obj = new stdClass;
                            $obj->nom = $name;
                            $obj->quantite = $quantite;
    
                            array_push($item_list, $obj);
                        }

                        //vérifier si les items demandé sont bien dans la base de donnée
                        $query = "SELECT id_item FROM item WHERE nom_item IN (";

                        //construire la requete sql en complétant avec le nom des items de $item_list 
                        for ($i=0; $i < sizeof($item_list); $i++) { 
                            if($i < sizeof($item_list)-1){
                                $query .= "'". $item_list[$i]->nom ."', ";
                            }
                            //pour le dernier item, on ferme la parenthèse de la requête
                            else{
                                $query .= "'". $item_list[$i]->nom ."'); ";
                            }
                        }
                        

                        $result = $conn->query(utf8_decode($query));
                        
                        //vérifier que TOUT les items sont dans la bdd sinon afficher un message d'erreur
                        if($result->num_rows == $nbItem){
                            $id_item_list = [];      //tableau contenant tout les id_items à ajouter dans la commande
                            
                            //récupérer les id_items à insérer dans la bdd
                            while($rows = mysqli_fetch_assoc($result)){
                                array_push($id_item_list, $rows["id_item"]);  
                            }

                            //ajouter l'id de l'item correspondant dans $item_list 
                            for ($i=0; $i < sizeof($item_list); $i++) { 
                                $item_list[$i]->id_item = $id_item_list[$i];
                            }


                            //vérifier qu'il y a assez de stock pour chaque item
                            $i = 0;
                            $in_stock = true;
                            while($i<sizeof($item_list) && $in_stock){
                                $query = "SELECT stock FROM item WHERE id_item =". $item_list[$i]->id_item .";";
                                $result = $conn->query(utf8_decode($query));
                                $stock= mysqli_fetch_array($result)[0];
                                

                                //message d'erreur s'il n'y a pas assez de stock pour un article et quitte la boucle
                                if($stock < $item_list[$i]->quantite){
                                    echo "<h2>Il n'y a pas assez de stock pour cet article : ". $item_list[$i]->nom."</h2>";
                                    $in_stock = false;
                                }
                                
                                $i++;
                            }



                            if($in_stock){
                                //récupérer le prix unitaire de chaque item
                                foreach($item_list as $item){
                                    $query = "SELECT item_price FROM item WHERE id_item=". $item->id_item .";";
                                    $result = $conn->query(utf8_decode($query));
                                    $item->item_price = mysqli_fetch_array($result)[0];
                                }
    
                                //créer une ligne dans la table commande
                                $query = "INSERT INTO commande (id_client, date) VALUES ($id_client, '". date("Y-m-d") ."');";
                                $conn->query(utf8_decode($query));
                                $id_order = $conn->insert_id;       //id de la commande crée
    
                                //message de confirmation de la commande affiché une fois que la demande est validée
                                $confirmation = "
                                <div id='confirmation'>
                                    <h2>Votre commande a été validée</h2>
                                    <table>
                                        <thead>
                                            <th>Article</th>
                                            <th>Quantité</th>
                                            <th>Prix unitaire</th>
                                            <th>Prix total</th>
                                        </thead>

                                        <tbody>";

                                $total = 0; //prix de la comande


                                // ajouter une ligne dans order_content pour chaque item de la liste et mettre à jour le stock
                                foreach($item_list as $item){
                                    $query = "INSERT INTO order_content(id_order, id_item, quantite, prix_total) VALUES ($id_order, $item->id_item, $item->quantite,". $item->item_price * $item->quantite.");\n";
                                    $conn->query(utf8_decode($query));
                                    
                                    $query = "UPDATE item SET stock = stock - $item->quantite WHERE id_item= $item->id_item; ";
                                    $conn->query(utf8_decode($query));

                                    $total += $item->item_price * $item->quantite;

                                    //créer un champ dans le tableau de récapitulatif avec les info du produit
                                    $confirmation .= 
                                        "<tr>
                                            <th>". $item->nom."</th>
                                            <th>". $item->quantite ."</th>
                                            <th>". $item->item_price ."€</th>
                                            <th>". $item->item_price * $item->quantite ."€</th>
                                        </tr>";

                                }

                                $query = "UPDATE commande SET prix = $total WHERE id_order=$id_order; ";
                                $conn->query(utf8_decode($query));

                                $confirmation .= "</tbody></table></div>";
                                $confirmation .= "<h3>Total : ". $total ."€</h3>" ;
                                echo $confirmation;

                            }
                        }
                        //message d'erreur si l'un des article n'est pas dans la base de donnée
                        else{
                            echo "<h2>Erreur : un des article saisi n'est pas connu</h2>";
                        }
                        

                    }
                    else{
                        echo "<h2>ID client inconnu </h2>";
                    }
                }
            
            ?>

        </div>             
        </main>                       
		    <!--FIN PARTIE CENTRALE-->
        <!-- Pied de page -->
        
    </body>
</html>