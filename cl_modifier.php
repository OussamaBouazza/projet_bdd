<!DOCTYPE html>

<html lang="fr"> 					<!-- Page française -->
    <head>					<!-- Nom qui apparait sur l'onglet de navigation -->
        <title> Modifier Client </title>

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

            <form action="cl_modifier.php" method="POST">
                <h1>Modifier un client</h1>

				<label for="nom_client"><b>Nom:</b></label>
                <input type="text" placeholder="Entre le nom/pseudo" name="nom_client" required>
				
				<label for="email"><b>Adresse email:</b></label>
                <input type="text" placeholder="Entrez votre adresse mail (facultatif)" name="email" required>

                <label for="facebook_account"><b></br>Facebook:</br></b></label>
                <input type="text" placeholder="Entrez votre facebook (facultatif)" name="facebook_account" >

                <label for="instagram_account"><b></br>Instagram:</br></b></label>
                <input type="text" placeholder="Entrez votre instagram (facultatif)" name="instagram_account" >

                <label for="noPhone"><b></br>Numero telephone:</br></b></label>
                <input type="text" placeholder="Entrez votre numéro de telephone" name="noPhone" >

                <label for="rue"><b></br>Rue:</br></b></label>
                <input type="text" placeholder="Entrez votre rue" name="rue" >

                <label for="code_postal"><b></br>Code postal:</br></b></label>
                <input type="text" placeholder="Entrez votre code postal" name="code_postal" >
                
                <label for="ville"><b></br>Ville:</br></b></label>
                <input type="text" placeholder="Entrez votre ville" name="ville" >

                <!-- menu déroulant pour choisir membership -->

                <label for="nom_membership"><b></br>Membership:</br></b></label>
                <select name="nom_membership">
                    <option value="Silver">Silver</option>
                    <option value="Gold">Gold</option>
                    <option value="Platinium">Platinium</option>
                    <option value="Ultimate">Ultimate</option>
                </select>
                


                <input type="submit"  id='ButtonMod'  value='Modifier' name="Modifier">   
        
            </form>

                <?php

                if(isset($_GET['erreur'])){
                    $err = $_GET['erreur'];
                    if($err==1 || $err==2) 
                        echo "<p style='color:red'>Données incohérentes</p>";   //vérifie si les données entrées sont cohérentes
				        }
				
				
                else if(isset($_POST['Modifier'])){     //création des variables en récupérant les données entrées dans le formulaire
                    $nom_client=$_POST["nom_client"];
                    $email=$_POST["email"];
                    $facebook_account=$_POST["facebook_account"];
                    $instagram_account=$_POST["instagram_account"];
                    $noPhone=$_POST["noPhone"];
                    $rue=$_POST["rue"];
                    $code_postal=$_POST["code_postal"];
                    $ville=$_POST["ville"];
                    $nom_membership=$_POST["nom_membership"];

                    echo "<p style='color:yellow'>Modifié</p>";

                    include "connect_sql.php";       //connexion à la BDD
    
                    $query="SELECT id_client FROM client WHERE nom_client='$nom_client';";  //Update des tables phone, adresse, membership, fidelité et client.
                    $result = $conn->query(utf8_decode($query)); 
                    $row1=mysqli_fetch_array($result);   
                    $query="UPDATE `client` SET `nom_client`='$nom_client', `email`='$email', `facebook_account`='$facebook_account', `instagram_account`='$instagram_account' WHERE id_client=$row1[0]";
                    $result = $conn->query(utf8_decode($query));
                    

                    $query="SELECT id_phone FROM client WHERE id_client=$row1[0];"; 
                    $result = $conn->query(utf8_decode($query)); 
                    $row2=mysqli_fetch_array($result);   
                    $query="UPDATE `telephone` SET `noPhone`='$noPhone' WHERE id_phone=$row2[0]";
                    $result = $conn->query(utf8_decode($query));
                    

                    $query="SELECT id_adresse FROM client WHERE id_client=$row1[0];"; 
                    $result = $conn->query(utf8_decode($query)); 
                    $row3=mysqli_fetch_array($result);   
                    $query="UPDATE `adresse` SET `rue`='$rue', `code_postal`='$code_postal', `ville`='$ville' WHERE id_adresse=$row3[0]";
                    $result = $conn->query(utf8_decode($query));
                    
                    
                    $query="SELECT id_fidelite FROM client WHERE id_client=$row1[0];"; 
                    $result = $conn->query(utf8_decode($query)); 
                    $row4=mysqli_fetch_array($result);
                   
                    $query="SELECT id_membership FROM membership WHERE nom_membership='$nom_membership';"; 
                    $result = $conn->query(utf8_decode($query)); 
                    $row5=mysqli_fetch_array($result);
                    $query="UPDATE `fidelite` SET `id_membership`='$id_membership' WHERE id_fidelite=$row4[0];";
                    $result = $conn->query(utf8_decode($query));
                    
                }
                
				?>
                 <p id="idBarreInfo"> Modifiez les données d'un client en remplissant les cases. </p>
        </div> 
            
        </main>                       
		    <!--FIN PARTIE CENTRALE-->
        <!-- Pied de page -->
        
    </body>
</html>