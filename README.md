# Payhalal Prestashop 1.7.7 Plugin

## Requirements
- PHP 7.4
- Prestashop 1.7.7

## Note

SouqaFintech SDN BHD **IS NOT RESPONSIBLE** for any problems that may arise from the use of this extension. Use this at your own risk. For any assistance, please email <mark>support@payhalal.freshdesk.com</mark>.

## Setup Instructions

```bash
git clone https://github.com/SouqaFintech/payhalal-prestashop-plugin.git
```

After you have activated the plugin and created your Payhalal account, head to the Payhalal Merchant Dashboard and click on Developer tools. Add the following URLs:

- Return URL: https://your-website/index.php?fc=module&module=payhalal&controller=confirmation  
- Success URL: https://your-website/index.php?fc=module&module=payhalal&controller=confirmation
- Cancel URL: https://your-website/index.php?fc=module&module=payhalal&controller=confirmation   

If you have any troubles with installation or have any questions, please contact <mark>support@payhalal.freshdesk.com</mark>
