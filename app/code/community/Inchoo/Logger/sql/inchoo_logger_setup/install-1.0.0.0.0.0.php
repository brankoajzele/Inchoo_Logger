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

$installer = $this;
/* @var $installer Inchoo_Logger_Model_Resource_Setup */

$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('inchoo_logger/logger'))
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Id')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'nullable'  => false,
    ), 'Created At')
    ->addColumn('timestamp', Varien_Db_Ddl_Table::TYPE_CHAR, 25, array(
        'nullable'  => false,
        ), 'Timestamp')
    ->addColumn('message', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable'  => false,
        ), 'Message')
    ->addColumn('priority', Varien_Db_Ddl_Table::TYPE_INTEGER, 2, array(
        'nullable'  => false,
        ), 'Priority')
    ->addColumn('priority_name', Varien_Db_Ddl_Table::TYPE_VARCHAR, 32, array(
        'nullable'  => false,
        ), 'Priority Name')
    ->addColumn('file', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable'  => false,
    ), 'File')
    ->addColumn('website', Varien_Db_Ddl_Table::TYPE_INTEGER, 5, array(
        'nullable'  => false,
    ), 'Website')
    ->addColumn('website_name', Varien_Db_Ddl_Table::TYPE_VARCHAR, 64, array(
        'nullable'  => false,
    ), 'Website Name')
    ->addColumn('store', Varien_Db_Ddl_Table::TYPE_INTEGER, 5, array(
        'nullable'  => false,
    ), 'Store')
    ->addColumn('store_name', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable'  => false,
    ), 'Store Name')
    ->addColumn('area', Varien_Db_Ddl_Table::TYPE_VARCHAR, 32, array(
        'nullable'  => true,
    ), 'Area')
    ->addColumn('user', Varien_Db_Ddl_Table::TYPE_INTEGER, 10, array(
        'nullable'  => true,
    ), 'Admin User ID')
    ->addColumn('user_email', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable'  => true,
    ), 'Admin User Email')
    ->addColumn('customer', Varien_Db_Ddl_Table::TYPE_INTEGER, 10, array(
        'nullable'  => false,
    ), 'Customer ID')
    ->addColumn('customer_email', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable'  => true,
    ), 'Customer Email')
    ->addColumn('request_method', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable'  => true,
    ), 'Request Method')
    ->addColumn('request_module_name', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable'  => true,
    ), 'Request Module Name')
    ->addColumn('request_base_url', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable'  => true,
    ), 'Request Base Url')
    ->addColumn('request_request_uri', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable'  => true,
    ), 'Request Request Uri')
    ->addColumn('request_controller_name', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable'  => true,
    ), 'Request Controller Name')
    ->addColumn('request_action_name', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable'  => true,
    ), 'Request Action Name')
    ->addColumn('request_client_ip', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable'  => true,
    ), 'Request Client Ip')
    ->addColumn('request_params', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable'  => true,
    ), 'Request Params')
    ->setComment('Inchoo_Logger');
$installer->getConnection()->createTable($table);

$installer->endSetup();
