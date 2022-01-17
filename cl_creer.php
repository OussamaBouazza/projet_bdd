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

                <label for="nom_membership"><b></br>Membership:</br></b></label>
                <select name="nom_membership">
                    <option value="Silver">Silver</option>
                    <option value="Gold">Gold</option>
                    <option value="Platinium">Platinium</option>
                </select>


                <input type="submit" id='ButtonAdd' value='Ajouter' name="Ajouter" >
        
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
                    $nom_membership=$_POST["nom_membership"];

                    include "connect_sql.php";
                    
                    $query="INSERT INTO telephone(noPhone) VALUES('$noPhone')";
                    $result = $conn->query(utf8_decode($query));  
                    $query="SELECT id_phone FROM telephone WHERE noPhone=$noPhone;"; 
                    $result = $conn->query(utf8_decode($query));
                    $row1=mysqli_fetch_array($result);

                    $query="INSERT INTO adresse(rue,code_postal,ville) VALUES('$rue','$code_postal','$ville')";
                    $result = $conn->query(utf8_decode($query)); 
                    $query="SELECT id_adresse FROM adresse WHERE rue='$rue';"; 
                    $result = $conn->query(utf8_decode($query)); 
                    $row2=mysqli_fetch_array($result);

                    $query="INSERT INTO membership(nom_membership) VALUES('$nom_membership')";
                    $result = $conn->query(utf8_decode($query)); 
                    $query="SELECT id_membership FROM membership WHERE nom_membership='$nom_membership';"; 
                    $result = $conn->query(utf8_decode($query)); 
                    $row3=mysqli_fetch_array($result);   

                    $query="INSERT INTO fidelite(id_membership) VALUES($row3[0])";
                    $result = $conn->query(utf8_decode($query)); 
                    $query="SELECT id_fidelite FROM fidelite WHERE id_membership=$row3[0];"; 
                    $result = $conn->query(utf8_decode($query)); 
                    $row4=mysqli_fetch_array($result);   

                    $query="INSERT INTO client(nom_client,email,facebook_account,instagram_account,id_phone,id_adresse,id_fidelite) VALUES('$nom_client','$email','$facebook_account','$instagram_account','$row1[0]','$row2[0]','$row4[0]');";
                    $result = $conn->query(utf8_decode($query));

                    echo "<p style='color:green'>Ajouté</p>";
                    }
                
				?>
                 <p id="idBarreInfo"> Remplissez toutes les cases pour créer un client. </p>
        </div> 
            
        </main>                       
		    <!--FIN PARTIE CENTRALE-->
        <!-- Pied de page -->
        
    </body>
</html>

