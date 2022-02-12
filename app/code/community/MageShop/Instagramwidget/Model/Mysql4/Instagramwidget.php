<?php

class MageShop_Instagramwidget_Model_Mysql4_Instagramwidget extends Mage_Core_Model_Mysql4_Abstract{

    public function _construct()
    {
        $this->_init('instagramwidget/instagramwidget', 'id');
    }
}