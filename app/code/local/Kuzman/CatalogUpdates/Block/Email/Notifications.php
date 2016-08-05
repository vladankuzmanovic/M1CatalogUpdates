<?php
/**
 * @author	    Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */
class Kuzman_CatalogUpdates_Block_Email_Notifications extends Mage_Core_Block_Template
{
    /**
     * Get the Log Model Collection
     *
     * @return object
     */
    public function getNotificationsCollection()
    {
        return Mage::getModel('kdcatalogupdates/log')->getCollection();
    }

    /**
     * Get Attribute Front Label Based On Attribute Id
     *
     * @param int $attributeId
     * @return string $attributeLabel
     */
    public function getAttributeFrontLabel($attributeId)
    {
        return Mage::getSingleton('eav/config')
                                    ->getAttribute('catalog_product', $attributeId)
                                    ->getData('frontend_label');
    }
}