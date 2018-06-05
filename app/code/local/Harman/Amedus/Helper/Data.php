<?php 
/**
 * Amedus Data Helper
 *
 * @category    Amedus
 * @package     Harman_Amedus
 * @author      Manish Sharma <manish198646@yahoo.com>
 */
class Harman_Amedus_Helper_Data extends Mage_Core_Helper_Abstract
{
	protected $api_url;
	protected $api_key;


	public function __construct(){
		$this->api_url = Mage::getStoreConfig('harman_section/config/url');
		$this->api_key = Mage::getStoreConfig('harman_section/config/api_key');
		
	}
	/*Location Search*/
	public function location_search($term){
		$term = substr($term, 0,3);
		$this->api_url .= 'v1.2/location/'.$term;
		$data = array();
		return $this->curl_request($data);
		
	}
	/*Low price search*/
	public function low_fare_search($data){
		$this->api_url .= 'v1.2/flights/low-fare-search';
		return $this->curl_request($data);
		
	}

	function curl_request($params)
	{

		$this->api_url.="?apikey=".$this->api_key;

		//AMADEUS API REQUEST URL.

		foreach($params as $param => $value)
		{
			$this->api_url.="&".$param."=".$value;
		}

		
		
		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0); 
		curl_setopt($ch, CURLOPT_URL, $this->api_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);	

		if (curl_errno($ch)) 
		{
		    echo 'Error:' . curl_error($ch); exit;
		}
		curl_close ($ch);

		$final=json_decode($result,TRUE);

		return $final;

	}
	
	public function randomKey(){
		$apis  = array(
			'QL5FeBFqWjkp1V2YnAuAoc7dkGXHKpS2',
			'QL5FeBFqWjkp1V2YnAuAoc7dkGXHKpS2',
			'QL5FeBFqWjkp1V2YnAuAoc7dkGXHKpS2',
			'blHnPQnCtfcLlR8hrCW2hDeMIJNALXn2',
			'nP4fBVWwaPc7ScUuO8rH2bEkBzgTWDPO',
			'nP4fBVWwaPc7ScUuO8rH2bEkBzgTWDPO',
			'nP4fBVWwaPc7ScUuO8rH2bEkBzgTWDPO',
			'nP4fBVWwaPc7ScUuO8rH2bEkBzgTWDPO',
		);
		$index  = array_rand($apis);
		return $apis[$index];

	}

	public function flight_duration($time1,$time2)
	{
	    $start_date = new DateTime($time1);
	    $since_start = $start_date->diff(new DateTime($time2));
	    // print_r($since_start);
	    $hh=$since_start->h;
	    $mm=$since_start->i;
	    if(isset($since_start->d) && $since_start->d>0)
	    {
	        $dd=$since_start->d;
	        $hh=$hh+($dd*24);
	    }
	   
	    $hhh=sprintf('%02d', $hh);
	    $mmm=sprintf('%02d', $mm);
	    $difff=$hhh."h ".$mmm."m ";    

	    return $difff;
	}
}
	 