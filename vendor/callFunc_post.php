<?php
	session_start();
	require 'autoload.php';
	$option = $_POST['option'];
	$nameFunc = $_POST['nameFunc'];
	$paramsFunc = json_decode($_POST['paramsFunc'],true);
	if ($option == 1) 
		$instance = new LandingPage\LandingPage;
	
	$result = call_user_func_array(array($instance, $nameFunc), $paramsFunc);
	echo json_encode($result);	
?>