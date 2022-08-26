<?php
require 'hyper-set.php';

if(isset($_GET['id'])) {
	$id = htmlentities($_GET['id']);
	$post_ID = 0;

	if(true) {
		$reqUse = $sql->prepare('SELECT ID, user_id, name, content FROM threads WHERE ID = ?');
		$reqUse->bind_param('s', $id);
		$reqUse->execute();
		$reqUse = $reqUse->get_result();

		if($reqUse->num_rows == 1) {
			$getThread = $reqUse->fetch_assoc();

			$reqPost = $sql->prepare('SELECT ID, user_id, post_id, content FROM posts WHERE thread_id = ? ORDER BY id DESC');
			$reqPost->bind_param('s', $id);
			$reqPost->execute();
			$reqPost = $reqPost->get_result();
			if($reqUse->num_rows > 0) {

			}

			echo '<head>';
				echo '<title>'.$getThread['name'].'</title>';
			echo '</head>';
		}
	}

	if(isset($_POST['in'])) {
		if(
			!empty($_POST['content'])
		) {
			$content = htmlentities($_POST['content']);

			$in = $sql->prepare("INSERT INTO posts(user_id, thread_id, post_id, content, date_) VALUES(?, ?, ?, ?, now())");
			$in->bind_param("iiis", $_SESSION['id'], $getThread['ID'], $post_ID, $content);
			$in->execute();

			header("Refresh:0");
		}
	}
}
?>
<form method="post">
	<textarea name="content"></textarea>
	<input type="submit" name="in" value="Post">
</form>
<?php
foreach ($reqPost->fetch_all(MYSQLI_ASSOC) as $key => $value) {
	$reqPost = $sql->prepare('SELECT username FROM users WHERE ID = ?');
	$reqPost->bind_param('i', $value['user_id']);
	$reqPost->execute();
	$reqPost = $reqPost->get_result();

	$username = "Unknow";
	if($reqPost->num_rows > 0) {
		$getPost = $reqPost->fetch_assoc();
		$username = $getPost['username'];
	}

	echo $username.' : ';
	echo $value['content'];
	echo "<br>";
}