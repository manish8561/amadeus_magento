<?php


class Harman_Amedus_Block_Adminhtml_Passenger extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_passenger";
	$this->_blockGroup = "amedus";
	$this->_headerText = Mage::helper("amedus")->__("Passenger Manager");
	$this->_addButtonLabel = Mage::helper("amedus")->__("Add New Item");
	parent::__construct();
	
	}

}