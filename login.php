<?php
	if(isset($_COOKIE['lembrar'])){
		$user = $_COOKIE['user'];
		$password = $_COOKIE['password'];
		$sql = MySql::conectar()->prepare("SELECT * FROM `tbl_user` WHERE user = ? AND password = ?");
		$sql->execute(array($user,$password));
		if($sql->rowCount() == 1){
				$info = $sql->fetch();
				$_SESSION['login'] = true;
				$_SESSION['user'] = $user;
				$_SESSION['password'] = $password;
				$_SESSION['cargo'] = $info['cargo'];
				$_SESSION['nome'] = $info['nome']; 
				$_SESSION['img'] = $info['img'];
				header('Location: '.INCLUDE_PATH_PAINEL);
				die();
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Painel de controle</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
	<link rel="stylesheet" href="estilo/font-awesome.min.css">
	<link href="css/style.css" rel="stylesheet" />
</head>
<body>

	<div class="box-login">
		<h2>Efetue o login:</h2>
		<?php
			if(isset($_POST['acao'])){
				$user = $_POST['user'];
				$password = $_POST['password'];
				$sql = MySql::conectar()->prepare("SELECT * FROM `tbl_user` WHERE user = ? AND password = ?");
				$sql->execute(array($user,$password));
				if($sql->rowCount() == 1){
					$info = $sql->fetch();
					//Logamos com sucesso.
					$_SESSION['login'] = true;
					$_SESSION['user'] = $user;
					$_SESSION['password'] = $password;
					$_SESSION['cargo'] = $info['cargo'];
					$_SESSION['nome'] = $info['nome']; 
					$_SESSION['img'] = $info['img'];
					if(isset($_POST['lembrar'])){
						setcookie('lembrar',true,time()+(60*60*24),'/');
						setcookie('user',$user,time()+(60*60*24),'/');
						setcookie('password',$password,time()+(60*60*24),'/');
					}
					header('Location: ../login-google/autenticador/aut.php');
					die();
				}else{
					//Falhou
					echo '<div class="erro-box"><i class="fa fa-times"></i> Usuário ou senha incorretos!</div>';
				}
			}
		?>

		
		<form method="post" class="box-login">
			<label><strong>Login:</strong></label>
				<input type="text" name="user" placeholder="Login..." required>
			<label><strong>Senha:</strong></label>
				<input type="password" name="password" placeholder="Senha..." required>
				
			<div class="form-group-login left">
				<input type="submit" name="acao" value="Logar!">
			</div>
			<div class="form-group-login right">
				<label>Lembrar-me</label>
				<input type="checkbox" name="lembrar" />
			</div>			
		</form>
	</div><!--box-login-->

</body>
</html>