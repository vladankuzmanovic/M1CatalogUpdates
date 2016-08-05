Kuzman_CatalogUpdates
==========================

Requirement was to enable Website owner to monitor changes on their products. 
This extension was hardcoded to monitor only for changes in Global scope.


Version:
------------------------

- Stable: version 0.0.2

Features:
-------------------------

- New configuration section on System->Configuration->Catalog->Catalog->Monitor
- Enable/Disable monitoring and notifications
- Define product attributes to include in monitoring. Changes will be logged only when values are changed for selected attributes.
- Define email address to receive notification containing all logged changes
- Define schedule for notification email sending.
- Append Magento database with new table "log_product_attribute_updates"
- Creates additional custom cron job "kdcatalogupdates_notification_send"
- Add observer on "catalog_product_save_commit_after" for log writting
- No rewrites
- Tested On: Enterprise Edition 1.13.1.0 
			 Community Edition 1.8.1.0 and 1.9.0.1 

Installation:
-------------------------

1. Clear the store cache under var/cache, var/full_page_cache and all cookies for your store domain. Disable compilation if enabled. This step eliminates almost all potential problems. It’s necessary since Magento uses cache heavily.
2. Backup your store database and web directory.
3. Download and unzip extension contents on your computer and navigate inside the extracted folder.
4. Using your FTP client upload content of ”app” directory to “app” directory inside your store root.

Uninstall:
-------------------------

- You can safely remove the extension files from your store.
- Delete custom extension database table, config values, resource record

```sql
DROP TABLE log_product_attribute_updates;
DELETE FROM core_config_data WHERE path LIKE 'catalog/notifications/%' OR path LIKE '%kdcatalogupdates%';
DELETE FROM core_resource WHERE code = 'kdcatalogupdates_setup';
```
