# Billingo-Magento

## Uninstall old version (pre 3.0)

- `bin/magento module:disable PWS_Billingo`
- delete `app/code/PWS/` folder
- `bin/magento setup:di:compile`
- `bin/magento setup:static-content:deploy`
- `bin/magento cache:flush`


## Install

- extract zip to magento-root-folder

- run `bin/magento module:enable PWS_Billingo`

- execute (in magento-root-folder):
  - `bin/magento setup:upgrade`
  - `bin/magento setup:di:compile`
  - `bin/magento setup:static-content:deploy`
  - `bin/magento cache:flush`

If the module was previously installed:

Remove module installation registry from database, in the setup_module table. (```DELETE FROM `setup_module` WHERE module = 'PWS_Billingo'```)
Re-run `bin/magento setup:upgrade`
