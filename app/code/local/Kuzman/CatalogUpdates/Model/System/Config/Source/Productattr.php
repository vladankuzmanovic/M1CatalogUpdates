<?php
/**
 * @author      Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */
class Kuzman_CatalogUpdates_Model_System_Config_Source_Productattr
{
    public function toOptionArray()
    {
        $attributes = Mage::getResourceModel('catalog/product_attribute_collection')->addVisibleFilter();
        $attributeArray = array();

        foreach($attributes as $attribute){
            $attributeArray[] = array(
                'label' => $attribute->getData('frontend_label'),
                'value' => $attribute->getData('attribute_code')
            );
        }
        return $attributeArray;
    }
}