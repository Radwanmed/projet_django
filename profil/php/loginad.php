<?php
        session_start();
        
        //Déclaration des variables pour stocker le nom du serveur, utilisateur, base
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "auth_db";

     // Création de la connexion au serveur et à la base des données
      $conn = mysqli_connect($servername, $username, $password, $database);
     // Vérification de la connexion
         //if (!$conn) {
           //  die("Échec de la connexion : " . mysqli_connect_error());
          //}
         //echo "Connexion réussie";
          if (isset($_POST['submit'])) {

          
              //if (!empty($_POST['email'])  AND !empty($_POST['password'])) {
          
         

             $nom=$_POST['username'];
             $password=$_POST['password'];
             $error = array();

              if (empty($nom) OR empty($password) ) {
                  
                array_push($error,"veuiller completer  tout les champs");
                //echo "<br/><a href='connexion.html'>retoure  connexion</a>";
              }

             if (!filter_var($nom)) {
                 array_push($error,"veuillser saisire le nom"); 

             }

             if(!filter_var($password)) {
              
             // if (strlen($password)<12) {
                array_push($error,"valide  le mots de passe de votre compte");
           // }

             }
             if (count($error)>0) {
              foreach($error as $error){
                  echo "<div class='alert_alert-danger'>$error</div>";
                 

              }
              echo "<br/><a href='login.html'><button>retoure connexion</button></a>";
            }


             else{

              
             $sql=("SELECT * FROM utilisateurs   WHERE 	username='$nom' AND  password='$password'");
             $result = mysqli_query($conn,$sql);
   
           if (mysqli_fetch_row($result)==0) {
            
               echo "<br/> Erreur :vorte compte ne pas valide veuiellez verifier votre Email ou password !";
               
               echo "<br/><a href='login.html'>retoure  connexion</a>";
              
            
             

           }
   
   
           else{
   
           
    
             header('Location: bibliotheque.html');

             
             exit();
   
            } 

           }
         
            
          

          }

  mysqli_close($conn);


 ?> 