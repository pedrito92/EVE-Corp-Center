<?php
	$_SESSION['isLoginIn']		= false;
	$_SESSION['currentUser']	= false;
	unset($_SESSION);
	session_destroy();

	header("Location: /");