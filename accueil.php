<!DOCTYPE html>
<!-- Page d'accueil -->

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
              
                <!--Bouton Matériel -->
				<a href="materiel.php"> <input  id="idButtonBarreNav" value="Matériel de pret"/> </a>

                <!--Bouton réservations -->
				<a href="reservation.php"> <input  id="idButtonBarreNav" value="Mes réservations"/> </a>

                <!--Bouton réserver -->
				<a href="reserver.php"> <input  id="idButtonBarreNav" value="Réserver"/> </a>

                <!--Admin Matériel -->
				<a href="administration_matériel.php"> <input  id="idButtonBarreNav" value="Ajouter Matériel (Admin)"/> </a>

                <!--Admin User -->
				<a href="administration_user.php"> <input  id="idButtonBarreNav" value="Ajouter Membre (Admin)"/> </a>

        <p id='idPresentation'> ! Les boutons (Admin) vous renverrons à l'accueil si vous n'avez pas les permissions ! </p>      
			</div>

                <!--PARTIE CENTRALE -->
                    
			<div class="slider">		 <!-- Affiche les images qui deffilent -->
                <div class="sliders">
                    <div class="slide">
                        <?php
                        include "connect_sql.php";

                          $query="SELECT Image FROM Vehicle WHERE Nom='Longboard' ";
                          $result = $conn->query($query);
                          //var_dump($result);
                          //print_r($result);
                          echo "<table><tr>";
                          while($row = mysqli_fetch_array($result)){
                              echo"<td> <img src='$row[0]'/></td>";
                            }
                          echo "</tr></table>";
                          mysqli_close($conn);
                          ?>
                           </div>

                    <div class="slide">
                      <?php
                    include "connect_sql.php";

                      $query="SELECT Image FROM Vehicle WHERE Nom='Skateboard' ";
                      $result = $conn->query($query);                     
                      echo "<table><tr>";
                      while($row = mysqli_fetch_array($result)){
                          echo"<td> <img src='$row[0]'/></td>";
                        }
                      echo "</tr></table>";
                      mysqli_close($conn);
                      ?>
                     </div>
                     <div class="slide">
                       <?php
                     include "connect_sql.php";

                       $query="SELECT Image FROM Vehicle WHERE Nom='VTT_L' ";
                       $result = $conn->query($query);                      
                       echo "<table><tr>";
                       while($row = mysqli_fetch_array($result)){
                           echo"<td> <img src='$row[0]' height='600' width='600'/></td>";
                         }
                       echo "</tr></table>";
                       mysqli_close($conn);
                       ?>
                      </div>

                       <div class="slide">
                         <?php
                       include "connect_sql.php";

                         $query="SELECT Image FROM Vehicle WHERE Nom='VTC_L' ";
                         $result = $conn->query($query);                       
                         echo "<table><tr>";
                         while($row = mysqli_fetch_array($result)){
                             echo"<td> <img src='$row[0]' height='600' width='600'/></td>";
                           }
                         echo "</tr></table>";
                         mysqli_close($conn);
                         ?>
                        </div>
                        <div class="slide">
                           <?php
                         include "connect_sql.php";

                           $query="SELECT Image FROM Vehicle WHERE Nom='TrotinetteAE' ";
                           $result = $conn->query($query);
                           //var_dump($result);
                           //print_r($result);
                           echo "<table><tr>";
                           while($row = mysqli_fetch_array($result)){
                               echo"<td> <img src='$row[0]' height='600' width='600' alt='scene_6'/></td>";
                             }
                           echo "</tr></table>";
                           mysqli_close($conn);
                           ?>
                         </div>
                </div> 
            </div>
        </main>                       
		    <!--FIN PARTIE CENTRALE-->
        <!-- Pied de page -->
        <footer>
            <p id="idBarreInfo"> Pret de Skate/vélo/rollers/trotinettes et bien d'autres VL. Choisissez votre matériel puis réservez le, à la récupération une caution fixe de 100euros vous sera demandé.  </h2>

        </footer>
        <script type="text/javascript" src="js/app.js"></script>		<!-- pour inclure javascript -->				<!-- Barre de navigation -->
    </body>
</html>
