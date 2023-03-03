<?php
namespace LandingPage;

/**
 * Class used to control the application
 *
 * @author Daniel Floriano	 
 */
class LandingPage {
	
	private $util;
	private $dao;
	
	public function __construct() {
		/*error_reporting(E_ALL);
		ini_set('display_errors', 1);*/	
		$this->util = new Util();
		$this->dao = new Database\LandingPageDAO;
	}

	/**
	 * Function that creates an email body and sends it
	 *
     * @access public 	 	 
	 * @param string $name
	 * @param string $email
	 * @param string $phone
	 * @param string $message	  
	 * @return array
	 */	
	public function sendEmail($name, $email, $phone, $message) {
		$des = 'xxxxxx';
		$sub = 'xxxxxx';
		$copy = [];
		$attachs = [];
		
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$success = false;
			$message = "Email inválido";
		} else if (!filter_var(str_replace(["(",")","-"," "],"",$phone),FILTER_VALIDATE_INT) && !empty($phone)) {
			$success = false;
			$message = "Telefone inválido";		
		} else {
			$body = "<br>
					 <div style='margin:auto;padding:1rem;
								 width:99%;
								 border-radius:.5rem;
								 box-shadow: 0 .3rem 1rem rgb(0 0 0 / 0.2);
								 font-family: arial
								 color:black'>
						 <img src='https://www.floriano.tech/assets/logo-black.png' style='position:relative; width:20%'>	
						 <br><br>
						 <b>Nome:</b> $name<br>";
						 
			if (!empty($phone))			 
				$body .="<b>Telefone:</b> $phone<br>";
			
			$body .=	"<b>Email:</b> $email<br><br>
						 <b>Mensagem:</b> $message
					 </div>
					 <br>";
					 
			$success = $this->util->sendEmail($name, $email, [$des], $copy , $sub, $body, $attachs);
			$msg = $success ? "Mensagem enviada com sucesso! Em breve retornaremos o contato" : "Erro ao enviar mensagem";
		}
		return ["success" => $success,
				"message" => $msg];
	}
	
	/**
	 * Function that formats data to create a access register on database
	 * 
     * @access public 	 	 
	 * @return bool
	 */		
	public function insertDataAccess() {
		
		$jsonLocation = $this -> util -> getDataIP();
		$jsonIP = json_decode($jsonLocation ,true);

		$ip = '';
		$arr = explode('.',$_SERVER["REMOTE_ADDR"]);
		
		foreach ($arr as $item)
			$ip .= str_pad($item,3,0,STR_PAD_LEFT);	
	
		$data = ["serverName" => $_SERVER['SERVER_NAME'],
				 "sessionId" => session_id(),
				 "device" => $this -> util -> getDevice(),
				 "ip" => str_replace("::1","0",$ip), 
				 "city" => isset($jsonIP['city']) ? $jsonIP['city'] : '', 
				 "state" => isset($jsonIP['region']) ? $jsonIP['region'] : '', 
				 "country" => isset($jsonIP['country']) ? $jsonIP['country'] : '',
				 "userAgent" => $_SERVER['HTTP_USER_AGENT'],
				 "location" => json_encode($jsonIP)];
		return $this -> dao -> insertDataAccess($data);
	}
}
?>