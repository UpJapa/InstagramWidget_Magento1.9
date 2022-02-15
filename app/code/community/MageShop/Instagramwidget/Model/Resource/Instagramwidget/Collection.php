<?php
class MageShop_Instagramwidget_Model_Resource_Instagramwidget_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract{
	public function _construct(){
		$this->_init('instagramwidget/instagramwidget');
	}
	public function addAttributeToSort($attribute, $dir="asc") 
	{ 
		if (!is_string($attribute)) { 
			return $this; 
		} 
		$this->setOrder($attribute, $dir); 
		return $this; 
	}
}