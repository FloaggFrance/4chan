<?php
require 'hyper-set.php';

if(isset($_POST['in'])) {
	if(
		!empty($_POST['username'])
		&&
		!empty($_POST['password'])
	) {
		$username = htmlentities($_POST['username']);
		$passwordd = password_hash(htmlentities($_POST['password']), PASSWORD_DEFAULT);

		if(preg_match("#([0-9a-zA-Z_-]+)#", $username, $params)) {
			$reqUse = $sql->prepare('SELECT * FROM users WHERE username = ?');
			$reqUse->bind_param('s', $username);
			$reqUse->execute();
			$reqUse = $reqUse->get_result();

			if($reqUse->num_rows == 0) {
				$in = $sql->prepare("INSERT INTO users(username, password, date_) VALUES(?, ?, now())");
				$in->bind_param("ss", $username, $passwordd);
				$in->execute();

				echo "Compte créer !";
			}
			else {
				echo "Le compt existe !";
			}
		}
		else {
			echo "Le pseudo n'est pas valide !";
		}
	}
	else {
		echo "Auccun champs n'est remplit !";
	}
}

if(isset($_POST['up'])) {
	if(
		!empty($_POST['username'])
		&&
		!empty($_POST['password'])
	) {
		$username = htmlentities($_POST['username']);
		$passwordd = htmlentities($_POST['password']);

		if(preg_match("#([0-9a-zA-Z_-]+)#", $username, $params)) {
			$reqUse = $sql->prepare('SELECT ID, password FROM users WHERE username = ?');
			$reqUse->bind_param('s', $username);
			$reqUse->execute();
			$reqUse = $reqUse->get_result();

			if($reqUse->num_rows == 1) {
				$getUse = $reqUse->fetch_assoc();

				if(password_verify($passwordd, $getUse['password'])) {
					echo 'Reirection !';
					$_SESSION['id'] = $getUse['ID'];
					header('Location: profil.php?get='.$username);
				}
				else {
					echo "Le compte existe pas !";
				}
			}
			else {
				echo "Le compt existe pas !";
			}
		}
		else {
			echo "Le pseudo n'est pas valide !";
		}
	}
	else {
		echo "Auccun champs n'est remplit !";
	}
}
?>
<form method="post">
	<input type="text" name="username" placeholder="Username">
	<input type="text" name="password" placeholder="Mot de Passe">
	<input type="submit" name="in" value="Log in">
</form>

<form method="post">
	<input type="text" name="username" placeholder="Username">
	<input type="text" name="password" placeholder="Mot de Passe">
	<input type="submit" name="up" value="Log Up">
</form>