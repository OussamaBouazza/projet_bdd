<!DOCTYPE html>

<html lang="fr"> 					<!-- Page française -->
    <head>					<!-- Nom qui apparait sur l'onglet de navigation -->
        <title> Créer Client </title>

        <meta charset="utf-8">

		<link rel="stylesheet" href="css/style1.css" />		<!-- lien entre html et CSS -->
        <link rel="stylesheet" href="css/cl_consulter.css"/>

    </head>
    <body>
        <header>					<!-- Barre d'informations -->

        </header>

        <main>            

                <!--PARTIE CENTRALE -->

        <div id="container1">
            <!-- zone de formulaire --> 
            <form action="cl_consulter.php" method="POST">
                <h1>Consulter les informations d'un client</h1>
                <p id="idBarreInfo"> Donnez l'ID du client à consulter. </p>
				
				<label for="id_client"><b>Id:</b></label>
                <input type="text" placeholder="Entrer ID du client à consulter:" name="id_client" required>
                
                <input type="submit" id='ButtonAdd' value='Consulter' name="Consulter">
        
            </form>



            <?php

                if(isset($_GET['erreur'])){
                    $err = $_GET['erreur'];
                    if($err==1 || $err==2) 
                        echo "<p style='color:red'>Données incohérentes</p>";
                }
                
                else if(isset($_POST['Consulter'])){
                    $id_client=$_POST["id_client"];
                    echo "<p style='color:green'>Client :</p>";
                    
                    // connect to the database
                    include "connect_sql.php";

                    // envoit une requête demandes les information de l'id_client demandé
                    $query="SELECT nom_client, noPhone, rue, code_postal, ville, facebook_account, instagram_account, email, nom_membership
                        FROM client
                        
                        NATURAL JOIN telephone
                        NATURAL JOIN adresse
                        NATURAL JOIN fidelite
                        NATURAL JOIN membership
                        
                        WHERE id_client=$id_client;";

                    $result = $conn->query(utf8_decode($query));

                    
                    $row = mysqli_fetch_array($result);

                    //si l'id fournit n'est pas dans la base de donnée
                    if($row==NULL){
                        echo "
                        <div class='client-details'>
                            Cet ID ne correspond à aucun client
                        </div>";
                    }
                    else{           // Affichage des caractéristiques du clien demandé
                        echo "
                            <div class='client-details'>
                                <ul>
                                    <li>Nom : ". $row['nom_client'] ." </li>
                                    <li>Compte Facebook : ". $row['facebook_account'] ."</li>
                                    <li>Compte Instagram : ". $row['instagram_account'] ."</li>
                                    <li>Email : ". $row['email'] ."</li>
                                    <li>Adresse : {$row['rue']}, {$row['code_postal']} {$row['ville']} </li>
                                    <li>Numero de téléphone : ". $row['noPhone'] ."</li>
                                    <li>Statut :  ". $row['nom_membership'] ."</li>
                                    
                                </ul>
                            </div>
                        ";
                    }
                    

                }
            ?>

                 
        </div> 
            
        </main>                       
		    <!--FIN PARTIE CENTRALE-->
        <!-- Pied de page -->
        
    </body>
</html>

