# Payhalal Prestashop 1.7.7 Plugin

## Requirements
- PHP 7.3
- Prestashop 1.7.7

## Note

SouqaFintech SDN BHD **IS NOT RESPONSIBLE** for any problems that may arise from the use of this extension. Use this at your own risk. For any assistance, please email <mark>support@payhalal.freshdesk.com</mark>.

## Setup Instructions

```bash
cd ~/path/to/your/prestashop/site/modules
git clone https://github.com/SouqaFintech/payhalal-prestashop-plugin.git
```

Go to your `Prestashop Admin > Modules > Module Catalogue > search for "Payhalal" > Install Plugin`

Once you have successfully installed the plugins, configure the plugin and enter your credentials. Refer to the screenshots below:

![image](https://payhalal.my/assets/images/PrestaShopSetup/prestashop1.jpeg) 
![image](https://payhalal.my/assets/images/PrestaShopSetup/prestashop2.jpeg) 
![image](https://payhalal.my/assets/images/PrestaShopSetup/prestashop3.jpeg) 
![image](https://payhalal.my/assets/images/PrestaShopSetup/prestashop4.jpeg) 
![image](https://payhalal.my/assets/images/PrestaShopSetup/prestashop5.jpeg) 
![image](https://payhalal.my/assets/images/PrestaShopSetup/prestashop6.jpeg) 
![image](https://payhalal.my/assets/images/PrestaShopSetup/prestashop7.jpeg) 
![image](https://payhalal.my/assets/images/PrestaShopSetup/prestashop8.jpeg) 

After following the instructions above and creating your Payhalal account, head to the Payhalal Merchant Dashboard and click on Developer tools. Add the following URLs:

- Return URL: https://your-website/index.php?fc=module&module=payhalal&controller=confirmation  
- Success URL: https://your-website/index.php?fc=module&module=payhalal&controller=confirmation
- Cancel URL: https://your-website/index.php?fc=module&module=payhalal&controller=confirmation   

If you have any troubles with installation or have any questions, please contact <mark>support@payhalal.freshdesk.com</mark>
