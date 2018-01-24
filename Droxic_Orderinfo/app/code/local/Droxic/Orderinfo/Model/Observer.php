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
    
}
