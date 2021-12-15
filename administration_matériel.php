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
                    }
                    else if($_SESSION['username'] !== ""){
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

            <!--Admin User -->
            <a href="administration_user.php"> <input  id="idButtonBarreNav" value="Ajouter Membre"/> </a>

            </div>

                <!--PARTIE CENTRALE -->

        <div id="container1">
            <!-- zone de formulaire -->

            <form action="administration_matériel.php" method="POST">
                <h1>Ajouter matériel</h1>
				
				<label for="Nom"><b>Nom:</b></label>
                <input type="text" placeholder="Entre le nom du véhicule" name="Nom" required>
				
				<label for="Image"><b></br>URL Image:</br></b></label>
                <input type="text" placeholder="URL image" name="Image" >
				
				<label for="Description"><b></br>Description:</br></b></label>
                <input type="text" placeholder="Entrez une description" name="Description" >
				
				<label for="Taille"><b></br>Taille:</b></label>
                <input type="text" placeholder="Taille: Adulte/Enfant" name="Taille" >
                
                <label for="Pointure"><b></br>Pointure:</b></label>
                <input type="text" placeholder="Pointure" name="Pointure" >

                <label for="Dispo"><b></br>Nombre Véhicules:</b></label>
                <input type="text" placeholder="Combien de véhicule au total" name="Dispo" >

                <input type="submit" id='ButtonAdd' value='Ajouter' name="Ajouter">
                <input type="submit" id='ButtonSupp' value='Supprimer' name="Supprimer">
                <input type="submit"  id='ButtonMod'  value='Modifier' name="Modifier">    
                  </form>

                <?php
				
                if(isset($_GET['erreur'])){
                    $err = $_GET['erreur'];
                    if($err==1 || $err==2)
                        echo "<p style='color:red'>Données incohérentes</p>";
				        }
				
				else if(isset($_POST['Ajouter'])){
                    $Nom=$_POST["Nom"];
                    $Image=$_POST["Image"];
                    $Description=$_POST["Description"];
                    $Taille=$_POST["Taille"];
                    $Pointure=$_POST["Pointure"];
                    $Dispo=$_POST["Dispo"];
                    echo "<p style='color:green'>Ajouté</p>";
				    include "connect_sql.php";
				    $query="INSERT INTO Vehicle(Nom,Image,Description,Taille,Dispo,Pointure) VALUES('$Nom', '$Image',' $Description', '$Taille', '$Dispo', '$Pointure')";
			        $result = $conn->query(utf8_decode($query));
                    }
                
                else if(isset($_POST['Supprimer'])){
                    $Nom=$_POST["Nom"];
                    echo "<p style='color:red'>Supprimé</p>";
                    include "connect_sql.php";
                    $query="DELETE FROM Vehicle WHERE Nom='$Nom'";
                    $result = $conn->query(utf8_decode($query));
                }

                else if(isset($_POST['Modifier'])){
                    $Nom=$_POST["Nom"];
                    $Image=$_POST["Image"];
                    $Description=$_POST["Description"];
                    $Taille=$_POST["Taille"];
                    $Pointure=$_POST["Pointure"];
                    $Dispo=$_POST["Dispo"];
                    echo "<p style='color:yellow'>Modifié</p>";
				    include "connect_sql.php";
                    
				    $query="UPDATE `Vehicle` SET `Nom`='$Nom', `Image`= '$Image',`Description`=' $Description',`Taille`= '$Taille', `Dispo`='$Dispo', `Pointure`='$Pointure' WHERE Nom='$Nom'";
			        $result = $conn->query(utf8_decode($query));
                    }
                
				?>
                <p id="idBarreInfo"> Entrez le nom pour supprimer, remplissez toutes les cases pour créer un véhicule. </p>
        </div> 
            
        </main>                       
		    <!--FIN PARTIE CENTRALE-->
        <!-- Pied de page -->
        
                    
        
        <script type="text/javascript" src="js/app.js"></script>		<!-- pour inclure javascript -->	
    </body>
</html>
