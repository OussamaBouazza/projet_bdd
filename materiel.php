
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
				<a href="reservation.php"> <input  id="idButtonBarreNav" value="Mes réservations"/> </a>

                <!--Bouton réserver -->
				<a href="reserver.php"> <input  id="idButtonBarreNav" value="Réserver"/> </a>

			</div>

    <div>
                <!--PARTIE CENTRALE -->

		 <!--Bouton Skates -->

     <a href="skates.php"> <input  id="idButtonMateriel" value="Skates"/> </a>

    <!--Bouton Rollers -->

    <a href="rollers.php"> <input  id="idButtonMateriel" value="Rollers"/> </a>

    <!--Bouton Vélos -->

    <a href="velos.php"> <input  id="idButtonMateriel" value="Vélos"/></a>

    <!--Bouton Trotinettes -->

    <a href="trotinettes.php"> <input  id="idButtonMateriel" value="Trotinettes"/></a>
    
    </div>
    
        </main>                       
		    <!--FIN PARTIE CENTRALE-->
        <!-- Pied de page -->
        <footer>
            <p id="idBarreInfo"> Pret de Skate/vélo/rollers/trotinettes et bien d'autres VL.  Merci de réserver votre matériel à l'aide du formulaire, à la récupération une caution fixe de 100euros vous sera demandé.  </h2>

        
        </footer>
        <script type="text/javascript" src="js/app.js"></script>		<!-- pour inclure javascript -->
    </body>
</html>
