<?php
	
class Harman_Amedus_Block_Adminhtml_Passenger_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

			parent::__construct();
			$this->_objectId = "id";
			$this->_blockGroup = "amedus";
			$this->_controller = "adminhtml_passenger";
			$this->_updateButton("save", "label", Mage::helper("amedus")->__("Save"));
			$this->_updateButton("delete", "label", Mage::helper("amedus")->__("Delete"));

			$this->_addButton("saveandcontinue", array(
				"label"     => Mage::helper("amedus")->__("Save And Continue Edit"),
				"onclick"   => "saveAndContinueEdit()",
				"class"     => "save",
			), -100);



			$this->_formScripts[] = "
				function saveAndContinueEdit(){
					editForm.submit($('edit_form').action+'back/edit/');
				}
			";
		}

		public function getHeaderText()
		{
			if( Mage::registry("passenger_data") && Mage::registry("passenger_data")->getId() ){

			    return Mage::helper("amedus")->__("Edit Passenger '%s'", $this->htmlEscape(Mage::registry("passenger_data")->getId()));

			} else{

			     return Mage::helper("amedus")->__("Add Passenger");

			}
		}
}