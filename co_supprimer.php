<!DOCTYPE html>

<html lang="fr"> 					<!-- Page française -->
    <head>					<!-- Nom qui apparait sur l'onglet de navigation -->
        <title> Supprimer Commande </title>

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

            <form action="co_supprimer.php" method="POST">
                <h1>Supprimer une commande</h1>
				
				<label for="id_client"><b>Id:</b></label>
                <input type="text" placeholder="Entrer ID de la commande à supprimer:" name="id_order" required>
				
	
                <input type="submit" id='ButtonSupp' value='Supprimer' name="Supprimer">
            </form>

                <?php

                if(isset($_GET['erreur'])){
                    $err = $_GET['erreur'];
                    if($err==1 || $err==2) 
                        echo "<p style='color:red'>Données incohérentes</p>";
				}
				
                else if(isset($_POST['Supprimer'])){
                    $id_order=$_POST["id_order"];
                    echo "<p style='color:green'>Supprimé</p>";
                    
                    include "connect_sql.php";
		            $query="DELETE FROM Order WHERE id_order='$id_order'";
                    $result = $conn->query(utf8_decode($query));
                }
                
				?>
                 <p id="idBarreInfo"> Entrez l'id puis cliquez sur Supprimer. </p>
        </div> 
            
        </main>                       
		    <!--FIN PARTIE CENTRALE-->
        <!-- Pied de page -->
        
    </body>
</html>

