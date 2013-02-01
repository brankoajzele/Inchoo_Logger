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
class Inchoo_Logger_Block_Adminhtml_Edit_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();

        $this->setId('inchoo_logger');
        $this->setDefaultSort('entity_id');
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('inchoo_logger/logger')
                            ->getCollection();

        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }

    protected function _prepareColumns()
    {
        $this->addColumn('entity_id', array(
            'header' => Mage::helper('inchoo_logger')->__('ID'),
            'sortable' => true,
            'index' => 'entity_id',
        ));

        $this->addColumn('timestamp', array(
            'header'    => Mage::helper('inchoo_logger')->__('Timestamp'),
            'index'     => 'timestamp',
            'type'      => 'text',
            'width' => '170px',
        ));

        $this->addColumn('website_name', array(
            'header'    => Mage::helper('inchoo_logger')->__('Website'),
            'index'     => 'website_name',
            'type'      => 'text',
        ));

        $this->addColumn('store_name', array(
            'header'    => Mage::helper('inchoo_logger')->__('Store'),
            'index'     => 'store_name',
            'type'      => 'text',
        ));

        $this->addColumn('area', array(
            'header'    => Mage::helper('inchoo_logger')->__('Area'),
            'index'     => 'area',
            'type'      => 'text',
        ));

        $this->addColumn('priority_name', array(
            'header' => Mage::helper('inchoo_logger')->__('Priority'),
            'sortable' => true,
            'index' => 'priority_name',
            'type'  => 'options',
            'options' => $this->getPrioritiesOptions()
        ));

        $this->addColumn('message', array(
            'header'    => Mage::helper('inchoo_logger')->__('Message'),
            'index'     => 'message',
            'type'      => 'text',
        ));

        $this->addColumn('user_email', array(
            'header'    => Mage::helper('inchoo_logger')->__('User'),
            'index'     => 'user_email',
            'type'      => 'text',
        ));

        $this->addColumn('customer_email', array(
            'header'    => Mage::helper('inchoo_logger')->__('Customer'),
            'index'     => 'customer_email',
            'type'      => 'text',
        ));

        $this->addColumn('request_controller_name', array(
            'header'    => Mage::helper('inchoo_logger')->__('Controller'),
            'index'     => 'request_controller_name',
            'type'      => 'text',
        ));

        $this->addColumn('request_action_name', array(
            'header'    => Mage::helper('inchoo_logger')->__('Action'),
            'index'     => 'request_action_name',
            'type'      => 'text',
        ));

        $this->addColumn('request_client_ip', array(
            'header'    => Mage::helper('inchoo_logger')->__('Client IP'),
            'index'     => 'request_client_ip',
            'type'      => 'text',
        ));

        $this->addExportType('*/*/exportCsv', Mage::helper('inchoo_logger')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('inchoo_logger')->__('Excel XML'));

        return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }

    public function getPrioritiesOptions()
    {
        $resource = Mage::getSingleton('core/resource');
        $conn = $resource->getConnection('core_write');
        $tableName = $resource->getTableName('inchoo_logger/logger');

        $priorities = $conn->fetchCol("SELECT DISTINCT priority_name FROM {$tableName}");


        $_priorities = array();

        foreach ($priorities as $priority) {
            $_priorities[$priority] = $priority;
        }

        return $_priorities;
    }
}
