<?php

class Atwix_WeHave404_Helper_Data extends Mage_Core_Helper_Abstract
{
    const EMAIL_TEMPLATE_ID = 'atwix_wehave404_notification';
    const DEFAULT_RECIPIENT_NAME = 'Support Team';
    const DEFAULT_SENDER = 'general';

    public function isEnabled()
    {
        $isEnabledSetting = Mage::getStoreConfigFlag('atwix_wehave404/general/is_enabled');
        $isOutputEnabled = !(Mage::getStoreConfigFlag('advanced/modules_disable_output/Atwix_WeHave404'));
        $result = ($isEnabledSetting && $isOutputEnabled) ? true : false;

        return $result;
    }

    public function getEmailTemplateId()
    {
         return self::EMAIL_TEMPLATE_ID;
    }

    public function getRecepientEmail()
    {
        return Mage::getStoreConfig('atwix_wehave404/general/recipient_email');
    }

    public function getRecipientName()
    {
        $savedValue = Mage::getStoreConfig('atwix_wehave404/general/recipient_name');

        return (empty($savedValue)) ? self::DEFAULT_RECIPIENT_NAME : $savedValue;
    }

    public function getSender()
    {
        return self::DEFAULT_SENDER;
    }
}