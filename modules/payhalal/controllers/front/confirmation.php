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

class PayHalalConfirmationModuleFrontController extends ModuleFrontController
{
    /**
     * This class should be use by your Instant Payment
     * Notification system to validate the order remotely
     */
    public function postProcess()
    {
        // echo 1;exit;
        $response   = [];
        foreach( $_POST As $k => $v )
            $response[] = "[".$k."]=".$v;

        $objOrder = new Order( (int)Order::getOrderByCartId($_POST['order_id']) );
        if (Order::getOrderByCartId($_POST['order_id']) === false )
        {
            
            $cart = new Cart($_POST['order_id']);
            if ($cart->id_customer == 0 || $cart->id_address_delivery == 0 || $cart->id_address_invoice == 0 || !$this->module->active)
                exit;
            
            // Check that this payment option is still available in case the customer changed his address just before the end of the checkout process
            $authorized = false;
            if (Module::isEnabled("Payhalal"))
            {
                $authorized = true;
            }
            if (!$authorized)
                exit;

            $customer = new Customer($cart->id_customer);

            if (!Validate::isLoadedObject($customer))
                exit;

            $cid = $_POST['order_id'];
            $amount = $_POST['amount'];
            $extra_vars['transaction_id'] = $_POST['transaction_id'];
            $status = $_POST['status'];
            $hash_sent = $_POST['hash'];

            $address  = new Address(intval($cart->id_address_invoice));

            $phone = ( empty($address->phone) ? $address->phone_mobile : $address->phone );

            $customer = new Customer($cart->id_customer);
            if (!Validate::isLoadedObject($customer))
                Tools::redirect('index.php?controller=order&step=1');
            $currency = $this->context->currency;
            $total = number_format((float)$cart->getOrderTotal(true, Cart::BOTH),2);

            $mode = Configuration::get('PAYHALAL_LIVE_MODE');

            if($mode == 1)
            {
                $secret = Configuration::get('PAYHALAL_SECRET_KEY');
                $key = Configuration::get('PAYHALAL_API_KEY');
            }
            else 
            {
                $secret = Configuration::get('PAYHALAL_SECRET_KEY_TESTING');
                $key = Configuration::get('PAYHALAL_API_KEY_TESTING');
            }

            $data_out["app_id"] = $key;
            $data_out["amount"] = $total;
            $data_out["currency"] = $currency->iso_code;
            $data_out["product_description"] = "Prestashop order ".$cart->id;
            $data_out["order_id"] = $cart->id;
            $data_out["customer_name"] = $customer->firstname." ".$customer->lastname;
            $data_out["customer_email"] = $customer->email;
            $data_out["customer_phone"] = $phone;
            $data_out["status"] = $status;

            $hash = self::ph_sha256($data_out,$secret);

            if ($hash == $hash_sent && $amount == $total) {

                if ($status == "SUCCESS") {
                    $PS_STATUS = Configuration::get('PS_OS_PAYMENT');
                } elseif ($status == "FAIL") {
                    $PS_STATUS = Configuration::get('PS_OS_ERROR');
                } else {
                    $PS_STATUS = Configuration::get('PS_OS_ERROR');
                }
                
                $this->module->validateOrder($cid, $PS_STATUS, $amount, $this->module->displayName, implode("\n ", $response), $extra_vars, null, false, $customer->secure_key, null);

                $url = $this->context->link->getPageLink('index',true);

                if ($status == "SUCCESS") {
                    Tools::redirect('index.php?controller=order-confirmation&id_cart='.$cid.'&id_module='.$this->module->id.'&id_order='.$this->module->currentOrder.'&key='.$customer->secure_key);
                } elseif ($status == "FAIL") {
                    Tools::redirect($url."order-history");
                } else {
                    Tools::redirect($url."order-history");
                }
            } 
        }
        else
        {
            die('<p>There something wrong when processing your payment. Please notified Payhalal tech support at support@payhalal.supportsystem.com</p>');
        }
    }

    public function ph_sha256($data, $secret)
    {
        $hash = hash('sha256', $secret . $data["amount"] . $data["currency"] . $data["product_description"] . $data["order_id"] . $data["customer_name"] . $data["customer_email"] . $data["customer_phone"] . $data["status"]);
        return $hash;
    }
}
