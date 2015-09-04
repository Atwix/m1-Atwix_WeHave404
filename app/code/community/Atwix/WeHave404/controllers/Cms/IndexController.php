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

require_once Mage::getModuleDir('controllers', 'Mage_Cms') . DS . 'IndexController.php';

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