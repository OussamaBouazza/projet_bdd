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
            <!-- zone de formulaire --> <form action="co_liste.php" method="POST">
                <h1>Générer la liste des commandes</h1>
				
                
                <input type="submit" id='ButtonAdd' value='Générer' name="Générer">
        
            </form>

                <?php
				
				if(isset($_POST['Générer'])){
                    echo "<p style='color:green'>Fichier excel généré</p>";

                    include "connect_sql.php";

                    $tableau = array( 
                        ['Nom', 'Age', 'Civil'], 
                        ['Laurent', 20, 'Homme'], 
                        ['Anne', 25, 'Femme'], 
                        ['Martin', 30, 'Homme'] 
                    );
                    $fp = fopen('fichier.csv', 'w'); 
                    foreach ($tableau as $data) { 
                        fputcsv($fp, $data, ";"); 
                    } 
                    fclose($fp); 
                
                          
                    }
                
				?>
                
        </div> 
            
        </main>                       
		    <!--FIN PARTIE CENTRALE-->
        <!-- Pied de page -->
        
    </body>
</html>


