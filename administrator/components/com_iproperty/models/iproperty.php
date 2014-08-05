<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.model');

class IpropertyModelIproperty extends JModel
{
    function getFprops()
    {
        return $this->getProperties('featured');
    }
    
    function getTprops()
    {
        return $this->getProperties('popular', 'p.hits', 'DESC');
    }    
    
    function getProperties($type, $sort = 'p.id', $order = 'ASC', $limit = 15)
	{
		$where = '';
        switch($type){
            case 'popular':
                $where = ' AND p.hits != 0';
                break;
            case 'featured':
                $where = ' AND p.featured = 1';
                break;
            default:
                //nothing
                break;
        }
        
        $query = "SELECT p.id, p.street, p.street2, p.street_num, p.title, p.hits, p.listing_office,"
                ." (SELECT COUNT(s.id) FROM #__iproperty_saved AS s WHERE s.prop_id = p.id) AS saved"
                ." FROM #__iproperty AS p"
                ." WHERE p.state = 1"
                .$where
                ." AND (p.publish_up = '0000-00-00 00:00:00' OR p.publish_up <= NOW())"
			    ." AND (p.publish_down = '0000-00-00 00:00:00' OR p.publish_down >= NOW())"
                ." ORDER BY $sort $order LIMIT 0,15";
        $this->_db->setQuery($query);
        return $this->_db->loadObjectList();
	}

    function getAusers()
    {
        $query = "SELECT u.id, u.name, u.username, u.email, u.registerDate,"
                ." (SELECT COUNT(s.id) FROM #__iproperty_saved AS s WHERE s.user_id = u.id AND s.active = 1) AS active_saves,"
                ." (SELECT COUNT(s.id) FROM #__iproperty_saved AS s WHERE s.user_id = u.id AND s.active = 0) AS inactive_saves"
                ." FROM #__users AS u, #__iproperty_saved AS s"
                ." WHERE u.block = 0 AND s.user_id = u.id"
                ." GROUP BY u.id"
                ." ORDER BY s.active DESC LIMIT 0,15";
        $this->_db->setQuery($query);
        return $this->_db->loadObjectList();
    }
}//Class end
?>