<?php

class Harman_Amedus_Block_Adminhtml_Passenger_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("passengerGrid");
				$this->setDefaultSort("id");
				$this->setDefaultDir("DESC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("amedus/passenger")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("id", array(
				"header" => Mage::helper("amedus")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "id",
				));
                
				$this->addColumn("firstname", array(
				"header" => Mage::helper("amedus")->__("First Name"),
				"index" => "firstname",
				));
				$this->addColumn("middlename", array(
				"header" => Mage::helper("amedus")->__("Middle Name"),
				"index" => "middlename",
				));
				$this->addColumn("lastname", array(
				"header" => Mage::helper("amedus")->__("Last Name"),
				"index" => "lastname",
				));
						$this->addColumn('gender', array(
						'header' => Mage::helper('amedus')->__('Gender'),
						'index' => 'gender',
						'type' => 'options',
						'options'=>Harman_Amedus_Block_Adminhtml_Passenger_Grid::getOptionArray3(),				
						));
						
					$this->addColumn('dob', array(
						'header'    => Mage::helper('amedus')->__('DOB'),
						'index'     => 'dob',
						'type'      => 'datetime',
					));
						$this->addColumn('status', array(
						'header' => Mage::helper('amedus')->__('Status'),
						'index' => 'status',
						'type' => 'options',
						'options'=>Harman_Amedus_Block_Adminhtml_Passenger_Grid::getOptionArray5(),				
						));
						
			$this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV')); 
			$this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel'));

				return parent::_prepareColumns();
		}

		public function getRowUrl($row)
		{
			   return $this->getUrl("*/*/edit", array("id" => $row->getId()));
		}


		
		protected function _prepareMassaction()
		{
			$this->setMassactionIdField('id');
			$this->getMassactionBlock()->setFormFieldName('ids');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_passenger', array(
					 'label'=> Mage::helper('amedus')->__('Remove Passenger'),
					 'url'  => $this->getUrl('*/adminhtml_passenger/massRemove'),
					 'confirm' => Mage::helper('amedus')->__('Are you sure?')
				));
			return $this;
		}
			
		static public function getOptionArray3()
		{
            $data_array=array(); 
			$data_array[0]='male';
			$data_array[1]='female';
            return($data_array);
		}
		static public function getValueArray3()
		{
            $data_array=array();
			foreach(Harman_Amedus_Block_Adminhtml_Passenger_Grid::getOptionArray3() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		
		static public function getOptionArray5()
		{
            $data_array=array(); 
			$data_array[0]='active';
			$data_array[1]='inactive';
            return($data_array);
		}
		static public function getValueArray5()
		{
            $data_array=array();
			foreach(Harman_Amedus_Block_Adminhtml_Passenger_Grid::getOptionArray5() as $k=>$v){
               $data_array[]=array('value'=>$k,'label'=>$v);		
			}
            return($data_array);

		}
		

}