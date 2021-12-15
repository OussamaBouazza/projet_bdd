<!DOCTYPE html>

<html lang="fr"> 					<!-- Page française -->
    <head>					<!-- Nom qui apparait sur l'onglet de navigation -->
        <title> Admin - Street'Runners </title>

        <meta charset="utf-8">

		<link rel="stylesheet" href="css/style1.css" />		<!-- lien entre html et CSS -->

    </head>
    <body>
        <header>					<!-- Barre d'informations -->
                <div>	<!-- allignement -->
                    <div class="toggle_btn">			<!-- bouton menu -->
			            <span></span>
		            </div>
                    <p id="idNomMenu"> Menu </p>	<!-- zone de texte dans la barre d'info -->
                </div>
              
                <img id='idImgTitre' src="media/scenes/Street'Runners.png">                  
            <div id='idSession'>
                    
                <!-- tester si l'utilisateur est connecté -->
                <?php
                    session_start();
                    if(isset($_GET['deconnexion'])) { 
                        if($_GET['deconnexion']==true) {  
                                session_unset();
                                header("location:login.php");
                        }
                    } else if($_SESSION['username'] !== ""){
                        $user = $_SESSION['username'];
                        include "connect_sql.php";
				        $result = $conn->query(utf8_decode("SELECT `Admin` FROM `Member` WHERE `username`='".$_SESSION['username']."';"));
                        $row=mysqli_fetch_array($result);
                        
                        if($row[0]=='1'){
                            echo "<p id='idInfoCo'>Bonjour $user, vous êtes connecté</p>";
                        }
                        else{
                            header("location:accueil.php");
                        }
                        
                        // afficher un message
                        
                    }
                ?>
                <a href='login.php?deconnexion=true'><p id="idInfoDeco">Déconnexion</p></a>
            </div>          
        </header>	
        <main>            

			<div class="menu nav">

            <!-- Bouton Accueil -->
			<a href="accueil.php"> <input  id="idButtonBarreNav" value="Accueil"/> </a>

            <!--Bouton réservations -->
            <a href="reservation.php"> <input  id="idButtonBarreNav" value="Réservation"/> </a>

            <!--Bouton Matériel -->
            <a href="materiel.php"> <input  id="idButtonBarreNav" value="Matériel de pret"/> </a>

            <!--Admin Matériel -->
            <a href="administration_matériel.php"> <input  id="idButtonBarreNav" value="Ajouter Matériel"/> </a>

            </div>

                <!--PARTIE CENTRALE -->

        <div id="container1">
            <!-- zone de formulaire -->

            <form action="administration_user.php" method="POST">
                <h1>Ajouter/Supprimer membre</h1>
				
				<label for="username"><b>Nom:</b></label>
                <input type="text" placeholder="Entre le nom/pseudo" name="username" required>
				
				<label for="Ville"><b></br>Ville:</br></b></label>
                <input type="text" placeholder="Entrez le nom de ville" name="Ville" >
				
				<label for="password"><b></br>Mot de passe:</br></b></label>
                <input type="password" placeholder="Entrez un mdp" name="password" required>
				
				<label for="Taille"><b></br>Taille:</b></label>
                <input type="text" placeholder="Taille en cm:" name="Taille" >
                
                <label for="Pointure"><b></br>Pointure:</b></label>
                <input type="text" placeholder="Pointure" name="Pointure" >

                <input type="submit" id='ButtonAdd' value='Ajouter' name="Ajouter">
                <input type="submit" id='ButtonSupp' value='Supprimer' name="Supprimer">
            </form>

                <?php

                if(isset($_GET['erreur'])){
                    $err = $_GET['erreur'];
                    if($err==1 || $err==2) 
                        echo "<p style='color:red'>Données incohérentes</p>";
				        }
				
				else if(isset($_POST['Ajouter'])){
                    $username=$_POST["username"];
                    $Ville=$_POST["Ville"];
                    $password=$_POST["password"];
                    $Taille=$_POST["Taille"];
                    $Pointure=$_POST["Pointure"];
                    $Resa1="";
                    $Resa2="";
                    $Resa3="";
                    $Reservations="";
                    $NbResa=0;
                    $Admin="0";
                    echo "<p style='color:green'>Ajouté</p>";
                    include "connect_sql.php";
                    $query="INSERT INTO Member(username,Ville,Taille,Pointure,password,Resa1,Resa2,Resa3,Reservations,NbResa,Admin) VALUES('$username','$Ville','$Taille','$Pointure','$password','$Resa1','$Resa2','$Resa3','$Reservations','$NbResa','$Admin')";
                    $result = $conn->query(utf8_decode($query));       
                    }
                
                else if(isset($_POST['Supprimer'])){
                    $username=$_POST["username"];
                    $password=$_POST["password"];
                    echo "<p style='color:green'>Supprimé</p>";
                    include "connect_sql.php";
		            $query="DELETE FROM Member WHERE username='$username'";
                    $result = $conn->query(utf8_decode($query));
                    }
				?>
                 <p id="idBarreInfo"> Entrez le nom et le mot de passe pour supprimer, remplissez toutes les cases pour créer un membre. </p>
        </div> 
            
        </main>                       
		    <!--FIN PARTIE CENTRALE-->
        <!-- Pied de page -->
        
                   
        
        <script type="text/javascript" src="js/app.js"></script>		<!-- pour inclure javascript -->
    </body>
</html>
