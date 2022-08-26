<?php
session_start();

$sql = new mysqli("127.0.0.1", "root", "", "4chan");

function verifyLog() {
	global $_SESSION;

	if(isset($_SESSION['id'])) {
		return true;
	}

	return false;
}

function redir() {
	if(!verifyLog()) {
		header('Location: /log.php');
	}
}