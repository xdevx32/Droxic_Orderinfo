<?php

class Droxic_Orderinfo_Model_Observer
{
    public function exportOrder(Varien_Event_Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        
        Mage::getModel('droxic_orderinfo/export')
            ->exportOrder($order);
        
        return true;
        
    }
    
    public function newCustomer(Varien_Event_Observer $observer)
    {
        $orderIds = $observer->getEvent()->getOrderIds();
        
        if (!is_array($orderIds) || (!array_key_exists(0, $orderIds))) {
            return;
        }
        
        $order = Mage::getModel('sales/order')->load($orderIds[0]);
        
        if (!$order->getId()) {
            return;
        }
        
        if (!$order->getCustomerId()) {
            //send a message only for registered customers
            return;
        }
        
        $customer = Mage::getModel('customer/customer')->load($order->getCustomerId());
        
        if (!$customer->getId()) {
            return;
        }
        
        $customerOrders = Mage::getModel('sales/order')
                ->getCollection()
                ->addAttributeToFilter('customer_id', $customer->getId());
        if (count($customerOrders) > 1) {
            // send a message only after the first order
            return;
        }
        
        return Mage::getModel('droxic_orderinfo/customer')
            ->newCustomer($customer, $order);        
    }
}
