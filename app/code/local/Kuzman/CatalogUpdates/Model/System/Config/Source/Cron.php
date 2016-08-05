<?php
/**
 * @author      Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */
class Kuzman_CatalogUpdates_Model_System_Config_Source_Cron extends Mage_Core_Model_Config_Data
{
    const CRON_STRING_PATH = 'crontab/jobs/kdcatalogupdates_notification_send/schedule/cron_expr';
    const CRON_MODEL_PATH   = 'crontab/jobs/kdcatalogupdates_notification_send/run/model';

    /**
     * Cron settings after save
     *
     * @return Kuzman_CatalogUpdates_Model_System_Config_Source_Cron
     */

    protected function _afterSave()
    {
        $enabled    = $this->getData('groups/notifications/fields/enabled/value');
        $time       = $this->getData('groups/notifications/fields/time/value');
        $frequncy   = $this->getData('groups/notifications/fields/frequency/value');
        $frequencyDaily     = Mage_Adminhtml_Model_System_Config_Source_Cron_Frequency::CRON_DAILY;
        $frequencyWeekly    = Mage_Adminhtml_Model_System_Config_Source_Cron_Frequency::CRON_WEEKLY;
        $frequencyMonthly   = Mage_Adminhtml_Model_System_Config_Source_Cron_Frequency::CRON_MONTHLY;

        if ($enabled) {
            $cronDayOfWeek = date('N');
            $cronExprArray = array(
                intval($time[1]),                                   # Minute
                intval($time[0]),                                   # Hour
                ($frequncy == $frequencyMonthly) ? '1' : '*',       # Day of the Month
                '*',                                                # Month of the Year
                ($frequncy == $frequencyWeekly) ? '1' : '*',        # Day of the Week
            );
            $cronExprString = join(' ', $cronExprArray);
        }
        else {
            $cronExprString = '';
        }

        try {
            Mage::getModel('core/config_data')
                ->load(self::CRON_STRING_PATH, 'path')
                ->setValue($cronExprString)
                ->setPath(self::CRON_STRING_PATH)
                ->save();

            Mage::getModel('core/config_data')
                ->load(self::CRON_MODEL_PATH, 'path')
                ->setValue((string) Mage::getConfig()->getNode(self::CRON_MODEL_PATH))
                ->setPath(self::CRON_MODEL_PATH)
                ->save();
        }
        catch (Exception $e) {
            Mage::throwException(Mage::helper('adminhtml')->__('Unable to save the cron expression.'));
        }
    }
}