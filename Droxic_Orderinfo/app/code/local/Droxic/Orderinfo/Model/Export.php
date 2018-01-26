<?php

class Droxic_Orderinfo_Model_Export
{

    public function exportOrder($order) 
    {
        $json = array(
              'order_id' => $order->getData('increment_id'),
              'order_data' => array(
                'order_status' => $order->getData('status'),
                'number_of_items' => $order->getData('total_qty_ordered'), 
                'sub_total' => $order->getData('subtotal'),
                'discount' => $order->getData('discount_amount'),
                'grand_total' => $order->getData('grand_total')
                 ),
              'customer_data' => array(
                  'customer_id' => $order->getData('customer_id'),
                  'firstname' => $order->getData('customer_firstname'),
                  'lastname' => $order->getData('customer_lastname'),
                  'email' => $order->getData('customer_email')
                )
            );



        $myJson = json_encode($json);
        
        $url = Mage::getStoreConfig('catalog/backend/droxic_api_url');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($myJson)));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS,$myJson);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        curl_close($ch);
        
        
        return true;
    }
}
