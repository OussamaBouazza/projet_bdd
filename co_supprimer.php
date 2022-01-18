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

                    $query ="SELECT * FROM commande WHERE id_order='$id_order'";
                        if($query!=0) {
                            echo "<p style='color:red'>Supprimé</p>";
                        }
                        else{
                            echo "<p style='color:red'>Le client n'existe pas !</p>";
                        }
                    
                    $query="DELETE FROM commande WHERE id_order=$id_order";
                    $result = $conn->query(utf8_decode($query));
    
                    $query="SELECT id_corder FROM client WHERE nom_client='$nom_client';";  //Supprime les éléments dans phone, adresse, membership, fidelité et client lié au client.
                    $result = $conn->query(utf8_decode($query)); 
                    $row_id=mysqli_fetch_array($result); 
                    
                    $query="SELECT id_adresse FROM client WHERE id_client=$row_id[0];";  
                    $result = $conn->query(utf8_decode($query)); 
                    $row_adr=mysqli_fetch_array($result);   

                    $query="SELECT id_phone FROM client WHERE id_client=$row_id[0];";  
                    $result = $conn->query(utf8_decode($query)); 
                    $row_pho=mysqli_fetch_array($result);   

                    $query="SELECT id_fidelite FROM client WHERE id_client=$row_id[0];";  
                    $result = $conn->query(utf8_decode($query)); 
                    $row_fid=mysqli_fetch_array($result);   

		            $query="DELETE FROM client WHERE id_client=$row_id[0]";
                    $result = $conn->query(utf8_decode($query));

                    $query="DELETE FROM telephone WHERE id_phone=$row_pho[0]";
                    $result = $conn->query(utf8_decode($query));

                    $query="DELETE FROM adresse WHERE id_adresse=$row_adr[0]";
                    $result = $conn->query(utf8_decode($query));

                    $query="DELETE FROM fidelite WHERE id_fidelite=$row_fid[0]";
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

