<?php
/**
 * Inchoo
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
 *
 * DISCLAIMER
 *
 * Please do not edit or add to this file if you wish to upgrade
 * Magento or this extension to newer versions in the future.
 * Inchoo developers (Inchooer's) give their best to conform to
 * "non-obtrusive, best Magento practices" style of coding.
 * However, Inchoo does not guarantee functional accuracy of
 * specific extension behavior. Additionally we take no responsibility
 * for any possible issue(s) resulting from extension usage.
 * We reserve the full right not to provide any kind of support for our free extensions.
 * Thank you for your understanding.
 *
 * @category    Inchoo
 * @package     Inchoo_Logger
 * @author      Branko Ajzele <ajzele@gmail.com>
 * @copyright   Copyright (c) Inchoo (http://inchoo.net/)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Inchoo_Logger_Model_Api extends Mage_Api_Model_Resource_Abstract
{
    public function logs($limit = 100, $sortOrder = 'DESC', $website = null, $store = null, $from = null, $to = null)
    {
        /* Sanitize limit */
        $limit = (int)$limit;
        if ($limit > 1000) {
            $limit = 1000; /* Set some max API limit */
        }

        /* Sanitize sort order */
        $sortOrder = strtoupper($sortOrder);
        if ($sortOrder !== 'DESC') {
            $sortOrder = 'ASC';
        }

        $logs = Mage::getModel('inchoo_logger/logger')
                    ->getCollection();

        /* Add website ID or website name filter if any */
        if ($website && !$store) {
            if (is_numeric($website)) {
                $logs->addFieldToFilter('website', array('eq'=>(int)$website));
            } else {
                $logs->addFieldToFilter('website_name', array('eq'=>$website));
            }
        }

        /* Add store ID or store name filter if any */
        if ($store && !$website) {
            if (is_numeric($store)) {
                $logs->addFieldToFilter('store', array('eq'=>(int)$store));
            } else {
                $logs->addFieldToFilter('store_name', array('eq'=>$store));
            }
        }

        /* Add FROM - TO date range filter if any, date supplied must be in form of 'Y-m-d H:i:s' */
        if ($from && $to) {
            $dtFrom = new DateTime($from);
            $dtTo = new DateTime($to);

            $logs->addFieldToFilter('created_at', array('from'=>$dtFrom->format('Y-m-d H:i:s'), 'to'=>$dtTo->format('Y-m-d H:i:s')));
        }

        /* Set SORT by entity_id column  */
        $logs->getSelect()->order('entity_id '.$sortOrder);
        /* Set LIMIT */
        $logs->getSelect()->limit($limit);

        $result = array();
        foreach ($logs as $log) {
            $_log = $log->toArray();
            unset($_log['request_params']); /* we don't send possibly sensitive request_params via API */
            $result[] = $_log;
        }

        return $result;
    }
}
