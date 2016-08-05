<?php
/**
 * @author      Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
*/
class Kuzman_CatalogUpdates_Helper_Data extends Mage_Core_Helper_Data {

    const XML_PATH_ATTRIBUTES = 'catalog/notifications/prod_attr';
    const XML_PATH_NOTIFICATION_EMAIL = 'catalog/notifications/email';
    const XML_PATH_NOTIFICATION_ENABLED = 'catalog/notifications/enabled';
    const XML_PATH_GENERAL_STORE_EMAIL = 'trans_email/ident_general/email';
    const XML_PATH_GENERAL_STORE_SENDER_NAME = 'trans_email/ident_general/name';

    /**
     * Get array of selected attributes that we've choose for notifications
     *
     * @return array
     */
    public function getSelectedAttributes()
    {
        $attributeArray = array();
        if(Mage::getStoreConfig(self::XML_PATH_ATTRIBUTES)){
            $attributeArray=explode(',',Mage::getStoreConfig(self::XML_PATH_ATTRIBUTES));
        }

        return $attributeArray;
    }

    /**
     * Get Email Address To Receive Notifications
     *
     * @return string
     */
    public function getNotificationEmail()
    {
        return Mage::getStoreConfig(self::XML_PATH_NOTIFICATION_EMAIL);
    }

    /**
     * Get is Notification functionality is enabled
     *
     * @return bool
     */
    public function isEnabled()
    {
        return (bool)Mage::getStoreConfig(self::XML_PATH_NOTIFICATION_ENABLED);
    }

    /**
     * Get Store Email Addresses - General Contact - sender email
     *
     * @return string
     */
    public function getSenderEmail()
    {
        return Mage::getStoreConfig(self::XML_PATH_GENERAL_STORE_EMAIL);
    }

    /**
     * Get Store Email Addresses - General Contact - sender name
     *
     * @return string
     */
    public function getSenderName()
    {
        return Mage::getStoreConfig(self::XML_PATH_GENERAL_STORE_SENDER_NAME);
    }
}