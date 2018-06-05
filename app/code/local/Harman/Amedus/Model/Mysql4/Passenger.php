<?php
class Harman_Amedus_Model_Mysql4_Passenger extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("amedus/passenger", "id");
    }
}