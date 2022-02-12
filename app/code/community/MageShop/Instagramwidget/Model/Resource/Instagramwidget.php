<?php
class MageShop_Instagramwidget_Model_Resource_Instagramwidget extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {  
        $this->_init('instagramwidget/instagramwidget', 'id');
    }  
}