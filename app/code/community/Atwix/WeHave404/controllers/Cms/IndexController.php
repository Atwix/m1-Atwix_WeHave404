<?php

require_once 'Mage/Cms/controllers/IndexController.php';


class Atwix_WeHave404_Cms_IndexController extends Mage_Cms_IndexController
{
    /**
     * Render CMS 404 Not found page and send notification to configured email address
     *
     * @param string $coreRoute
     */
    public function noRouteAction($coreRoute = null)
    {
        /** @var Atwix_WeHave404_Helper_Data $atwixNotFoundHelper */
        $atwixNotFoundHelper = Mage::helper('atwix_wehave404');

        $isNotificationEnabled = $atwixNotFoundHelper->isEnabled();
        if ($isNotificationEnabled) {
            $requestedUrl = Mage::helper('core/url')->getCurrentUrl();
            $emailTemplateVariables = array('requested_url' => $requestedUrl);
            $storeId = Mage::app()->getStore()->getId();

            $emailTemplateId = $atwixNotFoundHelper->getEmailTemplateId();
            $recipientEmail = $atwixNotFoundHelper->getRecepientEmail();
            $recipientName = $atwixNotFoundHelper->getRecipientName();
            $sender = $atwixNotFoundHelper->getSender();

            /** @var Mage_Core_Model_Email_Template $emailTemplate */
            $emailTemplate = Mage::getModel('core/email_template');

            $emailTemplate->sendTransactional($emailTemplateId, $sender, $recipientEmail, $recipientName, $emailTemplateVariables, $storeId);
        }

        $this->getResponse()->setHeader('HTTP/1.1','404 Not Found');
        $this->getResponse()->setHeader('Status','404 File not found');

        $pageId = Mage::getStoreConfig(Mage_Cms_Helper_Page::XML_PATH_NO_ROUTE_PAGE);
        if (!Mage::helper('cms/page')->renderPage($this, $pageId)) {
            $this->_forward('defaultNoRoute');
        }
    }

}