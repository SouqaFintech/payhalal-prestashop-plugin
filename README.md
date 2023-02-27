# Payhalal Prestashop 1.7.7 Plugin

## Setup Instructions

```bash
cd ~/path/to/your/prestashop/site/modules
git clone https://github.com/SouqaFintech/payhalal-prestashop-plugin.git
```

## Requirements
- PHP 7.3
- Prestashop 1.7.7

Go to your `Prestashop Admin > Modules > Module Catalogue > search for "Payhalal" > Install Plugin`

Once you have successfully installed and configured the plugin and entered your credentials. Refer to the screenshots below:

![image](https://payhalal.my/assets/images/PrestaShopSetup/prestashop1.jpeg) 
![image](https://payhalal.my/assets/images/PrestaShopSetup/prestashop2.jpeg) 
![image](https://payhalal.my/assets/images/PrestaShopSetup/prestashop3.jpeg) 
![image](https://payhalal.my/assets/images/PrestaShopSetup/prestashop4.jpeg) 
![image](https://payhalal.my/assets/images/PrestaShopSetup/prestashop5.jpeg) 
![image](https://payhalal.my/assets/images/PrestaShopSetup/prestashop6.jpeg) 
![image](https://payhalal.my/assets/images/PrestaShopSetup/prestashop7.jpeg) 
![image](https://payhalal.my/assets/images/PrestaShopSetup/prestashop8.jpeg) 

After following the instructions above and creating your Payhalal account, head to the Payhalal Merchant Dashboard and click on Developer tools. Add the following URLs:

Refer to the images below: 

- Login to your <a href='https://merchant.payhalal.my' target='_blank'>merchant dashboard</a>. Then on the left menu click General > Developer Tools, click edit app to insert the url (please refer image below).
![image](https://payhalal.my/images/opencart/developer_tools.jpeg)

- Select which app key that you want to integrate with prestashop plugin and insert the URL's as mention below and DO NOT insert callback url for this plugin. Click save button once you finish adding the url's.

![image](https://payhalal.my/images/opencart/url_setting.jpeg)

- Return URL: https://your-website/index.php?fc=module&module=payhalal&controller=confirmation  
- Success URL: https://your-website/index.php?fc=module&module=payhalal&controller=confirmation
- Cancel URL: https://your-website/index.php?fc=module&module=payhalal&controller=confirmation
- Callback URL: Please leave this blank to avoid any issues  

**Replace "your-website" with your shopping cart domain.**

If you have any troubles with installation or have any questions, please contact <mark>support@payhalal.freshdesk.com</mark>

## Note

SouqaFintech SDN BHD **IS NOT RESPONSIBLE** for any problems that may arise from the use of this extension. Use this at your own risk. For any assistance, please email <mark>tech_support@payhalal.my</mark>.
