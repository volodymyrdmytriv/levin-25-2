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

class IpropertyModelHome extends JModel
{
	var $_featured  = null;
	var $_data      = null;
	var $_types     = null;
	
	function __construct()
	{
		parent::__construct();		
	}
	
	function getData()
	{
	    $app  = JFactory::getApplication();
        
		$settings =  ipropertyAdmin::config();
		$perpage  = $settings->perpage;
		
		if (empty($this->_data))
		{
			$array  = array();
            $parent = 0;           
            $user   = JFactory::getUser();
            $groups	= $user->getAuthorisedViewLevels();
            
            //Loop through categories
            $this->catinfoRec($array, $parent);

            foreach($array as $cat){
                $p = $cat->parent;
                $c = $cat->id;
                while(isset($array[$p])){
                    if(!isset($array[$p]->entriesR)){
                        $array[$p]->entriesR = 0;
                    }
                    if(!isset($array[$p]->children)){
                        $array[$p]->children=array();
                    }

                    $array[$p]->children[] = $c;
                    $c = $p;
                    $p = $array[$p]->parent;
                }
            }

            for($i = 0; $i < count($array); $i++){
                $cat = &$array[$i];
                
                if(isset($cat->children)){
                    $cat->children = array_unique($cat->children);
                }else{
                    $cat->children = array();
                }
                
                if(!isset($cat->entriesR)){
                    $cat->entriesR = 0;
                }
            }
            
            // Filter by start and end dates.
            $nullDate   = $this->_db->Quote($this->_db->getNullDate());
            $date       = JFactory::getDate();
            $nowDate    = $this->_db->Quote($date->toSql());

			$query = $this->_db->getQuery(true);
            $query->select('*')
                ->from('#__iproperty_categories')
                ->where('parent = '.(int)$parent)
                ->where('(publish_up = '.$nullDate.' OR publish_up <= '.$nowDate.')')
                ->where('(publish_down = '.$nullDate.' OR publish_down >= '.$nowDate.')')
                ->where('state = 1');
            if(is_array($groups) && !empty($groups)){
                $query->where('access IN ('.implode(",", $groups).')');
            }
            $query->order('ordering ASC');

            $this->_db->setQuery($query);
            $array[0]= new StdClass();
            $array[0]->children = $this->_db->loadResultArray();
            
            $this->_data = $array;
		}
		return $this->_data;
	}
	
	function getFeatured()
	{
	    $app  = JFactory::getApplication();
        
		$settings   =  ipropertyAdmin::config();
		$fperpage   = $settings->num_featured;
        $where      = array();
        $where[]    = 'p.featured = 1';
		
		$this->_featured = new ipropertyHelperproperty($this->_db);
		$this->_featured->setType('properties');
        $this->_featured->setWhere( $where );
		$this->_featured->setOrderBy('RAND()', '');
		$this->_featured = $this->_featured->getProperty(0,$fperpage);
		
		return $this->_featured;
	}

    function catinfoRec(&$array,$parent){
		$query = $this->getCategories($parent);
		$this->_db->setQuery($query);
    	$cats = $this->_db->loadObjectList("id");

        foreach($cats as $cat){
			$cat->id            = $cat->id."";
            $cat->entries       = ipropertyHelperProperty::countObjects($cat->id);
			$cat->entriesR      = 0;
			$cat->children      = array();
			$array[$cat->id]    = $cat;
			$this->catinfoRec($array, $cat->id);
		}
	}

    function getCategories($parent="")
    {
		$user   = JFactory::getUser();
        $groups	= $user->getAuthorisedViewLevels();
        
        // Filter by start and end dates.
        $nullDate   = $this->_db->Quote($this->_db->getNullDate());
        $date       = JFactory::getDate();
        $nowDate    = $this->_db->Quote($date->toSql());
        
        $query = $this->_db->getQuery(true);
        $query->select('*')
            ->from('#__iproperty_categories')
            ->where('parent = '.(int)$parent)
            ->where('(publish_up = '.$nullDate.' OR publish_up <= '.$nowDate.')')
            ->where('(publish_down = '.$nullDate.' OR publish_down >= '.$nowDate.')')
            ->where('state = 1');
        if(is_array($groups) && !empty($groups)){
            $query->where('access IN ('.implode(",", $groups).')');
        }
        $query->order('ordering ASC');

		return  $query;
	}
}

?>