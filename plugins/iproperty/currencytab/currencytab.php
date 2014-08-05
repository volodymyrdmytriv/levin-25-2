<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.plugin.plugin');

class plgIpropertyCurrencyTab extends JPlugin
{
	function plgIpropertyCurrencyTab(&$subject, $config)  
    {
		parent::__construct($subject, $config);
        $this->loadLanguage();
	}

	function onAfterRenderMap($property, $settings)
	{
        $app = JFactory::getApplication();
        if($app->getName() != 'site') return true;

        // currencies supported by Google as of 09/2010
        $currencies = array (
            "ANG" => "Netherlands Antillean Guilder (ANG)",
            "VEF" => "Venezuelan Bolívar Fuerte (VEF)",
            "BHD" => "Bahraini Dinar (BHD)",
            "NPR" => "Nepalese Rupee (NPR)",
            "XOF" => "CFA Franc BCEAO (XOF)",
            "JMD" => "Jamaican Dollar (JMD)",
            "ILS" => "Israeli New Sheqel (ILS)",
            "OMR" => "Omani Rial (OMR)",
            "NAD" => "Namibian Dollar (NAD)",
            "DZD" => "Algerian Dinar (DZD)",
            "ISK" => "Icelandic Króna (ISK)",
            "AUD" => "Australian Dollar (AUD)",
            "HNL" => "Honduran Lempira (HNL)",
            "SKK" => "Slovak Koruna (SKK)",
            "RON" => "Romanian Leu (RON)",
            "TND" => "Tunisian Dinar (TND)",
            "EUR" => "Euro (EUR)",
            "JOD" => "Jordanian Dinar (JOD)",
            "IDR" => "Indonesian Rupiah (IDR)",
            "KES" => "Kenyan Shilling (KES)",
            "SEK" => "Swedish Krona (SEK)",
            "MDL" => "Moldovan Leu (MDL)",
            "QAR" => "Qatari Rial (QAR)",
            "PKR" => "Pakistani Rupee (PKR)",
            "BDT" => "Bangladeshi Taka (BDT)",
            "CAD" => "Canadian Dollar (CAD)",
            "BOB" => "Bolivian Boliviano (BOB)",
            "BND" => "Brunei Dollar (BND)",
            "TRY" => "Turkish Lira (TRY)",
            "SLL" => "Sierra Leonean Leone (SLL)",
            "MKD" => "Macedonian Denar (MKD)",
            "BWP" => "Botswanan Pula (BWP)",
            "MXN" => "Mexican Peso (MXN)",
            "PEN" => "Peruvian Nuevo Sol (PEN)",
            "DOP" => "Dominican Peso (DOP)",
            "NZD" => "New Zealand Dollar (NZD)",
            "TZS" => "Tanzanian Shilling (TZS)",
            "LTL" => "Lithuanian Litas (LTL)",
            "NOK" => "Norwegian Krone (NOK)",
            "KRW" => "South Korean Won (KRW)",
            "RUB" => "Russian Ruble (RUB)",
            "CHF" => "Swiss Franc (CHF)",
            "DKK" => "Danish Krone (DKK)",
            "ARS" => "Argentine Peso (ARS)",
            "NIO" => "Nicaraguan Cordoba Oro (NIO)",
            "CZK" => "Czech Republic Koruna (CZK)",
            "KYD" => "Cayman Islands Dollar (KYD)",
            "FJD" => "Fijian Dollar (FJD)",
            "MVR" => "Maldivian Rufiyaa (MVR)",
            "SAR" => "Saudi Riyal (SAR)",
            "PHP" => "Philippine Peso (PHP)",
            "ZMK" => "Zambian Kwacha (ZMK)",
            "CNY" => "Chinese Yuan Renminbi (CNY)",
            "LBP" => "Lebanese Pound (LBP)",
            "LKR" => "Sri Lanka Rupee (LKR)",
            "GBP" => "British Pound Sterling (GBP)",
            "UYU" => "Uruguayan Peso (UYU)",
            "TTD" => "Trinidad and Tobago Dollar (TTD)",
            "LVL" => "Latvian Lats (LVL)",
            "VND" => "Vietnamese Dong (VND)",
            "NGN" => "Nigerian Naira (NGN)",
            "RSD" => "Serbian Dinar (RSD)",
            "HKD" => "Hong Kong Dollar (HKD)",
            "EGP" => "Egyptian Pound (EGP)",
            "CRC" => "Costa Rican Colón (CRC)",
            "USD" => "US Dollar (USD)",
            "COP" => "Colombian Peso (COP)",
            "PYG" => "Paraguayan Guarani (PYG)",
            "UZS" => "Uzbekistan Som (UZS)",
            "INR" => "Indian Rupee (INR)",
            "YER" => "Yemeni Rial (YER)",
            "JPY" => "Japanese Yen (JPY)",
            "KWD" => "Kuwaiti Dinar (KWD)",
            "KZT" => "Kazakhstan Tenge (KZT)",
            "HUF" => "Hungarian Forint (HUF)",
            "SCR" => "Seychellois Rupee (SCR)",
            "MUR" => "Mauritian Rupee (MUR)",
            "BGN" => "Bulgarian Lev (BGN)",
            "MYR" => "Malaysian Ringgit (MYR)",
            "AED" => "United Arab Emirates Dirham (AED)",
            "UGX" => "Ugandan Shilling (UGX)",
            "EEK" => "Estonian Kroon (EEK)",
            "UAH" => "Ukrainian Hryvnia (UAH)",
            "THB" => "Thai Baht (THB)",
            "ZAR" => "South African Rand (ZAR)",
            "PGK" => "Papua New Guinean Kina (PGK)",
            "TWD" => "New Taiwan Dollar (TWD)",
            "CLP" => "Chilean Peso (CLP)",
            "MAD" => "Moroccan Dirham (MAD)",
            "SVC" => "Salvadoran Colón (SVC)",
            "PLN" => "Polish Zloty (PLN)",
            "SGD" => "Singapore Dollar (SGD)",
            "BRL" => "Brazilian Real (BRL)",
            "HRK" => "Croatian Kuna (HRK)"
        );

        asort($currencies);

        // get site's normal currency and check that it's in the Google array
        $start_curr = $settings->default_currency;
        if(!array_key_exists($start_curr, $currencies)) return true; // not in array so bail out

        // if "call for price" obviously we can't do a conversion so bail out
        if($property->formattedprice == JText::_('COM_IPROPERTY_CALL_FOR_PRICE')) return true;

        // else we can do this so get the price
        $price = $property->price;

        // create javascript for ajax request
        $javascript = "
        window.addEvent('domready', function() {
            $('currency_select').addEvent('change', function(event) {
                var curr = $('currency_select').value;
                var price = '" . $price . "';

                var url = '" . JURI::root(true) . "/plugins/iproperty/currencytab/currencytab_proxy.php?vars=1" . $start_curr . "%3D%3F' + curr + '&price=' +price;
                var request = new Request.JSON({
                    url: url,
                    onComplete: function(jsonObj) {
                        if(typeof(jsonObj) !== 'undefined'){
                            $('new_price').set('html', jsonObj + ' ' + curr );
                        }else{
                            $('new_price').set('html', '--' );
                        }
                    }
                }).get();
            });
        });";

        $doc = JFactory::getDocument();
        $doc->addScriptDeclaration($javascript);

        $currencies_list   = array();
        $currencies_list[] = JHTML::_('select.option', '', JText::_('PLG_IP_CONVERT_CURRENCY'), 'id', 'name' );

        foreach($currencies as $key => $value){
            $currencies_list[] = JHTML::_('select.option', $key, $value, 'id', 'name' );
        }

        $curr_select  = JHTML::_('select.genericlist', $currencies_list, 'currency_select', 'class="inputbox"', 'id', 'name', 'currency_select' );

        echo JHtml::_('tabs.panel', JText::_($this->params->get('tabtitle', 'PLG_IP_CONVERT_CONVERT')), 'ip_currency');
            echo '
                <div id="ip_currency_wrapper" style="width: '.$settings->tab_width.'px; height: '.$settings->tab_height.'px;">
                    <div class="ip_currency_wrapper2" style="padding: 8px;" align="center">
                    <table width="100%" class="ip_favorites">
                        <tr>
                            <td colspan="2" align="center">
                                <b>'.JText::_('PLG_IP_CONVERT_SELECT_CURRENCY').':</b><br />
                                '.$curr_select.'
                            </td>
                        </tr>
                        <tr bgcolor="' . $settings->accent . '">
                            <th width="50%">'.JText::_('PLG_IP_CONVERT_CURRENT_PRICE').'</th>
                            <th width="50%">'.JText::_('PLG_IP_CONVERT_NEW_PRICE').'</th>
                        </tr>
                        <tr>
                            <td align="center">'.ipropertyHTML::getFormattedPrice($price).'</td>
                            <td align="center"><span id="new_price">--</span></td>
                        </tr>
                    </table>
                    </div>
                </div>';
        return true;
	}
}
