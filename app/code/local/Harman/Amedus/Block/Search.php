<?php   
class Harman_Amedus_Block_Search extends Mage_Core_Block_Template{   
	/*Flight list */
	public function getResults(){
		$r = Mage::registry('flight_results');
		if(!empty($r)){
			return $r;
		}
	}
	/*single flight data*/
	public function getFlight(){
		$r = Mage::registry('product_result');
		if(!empty($r)){
			return $r;
		}
	}



}
