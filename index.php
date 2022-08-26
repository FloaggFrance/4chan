<?php
require 'hyper-set.php';

$reqUse = $sql->prepare('SELECT ID, user_id, name, content FROM threads');
$reqUse->execute();
$reqUse = $reqUse->get_result();

if(verifyLog()) {
	echo '<a href="/new_thread.php">[ New Thread ]</a>';
	echo '<br>';
	echo '<br>';
	echo '<br>';
	echo '<br>';
	echo '<br>';
}
echo 'Liste Thread';
echo '<br>';
foreach($reqUse->fetch_all(MYSQLI_ASSOC) as $key => $get) {
	echo '<a href="thread.php?id='.$get['ID'].'">'.$get['name'].'</a>';
	echo '<br>';
}