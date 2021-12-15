
<!DOCTYPE html>


<html lang="fr"> 					<!-- Page française -->
    <head>					<!-- Nom qui apparait sur l'onglet de navigation -->
        <title> Accueil - Street'Runners </title>

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
                        // afficher un message
                        echo "<p id='idInfoCo'>Bonjour $user, vous êtes connecté</p>";
                    }
                ?>
                <a href='login.php?deconnexion=true'><p id="idInfoDeco">Déconnexion</p></a>
            </div>          
        </header>	
        <main>            

			<div class="menu nav">

		   		<!-- Bouton Accueil -->
				<a href="accueil.php"> <input  id="idButtonBarreNav" value="Accueil"/> </a>

                <!--Bouton réserver -->
				<a href="reserver.php"> <input  id="idButtonBarreNav" value="Réserver"/> </a>

				<!--Bouton Matériel -->
				<a href="materiel.php"> <input  id="idButtonBarreNav" value="Matériel de pret"/> </a>

			</div>



	<!-- PARTIE CENTRALE -->
	<body>
	<div id="container1">
		<form style=background-color:#515151> 
		<?php
		include "connect_sql.php";	
		
		if ($reponse = $conn->query("SELECT * FROM `Member` WHERE username='".$_SESSION['username']."';")){

			while($ligne = mysqli_fetch_array($reponse)){
			 	$result = $conn->query(utf8_decode("SELECT `Admin` FROM `Member` WHERE `username`='".$_SESSION['username']."';"));
                $row=mysqli_fetch_array($result);
                if($row[0]=='1'){
                    echo "<p id='idInfoCo' style=color:#25bed3> $user, vous êtes un Administrateur,</p>";
                    }
                else{
                    echo "<p id='idInfoCo'> $user, vous êtes un Utilisateur,</p>";
                    }
					echo "<p id='idPresentation'> Votre taille en cm : ".$ligne["Taille"].", votre pointure : ".$ligne["Pointure"]."</p>";
				if($ligne["Resa1"]!=""){
					echo "<h2 id='idPresentation'> Première réservation : ".$ligne["Resa1"]."</h2><a href='reservation.php?rendre=1'><input  id='idButtonBarreNav' value='Rendre'/></a>";
				}
				else{
					echo "<h2 id='idInfoCo'> Aucune réservation de faite.</h2>";
				}
				if($ligne["Resa2"]!=""){
					echo "<h2 id='idPresentation'> Deuxième réservation : ".$ligne["Resa2"]."</h2><a href='reservation.php?rendre=2'><input  id='idButtonBarreNav' value='Rendre'/></a>";
				}
				if($ligne["Resa3"]!=""){
					echo "<h2 id='idPresentation'> Troisième réservation : ".$ligne["Resa3"]."</h2><a href='reservation.php?rendre=3'><input  id='idButtonBarreNav' value='Rendre'/></a>";
				}
				if(isset($_GET['rendre'])){
					if($_GET['rendre']==1){
						$conn->query("UPDATE `Vehicle` SET `Dispo`=`Dispo`+'1' WHERE `Vehicle`.`Nom`='".$ligne["Resa1"]."';");
						$conn->query("UPDATE `Member` SET `Resa`=`Resa`-'1' WHERE `Member`.`username`='".$_SESSION['username']."';");
						$conn->query("UPDATE `Member` SET `Resa1`='".$ligne["Resa2"]."' WHERE `Member`.`username`='".$_SESSION['username']."';");
						$conn->query("UPDATE `Member` SET `Resa2`='".$ligne["Resa3"]."' WHERE `Member`.`username`='".$_SESSION['username']."';");
						$conn->query("UPDATE `Member` SET `Resa3`='' WHERE `Member`.`username`='".$_SESSION['username']."';");
					}
					else if($_GET['rendre']==2){
						$conn->query("UPDATE `Member` SET `Resa`=`Resa`-'1' WHERE `Member`.`username`='".$_SESSION['username']."';");
						$conn->query("UPDATE `Member` SET `Resa2`='".$ligne["Resa3"]."' WHERE `Member`.`username`='".$_SESSION['username']."';");
						$conn->query("UPDATE `Member` SET `Resa3`='' WHERE `Member`.`username`='".$_SESSION['username']."';");
					}
					else{
						$conn->query("UPDATE `Member` SET `Resa`=`Resa`-'1' WHERE `Member`.`username`='".$_SESSION['username']."';");
						$conn->query("UPDATE `Member` SET `Resa3`='' WHERE `Member`.`username`='".$_SESSION['username']."';");
					}
					header ('location: reservation.php');
				}	
			}	
		}
		else{
			echo "bug";
		}
		
		?>

		</form>
	</div>
	
			
	</main> 
	<footer><p id="idBarreInfo"> Les réservations sont valables 30jours </footer>                      
	<!--FIN PARTIE CENTRALE-->
        
        
        <script type="text/javascript" src="js/app.js"></script>		<!-- pour inclure javascript -->
    </body>
</html>
