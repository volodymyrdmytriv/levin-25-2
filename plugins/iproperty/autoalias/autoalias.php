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

class plgIpropertyAutoAlias extends JPlugin
{
	function plgIpropertyAutoAlias(&$subject, $config)  
    {
		parent::__construct($subject, $config);
        if(JRequest::getVar('iptask') == 'autoalias'){
            $section = JRequest::getVar('section');
            $this->_createAlias($section);
        }
	}

    function onAfterRenderTools($user, $settings)
	{
        $app = JFactory::getApplication();
		if($app->getName() != 'administrator') return true;

        echo '
            <div style="float: left;">
                <div class="icon">
                    <a href="index.php?option=com_iproperty&iptask=autoalias&section=cat">
                        '.JHTML::_('image', 'administrator/components/com_iproperty/assets/images/iproperty_categories.png', 'Alias' ).'
                        <span>Cat Aliases</span>
                    </a>
                </div>
            </div>
            <div style="float: left;">
                <div class="icon">
                    <a href="index.php?option=com_iproperty&iptask=autoalias&section=prop">
                        '.JHTML::_('image', 'administrator/components/com_iproperty/assets/images/iproperty_properties.png', 'Alias' ).'
                        <span>Prop Aliases</span>
                    </a>
                </div>
            </div>
            <div style="float: left;">
                <div class="icon">
                    <a href="index.php?option=com_iproperty&iptask=autoalias&section=agent">
                        '.JHTML::_('image', 'administrator/components/com_iproperty/assets/images/iproperty_agents.png', 'Alias' ).'
                        <span>Agent Aliases</span>
                    </a>
                </div>
            </div>
            <div style="float: left;">
                <div class="icon">
                    <a href="index.php?option=com_iproperty&iptask=autoalias&section=company">
                        '.JHTML::_('image', 'administrator/components/com_iproperty/assets/images/iproperty_company.png', 'Alias' ).'
                        <span>Company Aliases</span>
                    </a>
                </div>
            </div>';
		return true;
	}

    function _createAlias($section)
    {
        $app = JFactory::getApplication();
        $db = JFactory::getDbo();
        $alias = '';
        
        switch($section){
            case 'cat':
                $query = $db->getQuery(true);
                $query->select('id, title');
                $query->from('#__iproperty_categories');
                $query->where('alias = ""');
                
                $db->setQuery($query);
                $result = $db->loadObjectList();
                
                if(count($result)){                    
                    foreach($result as $r){
                        try
                        {
                            $alias = JApplication::stringURLSafe($r->title.' '.$r->id);
                            //update db with clean alias here
                            $query = $db->getQuery(true);
                            $query->update('#__iproperty_categories')->set('alias = '.$db->Quote($alias));
                            $query->where('id = '.(int)$r->id);
                            $db->setQuery($query);
                            if (!$db->query()) {
                                throw new Exception($db->getErrorMsg());
                            }
                        }
                        catch (Exception $e)
                        {
                            $this->setError($e->getMessage());
                            return false;
                        }
                    }                    
                } else {
                    $app->redirect('index.php?option=com_iproperty', 'No empty aliases found', 'notice');
                }                    
                break;
            case 'prop':
                $query = $db->getQuery(true);
                $query->select('id, title, street_num, street, street2, city');
                $query->from('#__iproperty');
                $query->where('alias = ""');
                
                $db->setQuery($query);
                $result = $db->loadObjectList();
                
                if(count($result)){                    
                    foreach($result as $r){
                        try
                        {
                            $ptitle     = ($r->title) ? $r->title : $r->street_num.' '.$r->street.' '.$r->street2;
                            $alias      = JApplication::stringURLSafe($ptitle.' '.$r->city.' '.$r->id);
                            //update db with clean alias here
                            $query = $db->getQuery(true);
                            $query->update('#__iproperty')->set('alias = '.$db->Quote($alias));
                            $query->where('id = '.(int)$r->id);
                            $db->setQuery($query);
                            if (!$db->query()) {
                                throw new Exception($db->getErrorMsg());
                            }
                        }
                        catch (Exception $e)
                        {
                            $this->setError($e->getMessage());
                            return false;
                        }
                    }                    
                } else {
                    $app->redirect('index.php?option=com_iproperty', 'No empty aliases found', 'notice');
                }                    
                break;
            case 'agent':
                $query = $db->getQuery(true);
                $query->select('id, fname, lname');
                $query->from('#__iproperty_agents');
                $query->where('alias = ""');
                
                $db->setQuery($query);
                $result = $db->loadObjectList();
                
                if(count($result)){                    
                    foreach($result as $r){
                        try
                        {
                            $alias      = JApplication::stringURLSafe($r->fname.' '.$r->lname.' '.$r->id);
                            //update db with clean alias here
                            $query = $db->getQuery(true);
                            $query->update('#__iproperty_agents')->set('alias = '.$db->Quote($alias));
                            $query->where('id = '.(int)$r->id);
                            $db->setQuery($query);
                            if (!$db->query()) {
                                throw new Exception($db->getErrorMsg());
                            }
                        }
                        catch (Exception $e)
                        {
                            $this->setError($e->getMessage());
                            return false;
                        }
                    }                    
                } else {
                    $app->redirect('index.php?option=com_iproperty', 'No empty aliases found', 'notice');
                }                    
                break;
            case 'company':
                $query = $db->getQuery(true);
                $query->select('id, name');
                $query->from('#__iproperty_companies');
                $query->where('alias = ""');
                
                $db->setQuery($query);
                $result = $db->loadObjectList();
                
                if(count($result)){                    
                    foreach($result as $r){
                        try
                        {
                            $alias      = JApplication::stringURLSafe($r->name.' '.$r->id);
                            //update db with clean alias here
                            $query = $db->getQuery(true);
                            $query->update('#__iproperty_companies')->set('alias = '.$db->Quote($alias));
                            $query->where('id = '.(int)$r->id);
                            $db->setQuery($query);
                            if (!$db->query()) {
                                throw new Exception($db->getErrorMsg());
                            }
                        }
                        catch (Exception $e)
                        {
                            $this->setError($e->getMessage());
                            return false;
                        }
                    }                    
                } else {
                    $app->redirect('index.php?option=com_iproperty', 'No empty aliases found', 'notice');
                }                    
                break;
        }                
            
        $app->redirect('index.php?option=com_iproperty', 'New Aliases created successfully!');
    }
}
