<?php
namespace LandingPage;

/**
 * Class used by other classes
 *
 * @author Daniel Floriano	 
 */
class Util {
	
	/**
	 * Function that sends an email
	 *
     * @access public 	 
	 * @param string $name
	 * @param string $rem
	 * @param array $des
	 * @param array $copy	 
	 * @param string $body
	 * @param array $att	 
	 * @return bool
	 */	
	public function sendEmail($name, $rem, $des, $copy, $sub, $body, $att){
		$mail = new \PHPMailer\PHPMailer\PHPMailer();
		$mail->isSMTP();
		$mail->CharSet = 'utf-8';
		$mail->SMTPAuth = true;		
		$mail->Port = 587;		
		$mail->isHTML(true);		
		$mail->Host = 'xxxxxx';
		$mail->SMTPSecure = 'tls';
		$mail->Username = 'xxxxxx';
		$mail->Password = 'xxxxxx';		
		$mail->setFrom('xxxxxx',$name);	
		$mail->addReplyTo($rem);
		
		foreach ($des as $endereco) 
			$mail -> addAddress($endereco);
		
		foreach ($copy as $cc) 
			$mail -> addCC($cc);		
			
		foreach ($att as $pathAtt)
			$mail -> addAttachment($pathAtt);
			
		$mail -> Body = $body;		 
		$mail -> Subject = $sub;
		
		$result = $mail->send();
		return $result; 
	}
	
	/**
	 * Function that gets data from an IP
	 *
	 * @access public 
	 * @return mixed
	 */		
	public function getDataIP() {
		$ip = $_SERVER["REMOTE_ADDR"];

		try {
			$result = $this->file_get_contents_curl("https://ipinfo.io/$ip?token=xxxxxx");
		} catch (\Exception $e) {
			$result = false;			
		}
		
		if (!$result)
			return null;	
		else 
			return $result;
	}	
	
    /**
	 * Function that gets the type of device
	 *
     * @access public 	 
	 * @return string
	 */			
	public function getDevice() {
		
		$iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
		$ipad = strpos($_SERVER['HTTP_USER_AGENT'],"iPad");
		$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
		$palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
		$berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
		$ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
		$symbian = strpos($_SERVER['HTTP_USER_AGENT'],"Symbian");
		$windowsphone = strpos($_SERVER['HTTP_USER_AGENT'],"Windows Phone");
		 
		if (in_array(true,[$iphone,$ipad,$android,$palmpre,$ipod,$berry,$symbian,$windowsphone])) 
		   $device = "mobile";
		else 
			$device = "computer";

		return $device;
	}
	
    /**
	 * Function that gets the content of a page
	 *
     * @access public 	 
	 * @param string $url
	 * @return bool
	 */			
	public function file_get_contents_curl($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_REFERER, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3000);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10000);
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}
}
?>