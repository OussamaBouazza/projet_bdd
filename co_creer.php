<!DOCTYPE html>

<html lang="fr"> 					<!-- Page française -->
    <head>					<!-- Nom qui apparait sur l'onglet de navigation -->
        <title> Créer Commande </title>

        <meta charset="utf-8">

		<link rel="stylesheet" href="css/style1.css" />		<!-- lien entre html et CSS -->
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
				
				<label for="nom_client"><b>Nom client:</b></label>
                <input type="text" placeholder="Entrez le nom du client qui commande" name="nom_client" required>

                
                <div id="item-inputs">
                    <div class="field">
                        <label for="nom-item-1"><b>Nom de l'article :</b></label>
                        <input type="text" placeholder="Entrez le nom de l'objet à commander" name="nom_item_1" required>
                        
                        <label for="quantite-1"><b>Quantité :</b></label>
                        <input type="number" min="1" placeholder="Entrez la quantité voulue" name="quantite_1" required>
                    </div>            

                </div>

                <input type="button" value="Ajouter item" onClick="addField()"> 
                
                <input type="submit" id='ButtonAdd' value='Commander' name="Commander">
        
            </form>

                <?php

                if(isset($_GET['erreur'])){
                    $err = $_GET['erreur'];
                    if($err==1 || $err==2) 
                        echo "<p style='color:red'>Données incohérentes</p>";
				        }
				
				else if(isset($_POST['Commander'])){
                    $nom_client=$_POST["nom_client"];
                    $nom_item=$_POST["nom_item"];
                    $quantite=$_POST["quantite"];

                    echo "<p style='color:green'>Commandé</p>";
                    include "connect_sql.php";
                    $query="INSERT INTO ";
                    $result = $conn->query(utf8_decode($query));       
                    }
                
				?>
                 <p id="idBarreInfo"> Remplissez toutes les cases pour créer une commande. </p>
        </div> 

        <div>
            <!--Afficher le prix total-->
            <?php
            include "connect_sql.php";

              $query="SELECT prix FROM Item WHERE Nom='nom_item' ";
              $result = $conn->query($query);

              /* echo "<table><tr>";
              while($row = mysqli_fetch_array($result)){
                  echo"<td> </td>";
                }
              echo "</tr></table>";
              mysqli_close($conn); */
              ?>
        </div>
            
        </main>                       
		    <!--FIN PARTIE CENTRALE-->
        <!-- Pied de page -->
        
    </body>
</html>