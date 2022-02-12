<?php 
class MageShop_Instagramwidget_Block_Instagramwidget extends Mage_Adminhtml_Block_System_Config_Form_Field
{

    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
		$this->setElement($element);
        $buttonHtml = $this->_getAddRowButtonHtml($this->__('Atualizar'));
        return $buttonHtml;
    }

	protected function _getAddRowButtonHtml($title)
  	{
        // TODO: for real multi-store self-testing, the test button (and other configuration options) 
        // should probably be set to show in website. Currently they are not.
    	$url = Mage::getBaseUrl() . 'feed/graph/media';

    	$buttonHtml = $this->getLayout()->createBlock('adminhtml/widget_button')
                    ->setType('button')
                    ->setLabel($this->__($title))
                    ->setOnClick("getMediaInstagramGraph('".$url."')")
                    ->toHtml();
                    
        return $buttonHtml;    
    }
}
?>