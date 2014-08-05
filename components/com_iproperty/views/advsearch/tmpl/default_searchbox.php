<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

$pd = array();
$pd['cat'] = JRequest::getVar('cat', '', 'get', 'int');
$pd['stype'] = JRequest::getVar('stype', '', 'get', 'int');
$pd['country'] = JRequest::getVar('country', '', 'get', 'int');
$pd['city'] = JRequest::getVar('city', '', 'get', 'string');
$pd['locstate'] = JRequest::getVar('locstate', '', 'get', 'int');
$pd['province'] = JRequest::getVar('province', '', 'get', 'string');
$pd['county'] = JRequest::getVar('county', '', 'get', 'string');
$pd['region'] = JRequest::getVar('region', '', 'get', 'string');
$pd['beds'] = JRequest::getVar('beds', '', 'get', 'int');
$pd['baths'] = JRequest::getVar('baths', '', 'get', 'int');
$pd['price_low'] = JRequest::getVar('price_low', '', 'get', 'int');
$pd['price_high'] = JRequest::getVar('price_high', '', 'get', 'int');

$x = 0;
$predefines = '';
foreach($pd as $key => $value){
    if(!empty($value)){
        if($key == 'cat') $predefines .= '<b>'.JText::_('COM_IPROPERTY_CATEGORY').':</b>&nbsp; '.ipropertyHTML::getCatName($value);
        if($key == 'stype') $predefines .= '<b>'.JText::_('COM_IPROPERTY_SALE_TYPE').':</b>&nbsp; '.ipropertyHTML::get_stype($value);
        if($key == 'country') $predefines .= '<b>'.JText::_('COM_IPROPERTY_COUNTRY').':</b>&nbsp; '.ipropertyHTML::getCountryName($value);
        if($key == 'city') $predefines .= '<b>'.JText::_('COM_IPROPERTY_CITY').':</b>&nbsp; '.$value;
        if($key == 'locstate') $predefines .= '<b>'.JText::_('COM_IPROPERTY_STATE').':</b>&nbsp; '.ipropertyHTML::getStateName($value);
        if($key == 'province') $predefines .= '<b>'.JText::_('COM_IPROPERTY_PROVINCE').':</b>&nbsp; '.$value;
        if($key == 'county') $predefines .= '<b>'.JText::_('COM_IPROPERTY_COUNTY').':</b>&nbsp; '.$value;
        if($key == 'region') $predefines .= '<b>'.JText::_('COM_IPROPERTY_REGION').':</b>&nbsp; '.$value;
        if($key == 'beds') $predefines .= '<b>'.JText::_('COM_IPROPERTY_MIN_BEDS').':</b>&nbsp; '.$value;
        if($key == 'baths') $predefines .= '<b>'.JText::_('COM_IPROPERTY_MIN_BATHS').':</b>&nbsp; '.$value;
        if($key == 'price_low') $predefines .= '<b>'.JText::_('COM_IPROPERTY_MIN_PRICE').':</b>&nbsp; '.ipropertyHTML::getFormattedPrice($value);
        if($key == 'price_high') $predefines .= '<b>'.JText::_('COM_IPROPERTY_MAX_PRICE').':</b>&nbsp; '.ipropertyHTML::getFormattedPrice($value);
        $predefines .= '&nbsp;|&nbsp;';
    }
}
$predefines = rtrim($predefines, '&nbsp;|&nbsp;');
?>

<tr>
    <td colspan="2" id="ip_searchfilter_wrapper">
        <div id="main_ipfilter_container">
            <?php if($predefines): ?>
                <div class="ip-pdsearchfilters">
                    <?php echo $predefines; ?>               
                </div>
            <?php endif; ?>
            <form action="<?php echo htmlspecialchars(JFactory::getURI()->toString()); ?>" method="post" name="ip_quick_search" class="ip_quicksearch_form" id="ip_quicksearch_form">
                <div>
                    <div class="ip_quicksearch_optholder">
                        <ul class="ip_quicksearch_filters">
                            <?php
                            if ( $this->settings->qs_show_keyword ) echo '<li><label for="search">' . JText::_('COM_IPROPERTY_KEYWORD') . ':</label> <input type="text" class="inputbox ip_qssearch" onclick="this.value=\'\'" name="search" value="' . $this->lists['search'] . '" /></li>';
                            if ( $this->settings->qs_show_cat && !$pd['cat'] && ((JRequest::getVar('view') != 'cat') || (JRequest::getVar('view') == 'cat' && JRequest::getInt('id') == 0))) echo '<li><label for="cat">' . JText::_('COM_IPROPERTY_CATEGORY') . ':</label> ' . $this->lists['cat'] . '</li>';
                            if ( $this->settings->qs_show_stype && !$pd['stype'] ) echo '<li><label for="stype">' . JText::_('COM_IPROPERTY_SALE_TYPE') . ':</label> ' . $this->lists['stype'] . '</li>';
                            if ( $this->settings->qs_show_country && !$pd['country'] ) echo '<li><label for="country">' . JText::_('COM_IPROPERTY_COUNTRY') . ':</label> ' . $this->lists['country'] . '</li>';
                            if ( $this->settings->qs_show_city && !$pd['city'] ) echo '<li><label for="city">' . JText::_('COM_IPROPERTY_CITY') . ':</label> ' . $this->lists['city'] . '</li>';
                            if ( $this->settings->qs_show_state && !$pd['locstate'] ) echo '<li><label for="locstate">' . JText::_('COM_IPROPERTY_STATE') . ':</label> ' . $this->lists['state'] . '</li>';
                            if ( $this->settings->qs_show_province && !$pd['province'] ) echo '<li><label for="province">' . JText::_('COM_IPROPERTY_PROVINCE') . ':</label> ' . $this->lists['province'] . '</li>';
                            if ( $this->settings->qs_show_county && !$pd['county'] ) echo '<li><label for="county">' . JText::_('COM_IPROPERTY_COUNTY') . ':</label> ' . $this->lists['county'] . '</li>';
                            if ( $this->settings->qs_show_region && !$pd['region'] ) echo '<li><label for="region">' . JText::_('COM_IPROPERTY_REGION') . ':</label> ' . $this->lists['region'] . '</li>';
                            if ( $this->settings->qs_show_minbeds && !$pd['beds'] ) echo '<li><label for="beds">' . JText::_('COM_IPROPERTY_MIN_BEDS') . ':</label> ' . $this->lists['beds'] . '</li>';
                            if ( $this->settings->qs_show_minbaths && !$pd['baths'] ) echo '<li><label for="baths">' . JText::_('COM_IPROPERTY_MIN_BATHS') . ':</label> ' . $this->lists['baths'] . '</li>';
                            if ( $this->settings->qs_show_price && !$pd['price_low'] ) echo '<li><label for="price_low" class="hasTip" title="'.JText::_('COM_IPROPERTY_MIN_PRICE').' :: '.JText::_('COM_IPROPERTY_NUMBER_ONLY_TEXT').'">' . JText::_('COM_IPROPERTY_MIN_PRICE') . ':</label> <input onclick="this.value=\'\'" onkeypress="return isNumberKey(event)" type="text" class="inputbox ip_qsprice" name="price_low" value="' . $this->lists['price_low'] . '" /></li>';
                            if ( $this->settings->qs_show_price && !$pd['price_high'] ) echo '<li><label for="price_high" class="hasTip" title="'.JText::_('COM_IPROPERTY_MAX_PRICE').' :: '.JText::_('COM_IPROPERTY_NUMBER_ONLY_TEXT').'">' . JText::_('COM_IPROPERTY_MAX_PRICE') . ':</label> <input onclick="this.value=\'\'" onkeypress="return isNumberKey(event)" type="text" class="inputbox ip_qsprice" name="price_high" value="' . $this->lists['price_high'] . '" /></li>';
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="ip_quicksearch_sortholder">                
                    <?php
                    $pd['filter_order'] = JRequest::getVar('filter_order', '', 'get', 'cmd');
                    $pd['filter_order_dir'] = JRequest::getVar('filter_order_dir', '', 'get', 'cmd');
                    echo '<ul class="ip_quicksearch_filters">';
                        if(!$pd['filter_order']) echo '<li><label for="filter_order">' . JText::_('COM_IPROPERTY_SORTBY') . ':</label> ' . $this->lists['sort'] . '</li>';
                        if(!$pd['filter_order_dir']) echo '<li><label for="filter_order_dir">' . JText::_('COM_IPROPERTY_ORDERBY') . ':</label> ' . $this->lists['order'] . '</li>';
                        echo '<li><input type="button" class="ipbutton" onclick="clearForm(this.form);" value="'.JText::_('COM_IPROPERTY_RESET').'" /></li>';
                        echo '<li><input type="submit" class="ipbutton" value="'.JText::_('COM_IPROPERTY_GO').'" /></li>';
                    echo '</ul>';
                    ?>
                </div>
                <input type="hidden" name="option" value="com_iproperty" />
            </form>
        </div>
    </td>
</tr>