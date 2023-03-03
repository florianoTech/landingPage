<?php
namespace LandingPage\Database;

/**
 * Class used to manage database
 *
 * @author Daniel Floriano	 
 */
class LandingPageDAO {
	
	public function __construct() {
	}	
	
   /** 
    * Function used to insert access data in database
	*
    * @access public 
    * @param array $data
    * @return bool
    */ 
	public function insertDataAccess($data) {
		$obj = new Sql();
		
		$sql = "CALL xxxxxx.insert_access_data(:serverName, :sessionId, :ip, :userAgent, :location)";	

		try {	
			$result = $obj -> query ($sql, 
									 [":serverName" => $data['serverName'],
									  ":sessionId"  => $data['sessionId'],
									  ":ip" 	    => $data['ip'], 
									  ":userAgent"  => $data['userAgent'],
									  ":location"   => $data['location']]);
									
			return $result;
		} catch (\Exception $e) {
			return false;
		}
	}
}
?>