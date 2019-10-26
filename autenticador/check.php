<?php
session_start();
require "Authenticator.php";
if ($_SERVER['REQUEST_METHOD'] != "POST") {
    header("location: aut.php");
    die();
}
$Authenticator = new Authenticator();

$checkResult = $Authenticator->verifyCode($_SESSION['auth_secret'], $_POST['code'], 2);    // 2 = 2*30sec clock tolerance

if (!$checkResult) {
    $_SESSION['failed'] = true;
    header("location: aut.php");
    die();
} 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Authentication Successful</title>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
   
    <style>
        body,html {
            height: 100%;
        }       


        .bg { 
            /* The image used */
            background: gray;
            /* Full height */
            height: 100%; 
            /* Center and scale the image nicely */
            background-position: center;
            background-repeat: no-repeat;
           
            background-size: cover;
        }
    </style>
</head>
<body  class="bg">

        <?php
            if(( $_SESSION['failed']== false)){
                
                    header('Location: '.INCLUDE_PATH_PAINEL);
                    die();
                }else{
                    //Falhou
                    echo '<div class="erro-box"><i class="fa fa-times"></i> Códgio inválido</div>';
                }            
        ?>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3"  style="background: white; padding: 20px; box-shadow: 10px 10px 5px #888888; margin-top: 100px;">
                <hr>
                    <div style="text-align: center;">
                           <h1>Autenticação realizada com Sucesso!</h1>
                           <p>Obrigado por usar o Google autenticador</p>
                    </div>
                <hr>    
                  
            </div>
        </div>
    </div>
</body>
</html>