<?php namespace Pluton\Dhl;

/**
*  The DHL Express Global Web Services are a set of operations offering DHL’s core services like capability,
* rating or booking a pickup request to any customer. This enables the customer to integrate these services 
* seamlessly into their own IT infrastructure. Customers can then ask for the available products and their prices(
* where applicable) online as well as creating a shipment together with a courier pickup.
*
*  @author Keshav Joshi
*/
class DHLAPI{

	/*Dhl Base Auth username */
	private $username = 'ventasacomiES';
	
	/*Dhl Base Auth password */
	private $password = 'D$8dF^0vX$7b';
	
	/*Dhl REST API Url */
	private $api_url = 'https://wsbexpress.dhl.com/rest/sndpt/';


	
	function sendRequest($calledFunction, $data){
		/*Creates the endpoint URL*/
		$request_url = $this->api_url.$calledFunction;

		$payload = json_encode($data);
		
		/*Preparing Query...*/
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_URL, $request_url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		curl_setopt($ch, CURLOPT_USERPWD, $this->username . ":" . $this->password);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		$response = curl_exec($ch);
		
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($response, 0, $header_size);
		$body = substr($response, $header_size);
		curl_close($ch);
		// Then, after your curl_exec call:
		/*Will print back the response from the call*/
		/*Used for troubleshooting/debugging		*/
		if(!$response){
			return false;
		}
		/*Return the data in JSON format*/
		return ($body);
	}

}
