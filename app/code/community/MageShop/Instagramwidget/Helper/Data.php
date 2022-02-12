<?php
class MageShop_Instagramwidget_Helper_Data extends Mage_Core_Helper_Abstract
{

    const INSTAGRAM_ENABLE = 'instagramwidget/general/mageshop_select';
    const TOKEN = 'instagramwidget/general/token';
    const IDUSER = 'instagramwidget/general/iduser';
    const USENAME = 'instagramwidget/general/username';

    public function isEnabled()
    {
        return (bool) Mage::getStoreConfig(self::INSTAGRAM_ENABLE);
    }

    public function getUserName()
    {
        return Mage::getStoreConfig(self::USENAME);
    }

    public function getIdUser()
    {
        return Mage::getStoreConfig(self::IDUSER);
    }

    public function getToken()
    {
        return Mage::getStoreConfig(self::TOKEN);
    }

    
}