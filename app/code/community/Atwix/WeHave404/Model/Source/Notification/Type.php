<?php

class Atwix_WeHave404_Model_Source_Notification_Type
{
    public function toOptionArray()
    {
        $helper = Mage::helper('atwix_wehave404');
        $optionArray = array(
            '0' => $helper->__('Log File'),
            '1' => $helper->__('Email Notification')
        );

        return $optionArray;
    }

}