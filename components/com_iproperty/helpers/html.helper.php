<?php

/**

 * @version 2.0.3 2013-04-08

 * @package Joomla

 * @subpackage Intellectual Property

 * @copyright (C) 2013 the Thinkery

 * @license GNU/GPL see LICENSE.php

 */



defined( '_JEXEC' ) or die( 'Restricted access' );

require_once (JPATH_ADMINISTRATOR.DS.'components'.DS.'com_iproperty'.DS.'classes'.DS.'admin.class.php' );

require_once (JPATH_SITE.DS.'components'.DS.'com_iproperty'.DS.'helpers'.DS.'auth.php' );



abstract class IpropertyHTML

{

	

    function buildToolbar($view = '', $extras = '')

    {

        JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

        $settings   = ipropertyAdmin::config();



        if( $extras ){

            foreach( $extras as $key=>$value ){

                $this->$key = $value;

            }

        }



        $ipversion = ipropertyAdmin::_getversion();

        $html = "<!-- Iproperty v".$ipversion['iproperty']." by The Thinkery. http://thethinkery.net -->\n";

        if(JRequest::getInt('print') == 1){

            $html .= '<div align="center">

                        <script language="JavaScript">

                            if (window.print) {

                                document.write(\'<form><input type="button" class="inputbox" name="print" value="'.JText::_( 'COM_IPROPERTY_PRINT' ).'" onClick="window.print()"></form>\');

                            }

                        </script>

                      </div>';

        }else{

            $html .= '<div id="ip_toolbar">';

            $html .= '<a href="javascript:history.back();">'.JText::_( 'COM_IPROPERTY_BACK' ).'</a>';

                switch( $view ){

                    // PROPERTY VIEW TOOLBAR :::: VIEWING ACTUAL PROPERTY DETAILS

                    case 'property':

                        //if($this->ipauth->canEditProp($this->property->id)){

                        //    $html .= JHtml::_('icon.edit',  $this->property, 'property', true);

                        //}

                        //if( $settings->show_print ){

                        //    $urlPrint = JRoute::_('&print=1');

                        //    $html   .= '<a href="' . $urlPrint . '" class="hasTip modal" title="'.JText::_( 'COM_IPROPERTY_PRINT' ).' :: '.JText::_( 'COM_IPROPERTY_PRINT_TIP' ).'" rel="{handler: \'iframe\', size: {x: 650, y: 750}}">'.JText::_( 'COM_IPROPERTY_PRINT' ).'</a>';

                        //}

                        //if( $settings->show_saveproperty ){

                        //    $html   .= '<a href="#" id="saveslidein">'.JText::_( 'COM_IPROPERTY_SAVE' ).'</a>';

                        //}

                        //if( $settings->show_mtgcalc ){

                        //    $html   .= '<a href="#" id="calcslidein">'.JText::_( 'COM_IPROPERTY_CALCULATE_MORTGAGE' ).'</a>';

                        //}

                        

                    break;



                    // CATEGORY TOOLBAR :::: ON CATEGORY LISTINGS DISPLAY

                    case 'allproperties':

                    case 'cat':

                    case 'companyproperties':

                    case 'agentproperties':

                    case 'openhouses':

                        if( $settings->rss ){

                            $document = JFactory::getDocument();

                            $link = '&format=feed&limitstart=';

                            $attribs = array('type' => 'application/rss+xml', 'title' => 'RSS 2.0');

                            $document->addHeadLink(JRoute::_($link.'&type=rss'), 'alternate', 'rel', $attribs);

                            $attribs = array('type' => 'application/atom+xml', 'title' => 'Atom 1.0');

                            $document->addHeadLink(JRoute::_($link.'&type=atom'), 'alternate', 'rel', $attribs);

                            $urlRss = JRoute::_($link.'&type=rss');

                            $html .= '<a href="'.$urlRss.'" class="hasTip" title="'.JText::_('RSS').' :: '.JText::_('COM_IPROPERTY_RSS_TIP').'" target="_blank">'.JText::_('RSS').'</a>';

                        }

                    break;

                }

            //$html .= ( $view != 'ipuser' && $settings->show_saveproperty ) ? '<a href="'.JRoute::_(ipropertyHelperRoute::getIpuserRoute()).'" class="hasTip" title="'.JText::_( 'COM_IPROPERTY_MY_FAVORITES' ).' :: '.JText::_( 'COM_IPROPERTY_MY_FAVORITES_TIP' ).'">'.JText::_( 'COM_IPROPERTY_MY_FAVORITES' ).'</a>' : '';

            $html .= ( $view != 'advsearch' && $settings->googlemap_enable ) ? '<a href="'.JRoute::_(ipropertyHelperRoute::getAdvsearchRoute()).'">'.JText::_( 'COM_IPROPERTY_SEARCH' ).'</a>' : '';

            $html .= '</div>';

            $html .= '<div class="ipclear"></div>';

        }

        return $html;

    }



    function snippet($text, $length = 200, $tail = "(...)")

    {

       $text = trim($text);

       $txtl = strlen($text);

       if($txtl > $length) {

           for($i = 1; $text[$length-$i] != " "; $i++) {

               if($i == $length) {

                   return substr($text, 0, $length) . $tail;

               }

           }

           $text = substr($text, 0, $length-$i+1) . $tail;

       }

       return $text;

    }



    function buildNoResults($wrapper = false)

    {

        $html = '';

        if( $wrapper ) $html .= '<table class="ptable">';

        $html .= '<tr>

                     <td colspan="2" align="center">

                        <div class="pe_noresults">

                            '.JHTML::_('image.site', 'iproperty1.png','/components/com_iproperty/assets/images/','','',JText::_( 'COM_IPROPERTY_NO_RECORDS' )).'

                            <br />

                            ' . JText::_( 'COM_IPROPERTY_NO_RECORDS_TEXT' ) . '

                        </div>

                    </td>

                 </tr>';

        if( $wrapper ) $html .= '</table>';



        return $html;

    }



    function buildThinkeryFooter()

    {

        $ipversion = ipropertyAdmin::_getversion();

        return '<div class="property_footer">'.JText::_( 'COM_IPROPERTY_PROPERTY_AGENT_FOOTER' ).' <a href="http://www.thethinkery.net" target="_blank">theThinkery.net</a>.  v'.$ipversion['iproperty'].'</div>';

    }



    function sentence_case($string)

    {

        $sentences = preg_split('/([.?!]+)/', $string, -1, PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE);

        $new_string = '';

        foreach ($sentences as $key => $sentence) {

            $new_string .= ($key & 1) == 0?

            ucfirst(strtolower(trim($sentence))) :

            $sentence.' ';

        }

        return trim($new_string);

    }



    function buildSortList($filter_order, $attrib = '', $listonly = false, $tag = false, $raw = false)

    {

        $settings = ipropertyAdmin::config();

        $munits   = (!$settings->measurement_units) ? JText::_( 'COM_IPROPERTY_SQFTDD' ) : JText::_( 'COM_IPROPERTY_SQMDD' );

        $sortbys = array();

        $sort_options = array();

        

        if($settings->showtitle){

            $sort_options['p.title'] = JText::_( 'COM_IPROPERTY_TITLE' );

        }else{

            $sort_options['p.street'] = JText::_( 'COM_IPROPERTY_STREET' );

        }

        $sort_options['p.beds'] = JText::_( 'COM_IPROPERTY_BEDS' );

        $sort_options['p.baths'] = JText::_( 'COM_IPROPERTY_BATHS' );

        $sort_options['p.sqft'] = $munits;

        $sort_options['p.price'] = JText::_( 'COM_IPROPERTY_PRICE' );

        $sort_options['p.created'] = JText::_( 'COM_IPROPERTY_LISTED_DATE' );

        $sort_options['p.modified'] = JText::_( 'COM_IPROPERTY_MODIFIED_DATE' );



        $tag = ($tag) ? $tag : 'filter_order';

        

        if($raw){

            return $sort_options;

        }else{       

            foreach($sort_options as $key => $value){

                $sortbys[] = JHTML::_('select.option', $key, $value );

            }

        }



        if($listonly){

            return $sortbys;

        }else{

            return JHTML::_('select.genericlist', $sortbys, $tag, $attrib, 'value', 'text', $filter_order );

        }

    }



    function buildAgentSortList($filter_order, $attrib = '', $listonly = false, $tag = false)

    {

        $sortbys = array();

        $sortbys[] = JHTML::_('select.option', 'a.ordering', JText::_( 'COM_IPROPERTY_SELECT' ) );

        $sortbys[] = JHTML::_('select.option', 'a.lname', JText::_( 'COM_IPROPERTY_LAST_NAME' ) );

        $sortbys[] = JHTML::_('select.option', 'a.fname', JText::_( 'COM_IPROPERTY_FIRST_NAME' ) );

        if(JRequest::getVar('view') == 'agents') $sortbys[] = JHTML::_('select.option', 'c.id', JText::_( 'COM_IPROPERTY_COMPANY' ) );



        $tag = ($tag) ? $tag : 'filter_order';



        if($listonly){

            return $sortbys;

        }else{

            return JHTML::_('select.genericlist', $sortbys, $tag, $attrib, 'value', 'text', $filter_order );

        }

    }



    function buildCompanySortList($filter_order, $attrib = '', $listonly = false, $tag = false)

    {

        $sortbys = array();

        $sortbys[] = JHTML::_('select.option', 'ordering', JText::_( 'COM_IPROPERTY_SELECT' ) );

        $sortbys[] = JHTML::_('select.option', 'name', JText::_( 'COM_IPROPERTY_NAME' ) );

        $sortbys[] = JHTML::_('select.option', 'city', JText::_( 'COM_IPROPERTY_CITY' ) );



        $tag = ($tag) ? $tag : 'filter_order';



        if($listonly){

            return $sortbys;

        }else{

            return JHTML::_('select.genericlist', $sortbys, $tag, $attrib, 'value', 'text', $filter_order );

        }

    }



    function buildOrderList($filter_order_dir, $attrib = '', $listonly = false, $tag = false)

    {

        $orderbys = array();

        $orderbys[] = JHTML::_('select.option', 'ASC', JText::_( 'COM_IPROPERTY_ASCENDING' ) );

        $orderbys[] = JHTML::_('select.option', 'DESC', JText::_( 'COM_IPROPERTY_DESCENDING' ) );



        $tag = ($tag) ? $tag : 'filter_order_dir';



        if($listonly){

            return $orderbys;

        }else{

            return JHTML::_('select.genericlist', $orderbys, $tag, $attrib, 'value', 'text', $filter_order_dir );

        }

    }



    function getCountryName($country)

    {

        $db = JFactory::getDbo();



        $query = $db->getQuery(true);

        $query->select('id, title')

            ->from('#__iproperty_countries')

            ->where('id = '.(int)$country);



        $db->setQuery($query, 0, 1);

        $result = $db->loadObject();



        return $result->title;

    }



    function getStateName($state)

    {

        $db = JFactory::getDbo();



        $query = $db->getQuery(true);

        $query->select('id, title')

            ->from('#__iproperty_states')

            ->where('id = '.(int)$state);



        $db->setQuery($query, 0, 1);

        $result = $db->loadObject();



        return $result->title;

    }



    function getStateCode($state)

    {

        $db = JFactory::getDbo();



        $query = $db->getQuery(true);

        $query->select('mc_name')

            ->from('#__iproperty_states')

            ->where('id = '.(int)$state);



        $db->setQuery($query, 0, 1);

        $result = $db->loadResult();



        return $result;

    }



    function getCompanyName($co, $alias = false)

    {

        $db = JFactory::getDbo();



        $query = $db->getQuery(true);

        $query->select('id, alias, name')

            ->from('#__iproperty_companies')

            ->where('id = '.(int)$co);



        $db->setQuery($query, 0, 1);

        $result = $db->loadObject();



        if($alias && $result->alias){

            return $result->alias;

        }else{

            return $result ? $result->name : '';

        }

    }



    function getCompanyEmail($co)

    {

        $db = JFactory::getDbo();



        $query = $db->getQuery(true);

        $query->select('email')

            ->from('#__iproperty_companies')

            ->where('id = '.(int)$co);



        $db->setQuery($query, 0, 1);

        $result = $db->loadResult();



        return $result;

    }



    function getAvailableCats( $id = null )

    {

        $db = JFactory::getDbo();



        $query = $db->getQuery(true);

        $query->select('cat_id')

            ->from('#__iproperty_propmid')

            ->where('amen_id = 0')

            ->where('prop_id = '.(int)$id);



        $db->setQuery($query);

        $result = $db->loadResultArray();



        return $result;

    }



    function getCatIcon($cat, $width = '', $admin = false, $text_only = false)

    {

        $db = JFactory::getDbo();

        $caticon = '';



        $query = $db->getQuery(true);

        $query->select('id, icon, title, alias')

            ->from('#__iproperty_categories')

            ->where('id = '.(int)$cat);



        $db->setQuery($query, 0, 1);



        if($result = $db->loadObject()){

            if($text_only){

                $caticon = $result->title;

            }else if(isset($result->icon) && $admin){

                $caticon = '<img src="'.JURI::root(true).'/media/com_iproperty/categories/'.$result->icon.'" alt="'.$result->title.'" width="'.$width.'" class="hasTip" title="'.$result->title.'" class="caticon" />';

            }else if(isset($result->icon) && $result->icon != "nopic.png"){

                $caticon = '<img src="'.JURI::root(true).'/media/com_iproperty/categories/'.$result->icon.'" alt="'.$result->title.'" width="'.$width.'" class="hasTip" title="'.$result->title.'" class="caticon" />';

            }else{

                $caticon = $result->title;

            }



            if(!$admin){

                $catlink = ipropertyHelperRoute::getCatRoute($result->id.':'.$result->alias);

                $caticon = '<a href="'.$catlink.'">'.$caticon.'</a>';

            }

        }

        return $caticon;

    }



    function getIconpath($icon, $type)

    {

        $folder = false;

        switch ($type) {

            case 'agent':

                $folder = 'media/com_iproperty/agents/';

                break;

            case 'company':

                $folder = 'media/com_iproperty/companies/';

                break;

        }

        if (!$folder) return false;



        $folderpath = (substr($icon, 0, 4) == 'http') ? '' : JURI::root().$folder;

        $iconpath   = $folderpath.$icon;



        return $iconpath;

    }

    

	function type_select_list($tag, $attrib = '', $sel = '', $show_available = false, $listonly = false)

    {

        $db         = JFactory::getDbo();

        $stypes     = array();

        $stypes[]   = JHTML::_('select.option', '', 'Type', "value", "text" );



        $query = $db->getQuery(true);

        $query->select('DISTINCT(s.id), s.id AS value, s.name AS text')

            ->from('#__iproperty_types as s');

        //if($show_available){

        //    $query->join('INNER','#__iproperty AS p ON p.stype = s.id');

        //}

        $query->order('s.name ASC');



        $db->setQuery($query);

        $result = $db->loadObjectList();



        foreach($result as $r){

            $stypes[] = JHTML::_('select.option', $r->value, JText::_($r->text), "value", "text" );

        }



        if($listonly){

            return $stypes;

        }else{

            return JHTML::_('select.genericlist', $stypes, $tag, $attrib, "value", "text", $sel );

        }

    }

    

    function stype_select_list($tag, $attrib = '', $sel = '', $show_available = false, $listonly = false)

    {

        $db         = JFactory::getDbo();

        $stypes     = array();

        $stypes[]   = JHTML::_('select.option', '', JText::_( 'COM_IPROPERTY_SALE_TYPE' ), "value", "text" );



        $query = $db->getQuery(true);

        $query->select('DISTINCT(s.id), s.id AS value, s.name AS text')

            ->from('#__iproperty_stypes as s')

            ->where('s.state = 1');

        if($show_available){

            $query->join('INNER','#__iproperty AS p ON p.stype = s.id');

        }

        $query->order('s.name ASC');



        $db->setQuery($query);

        $result = $db->loadObjectList();



        foreach($result as $r){

            $stypes[] = JHTML::_('select.option', $r->value, JText::_($r->text), "value", "text" );

        }



        if($listonly){

            return $stypes;

        }else{

            return JHTML::_('select.genericlist', $stypes, $tag, $attrib, "value", "text", $sel );

        }

    }



    function get_stype($stype)

    {

        $db = JFactory::getDbo();



        $query = $db->getQuery(true);

        $query->select('id, name')

            ->from('#__iproperty_stypes')

            ->where('id = '.(int)$stype);



        $db->setQuery($query, 0, 1);

        $result = $db->loadObject();



        return JText::_($result->name);

    }



    function get_stypes()

    {

        $db = JFactory::getDbo();



        $query = $db->getQuery(true);

        $query->select('id, name')

            ->from('#__iproperty_stypes');



        $db->setQuery($query);

        $result = $db->loadObjectList();



        $stypes = array();

        foreach ($result as $r){

            $stypes[$r->id] = $r->name;

        }

        return $stypes;

    }



    function beds_select_list($tag, $attrib = '', $sel = '', $listonly = false)

    {

        $settings = ipropertyAdmin::config();

        $lowbeds = $settings->adv_beds_low;

        $highbeds = $settings->adv_beds_high;



        $rooms = array();

        $rooms[] = JHTML::_('select.option', '', JText::_( 'COM_IPROPERTY_MIN_BEDS' ) );

        for($i = $lowbeds; $i <= $highbeds; $i++){

            $rooms[] = JHTML::_('select.option', $i, $i );

        }



        if($listonly){

            return $rooms;

        }else{

            return JHTML::_('select.genericlist', $rooms, $tag, $attrib, 'value', 'text', $sel );

        }

    }



    function baths_select_list($tag, $attrib = '', $sel = '', $fractions = 1, $listonly = false)

    {

        $settings   = ipropertyAdmin::config();

        $lowbaths   = $settings->adv_baths_low;

        $highbaths  = $settings->adv_baths_high;



        $rooms      = array();

        $rooms[]    = JHTML::_('select.option', '', JText::_( 'COM_IPROPERTY_MIN_BATHS' ) );

        for($i = $lowbaths; $i <= $highbaths; $i++){

            $rooms[] = JHTML::_('select.option', $i, $i );

            if($fractions == 1 && $i != $highbaths){

                $rooms[] = JHTML::_('select.option', $i.'.5', $i.'.5' );

                $rooms[] = JHTML::_('select.option', $i.'.75', $i.'.75' );

            }

        }



        if($listonly){

            return $rooms;

        }else{

            return JHTML::_('select.genericlist', $rooms, $tag, $attrib, 'value', 'text', $sel );

        }

    }



    function country_select_list($tag, $attrib, $sel = null, $show_available = false, $listonly = false)

    {

        $db             = JFactory::getDbo();

        $countries      = array();

        $countries[]    = JHTML::_('select.option', '', JText::_( 'COM_IPROPERTY_COUNTRY' ), "value", "text" );



        $query = $db->getQuery(true);

        $query->select('DISTINCT(c.id), c.id AS value, c.title AS text')

            ->from('#__iproperty_countries as c');

        if($show_available){

            $query->join('INNER','#__iproperty AS p ON p.country = c.id');

        }

        $query->order('c.title ASC');



        $db->setQuery($query);

        $result = $db->loadObjectList();



        foreach($result as $r){

            $countries[] = JHTML::_('select.option', $r->value, JText::_($r->text), "value", "text" );

        }



        if($listonly){

            return $countries;

        }else{

            return JHTML::_('select.genericlist', $countries, $tag, $attrib, "value", "text", $sel );

        }

    }



    function state_select_list($tag, $attrib, $sel = null, $show_available = false, $listonly = false)

    {

        $db         = JFactory::getDbo();

        $states     = array();

        $states[]   = JHTML::_('select.option', '', JText::_( 'COM_IPROPERTY_STATE' ), "value", "text" );



        $query = $db->getQuery(true);

        $query->select('DISTINCT(s.id), s.id AS value, s.title AS text')

            ->from('#__iproperty_states as s');

        if($show_available){

            $query->join('INNER','#__iproperty AS p ON p.locstate = s.id');

        }

        $query->order('s.title ASC');



        $db->setQuery($query);

        $result = $db->loadObjectList();



        foreach($result as $r){

            $states[] = JHTML::_('select.option', $r->value, JText::_($r->text), "value", "text" );

        }



        if($listonly){

            return $states;

        }else{

            return JHTML::_('select.genericlist', $states, $tag, $attrib, "value", "text", $sel );

        }

    }



    function city_select_list($tag, $attrib, $sel = null, $listonly = false, $state = false)

    {

        $db         = JFactory::getDbo();

        $cities     = array();

        $cities[]   = JHTML::_('select.option', '', JText::_( 'COM_IPROPERTY_CITY' ), "value", "text" );



        $query = $db->getQuery(true);

        $query->select('DISTINCT(city) AS value, city AS text')

            ->from('#__iproperty')

            ->where('state = 1')

            ->where('city != ""');

        if($state){

            $query->where('locstate = '.(int)$state);

        }

        $query->order('city ASC');



        $db->setQuery($query);

        $result = $db->loadObjectList();



        foreach($result as $r){

            $cities[] = JHTML::_('select.option', $r->value, JText::_($r->text), "value", "text" );

        }



        if($listonly){

            return $cities;

        }else{

            return JHTML::_('select.genericlist', $cities, $tag, $attrib, "value", "text", $sel );

        }

    }



    function region_select_list($tag, $attrib, $sel = null, $listonly = false)

    {

        $db         = JFactory::getDbo();

        $regions    = array();

        $regions[]  = JHTML::_('select.option', '', JText::_( 'COM_IPROPERTY_REGION' ), "value", "text" );



        $query = $db->getQuery(true);

        $query->select('DISTINCT(region) AS value, region AS text')

            ->from('#__iproperty')

            ->where('state = 1')

            ->where('region != ""')

            ->order('region ASC');



        $db->setQuery($query);

        $result = $db->loadObjectList();



        foreach($result as $r){

            $regions[] = JHTML::_('select.option', $r->value, JText::_($r->text), "value", "text" );

        }



        if($listonly){

            return $regions;

        }else{

            return JHTML::_('select.genericlist', $regions, $tag, $attrib, "value", "text", $sel );

        }

    }



    function county_select_list($tag, $attrib, $sel = null, $listonly = false)

    {

        $db         = JFactory::getDbo();

        $counties   = array();

        $counties[] = JHTML::_('select.option', '', JText::_( 'COM_IPROPERTY_COUNTY' ), "value", "text" );



        $query = $db->getQuery(true);

        $query->select('DISTINCT(county) AS value, county AS text')

            ->from('#__iproperty')

            ->where('state = 1')

            ->where('county != ""')

            ->order('county ASC');



        $db->setQuery($query);

        $result = $db->loadObjectList();



        foreach($result as $r){

            $counties[] = JHTML::_('select.option', $r->value, JText::_($r->text), "value", "text" );

        }



        if($listonly){

            return $counties;

        }else{

            return JHTML::_('select.genericlist', $counties, $tag, $attrib, "value", "text", $sel );

        }

    }



    function province_select_list($tag, $attrib, $sel = null, $listonly = false)

    {

        $db         = JFactory::getDbo();

        $provs      = array();

        $provs[]    = JHTML::_('select.option', '', JText::_( 'COM_IPROPERTY_PROVINCE' ), "value", "text" );



        $query = $db->getQuery(true);

        $query->select('DISTINCT(province) AS value, province AS text')

            ->from('#__iproperty')

            ->where('state = 1')

            ->where('province != ""')

            ->order('province ASC');



        $db->setQuery($query);

        $result = $db->loadObjectList();



        foreach($result as $r){

            $provs[] = JHTML::_('select.option', $r->value, JText::_($r->text), "value", "text" );

        }



        if($listonly){

            return $provs;

        }else{

            return JHTML::_('select.genericlist', $provs, $tag, $attrib, "value", "text", $sel );

        }

    }



    function currencySelectList( $tag, $attrib, $sel = 'USD', $listonly = false )

    {

        $db = JFactory::getDbo();



        $query = $db->getQuery(true);

        $query->select('DISTINCT(curr_abbreviation) AS value, CONCAT( TRIM(currency), " - ", curr_abbreviation ) AS text')

            ->from('#__iproperty_currency')

            ->order('currency ASC');



        $db->setQuery($query);

        $result = $db->loadObjectList();



        if($listonly){

            return $result;

        }else{

            return  JHTML::_('select.genericlist', $result, $tag, $attrib, "value", "text", $sel);

        }

    }



    function price_select_list($tag, $attrib, $sel = null, $listonly = false, $do_high = false, $increment = false)

    {

        $settings   = ipropertyAdmin::config();

        $high       = $settings->adv_price_high;

        $low        = $settings->adv_price_low;

        $steps      = $increment ? ($do_high ? ceil(($high - $low) / $increment) : floor(($high - $low) / $increment) ) : 10; // you can edit this to make more or fewer steps

        $increment  = $increment ? $increment : ($high - $low) / $steps;



        $i = 0;

        $t_price = $low;

        $temp_price = '';



        $prices = array();

        if ($do_high){

            $prices[] = JHTML::_('select.option', '', JText::_( 'COM_IPROPERTY_MAX_PRICE' ), "value", "text" );

        } else {

            $prices[] = JHTML::_('select.option', '', JText::_( 'COM_IPROPERTY_MIN_PRICE' ), "value", "text" );

        }



        while ($i <= $steps) {

            if ($i == 0 && $settings->adv_nolimit && !$do_high ) {

                $temp_value = '';

                $temp_price = ipropertyHTML::getFormattedPrice(0, '', true);

            } else if ($i == $steps && $settings->adv_nolimit && $do_high) {

                $temp_value = '';

                $temp_price = ipropertyHTML::getFormattedPrice($high, '', true) . '+';

            } else {

                $temp_value = $t_price;

                $temp_price = ipropertyHTML::getFormattedPrice($t_price, '', true);

            }

            $prices[]   =  JHTML::_('select.option', $temp_value, $temp_price, "value", "text" );

            $t_price    = $t_price + $increment;

            $i++;

        }



        if($listonly){

            return $prices;

        }else{

            return  JHTML::_('select.genericlist', $prices, $tag, $attrib, "value", "text", $sel);

        }

    }



    function checkbox( $name, $tag_attribs, $value, $text = '', $showtext = 0, $checked = null )

    {

        $t = ($showtext == '1') ? "&nbsp;".$text : '';

        $checked = ($checked == 1) ? " checked=\"checked\"" : '';

        return "<input type=\"checkbox\" name=\"".$name."\" ".$tag_attribs." value=\"".$value."\"".$checked." />".$t;

    }



    function agentSelectList($tag, $attrib, $selected = null, $listonly = false, $useauth = false )

    {

        $db         = JFactory::getDBO();

        $agents     = array();

        $agents[]   = JHTML::_('select.option', '', JText::_( 'COM_IPROPERTY_AGENT' ), "value", "text" );



        $query = $db->getQuery(true);

        $query->select('id AS value, CONCAT_WS(",", lname, fname) AS text')

            ->from('`#__iproperty_agents`')

            ->where('state = 1');

        if($useauth){

            $ipauth = new ipropertyHelperAuth();

            if (!$ipauth->getAdmin()) {

                switch ($ipauth->getAuthLevel()){

                    case 1: //company level

                        $query->where('company = '.(int)$ipauth->getUagentCid());

                    break;

                    case 2: //agent level

                        $query->where('company = '.(int)$ipauth->getUagentCid());

                        // if not a super agent, only show all company agents if its the multiselect list

                        if (!$ipauth->getSuper()) $query->where('id = '.(int)$ipauth->getUagentId());

                    break;

                }

            }

        }

        $query->order('lname ASC');



        $db->setQuery( $query );

        $agents = array_merge( $agents, $db->loadObjectList() );



        if( $selected ){

            $selected = explode(',',$selected);

        }



        if($listonly){

            return $agents;

        }else{

            return  JHTML::_('select.genericlist', $agents, $tag, $attrib, "value", "text", $selected);

        }

    }



    function multicatSelectList($tag, $attrib, $sel = null, $listonly = false)

    {

        $db         = JFactory::getDbo();

        $cats       = array();

        $cats[]     = JHTML::_('select.option', '', JText::_( 'COM_IPROPERTY_CATEGORY' ) ,"value","text");



        $cats   = array_merge($cats, ipropertyHTML::multisubcatSelect(0, ""));

        $sel    = explode(',', $sel);



        if($listonly){

            return $cats;

        }else{

            return  JHTML::_('select.genericlist', $cats, $tag, $attrib, "value", "text", $sel);

        }

    }



    function multisubcatSelect($parent, $prefix)

    {

        $db         = JFactory::getDbo();

        $options    = array();



        $query      = ipropertyHelperQuery::getCategories($parent);

        $db->setQuery($query);



        $result     = $db->loadObjectList();

        $total      = count($result);



        for($i = 0; $i < ($total-1); $i++){

            $options[]  = JHTML::_('select.option', $result[$i]->id,$prefix."- ".$result[$i]->title, "value", "text");

            $options    = array_merge($options, ipropertyHTML::multisubcatSelect($result[$i]->id, $prefix."- "));

        }



        if($total > 0){

            $options[]  = JHTML::_('select.option', $result[$total-1]->id, $prefix."- ".$result[$total-1]->title, "value", "text");

            $options    = array_merge($options, ipropertyHTML::multisubcatSelect($result[$total-1]->id, $prefix."- "));

        }



        return $options;

    }



    function getAgentName($agent_id, $alias = false)

    {

        $db = JFactory::getDbo();



        $query = $db->getQuery(true);

        $query->select('id, alias, fname, lname')

            ->from('#__iproperty_agents')

            ->where('id = '.(int)$agent_id);



        $db->setQuery($query, 0, 1);

        $result = $db->loadObject();

        

        if($alias && $result->alias){

            return $result->alias;

        }else{        

            return $result ? $result->fname.' '.$result->lname : '';

        }

    }



    function getAgentEmail($agent_id)

    {

        $db = JFactory::getDbo();



        $query = $db->getQuery(true);

        $query->select('email')

            ->from('#__iproperty_agents')

            ->where('id = '.(int)$agent_id);



        $db->setQuery($query, 0, 1);

        $result = $db->loadResult();

        return $result;

    }



    function amen_select_list( $tag, $attrib, $sel = null )

    {

        $db = JFactory::getDbo();



        $query = $db->getQuery(true);

        $query->select('id AS value, title AS text')

            ->from('#__iproperty_amenities');



        $db->setQuery($query);

        $amens = $db->loadObjectList();



        $sel = explode(',', $sel);

        return JHTML::_('select.genericlist', $amens, $tag, $attrib, "value", "text", $sel);

    }



    function companySelectList($tag, $attrib, $sel = null, $listonly = false, $useauth = false)

    {

        $db         = JFactory::getDbo();



        $companies = array();

        $companies[] = JHTML::_('select.option', '', JText::_( 'COM_IPROPERTY_COMPANY' ), "value", "text" );



        $query = $db->getQuery(true);

        $query->select('id AS value, name AS text')

            ->from('`#__iproperty_companies`')

            ->where('state = 1');

        if($useauth){

            $ipauth = new ipropertyHelperAuth();

            if (!$ipauth->getAdmin()) {

                switch ($ipauth->getAuthLevel()){

                    case 1: //company level

                    case 2: //agent level

                        $query->where('id = '.(int)$ipauth->getUagentCid());

                    break;

                }

            }

        }

        $query->order('name ASC');



        $db->setQuery( $query );

        $companies = array_merge( $companies, $db->loadObjectList() );



        if($listonly){

            return $companies;

        }else{

            return  JHTML::_('select.genericlist', $companies, $tag, $attrib, "value", "text", $sel);

        }

    }



    function amenCheckboxList( $tag, $attrib, $sel = array(), $cat = '' )

    {

        $db = JFactory::getDbo();



        $query = $db->getQuery(true);

        $query->select('id AS value, title AS text')

            ->from('#__iproperty_amenities');

        if($cat){

            $query->where('cat = '.(int)$cat);

        }

        $query->order('title ASC');



        $db->setQuery($query);

        $amen_array = $db->loadObjectList();



        return ipropertyHTML::checkBoxList($amen_array, $tag, $attrib, $sel);

    }



    function typesCheckboxList( $tag, $attrib, $sel = array() )

    {

        $db = JFactory::getDbo();



        $query = $db->getQuery(true);

        $query->select('id AS value, title AS text')

            ->from('#__iproperty_categories')

            ->where('state = 1')

            ->order('title ASC');



        $db->setQuery($query);

        $types_array = $db->loadObjectList();



        return ipropertyHTML::checkBoxList($types_array, $tag, $attrib, $sel);

    }



    function checkBoxList( &$arr, $tag_name, $tag_attribs, $selected = null, $key = 'value', $text = 'text' )

    {

       $html = "

       <table class=\"ptable\" id=\"checkBoxContainer\">

           \n\t<tr>";

           $colcount = 0;

           for ($i=0, $n=count( $arr ); $i < $n; $i++ ) {

              $k = $arr[$i]->$key;

              $t = $arr[$i]->$text;

              $id = @$arr[$i]->id;



              $extra = '';

              $extra .= $id ? " id=\"" . $arr[$i]->id . "\"" : '';

              if (is_array( $selected )) {

                 foreach ($selected as $obj) {

                    $k2 = $obj;

                    if ($k == $k2) {

                       $extra .= " checked=\"checked\" ";

                       break;

                    }

                 }

              } else {

                 $extra .= ($k == $selected ? " checked=\"checked\" " : '');

              }

              $html .= "\n\t<td valign='top' width='25%'><input type=\"checkbox\" name=\"$tag_name\" value=\"".$k."\"$extra $tag_attribs />&nbsp;&nbsp;" . $t . "</td>";



              $colcount++;

              if( $colcount == 4 ){

                $colcount = 0;

                $html .= "\n</tr>\n<tr>";

              }

           }

       $html .= "\n</tr>

       \n</table>";

       return $html;

    }



    function getAvailableAgents( $id = null, $order = 'lname ASC', $limit = 999999 )

    {

        $db = JFactory::getDbo();



        $query = $db->getQuery(true);

        $query->select('a.*, CONCAT(fname, " ", lname) AS agent_name, c.id AS companyid, c.name AS companyname, c.alias as co_alias')

            ->from('#__iproperty_agents AS a')

            ->leftJoin('#__iproperty_companies AS c ON c.id = a.company')

            ->leftJoin('#__iproperty_agentmid AS am ON am.agent_id = a.id')

            ->where('am.prop_id = '.(int)$id)

            ->where('a.state = 1')

            ->order($order);



        $db->setQuery($query, 0, $limit);

        $result = $db->loadObjectList();



        return $result;

    }



    function getPropertyAmens($id)

    {

        $db = JFactory::getDbo();



        $query = $db->getQuery(true);

        $query->select('a.*')

            ->from('#__iproperty_amenities AS a')

            ->leftJoin('#__iproperty_propmid AS pm ON pm.amen_id = a.id')

            ->where('pm.prop_id = '.(int)$id);



        $db->setQuery($query);

        $amens = $db->loadObjectList();



        return $amens;

    }



    function notifyAdmin($id )

    {

        $app  = JFactory::getApplication();



        $admin_from    = $app->getCfg('fromname');

        $admin_email   = $app->getCfg('mailfrom');



        $user          = JFactory::getUser();

        $userid        = $user->get('id');

        $username      = $user->get('name');

        $useremail     = $user->get('email');

        $settings      = ipropertyAdmin::config();

        //$uri           =JURI::getInstance();

        $property_path  = JURI::base().ipropertyHelperRoute::getPropertyRoute($id);

        $fulldate       = JHTML::_('date','now',JText::_('DATE_FORMAT_LC2'));



        $text = '<style>

                    body{ font-family: arial; font-size: 12px; }

                    .result{color: ' . $settings->accent_color . ';}

                    .footer{font-size: 10px; color: #999;}

                </style>';





        $where          = array();

        $where[]        = 'p.id = '.$id;

        $notification   = $app->getCfg('fromname') .' '. JText::_( 'COM_IPROPERTY_SAVED_PROPERTY_NOTIFICATION' );

        $property       = new IpropertyHelperProperty($this->_db);

        $property->setType('property');

        $property->setWhere( $where );

        $property       = $property->getProperty(0,1);

        $property       = $property[0];



        $property_full_address = $property->street_address.'<br />'

                                .$property->city.', '.ipropertyHTML::getstatename($property->locstate).$property->province.' '.$property->postcode.'<br />'

                                .ipropertyHTML::getcountryname($property->country);



        $text .= '<p>' . $username . ' (' . $useremail . ') '.JText::_( 'COM_IPROPERTY_SAVED_PROPERTY_NOTIFY_TEXT' ).'</p>';

        $text .= '---------------------------------------------------------<br />';

        $text .= JText::_( 'COM_IPROPERTY_USER' ).'<br />';

        $text .= '---------------------------------------------------------<br />';

        $text .= '<p><strong>'.JText::_( 'COM_IPROPERTY_USER_ID' ).':</strong> <span class="result">' . $userid . '</span><br />';

        $text .= '<strong>'.JText::_( 'COM_IPROPERTY_USER_NAME' ).':</strong> <span class="result">' . $username . '</span><br />';

        $text .= '<strong>'.JText::_( 'COM_IPROPERTY_USER_EMAIL' ).':</strong> <span class="result">' . $useremail . '</span><br /></p>';



        $text .= '---------------------------------------------------------<br />';

        $text .= JText::_( 'COM_IPROPERTY_PROPERTY' ).'<br />';

        $text .= '---------------------------------------------------------<br />';



        $text .= '<p><strong>'.JText::_( 'COM_IPROPERTY_PROP_ID' ).':</strong> <span class="result">' . $property->mls_id . '</span><br />';

        $text .= '<strong>'.JText::_( 'COM_IPROPERTY_ADDRESS' ).':</strong><br /><span class="result">' . $property_full_address . '</span><br />';

        $text .= '<strong>'.JText::_( 'COM_IPROPERTY_PRICE' ).':</strong> <span class="result">' . $property->formattedprice . '</span><br />';

        $text .= '</p>';



        $text .= '<p>' . JText::_( 'COM_IPROPERTY_FOLLOW_LINK' ) . ':<br />

                     <a href="' . $property_path . '">' . $property_path . '</a><br /><br />

                     <span class="footer">' . JText::_( 'COM_IPROPERTY_GENERATED_BY_INTELLECTUAL_PROPERTY' ) . ' ' . $fulldate . '.

                  </p>';





        if( $admin_email && $settings->notify_saveprop == 1 ){

            $mail = JFactory::getMailer();

            $mail->addRecipient( $admin_email );

            $mail->setSender( array( $admin_email, $admin_from ) );

            $mail->setSubject( $notification );

            $mail->setBody( $text );

            $mail->isHTML(true);

            $mail->Send();

        }

    }



    function isNew($created, $days = 7)

    {

        $stamp = strtotime("-$days days");

        $created = strtotime($created);

        $new = ( $created >= $stamp ) ? true : false;

        return $new;

    }



    function getThumbnail($prop_id, $link = '', $alt = '', $width = 200, $imgattributes = '', $linkattributes = '', $suffix = true, $tags = true, $rel_path = true)

    {

        $db             = JFactory::getDbo();

        $settings       = ipropertyAdmin::config();



        $query = $db->getQuery(true);

        $query->select('path, type, fname, remote')

            ->from('#__iproperty_images')

            ->where('propid = '.(int)$prop_id)

            ->where('( type = ".jpg" OR type = ".jpeg" OR type = ".gif" OR type = ".png")')

            ->where('title = ' . $db->Quote('property') )

            ->order('ordering ASC');



        $db->setQuery($query, 0, 1);

        $thumb         = $db->loadObject();

        $imgsuffix     = ($suffix) ? '_thumb' : '';

        

        $root_path     = ($rel_path) ? JURI::root(true) : substr(JURI::root(), 0, -1);



        //add appropriate path to thumbnail file

        if ( $thumb ) {

            $path      = ($thumb->remote == 1) ? $thumb->path : $root_path.$settings->imgpath;

            $thumbnail = ($thumb->remote == 1) ? $path.$thumb->fname.$thumb->type : $path.$thumb->fname.$imgsuffix.$thumb->type;

        } else { //no filename found - return nopic img

            $path      = $root_path.$settings->imgpath;

            $thumbnail = $path.'nopic.png';

        }



        if($tags){

            //create thumbnail image with link if applicable

            $thumbimg = '';

            if($link) $thumbimg .= '<a href="'.$link.'" '.$linkattributes.'>';

            $thumbimg .= '<img src="'.$thumbnail.'" alt="'.$alt.'" width="'.$width.'" '.$imgattributes.'/>';

            if($link) $thumbimg .= '</a>';

            return $thumbimg;

        } else {

            return $thumbnail;

        }

    }



    function getFormattedPrice($price='', $stype_freq='', $advsearch = false, $call = false, $price2 = false, $newline = false)

    {

        if($call == true){ //call for price flag

            $formattedprice = JText::_( 'COM_IPROPERTY_CALL_FOR_PRICE' );

        }else if($price != 0 || $advsearch == true){ //if valid price & not using advanced search

            $settings  = ipropertyAdmin::config();



            $nformat            = $settings->nformat;

            $currency_digits    = $settings->currency_digits;

            $currency           = $settings->currency;

            $currency_pos       = $settings->currency_pos;



            if($stype_freq == '') $currency_digits = 0;

            $before_curr    = ($currency_pos == 0) ? $currency : ''; //currency before price

            $after_curr     = ($currency_pos == 1) ? ' '.$currency : ''; //currency after price



            $payments       = ($stype_freq) ? '/'.$stype_freq : '';

            $format         = ($nformat == 1) ? number_format($price, $currency_digits) : number_format($price,  $currency_digits, ',', '.');

            $formattedprice = $before_curr.$format.$after_curr.$payments;



            if($price2 && $price2 != '0.00'){

                $p2format           = ($nformat == 1) ? number_format($price2, $currency_digits) : number_format($price2,  $currency_digits, ',', '.');

                $oldprice           = '<span class="ip_slashprice">'.$before_curr.$p2format.$after_curr.'</span>';

                $oldprice           .= ($newline) ? '<br />' : ' ';

                $formattedprice     = $oldprice.'<span class="ip_newprice">'.$formattedprice.'</span>';

            }

        }else{ //there was no price set

            $formattedprice = JText::_( 'COM_IPROPERTY_CALL_FOR_PRICE' );

        }

        return $formattedprice;

    }



    function displayBanners($stype = '', $new = '', $path = '', $settings = '', $updated = '')

    {

        if($settings->banner_display == 1){ //image banners

            $banner_display = '';

            if( $new == 1 && $settings->new_days ){

                $banner_display .= '

                    <div class="property_overview_bannerbotleft">

                        <img src="'.$path.'/components/com_iproperty/assets/images/banners/banner_new.png" alt="'.JText::_( 'COM_IPROPERTY_NEW' ).'" title="'.JText::_( 'COM_IPROPERTY_NEW' ).'" />

                    </div>';

            }else if( $updated == 1 && $settings->updated_days ){

                $banner_display .= '

                    <div class="property_overview_bannerbotleft">

                        <img src="'.$path.'/components/com_iproperty/assets/images/banners/banner_updated.png" alt="'.JText::_( 'COM_IPROPERTY_UPDATED' ).'" title="'.JText::_( 'COM_IPROPERTY_UPDATED' ).'" />

                    </div>';

            }

            // dynamic sale type banners v1.5.5

            $banner_display .= ipropertyHTML::displayStypeBanner($stype, 1, $path);

        }else if($settings->banner_display == 2){ //css banners

            $banner_display = '';

            if( $new == 1 && $settings->new_days ){

                $banner_display .= '

                    <div class="property_overview_bannercsstop bannernew">

                        '.JText::_( 'COM_IPROPERTY_NEW' ).'

                    </div>';

            }else if( $updated == 1 && $settings->updated_days ){

                $banner_display .= '

                    <div class="property_overview_bannercsstop bannerupdated">

                        '.JText::_( 'COM_IPROPERTY_UPDATED' ).'

                    </div>';

            }

            // dynamic sale type banners v1.5.5

            $banner_display .= ipropertyHTML::displayStypeBanner($stype, 2);

        }else{ //no banners

            $banner_display = '';

        }

        return $banner_display;

    }



    function displayStypeBanner($stype, $type, $path = null)

    {

        // load stype object from db

        jimport('joomla.filesystem.file');

        $db = JFactory::getDbo();



        $query = $db->getQuery(true);

        $query->select('*')

                ->from('#__iproperty_stypes')

                ->where('id = '.(int)$stype);



        $db->setQuery($query, 0, 1);

        $result = $db->loadObject();



        $stype_banner = '';

        if($result->show_banner && $result->state){

            // banner image

            if($type == 1 && $result->banner_image){

                $stype_banner = '<div class="property_overview_bannerright"><img src="'.$path.'/'.$result->banner_image.'" alt="'.JText::_($result->name).'" /></div>';

            }elseif($type == 2 && $result->banner_color){

                $stype_banner = '<div class="property_overview_bannercssbot" style="background: '.$result->banner_color.';">'.JText::_($result->name).'</div>';

            }

        }

        return $stype_banner;

    }



    function getStreetAddress($settings, $title = null, $street_num = null, $street = null, $street2 = null, $apt = null, $hide = null)

    {

        $street_address = '';

        if($settings->showtitle && $title){

            $street_address = $title;

        }else{

            if($hide){

                $street_address = JText::_( 'COM_IPROPERTY_ADDRESS_HIDDEN' );

            }else{

                if(!$settings->street_num_pos){ //street number before street

                    $street_address .= $street_num.' '.$street;

                    $street_address .= ($street2) ? ' '.$street2 : '';

                    $street_address .= ($apt) ? ' '.$apt : '';

                }else{ //street number after street

                    $street_address .= $street;

                    $street_address .= ($street2) ? ' '.$street2 : '';

                    $street_address .= ($street_num) ? ' '.$street_num : '';

                    $street_address .= ($apt) ? ' '.$apt : '';

                }

            }

        }

        return $street_address;

    }

    

	function getStreetAddress2($settings, $title = null, $street_num = null, $street = null, $street2 = null, $apt = null, $hide = null)

    {

        

            if($hide){

                $street_address = JText::_( 'COM_IPROPERTY_ADDRESS_HIDDEN' );

            }else{

                if(!$settings->street_num_pos){ //street number before street

                    $street_address .= $street_num.' '.$street;

                    $street_address .= ($street2) ? ' '.$street2 : '';

                    $street_address .= ($apt) ? ' '.$apt : '';

                }else{ //street number after street

                    $street_address .= $street;

                    $street_address .= ($street2) ? ' '.$street2 : '';

                    $street_address .= ($street_num) ? ' '.$street_num : '';

                    $street_address .= ($apt) ? ' '.$apt : '';

                }

            }

        

        return $street_address;

    }



    function getFullAddress($street = null, $city = null, $locstate = null, $province = null, $zip = null, $country = null)

    {

        $fulladdress = '';

        $fulladdress .= ($street) ? '<span>'.$street.'</span><br />' : '';

        $fulladdress .= ($city) ? $city : '';

        $fulladdress .= ($locstate) ? ', '.ipropertyHTML::getstatename($locstate) : '';

        $fulladdress .= ($province) ? ', '.$province : '';

        $fulladdress .= ($zip) ? ' '.$zip : '';

        $fulladdress .= ($country) ? '<br />'.ipropertyHTML::getcountryname($country) : '';

        return $fulladdress;

    }



    function getCatName($catid, $alias = false)

    {

        $db   = JFactory::getDbo();



        $query = $db->getQuery(true);

        $query->select('id, alias, title')

                ->from('#__iproperty_categories')

                ->where('id = '.(int)$catid);



        $db->setQuery($query, 0, 1);

        $result     = $db->loadObject();

        

        if($alias && $result->alias){

            return $result->alias;

        }else{        

            return $result ? $result->title : '';

        }

    }



    function getPropertyTitle($prop_id, $alias = false)

    {

        $db         = JFactory::getDbo();

        $settings   = ipropertyAdmin::config();



        $query = $db->getQuery(true);

        $query->select('id, alias, street_num, street, street2, title')

                ->from('#__iproperty')

                ->where('id = '.(int)$prop_id);



        $db->setQuery($query, 0, 1);



        if($p = $db->loadObject()){

            if($alias && $p->alias){

                $prop_title = $p->alias;

            }else{

                $prop_title = '';

                if($settings->showtitle && $p->title){

                    $prop_title = $p->title;

                }else{

                    if(!$settings->street_num_pos){ //street number before street

                        $prop_title = $p->street_num.' '.$p->street.' '.$p->street2;

                    }else{ //street number after street

                        $prop_title = $p->street.' '.$p->street2.' '.$p->street_num;

                    }

                }

            }

            return $prop_title;

        }else{

            return JText::_( 'COM_IPROPERTY_PROPERTY_NOT_FOUND' );

        }

    }



    function propertySelectList($tag, $attrib, $sel = null, $listonly = false, $useauth = false)

    {

        $db         = JFactory::getDbo();

        $user       = JFactory::getUser();

        $groups     = $user->getAuthorisedViewLevels();



        // Filter by start and end dates.

        $nullDate   = $db->Quote($db->getNullDate());

        $date       = JFactory::getDate();

        $nowDate    = $db->Quote($date->toSql());



        $properties = array();

        $properties[] = JHTML::_('select.option', '', JText::_( 'COM_IPROPERTY_PROPERTY' ), "value", "text" );



        $query = $db->getQuery(true);

        $query->select('id AS value, CONCAT(street_num, " ", street, ", ", city, " - ", mls_id) AS text')

            ->from('`#__iproperty`');

        if($useauth){

            $ipauth = new ipropertyHelperAuth();

            if (!$ipauth->getAdmin()) {

                switch ($ipauth->getAuthLevel()){

                    case 1: //company level

                        $query->where('listing_office = '.(int)$ipauth->getUagentCid());

                    break;

                    case 2: //agent level

                        $query->where('listing_office = '.(int)$ipauth->getUagentCid());

                        if (!$ipauth->getSuper()) $query->where('id IN ( SELECT prop_id FROM #__iproperty_agentmid WHERE agent_id = '.(int)$ipauth->getUagentId().' )');

                    break;

                }

            }

        }

        (is_array($groups) && !empty($groups)) ? $query->where('access IN ('.implode(",", $groups).')') : '';

        $query->where('state = 1')

            ->where('(publish_up = '.$nullDate.' OR publish_up <= '.$nowDate.')')

            ->where('(publish_down = '.$nullDate.' OR publish_down >= '.$nowDate.')')

            ->order('street_num, street ASC');



        $db->setQuery($query);

        $properties = array_merge( $properties, $db->loadObjectList() );



        if($listonly){

            return $properties;

        }else{

            return  JHTML::_('select.genericlist', $properties, $tag, $attrib, "value", "text", $sel);

        }

    }



    function getOpenHouses($prop_id)

    {

        $db     = JFactory::getDBO();



        // Filter by start and end dates.

        $nullDate   = $db->Quote($db->getNullDate());

        $date       = JFactory::getDate();

        $nowDate    = $db->Quote($date->toSql());



        $query = $db->getQuery(true);

        $query->select('id, name, openhouse_start AS startdate, openhouse_end AS enddate, comments AS comments')

                ->from('#__iproperty_openhouses')

                ->where('prop_id = '.(int)$prop_id)

                ->where('state = 1')

                ->where('openhouse_end >= '.$nowDate)

                ->order('openhouse_start DESC');



        $db->setQuery($query);

        return $db->loadObjectList();

    }



    #as of 1.6.1 used in advsearch

    function getCategories($parent = null, $order = 'ordering ASC')

    {

        $user = JFactory::getUser();

        $db = JFactory::getDbo();



        $groups = $user->getAuthorisedViewLevels();



        // Filter by start and end dates.

        $nullDate   = $db->Quote($db->getNullDate());

        $date       = JFactory::getDate();

        $nowDate    = $db->Quote($date->toSql());



        $query = $db->getQuery(true);

        $query->select('id AS value, title AS text, parent')

                ->from('#__iproperty_categories')

                ->where('(publish_up = '.$nullDate.' OR publish_up <= '.$nowDate.')')

                ->where('(publish_down = '.$nullDate.' OR publish_down >= '.$nowDate.')')

                ->where('state = 1');

        if(is_array($groups) && !empty($groups)){

            $query->where('access IN ('.implode(",", $groups).')');

        }

        if(is_numeric($parent)){

            $query->where('parent = '.(int)$parent);

        }

        $query->order($order);



        $db->setQuery($query);

        return $db->loadObjectList();

    }



    function getCategory($catid)

    {

        $user = JFactory::getUser();

        $db = JFactory::getDbo();



        $groups = $user->getAuthorisedViewLevels();



        // Filter by start and end dates.

        $nullDate   = $db->Quote($db->getNullDate());

        $date       = JFactory::getDate();

        $nowDate    = $db->Quote($date->toSql());



        $query = $db->getQuery(true);

        $query->select('id, alias')

                ->from('#__iproperty_categories')

                ->where('id = '.(int)$catid)

                ->where('(publish_up = '.$nullDate.' OR publish_up <= '.$nowDate.')')

                ->where('(publish_down = '.$nullDate.' OR publish_down >= '.$nowDate.')')

                ->where('state = 1');

        if(is_array($groups) && !empty($groups)){

            $query->where('access IN ('.implode(",", $groups).')');

        }



        $db->setQuery($query, 0, 1);

        if($result = $db->loadObject()){

            return $result;

        }else{

            return false;

        }

    }

    

    function doCatMap($document, $params, $properties)

    {

        $app  = JFactory::getApplication();

        $settings           = ipropertyAdmin::config();

        $map_house_icon     = '/components/com_iproperty/assets/images/map/icon56.png';

        $templatepath        = $app->getTemplate();

        $catcss             = (JFile::exists('templates'.DS.$templatepath.DS.'css'.DS.'catmap.css')) ? 'templates/'.$templatepath.'/css/catmap.css' : '/components/com_iproperty/assets/css/catmap.css';

        

        if(JFile::exists('templates'.DS.$templatepath.DS.'images'.DS.'iproperty'.DS.'map'.DS.'icon56.png')) $map_house_icon = '/templates/'.$templatepath.'/images/iproperty/map/icon56.png';

        $document->addStyleSheet(JURI::root(true).$catcss);

        $document->addScript('http://maps.google.com/maps/api/js?sensor=false');

        $document->addScript(JURI::root(true).'/components/com_iproperty/assets/js/ipGmapCat.js');



        $jsondata = json_encode($properties);



        $mapscript = "

        var langOptions = {

            tprop:'".addslashes(JText::_('COM_IPROPERTY_RESULTS'))."',

            price:'".addslashes(JText::_('COM_IPROPERTY_PRICE'))."',

            nolimit: '".addslashes(JText::_('COM_IPROPERTY_NO_LIMIT'))."',

            pid: '".addslashes(JText::_('COM_IPROPERTY_PROPERTY_ID'))."',

            street: '".addslashes(JText::_('COM_IPROPERTY_STREET'))."',

            beds: '".addslashes(JText::_('COM_IPROPERTY_BEDS'))."',

            baths: '".addslashes(JText::_('COM_IPROPERTY_BATHS'))."',

            sqft: '".addslashes($munits)."',

            preview: '".addslashes(JText::_('COM_IPROPERTY_PREVIEW'))."',

            more: '".addslashes(JText::_('COM_IPROPERTY_MORE' ))."',

            inputText: '".addslashes(JText::_('COM_IPROPERTY_INPUT_TIP'))."',

            noRecords: '".addslashes(JText::_('COM_IPROPERTY_NO_RECORDS_TEXT'))."',

            previous: '".addslashes(JText::_('COM_IPROPERTY_PREVIOUS'))."',

            next: '".addslashes(JText::_('COM_IPROPERTY_NEXT'))."',

            of: '".addslashes(JText::_('COM_IPROPERTY_OF'))."',

            searchopt: '".addslashes(JText::_('COM_IPROPERTY_SEARCH_OPTIONS'))."',

            savesearch: '".addslashes(JText::_('COM_IPROPERTY_SAVESEARCH'))."',

            clearsearch: '".addslashes(JText::_('COM_IPROPERTY_CLEARSEARCH'))."'

        };



        var mapOptions = {

            zoom: ".$params->get('adv_default_zoom', $settings->adv_default_zoom).",

            maxZoom: ".$params->get('max_zoom', $settings->max_zoom).",

            mapTypeId: google.maps.MapTypeId.".$params->get('adv_maptype', $settings->adv_maptype).",

            lat: '".$params->get('adv_default_lat', $settings->adv_default_lat)."',

            lng: '".$params->get('adv_default_long', $settings->adv_default_long)."'

        };





        window.addEvent((window.webkit) ? 'load' : 'domready', function(){

            var pw = new ipCatMap({

                ipbaseurl: '".JURI::root()."',

                currencyFormat: '".$params->get('nformat', $settings->nformat)."',

                currencySymbol: '".$params->get('currency', $settings->currency)."',

                currencyPos: '".$params->get('currency_pos', $settings->currency_pos)."',

                marker: '".$map_house_icon."',

                text: langOptions,

                map: mapOptions

            },".$jsondata.");

        });";



        $document->addScriptDeclaration($mapscript);

    }

    

    function isMobileRequest() 

    {

        // adapted from sh404sef

        // shmobile plugin by Yannick Gaultier

        // anything-digital.com



        // For now, if IPad, return false        

        $isIpad = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPad');

        if($isIpad) return false;

        

        $isMobile = null;

        $defaultRecords = array(

        array( 'start' => 0, 'stop' => 0, 'string' =>

            '/android|avantgo|blackberry|blazer|compal|elaine|fennec|hiptop|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile|o2|opera m(ob|in)i|palm( os)?|p(ixi|re)\/|plucker|pocket|psp|smartphone|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce; (iemobile|ppc)|xiino/i')

            ,array( 'start' => 0, 'stop' => 4, 'string' => 

            '/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i')

        );



        if( is_null( $isMobile)) 

        {

            jimport( 'joomla.environment.browser');



            $browser    = &JBrowser::getInstance();

            $isMobile   = $browser->get( '_mobile');

            $userAgent  = $browser->get('_lowerAgent');



            // detection code adapted from http://detectmobilebrowser.com/

            foreach( $defaultRecords as $record) 

            {

                $isMobile = $isMobile || (empty($record['stop']) ? preg_match( $record['string'], substr( $userAgent, $record['start'])) : preg_match( $record['string'], substr( $userAgent, $record['start'], $record['stop'])));

            }

        }



        return $isMobile;

    }

    

    function includeIpScripts($css = true, $js = false)

    {        

        $app        = JFactory::getApplication();

        $document   = JFactory::getDocument();

        $settings   = ipropertyAdmin::config();

        

        // check if IP css files exist in template css folder

        // if so, use template css instead of IP css

        $templatepath   = $app->getTemplate();

        $ipcss          = (JFile::exists('templates'.DS.$templatepath.DS.'css'.DS.'iproperty.css')) ? '/templates/'.$templatepath.'/css/iproperty.css' : '/components/com_iproperty/assets/css/iproperty.css';

        $ipadvcss       = (JFile::exists('templates'.DS.$templatepath.DS.'css'.DS.'advsearch.css')) ? '/templates/'.$templatepath.'/css/advsearch.css' : '/components/com_iproperty/assets/css/advsearch.css';        

        $accent         = $settings->accent;

        $secondary      = $settings->secondary_accent;



        if($css){

        	

            $document->addStyleSheet(JURI::root(true).$ipcss);

            if(JRequest::getVar('view') == 'advsearch'){

                $document->addStyleSheet(JURI::root(true).$ipadvcss);

            }

        }

        if($js){

            $document->addScript(JURI::root(true).'/components/com_iproperty/assets/js/ipcommon.js');

        }

        

        if(!defined('_IPMAINSCRIPTS'))

        {

            define('_IPMAINSCRIPTS', true);           

        //.property_thumb_holder{width: ".$settings->thumbwidth."px; height: ".round((( $settings->thumbwidth ) / 1.5 ), 0)."px;}

            $defaultstyle = "

            dl.tabs dt.open{border-bottom: 0px !important;}           

            .ip_agent_photo{width: ".$settings->agent_photo_width."px;}

            .ip_company_photo{width: ".$settings->company_photo_width."px;}

            

            .ip_imagetab,.ip_doctab,#map_canvas{width: ".$settings->tab_width."px; height: ".$settings->tab_height."px; overflow: hidden; background-color: ".$secondary.";}

            .adv_thumbnail{width: ".$settings->thumbwidth."px;}";

        

            if((!JFile::exists('templates'.DS.$templatepath.DS.'css'.DS.'iproperty.css') || $settings->force_accents))

            {
				
                $defaultstyle .= "

                .property_header,.ip_loginform_container,.ip_container,dl.tabs dt,dl.tabs dt.open,fieldset.ip_plg_favoritetools,.ip_mapright div{border-color: $accent !important;}

                .ip_favorites th,#ip_toolbar,dl.tabs dt,.ptable.bordered-table.zebra-striped th,.ip_sidecol_header,.ptable th{background-color:transparent !important;}               

                .property_footer a,dl.tabs dt.open a{color: $accent !important;}                

                div.current{border-top-color: $accent !important;}

                .iprow0,.ip_doctab,.ip_mapright div,.ip_sidecol_address,.ip_education tr,dl.tabs dt.open{background-color: $secondary !important;}

                dl.tabs dt a,.ptable.bordered-table.zebra-striped th,.ip_favorites th{color: $accent !important;}";                
				
            } 

            $document->addStyleDeclaration($defaultstyle);

        }

    }



    function getListingInfo($listing_office, $listing_agent, $created, $modified, $stype, $show_list_ag = true, $show_list_co = true, $show_created = true, $show_modified = true, $show_stype = true, $listing_info = false)

    {

        // Get listing info display

		$created 	= ($created && $created != '0000-00-00 00:00:00') ? JHTML::_('date', htmlspecialchars($created),JText::_('DATE_FORMAT_LC1'), $tzoffset) : false;

		$modified 	= ($modified && $modified != '0000-00-00 00:00:00') ? JHTML::_('date', htmlspecialchars($modified),JText::_('DATE_FORMAT_LC1'), $tzoffset) : false;

		$listing_info_basic = '';

		

        if ($listing_info) {

            $listing_info_basic .= JText::_( 'COM_IPROPERTY_LISTED_BY' ).' '.$listing_info;

			if( $show_created && $created ) $listing_info_basic .= ' '.JText::_( 'COM_IPROPERTY_ON' ).' '.$created;

			if( $stype && $show_stype ) $listing_info_basic .= ' ['.ipropertyHTML::get_stype($stype).']';

			if( $show_modified && $modified )	$listing_info_basic .= ' '.JText::_( 'COM_IPROPERTY_LAST_MODIFIED' ).' '.$modified;

        } elseif ($show_list_ag || $show_list_co) {

            $listed_by = '';

			$listed_by .= ($show_list_ag && $listing_agent) ? ipropertyHTML::getAgentName($listing_agent) : '';

			$listed_by .= ($show_list_ag && $show_list_co) ? ', ' : ''; 

			$listed_by .= ($show_list_co && $listing_office) ? ipropertyHTML::getCompanyName($listing_office).' ' : '';

	

			$listing_info_basic .= JText::_( 'COM_IPROPERTY_LISTED_BY' ).' '.$listed_by;

			if( $show_created && $created ) $listing_info_basic .= JText::_( 'COM_IPROPERTY_ON' ).' '.$created;

			if( $stype && $show_stype ) $listing_info_basic .= ' ['.ipropertyHTML::get_stype($stype).']';

			if( $show_modified && $modified )	$listing_info_basic .= ' '.JText::_( 'COM_IPROPERTY_LAST_MODIFIED' ).' '.$modified;

        } else {

			if( $show_created && $created ) $listing_info_basic .= ' '.JText::_( 'COM_IPROPERTY_ON' ).' '.$created;

            if( $stype && $show_stype ) $listing_info_basic .= ' ['.ipropertyHTML::get_stype($stype).']';

			if( $show_modified && $modified )	$listing_info_basic .= ' '.$modified;

        }

        return $listing_info_basic;

    }

    

}

