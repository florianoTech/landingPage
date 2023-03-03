<?php
/**
 * main page
 *
 * @author Daniel Floriano	 
 */
 
require 'vendor/autoload.php';

if(!isset($_COOKIE['xxxxxx'])) {
	session_start();
	$obj = new LandingPage\LandingPage;
	$obj -> insertDataAccess();
}

include('html/index.html');
?>