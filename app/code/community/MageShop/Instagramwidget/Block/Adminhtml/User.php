<?php

/**
 * This is the Self test Button
 *
 * @author Ashley Schroder (aschroder.com)
 * @copyright  Copyright (c) 2014 Ashley Schroder
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class MageShop_Instagramwidget_Block_Adminhtml_User
    extends Mage_Adminhtml_Block_System_Config_Form_Field
{


    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element) 
    {
        $this->setElement($element);
        $buttonHtml = $this->_getAddRowButtonHtml($this->__('Atualizar'));
        return $buttonHtml;
    }


  protected function _getAddRowButtonHtml($title)
  {

    	$buttonHtml = $this->getLayout()->createBlock('adminhtml/widget_button')
                    ->setType('button')
                    ->setLabel($this->__($title))
                    ->setOnClick("getUserInstagramGraph(this)")
                    ->toHtml();

        return $buttonHtml;    
    }



}