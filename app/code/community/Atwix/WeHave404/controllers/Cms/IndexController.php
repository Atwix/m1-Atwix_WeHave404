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
        $atwixNotFoundHelper->notifyAbout404();

        $this->getResponse()->setHeader('HTTP/1.1','404 Not Found');
        $this->getResponse()->setHeader('Status','404 File not found');

        $pageId = Mage::getStoreConfig(Mage_Cms_Helper_Page::XML_PATH_NO_ROUTE_PAGE);
        if (!Mage::helper('cms/page')->renderPage($this, $pageId)) {
            $this->_forward('defaultNoRoute');
        }
    }

}