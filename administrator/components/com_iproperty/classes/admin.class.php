<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

class ipropertyAdmin {

    function _getversion()
    {
        $versions = array();
        jimport( 'joomla.utilities.simplexml' );

        $ipropfile  = JPATH_COMPONENT_ADMINISTRATOR.DS.'iproperty.xml';
        $iportfile  = JPATH_COMPONENT_ADMINISTRATOR.DS.'iportal.xml';
        $ipresfile  = JPATH_COMPONENT_ADMINISTRATOR.DS.'ipreserve.xml';
        $irepofile  = JPATH_COMPONENT_ADMINISTRATOR.DS.'ireport.xml';
        $versions['iproperty']  = false;
        $versions['iportal']    = false;
        $versions['ipreserve']  = false;
        $versions['ireport']    = false;
        //$xmlDoc = new JSimpleXML();        

        if (file_exists($ipropfile)) {
            $xmlDoc = new JSimpleXML();
            $xmlDoc->loadFile($ipropfile);
            $versions['iproperty'] = $xmlDoc->document->version[0]->_data;
        }

        if (file_exists($iportfile)) {
            $xmlDoc = new JSimpleXML();
            $xmlDoc->loadFile($iportfile);
            $versions['iportal'] = $xmlDoc->document->version[0]->_data;
        }

        if (file_exists($ipresfile)) {
            $xmlDoc = new JSimpleXML();
            $xmlDoc->loadFile($ipresfile);
            $versions['ipreserve'] = $xmlDoc->document->version[0]->_data;
        }

        if (file_exists($irepofile)) {
            $xmlDoc = new JSimpleXML();
            $xmlDoc->loadFile($irepofile);
            $versions['ireport'] = $xmlDoc->document->version[0]->_data;
        }

        return $versions;
    }

    function footer( )
    {
        $versions = ipropertyAdmin::_getversion();

        if($versions['iproperty']){
            echo '<span style="color: #377391;">Intellectual Property v.'.$versions['iproperty'].'</span>';
        }

        if($versions['iportal']){
            echo ' | <span style="color: #bf4410;">IPortal v.'.$versions['iportal'].'</span>';
        }

        if($versions['ipreserve']){
            echo ' | <span style="color: #66A736;">IReservations v.'.$versions['ipreserve'].'</span>';
        }

        if($versions['ireport']){
            echo ' | <span style="color: #72597C;">IReport v.'.$versions['ireport'].'</span>';
        }
        echo '<br /><a href="http://www.thethinkery.net" target="_blank">By The Thinkery LLC</a>';
    }

    function config($globals = true)
    {
        if($globals == true){
            global $ipsettings;
            if (!$ipsettings){
                $db     = JFactory::getDBO();
                $query	= $db->getQuery(true);

                $query->select('*');
                $query->from('#__iproperty_settings');
                $query->where('id = 1');

                $db->setQuery($query);
                $ipsettings = $db->loadObject();

                $GLOBALS['ipsettings'] = $ipsettings;
            }
            return $ipsettings;
        }else{
            $db     = JFactory::getDBO();
            $query	= $db->getQuery(true);

            $query->select('*');
            $query->from('#__iproperty_settings');
            $query->where('id = 1');

            $db->setQuery($query);
            $config = $db->loadObject();
            return $config;
        }
    }

    function buildAdminToolbar()
    {
        $user = JFactory::getUser();
        $settings = ipropertyAdmin::config();

        JPluginHelper::importPlugin( 'iproperty' );
        $dispatcher = JDispatcher::getInstance();

        $portalinstall = JPATH_COMPONENT_ADMINISTRATOR.DS.'iportal.xml';
        $preserveinstall = JPATH_COMPONENT_ADMINISTRATOR.DS.'ipreserve.xml';

        echo JHTML::_('image', 'administrator/components/com_iproperty/assets/images/iproperty_admin_logo.gif', 'Intellectual Property :: By The Thinkery' );
        ipropertyAdmin::quickiconButton('index.php?option=com_iproperty&amp;view=categories', JText::_( 'COM_IPROPERTY_CATEGORIES' ), 'ip_cpanel_cat');
        ipropertyAdmin::quickiconButton('index.php?option=com_iproperty&amp;view=properties', JText::_( 'COM_IPROPERTY_PROPERTIES' ), 'ip_cpanel_prop');
        ipropertyAdmin::quickiconButton('index.php?option=com_iproperty&amp;view=agents', JText::_( 'COM_IPROPERTY_AGENTS' ), 'ip_cpanel_agent');
        ipropertyAdmin::quickiconButton('index.php?option=com_iproperty&amp;view=companies', JText::_( 'COM_IPROPERTY_COMPANIES' ), 'ip_cpanel_company');
        ipropertyAdmin::quickiconButton('index.php?option=com_iproperty&amp;view=amenities', JText::_( 'COM_IPROPERTY_AMENITIES' ), 'ip_cpanel_amenity');
        ipropertyAdmin::quickiconButton('index.php?option=com_iproperty&amp;view=openhouses', JText::_( 'COM_IPROPERTY_OPENHOUSES' ), 'ip_cpanel_openhouse');
        if(file_exists($portalinstall) && $user->authorise('core.admin')) ipropertyAdmin::quickiconButton('index.php?option=com_iproperty&amp;view=plans', JText::_( 'COM_IPROPERTY_PORTAL' ), 'ip_cpanel_portal');
        if(file_exists($preserveinstall) && $user->authorise('core.admin')) ipropertyAdmin::quickiconButton('index.php?option=com_iproperty&amp;view=resreservations', JText::_( 'COM_IPROPERTY_RESERVATIONS' ), 'ip_cpanel_reservation');
        ipropertyAdmin::quickiconButton('index.php?option=com_iproperty&amp;view=settings', JText::_( 'COM_IPROPERTY_SETTINGS' ), 'ip_cpanel_setting');
        if($user->authorise('core.admin')){
            ipropertyAdmin::quickiconButton('index.php?option=com_iproperty&amp;view=backup', JText::_( 'COM_IPROPERTY_BACKUP' ), 'ip_cpanel_backup');
            ipropertyAdmin::quickiconButton('index.php?option=com_iproperty&amp;view=restore', JText::_( 'COM_IPROPERTY_RESTORE' ), 'ip_cpanel_restore');
            ipropertyAdmin::quickiconButton('index.php?option=com_iproperty&amp;view=bulkimport', JText::_( 'COM_IPROPERTY_BULKIMPORT_FILE' ), 'ip_cpanel_import');
        }
        $dispatcher->trigger( 'onAfterRenderAdmin', array( &$user, &$settings ) );
    }

    function quickiconButton( $link, $text, $buttonclass = '' )
    {
        $button = '';
        $button .= '
        <div class="ip_cpanel_button '.$buttonclass.'">
            <span><a href="'.$link.'">'.$text.'</a></span>
        </div>';
        echo $button;
    }
}

?>
