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

	/*save product function */
	public function saveProduct($data){		

		//Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
		$product = Mage::getModel('catalog/product');

		$basic_search = json_decode($data['basic_search'], true); 

		$sku = $this->generateSku($basic_search);
		/*echo $sku; exit;*/		
		$_productId = $product->getIdBySku($sku);
		if($_productId > 0){
			return Mage::getModel('catalog/product')->load($_productId);
	    }
		try{
		$product
		//    ->setStoreId(1) //you can set data in store scope
		    ->setWebsiteIds(array(1)) //website ID the product is assigned to, as an array
		    ->setAttributeSetId(4) //ID of a attribute set named 'default'
		    ->setTypeId('simple') //product type
		    //->setCreatedAt(time()) //product creation time
		//    ->setUpdatedAt(strtotime('now')) //product update time
		 
		    ->setSku($sku) //SKU
		    ->setName($data['name']) //product name
		    ->setWeight(1.0000)
		    ->setStatus(1) //product status (1 - enabled, 2 - disabled)
		    ->setTaxClassId(2) //tax class (0 - none, 1 - default, 2 - taxable, 4 - shipping)
		    ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH) //catalog and search visibility
		    /*->setManufacturer(28) //manufacturer id
		    ->setColor(24)
		    ->setNewsFromDate('06/26/2014') //product set as new from
		    ->setNewsToDate('06/30/2014') //product set as new to
		    ->setCountryOfManufacture('AF') //country of manufacture (2-letter country code)*/
		 
		    ->setPrice($data['total_price']) //price in form 11.22
		    /*->setCost(22.33) //price in form 11.22
		    ->setSpecialPrice(00.44) //special price in form 11.22
		    ->setSpecialFromDate('06/1/2014') //special price from (MM-DD-YYYY)
		    ->setSpecialToDate('06/30/2014') //special price to (MM-DD-YYYY)
		    ->setMsrpEnabled(1) //enable MAP
		    ->setMsrpDisplayActualPriceType(1) //display actual price (1 - on gesture, 2 - in cart, 3 - before order confirmation, 4 - use config)
		    ->setMsrp(99.99) //Manufacturer's Suggested Retail Price*/
		 
		    ->setMetaTitle($data['name'])
		    ->setMetaKeyword($data['name'])
		    ->setMetaDescription($data['description'])
		 
		    ->setDescription($data['description'])
		    ->setShortDescription($data['description'])
		 
		    /*->setMediaGallery (array('images'=>array (), 'values'=>array ())) //media gallery initialization
		    ->addImageToMediaGallery('media/catalog/product/1/0/10243-1.png', array('image','thumbnail','small_image'), false, false) //assigning image, thumb and small image to media gallery*/
		 
		    ->setStockData(array(
		                       'use_config_manage_stock' => 0, //'Use config settings' checkbox
		                       'manage_stock'=>0, //manage stock
		                       'min_sale_qty'=>0, //Minimum Qty Allowed in Shopping Cart
		                       'max_sale_qty'=>0, //Maximum Qty Allowed in Shopping Cart
		                       'is_in_stock' => 1, //Stock Availability
		                       'qty' => 1 //qty
		                   )
		    )
		 
		    ->setCategoryIds(array(3)); //assign product to categories
/*Amedus details*/
		$product->setBasicsearch($data['basic_search'])
		->setAmedusData($data['itinerary'])
		->setTotalPrice($data['total_price'])
		->setDepartureDate($basic_search['depature_date']);

		$product->save();

		$_productId = $product->getIdBySku($sku);
		if($_productId > 0){
			return Mage::getModel('catalog/product')->load($_productId);
	    }

		//endif;
		}catch(Exception $e){
			print_r($e->getMessage()); die;
			Mage::log($e->getMessage());
		}
	}
	public function generateSku($search){
		$departure_date = date('Y-m-d', strtotime($search['departure_date']));
		return $search['origin_label'].'_'.$search['destination_label'].'_'.$departure_date.'_'.time();
	}
}
	 