<?php
/**
 * Atwix
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 * @category    Atwix Mod
 * @package     Atwix_WeHave404
 * @author      Atwix Core Team
 * @copyright   Copyright (c) 2015 Atwix (http://www.atwix.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Atwix_WeHave404_Helper_Data extends Mage_Core_Helper_Abstract
{
    const EMAIL_TEMPLATE_ID = 'atwix_wehave404_notification';
    const DEFAULT_RECIPIENT_NAME = 'Support Team';
    const DEFAULT_SENDER = 'general';
    const DEFAULT_LOGFILE_NAME = 'atwix_wehave404.log';
    const NOTIFICATION_TYPE_LOG = 0;
    const NOTIFICATION_TYPE_EMAIL = 1;

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

    public function getNotificationType()
    {
        $savedValue = Mage::getStoreConfig('atwix_wehave404/general/notification_type');

        return $savedValue;
    }

    public function getLogfileName()
    {
        $savedValue = Mage::getStoreConfig('atwix_wehave404/general/logfile_name');

        return (empty($savedValue)) ? self::DEFAULT_LOGFILE_NAME : $savedValue;
    }

    public function notifyAbout404()
    {
        $result = false;
        if ($this->isEnabled()) {
            $notificationType = (int) $this->getNotificationType();
            $requestedUrl = Mage::helper('core/url')->getCurrentUrl();

            if ($notificationType === self::NOTIFICATION_TYPE_LOG) {
                $fileName = $this->getLogfileName();
                Mage::log($requestedUrl, Zend_Log::INFO, $fileName, false);
                $result = true;
            } elseif ($notificationType === self::NOTIFICATION_TYPE_EMAIL) {
                $emailTemplateVariables = array('requested_url' => $requestedUrl);
                $storeId = Mage::app()->getStore()->getId();
                $emailTemplateId = $this->getEmailTemplateId();
                $recipientEmail = $this->getRecepientEmail();
                $recipientName = $this->getRecipientName();
                $sender = $this->getSender();

                /** @var Mage_Core_Model_Email_Template $emailTemplate */
                $emailTemplate = Mage::getModel('core/email_template');
                $emailTemplate->sendTransactional($emailTemplateId, $sender, $recipientEmail, $recipientName, $emailTemplateVariables, $storeId);
                $result = true;
            }
        }

        return $result;
    }

}