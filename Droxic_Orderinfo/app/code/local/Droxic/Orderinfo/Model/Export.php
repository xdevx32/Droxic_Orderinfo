<?php
/**
 * Solvingmagento_OrderExport Export class
 * 
 * PHP version 5.3
 * 
 * @category  Knm
 * @package   Solvingmagento_OrderExport
 * @author    Oleg Ishenko <oleg.ishenko@solvingmagento.com>
 * @copyright 2013 Oleg Ishenko
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @version   GIT: <0.1.0>
 * @link      http://www.solvingmagento.com/
 *
 */

/** Solvingmagento_OrderExport_Model_Export
 * 
 * @category Knm
 * @package  Solvingmagento_OrderExport
 * 
 * @author   Oleg Ishenko <oleg.ishenko@solvingmagento.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @version  Release: <package_version>
 * @link     http://www.solvingmagento.com/
 * 
 * 
 */
class Droxic_Orderinfo_Model_Export
{
    
    /**
     * Generates an XML file from the order data and places it into
     * the var/export directory
     * 
     * @param Mage_Sales_Model_Order $order order object
     * 
     * @return boolean
     */
    public function exportOrder($order) 
    {
        $dirPath = Mage::getBaseDir('var') . DS . 'acho';
        
        //if the export directory does not exist, create it
        if (!is_dir($dirPath)) {
            mkdir($dirPath, 0777, true);
        }

        $json = array(
              'order_id' => $order->getData('increment_id'),
              'order_data' => array(
                'order_status' => $order->getData('status'),
                'number_of_items' => $order->getData('total_qty_ordered'), //payment method is missing
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
        /*
        $url = Mage::getStoreConfig('catalog/backend/droxic_api_url');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($myJson)));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS,$myJson);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        curl_close($ch);
        */
        file_put_contents(
            $dirPath. DS .$order->getIncrementId().'.json', 
            $myJson
        );
        
        return true;
    }
}