<?php 
class Harman_Amedus_Model_Observer

{
    public function addQuote(Varien_Event_Observer $observer)
	{
		$product = $observer->getEvent()->getProduct();
		$quote = Mage::getSingleton('checkout/cart')->getQuote();
   		$quote_id = $quote->getId();

        if ($product->getId() > 0) {
        	$collection = Mage::getModel('amedus/passenger')->getCollection()
							        	->addFieldToFilter('product_id', $product->getId())
							        	->addFieldToFilter('quote_id', 0)
							        	//->addFieldToFilter('order_id', 0)
							        	;
			echo '<pre>';
			print_r($collection->getData()); 	
			foreach ($collection as $p)
			{
			    $passenger = Mage::getModel('amedus/passenger')->load($p->getId());
			    echo '<hr>';
			    print_r($passenger->getData()); 	
			    $passenger->QuoteId($quote_id);
			    $passenger->save();
			}
				
        }
        die();
		
	}

	public function addOrder(Varien_Event_Observer $observer)
	{
		//Mage::dispatchEvent('admin_session_user_login_success', array('user'=>$user));
		//$user = $observer->getEvent()->getUser();
		//$user->doSomething();
	}

}