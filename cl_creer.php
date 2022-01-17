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
            <!-- zone de formulaire -->

            <form action="cl_creer.php" method="POST">
                <h1>Creer un client</h1>
				
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
                
                <input type="submit" id='ButtonAdd' value='Ajouter' name="Ajouter">
        
            </form>

                <?php

                if(isset($_GET['erreur'])){
                    $err = $_GET['erreur'];
                    if($err==1 || $err==2) 
                        echo "<p style='color:red'>Données incohérentes</p>";
				        }
				
				else if(isset($_POST['Ajouter'])){
                    $nom_client=$_POST["nom_client"];
                    $email=$_POST["email"];
                    $facebook_account=$_POST["facebook_account"];
                    $instagram_account=$_POST["instagram_account"];
                    $noPhone=$_POST["noPhone"];
                    $rue=$_POST["rue"];
                    $code_postal=$_POST["code_postal"];
                    $ville=$_POST["ville"];
                    

                    echo "<p style='color:green'>Ajouté</p>";
                    include "connect_sql.php";
                    $query="INSERT INTO client(nom_client,email,facebook_account,instagram_account) VALUES('$nom_client','$email','$facebook_account','$instagram_account')";
                    $result = $conn->query(utf8_decode($query));
                    $query="INSERT INTO telephone(noPhone) VALUES('$noPhone')";
                    $result = $conn->query(utf8_decode($query)); 
                    $query="INSERT INTO adresse(rue,code_postal,ville) VALUES('$rue','$code_postal','$ville')";
                    $result = $conn->query(utf8_decode($query));          
                    }
                
				?>
                 <p id="idBarreInfo"> Remplissez toutes les cases pour créer un client. </p>
        </div> 
            
        </main>                       
		    <!--FIN PARTIE CENTRALE-->
        <!-- Pied de page -->
        
    </body>
</html>

