<?php

class Droxic_Orderinfo_Model_Customer 
{
    public function newCustomer($customer, $order)
    {
        try {
            $storeId = $order->getStoreId();

            $templateId = Mage::getStoreConfig(
                'sales_email/order/new_customer_template', 
                $storeId
            );

            $mailer = Mage::getModel('core/email_template_mailer');
            $emailInfo = Mage::getModel('core/email_info');
            $emailInfo->addTo(
                Mage::getStoreConfig(Mage_Sales_Model_Order::XML_PATH_EMAIL_IDENTITY)
            );

            $mailer->addEmailInfo($emailInfo);

            // Set all required params and send emails
            $mailer->setSender(
                Mage::getStoreConfig(
                    Mage_Sales_Model_Order::XML_PATH_EMAIL_IDENTITY, 
                    $storeId
                )
            );
            $mailer->setStoreId($storeId);
            $mailer->setTemplateId($templateId);
            $mailer->setTemplateParams(
                array(
                    'customer'  => $customer
                )
            );
            $mailer->send();
        } catch (Exception $e) {
            Mage::logException($e);
            return false;
        } 
        
        return true;

    }
}
