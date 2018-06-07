<?php   
class Harman_Amedus_Block_Product extends Mage_Core_Block_Template{   
	
	/*single flight data*/
	public function getFlight(){
		$r = Mage::registry('product_result');
		if(!empty($r)){
			return $r;
		}
	}

	public function getAddToCartUrl($product, $additional = array())
    {
       

        if ($this->getRequest()->getParam('wishlist_next')) {
            $additional['wishlist_next'] = 1;
        }

        $addUrlKey = Mage_Core_Controller_Front_Action::PARAM_NAME_URL_ENCODED;
        $addUrlValue = Mage::getUrl('*/*/*', array('_use_rewrite' => true, '_current' => true));
        $additional[$addUrlKey] = Mage::helper('core')->urlEncode($addUrlValue);

        return $this->helper('checkout/cart')->getAddUrl($product, $additional);
    }

}
