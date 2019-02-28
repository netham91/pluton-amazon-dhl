<?php 
namespace DHL;
/**
 * 
 */

/*
The Rate request will return DHL’s product capabilities (products, services and estimated delivery
time) and prices (where applicable) for a certain set of input data.

Using the shipper and receiver address as well as the dimension and weights of the pieces belonging
to a shipment, this operation returns the available products and service including the shipping price
(where applicable) and the potential delivery date considering the planned pickup date.

A shipment request can just be successfully executed (assuming the same input data) for a product
and service combination which is returned by the rate request.
*/

class Rate
{
	
	public  $ClientDetails; //This is optional

	/*
	The DropoffType is used to indicate whether a scheduled pickup is required as part of the
	consideration for the rate request. There are two possible values to indicate whether a pickup is
	considered.
	
	REGULAR_PICKUP – The pickup location is already serviced by regularly scheduled courier
	pickup and an additional pickup does not need to be considered for this service.
	
	REQUEST_COURIER- The rating response returns products, for which the pickup capability is
	given, based on ShipmentTimeStamp.
	 */
	public  $DropOffType;

	/*
	This timestamp identifies the ready date and time of the rated shipment.
	It needs to be provided in the following format with GMT offset
	YYYY-MM-DDTHH:MM:SSGMT+k
	2010-02-26T17:00:00GMT+01:00
	
	If the date is on a public holiday, sunday or any other day where there is no pickup, the rate request will return this in the error code as it is a non valid request.
	*/
	public  $ShipTimestamp;
	
	/*
	The UnitOfMeasurement node conveys the unit of measurements used in the operation. This single value corresponds to the units of weight and measurement which are used throughout the message processing.

	Possible values:
	- SI, international metric system (KG, CM)
	- SU, UK, US system of measurement (LB, IN)
	The unit of measurement for the dimensions of the package.
	*/
	public  $UnitOfMeasurement;

	/*
	The Contents node details whether a shipment is non-dutiable (value DOCUMENTS) or dutiable (NON_DOCUMENTS). Depending on the nature of the contents of the shipment, is customs duties are applicable, different products may be offered by the DHL web services.
	*/
	public  $Content;
	public  $PaymentInfo;
	public  $NextBusinessDay;
	public  $Account;
	public  $S_City;
	public  $S_PostalCode;
	public  $S_CountryCode;
	public  $R_City;
	public  $R_PostalCode;
	public  $R_CountryCode;
	public  $number;
	public  $Weight;
	public  $Length;
	public  $Width;
	public  $Height;

	private $validation_errors = [];
	public function getValidationErrors()
	{
		return $this->validation_errors;   
	}

	public function validate()
	{
		if (!isset($this->DropOffType) && empty($this->DropOffType)) {
			$this->validation_errors['DropOffType'] = 'Required DropOffType';                    
		}
		$os = array("REGULAR_PICKUP", "REQUEST_COURIER");
		if (!in_array($this->DropOffType, $os)) {
		    $this->validation_errors['DropOffType']='DropOffType Possible values REGULAR_PICKUP,REQUEST_COURIER';
		}
		if (!isset($this->S_City) && empty($this->S_City)) {
			$this->validation_errors['S_City'] = 'Required Shipper City';                    
		}
		if (!isset($this->S_PostalCode) && empty($this->S_PostalCode)) {
			$this->validation_errors['S_PostalCode'] = 'Required Shipper PostalCode';                    
		}
		if (!isset($this->S_CountryCode) && empty($this->S_CountryCode)) {
			$this->validation_errors['S_CountryCode'] = 'Required Shipper City';                    
		}
		if (!isset($this->R_City) && empty($this->R_City)) {
			$this->validation_errors['R_City'] = 'Required Recipient City';                    
		}
		if (!isset($this->R_PostalCode) && empty($this->R_PostalCode)) {
			$this->validation_errors['R_PostalCode'] = 'Required Recipient City';                    
		}
		if (!isset($this->R_CountryCode) && empty($this->R_CountryCode)) {
			$this->validation_errors['R_CountryCode'] = 'Required Recipient City';                    
		}
		

		if (count($this->validation_errors) > 0) {
			return false;    
		} else {
			return true;    
		}
	}
}

 ?>