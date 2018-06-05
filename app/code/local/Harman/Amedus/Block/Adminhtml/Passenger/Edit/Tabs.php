<?php
class Harman_Amedus_Block_Adminhtml_Passenger_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("passenger_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("amedus")->__("Passenger Information"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("amedus")->__("Passenger Information"),
				"title" => Mage::helper("amedus")->__("Passenger Information"),
				"content" => $this->getLayout()->createBlock("amedus/adminhtml_passenger_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
