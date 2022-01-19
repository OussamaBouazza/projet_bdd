<!DOCTYPE html>

<html lang="fr"> 					<!-- Page française -->
    <head>					<!-- Nom qui apparait sur l'onglet de navigation -->
        <title> Générer Facture </title>

        <meta charset="utf-8">

		<link rel="stylesheet" href="css/style1.css" />		<!-- lien entre html et CSS -->

    </head>
    <body>
        <header>					<!-- Barre d'informations -->

        </header>

        <main>            

                <!--PARTIE CENTRALE -->

        <div id="container1">
            <!-- zone de formulaire --> <form action="co_facture.php" method="POST">
                <h1>Consulter les informations d'une commande</h1>
				
				<label for="id_client"><b>Id:</b></label>
                <input type="text" placeholder="Entrer ID de la commande pour générer sa facture:" name="id_commande" required>
                
                <input type="submit" id='ButtonAdd' value='Générer' name="Générer">
        
            </form>

                <?php

                if(isset($_GET['erreur'])){
                    $err = $_GET['erreur'];
                    if($err==1 || $err==2) 
                        echo "<p style='color:red'>Données incohérentes</p>";
				        }
				
				else if(isset($_POST['Consulter'])){
                    $id_commande=$_POST["id_commande"];
                    echo "<p style='color:green'>Facture généré</p>";

                    include "connect_sql.php";
                   
                    $query="SELECT ...";
                    $result = $conn->query(utf8_decode($query)); 
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


