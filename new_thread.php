<?php
require 'hyper-set.php';
redir();

if(isset($_POST['in'])) {
	if(
		!empty($_POST['username'])
		&&
		!empty($_POST['content'])
	) {
		$name = htmlentities($_POST['username']);
		$lengName = strlen($name);
		$content = htmlentities($_POST['content']);

		$ps = $sql->prepare("SELECT ID FROM threads");
		$ps->execute();
		$ps = $ps->get_result();

		if($lengName <= 255) {
			$in = $sql->prepare("INSERT INTO threads(user_id, name, content, date_) VALUES(?, ?, ?, now())");
			$in->bind_param("iss", $_SESSION['id'], $name, $content);
			$in->execute();

			echo "Login";
			header('Location: thread.php?id='.$ps->num_rows+1);
		}
		else {
			echo "Le nom est trop long !";
		}
	}
	else {
		echo "Auccun champs n'est remplit !";
	}
}
?>
<form method="post">
	<input type="text" name="username" placeholder="Name">
	<textarea name="content" placeholder="Descritpino"></textarea>
	<input type="submit" name="in" value="Log in">
</form>