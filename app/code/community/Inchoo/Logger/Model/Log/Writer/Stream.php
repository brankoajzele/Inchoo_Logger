<?php

class Inchoo_Logger_Model_Log_Writer_Stream extends Zend_Log_Writer_Stream
{
    /* inchoo logger file path */
    private static $_ilfp;

    public function __construct($streamOrUrl, $mode = NULL)
    {
        self::$_ilfp = $streamOrUrl;
        return parent::__construct($streamOrUrl, $mode);
    }

    protected function _write($event)
    {
        /* First we will try to write a log entry to database */
        if (Mage::helper('inchoo_logger')->isModuleEnabled(Mage::app()->getStore()->getId())) {
            $logger = Mage::getModel('inchoo_logger/logger');

            $logger->setTimestamp($event['timestamp']);
            $logger->setMessage($event['message']);
            $logger->setPriority($event['priority']);
            $logger->setPriorityName($event['priorityName']);
            $logger->setWebsite(Mage::app()->getWebsite()->getId());
            $logger->setWebsiteName(Mage::app()->getWebsite()->getName());
            $logger->setStore(Mage::app()->getStore()->getId());
            $logger->setStoreName(Mage::app()->getStore()->getName());
            $logger->setArea(Mage::getSingleton('core/design_package')->getArea());

            if (is_string(self::$_ilfp)) {
                $logger->setFile(self::$_ilfp);
            }

            /* Check if admin user is logged in, if it is then add its info to the log entry */
            $user = Mage::getSingleton('admin/session')->getUser();
            if ($user && $user->getId()) {
                $logger->setUser($user->getId());
                $logger->setUserEmail($user->getEmail());
            }

            /* Check if customer is logged in, if it is then add its info to the log entry */
            $customer = Mage::getSingleton('customer/session')->getCustomer();
            if ($customer && $customer->getId()) {
                $logger->setCustomer($customer->getId());
                $logger->setCustomerEmail($customer->getEmail());
            }

            $request = Mage::app()->getRequest();

            if ($request instanceof Mage_Core_Controller_Request_Http) {
                $dt = new DateTime('now'); /* $dt->format('Y-m-d H:i:s') */

                $logger->setCreatedAt($dt->format('Y-m-d H:i:s'));
                $logger->setRequestMethod($request->getMethod());
                $logger->setRequestModuleName($request->getModuleName());
                $logger->setRequestBaseUrl($request->getBaseUrl());
                $logger->setRequestRequestUri($request->getRequestUri());
                $logger->setRequestControllerName($request->getControllerName());
                $logger->setRequestActionName($request->getActionName());
                $logger->setRequestClientIp($request->getClientIp());

                if (Mage::helper('inchoo_logger')->logRequestParams()) {
                    if ($params = $request->getParams()) {
                        $params = serialize($params);
                        $params = Mage::helper('core')->encrypt($params);
                        $logger->setRequestParams($params);
                    }
                }
            }

            try {
                $logger->save();
            } catch (Exception $e) {
                echo $e->getMessage(); exit;
                /* Silently die... */
            }
        }

        /* Now pass the execution to original parent code */
        return parent::_write($event);
    }
}
