<?php
/**
* 2007-2018 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2018 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class PayHalalValidationModuleFrontController extends ModuleFrontController
{
    /**
     * This class should be use by your Instant Payment
     * Notification system to validate the order remotely
     */
    public function postProcess()
    {
        
        $cart = $this->context->cart;
        if ($cart->id_customer == 0 || $cart->id_address_delivery == 0 || $cart->id_address_invoice == 0 || !$this->module->active)
            Tools::redirect('index.php?controller=order&step=1');

        // Check that this payment option is still available in case the customer changed his address just before the end of the checkout process
        $authorized = false;
        foreach (Module::getPaymentModules() as $module){
            if ($module['name'] == 'PayHalal')
            {
                $authorized = true;
                break;
            }
        }
        if (!$authorized)
            die($this->module->getTranslator()->trans('This payment method is not available.', array(), 'Modules.PayHalal.Shop'));

        $customer = new Customer($cart->id_customer);
        $address  = new Address(intval($cart->id_address_invoice));

        $mode = Configuration::get('PAYHALAL_LIVE_MODE');

        if($mode == 1)
        {
            $live = 1;
            $secret = Configuration::get('PAYHALAL_SECRET_KEY');
            $key = Configuration::get('PAYHALAL_API_KEY');
            
        }
        else 
        {
            $live = 0;
            $secret = Configuration::get('PAYHALAL_SECRET_KEY_TESTING');
            $key = Configuration::get('PAYHALAL_API_KEY_TESTING');
        }

        $amount = number_format($cart->getOrderTotal(true, Cart::BOTH),2);
        $currency = $this->context->currency->iso_code;
        $description = "Prestashop order ". $cart->id;
        $oid = $cart->id;
        $name = $customer->firstname." ".$customer->lastname;
        $email = $customer->email;
        $phone = $address->phone;
        $hash = hash('sha256', $secret.$amount.$currency.$description.$oid.$name.$email.$phone);

        
        if (!Validate::isLoadedObject($customer))
            Tools::redirect('index.php?controller=order&step=1');
      
        Tools::redirect('https://payhalal.my/cart_payment.php?amount='.$amount.'&currency='.$currency.'&product_description='.$description.'&order_id='.$oid.'&customer_name='.$name.'&customer_email='.$email.'&customer_phone='.$phone.'&hash='.$hash.'&key='.$key.'&live='.$live);
    }
}
