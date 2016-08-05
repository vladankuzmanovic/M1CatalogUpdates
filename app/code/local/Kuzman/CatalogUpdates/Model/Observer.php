<?php
/**
 * @author      Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */
class Kuzman_CatalogUpdates_Model_Observer extends Mage_Core_Model_Abstract
{
	/**
     * This method is used to send emails which contains data of changed product attribute values
     * Delete the data from table log_product_attribute_updates after the email is sent
     * run on cron
     */
    public function sendNotificationEmail()
    {
        $helper=Mage::helper('kdcatalogupdates');
        if($helper->isEnabled()){
            $logCollection=Mage::getModel('kdcatalogupdates/log')->getCollection();
            if($logCollection->count()){
                $notificationEmail= $helper->getNotificationEmail();
                $emailTemplate  = Mage::getModel('core/email_template')
                    ->loadDefault('productattribute_update_notification');

                $emailTemplateVariables = array();
                $emailTemplate->setTemplateSubject('Changed Product Attributes');
                $emailTemplate->setSenderName($helper->getSenderName());
                $emailTemplate->setSenderEmail($helper->getSenderEmail());
                if($emailTemplate->send($notificationEmail,'', $emailTemplateVariables))
                {
                    foreach($logCollection as $log){
                        $log->delete();
                    }
                }
            }
        }
    }
    /*
     * Observes - catalog_product_save_commit_after @Global
     * This method is used to log the changes of selected product attributes
     * Data is saved in log_product_attribute_updates table
     */
    public function logAttributeChanges($observer)
    {
        $helper=Mage::helper('kdcatalogupdates');
        if($helper->isEnabled()){
            $product=$observer->getProduct();
            $storeId= $product->getData('store_id');
            $productId=$product->getData('entity_id');
            // only for global scope    
            if(!$storeId){
                $attributeList=$helper->getSelectedAttributes();
                foreach((array) $attributeList as $attributeCode){
                    $notificationLogModel=Mage::getModel('kdcatalogupdates/log');
                    $attributeId = Mage::getResourceModel('eav/entity_attribute')
                                            ->getIdByCode(Mage_Catalog_Model_Product::ENTITY,$attributeCode);

                    $notificationLogId = $notificationLogModel->getIdByProductIdAndAttributeId($productId,$attributeId);
                    //  don't log for new products
                    if($product->getOrigData('entity_id')){
                        $oldAttributeValue = $product->getOrigData($attributeCode);
                        $newAttributeValue= $product->getData($attributeCode);
                        if ($oldAttributeValue!=$newAttributeValue){
                            if($notificationLogId){
                                $notificationLogModel->load($notificationLogId);
                                $notificationLogModel->setNewVal($newAttributeValue);
                                $notificationLogModel->save();
                            }else{
                                $notificationLogModel->setPid($productId);
                                $notificationLogModel->setAttrId($attributeId);
                                $notificationLogModel->setOldVal($oldAttributeValue);
                                $notificationLogModel->setNewVal($newAttributeValue);
                                $notificationLogModel->save();
                            }
                        }
                    }
                }
            }
        }
    }
}