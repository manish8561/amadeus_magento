<?php 
class Harman_Amedus_Block_Adminhtml_Passenger_Grid_Renderer_Product extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
    	$_productId = $row->getProductId();
    	$html = '-Not found-';
        $product = Mage::getModel('catalog/product')->load($_productId);
        if($product->getId() > 0){
        	$html = '<a target="_blank" rel="external" href="'. Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/catalog_product/edit', array('id' => $_productId)).'">'.$product->getName().'</a>';
        }
        
        return $html;
    }
}