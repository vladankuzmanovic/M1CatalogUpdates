<?php
/**
 * @author      Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */
class Kuzman_CatalogUpdates_Model_Log extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('kdcatalogupdates/log');
    }

    /**
     * Get the modelId by product id and attribute id
     *
     * @param int $productId
     * @param int $attributeId
     * @return int modelId
     */
    public function getIdByProductIdAndAttributeId($productId, $attributeId)
    {
        foreach ($this->getCollection() as $item){

            if (($item->getPid() == $productId) && ($item->getAttrId() == $attributeId)){

                return $item->getId();
            }
        }
        return null;
    }
}