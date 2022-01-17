<!DOCTYPE html>

<html lang="fr"> 					<!-- Page française -->
    <head>					<!-- Nom qui apparait sur l'onglet de navigation -->
        <title> Supprimer Client </title>

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

            <form action="cl_supprimer.php" method="POST">
                <h1>Supprimer un client</h1>
				
				<label for="id_client"><b>Id:</b></label>
                <input type="text" placeholder="Entrer ID du client à supprimer:" name="id_client" required>
				
	
                <input type="submit" id='ButtonSupp' value='Supprimer' name="Supprimer">
            </form>

                <?php

                if(isset($_GET['erreur'])){
                    $err = $_GET['erreur'];
                    if($err==1 || $err==2) 
                        echo "<p style='color:red'>Données incohérentes</p>";
				        }
				
                else if(isset($_POST['Supprimer'])){
                    $id_client=$_POST["id_client"];
                    echo "<p style='color:green'>Supprimé</p>";
                    
                    include "connect_sql.php";
		            $query="DELETE FROM Client WHERE id_client='$id_client'";
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

