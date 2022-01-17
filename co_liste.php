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
            <!-- zone de formulaire --> <form action="co_liste.html" method="POST">
                <h1>Générer la liste des commandes</h1>
				
                
                <input type="submit" id='ButtonAdd' value='Générer' name="Générer">
        
            </form>

                <?php
				
				if(isset($_POST['Générer'])){
                    echo "<p style='color:green'>Fichier excel généré</p>";

                    include "connect_sql.php";
                   
                    $query="SELECT ...";
                    $result = $conn->query(utf8_decode($query)); 
                          
                    }
                
				?>
                
        </div> 
            
        </main>                       
		    <!--FIN PARTIE CENTRALE-->
        <!-- Pied de page -->
        
    </body>
</html>


