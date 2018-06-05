<?php
class Harman_Amedus_Block_Adminhtml_Passenger_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("amedus_form", array("legend"=>Mage::helper("amedus")->__("Passenger information")));

				
				$fieldset->addField("firstname", "text", array(
					"label" => Mage::helper("amedus")->__("First Name"),					
					"class" => "required-entry",
					"required" => true,
					"name" => "firstname",
				));
			
				$fieldset->addField("middlename", "text", array(
					"label" => Mage::helper("amedus")->__("Middle Name"),
					"name" => "middlename",
				));
			
				$fieldset->addField("lastname", "text", array(
					"label" => Mage::helper("amedus")->__("Last Name"),					
					"class" => "required-entry",
					"required" => true,
					"name" => "lastname",
				));
							
				 $fieldset->addField('gender', 'select', array(
					'label'     => Mage::helper('amedus')->__('Gender'),
					'values'   => Harman_Amedus_Block_Adminhtml_Passenger_Grid::getValueArray3(),
					'name' => 'gender',					
					"class" => "required-entry",
					"required" => true,
				));
				$dateFormatIso = Mage::app()->getLocale()->getDateTimeFormat(
					Mage_Core_Model_Locale::FORMAT_TYPE_SHORT
				);

				$fieldset->addField('dob', 'date', array(
					'label'        => Mage::helper('amedus')->__('DOB'),
					'name'         => 'dob',					
					"class" => "required-entry",
					"required" => true,
					'time' => true,
					'image'        => $this->getSkinUrl('images/grid-cal.gif'),
					'format'       => $dateFormatIso
				));				
				 $fieldset->addField('status', 'select', array(
					'label'     => Mage::helper('amedus')->__('Status'),
					'values'   => Harman_Amedus_Block_Adminhtml_Passenger_Grid::getValueArray5(),
					'name' => 'status',
				));

				if (Mage::getSingleton("adminhtml/session")->getPassengerData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getPassengerData());
					Mage::getSingleton("adminhtml/session")->setPassengerData(null);
				} 
				elseif(Mage::registry("passenger_data")) {
				    $form->setValues(Mage::registry("passenger_data")->getData());
				}
				return parent::_prepareForm();
		}
}
