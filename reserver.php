
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

                <!--Bouton réservations -->
				<a href="reservation.php"> <input  id="idButtonBarreNav" value="Mes réservation"/> </a>

				<!--Bouton Matériel -->
				<a href="materiel.php"> <input  id="idButtonBarreNav" value="Matériel de pret"/> </a>


			</div>

                <!--PARTIE CENTRALE -->



	<div class="position">
	
		
		<?php
		include "connect_sql.php";

		if ($reponse = $conn->query("SELECT * FROM Vehicle ")){
		
			while($ligne = mysqli_fetch_array($reponse)){
				echo "<div id='idPresentation'><table><tr>";
				echo "<td><h2 id='idPresentation'>" . $ligne["Nom"]. "</h2><img width='200' height='200' style='border-color:#000000;' border='2' src= ". $ligne["Image"] ."></td><td><p id='idPresentation'>Description : ".utf8_encode($ligne["Description"])." </p><p id='idPresentation'>Taille : ".$ligne["Taille"]." </p><p id='idPresentation'>Pointure : ".$ligne["Pointure"]." </p><p id='idPresentation'>Nombre restant : ".$ligne['Dispo']."</p></td>";
				if(isset($_SESSION['username'])){
					echo '<td><a href="reserver.php?reservation='.$ligne["ID"].'"> <input  id="idButtonReserver" value="Reserver"/></a></td>';
					if(isset($_GET['reservation'])){ 
						if($_GET['reservation']==$ligne["ID"]){
							if($ligne['Dispo']==0){
								echo "<p id='idPresentation'>Stock épuisé</p>";
							}
						else{
							$reponse2 = $conn->query("SELECT `Resa1` FROM `Member` WHERE `username`='".$_SESSION['username']."';");
							$ligne2 = mysqli_fetch_array($reponse2);
							if($ligne2[0]!=""){
								$reponse3 = $conn->query("SELECT `Resa2` FROM `Member` WHERE `username`='".$_SESSION['username']."';");
								$ligne3 = mysqli_fetch_array($reponse3);
								if($ligne3[0]!=""){
									$reponse4 = $conn->query("SELECT `Resa3` FROM `Member` WHERE `username`='".$_SESSION['username']."';");
									$ligne4 = mysqli_fetch_array($reponse4);
									if($ligne4[0]!=""){
										echo "<p id='idPresentation' style='color:red'>Pour faire d'autre réservation vous devez en rendre une.</p>";
									}
									else{
										$conn->query("UPDATE `Member` SET `NbResa`=`NbResa`+'1' WHERE `Member`.`username`='".$_SESSION['username']."';");
										$conn->query("UPDATE `Member` SET `Resa3`='".$ligne["Nom"]."' WHERE `Member`.`username`='".$_SESSION['username']."';");
										$conn->query("UPDATE `Vehicle` SET `Dispo`=`Dispo`-'1' WHERE `Vehicle`.Nom='".$ligne["Nom"]."'");
										echo "<p id='idPresentation' style='color:yellow'>Vous avez Reservé un véhicule ".$ligne["Nom"]."</p>";
										$conn->query("UPDATE `Member` SET `Reservations`=CONCAT(`Reservations`,', ".$ligne["Nom"]."') WHERE `Member`.`username`='".$_SESSION['username']."';");
									}
								}
								else{
									$conn->query("UPDATE `Member` SET `NbResa`=`NbResa`+'1' WHERE `Member`.`username`='".$_SESSION['username']."';");
									$conn->query("UPDATE `Member` SET `Resa2`='".$ligne["Nom"]."' WHERE `Member`.`username` = '".$_SESSION['username']."';");
									$conn->query("UPDATE `Vehicle` SET `Dispo`=`Dispo`-'1' WHERE `Vehicle`.`Nom`='".$ligne["Nom"]."';");
									echo "<p id='idPresentation' style='color:yellow'>Vous avez Reservé un véhicule  ".$ligne["Nom"]."</p>";
									$conn->query("UPDATE `Member` SET `Reservations`=CONCAT(`Reservations`,', ".$ligne["Nom"]."') WHERE `Member`.`username`='".$_SESSION['username']."';");
								}								
							}
							else{
								$conn->query("UPDATE `Member` SET `NbResa`=`NbResa`+'1' WHERE `Member`.`username`='".$_SESSION['username']."';");
								$conn->query("UPDATE `Member` SET `Resa1`='".$ligne["Nom"]."' WHERE `Member`.`username`='".$_SESSION['username']."';");
								$conn->query("UPDATE `Vehicle` SET `Dispo`=`Dispo`-'1' WHERE `Vehicle`.Nom='".$ligne["Nom"]."'");
								echo "<p id='idPresentation' style='color:yellow'>Vous avez Reservé un véhicule ".$ligne["Nom"]."</p>";
								$conn->query("UPDATE `Member` SET `Reservations`=CONCAT(`Reservations`,', ".$ligne["Nom"]."') WHERE `Member`.`username`='".$_SESSION['username']."';");
							}	
						}
						}
					}
				}
				echo "</tr></table></div>";
			}
		}
		else{echo "erreur connexion";}
		?>

	</div>
	

			
	</main>                       
	<!--FIN PARTIE CENTRALE-->
        
        
        <script type="text/javascript" src="js/app.js"></script>		<!-- pour inclure javascript -->
    </body>
</html>
