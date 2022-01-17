<!DOCTYPE html>

<html lang="fr"> 					<!-- Page française -->
    <head>					<!-- Nom qui apparait sur l'onglet de navigation -->
        <title> Modifier Commande </title>

        <meta charset="utf-8">

		<link rel="stylesheet" href="css/style1.css" />		<!-- lien entre html et CSS -->

    </head>
    <body>
        <header>					<!-- Barre d'informations -->

        </header>

        <main>            

                <!--PARTIE CENTRALE -->

        <div id="container1">
            <!-- zone de formulaire -->

            <form action="cl_creer.html" method="POST">
                <h1>Modifier une commande</h1>

                <label for="id_commande"><b>N° commande:</b></label>
                <input type="text" placeholder="Entre le numéro de la commande" name="id_commande" required>
                <br/>
                <br/>

                <label for="nom_client"><b>Nom client:</b></label>
                <input type="text" placeholder="Entrez le nom du client qui commande" name="nom_client" required>
				
				<label for="nom_item"><b>Nom item:</b></label>
                <input type="text" placeholder="Entre le nom de l'objet à commander" name="nom_item" required>
				
				<label for="quantite"><b>Quantite:</b></label>
                <input type="text" placeholder="Entrez la quantité voulue" name="quantite" required>
                
                <SCRIPT LANGUAGE="JavaScript">
                    function addField(){
                        var field = "<br><br><label for='nom_item'><b>Nom item:</b></label> <input type='text' placeholder='Entrez le nom de l objet à commander' name='nom_item' /><br/> <label for='quantite'><b>Quantite:</b></label><input type='text' placeholder='Entrez la quantité voulue' name='quantite' value=''/><br/>";
                        document.getElementById('fields').innerHTML += field;
                    }
                </SCRIPT>
                
                <div id="fields">
                </div>
                <input type="button" value="Ajouter un item à modifier/commander/retirer" onClick="addField();"> 
                
                <input type="submit" id='ButtonAdd' value='Ajouter' name="Ajouter">

                <input type="submit" id='ButtonSupp' value='Rendre' name="Rendre">";
            }
        
            </form>

                <?php

                if(isset($_GET['erreur'])){
                    $err = $_GET['erreur'];
                    if($err==1 || $err==2) 
                        echo "<p style='color:red'>Données incohérentes</p>";
				        }
				
				else if(isset($_POST['Ajouter'])){
                    $nom_client=$_POST["nom_client"];
                    $nom_item=$_POST["nom_item"];
                    $quantite=$_POST["quantite"];

                    echo "<p style='color:green'>Commandé</p>";
                    include "connect_sql.php";
                    $query="INSERT INTO ";
                    $result = $conn->query(utf8_decode($query));       
                    }
               
				else if(isset($_GET['Rendre'])){
					if($_GET['Rendre']==1){
						$conn->query("UPDATE `Stock` SET `Dispo`=`Dispo`+'$quantite' WHERE `Item`.`nom_item`='".$ligne["nom_item"]."';"); 
                
				?>
                
                 <p id="idBarreInfo"> Remplissez toutes les cases pour créer une commande. </p>
        </div> 
            
        </main>                       
		    <!--FIN PARTIE CENTRALE-->
        <!-- Pied de page -->
        
    </body>
</html>