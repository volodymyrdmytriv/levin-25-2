<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.view');

class IpropertyViewManage extends JView
{    
    public function display($tpl = null)
    {
        $user           = JFactory::getUser();
        $app            = JFactory::getApplication();
        $document       = JFactory::getDocument();
        $db             = JFactory::getDBO();
        $menus          = $app->getMenu();
        $pathway        = $app->getPathway();
        
        JPluginHelper::importPlugin( 'iproperty' );
        $this->dispatcher = JDispatcher::getInstance();

        $properties     = null;
        $agent          = null;
        $agents         = null;

        $ipauth                 = new ipropertyHelperAuth();
        $agentid                = $ipauth->getUagentId();
        $agentcid               = $ipauth->getUagentCid();
        $settings               = ipropertyAdmin::config();
        $this->params           = $app->getParams();
        $this->ipbaseurl        = JURI::root(true);

        // if not admin, check for agent profile. If not found, kick them out
        if( !$user->get('id') ){
            $this->_displayLogin();
            return;
        }else if(!$ipauth->getAdmin()){
            if (!$ipauth->getAuthLevel() || !$agent = IpropertyHelperQuery::buildAgent($agentid)){
                $this->_displayNoAccess();
                return;
            }
        }

        // get properties and agents lists
        $pwhere         = array();
        $awhere         = array();
        $cwhere         = '';

        if (!$ipauth->getAdmin()){
            switch($ipauth->getAuthLevel()){
                case 1: //company
                    $awhere[] = 'a.company = '.$agentcid;
                    if(!$ipauth->getSuper()) $awhere[] = 'a.id = '.$agentid;
                    $pwhere[] = 'p.listing_office = '.$agentcid;
                    $cwhere = 'c.id = '.(int) $ipauth->getUagentCid();
                break;
                case 2: //agent
                    $awhere[] = 'a.company = '.$agentcid;
                    if(!$ipauth->getSuper()) $awhere[] = 'a.id = '.$agentid;

                    $pwhere[] = 'p.listing_office = '.$agentcid;
                    if(!$ipauth->getSuper()) $pwhere[] = 'am.agent_id = '.$agentid;
                    $cwhere = 'c.id = '.(int) $ipauth->getUagentCid();
                break;
            }
        }
        
        // get properties list
        $properties = new ipropertyHelperProperty($db);
        $properties->setType('ipuser');
        $properties->setWhere( $pwhere );
        $properties = $properties->getProperty();

        // get agents list
        $agents = new ipropertyHelperagent($db);
        $agents->setType('ipuser');
        $agents->setWhere( $awhere );
        $agents = $agents->getAgent();
        
        // get companies list
        if($ipauth->getSuper() || $ipauth->getAdmin() || $ipauth->getAuthLevel() == 3){
            $query = $db->getQuery(true);
            $query->select('c.id, c.name, c.state, c.featured, c.icon, c.alias');
            $query->from('#__iproperty_companies AS c');
            if($cwhere) $query->where($cwhere);
            $query->order('c.ordering, c.name ASC');
            $query->group('c.id');
            $db->setQuery($query);
            $companies = $db->loadObjectList();
        }else{ // basic agents do not have the option to view/edit company info
            $companies = '';
        }

        $this->assignRef('agent', $agent);
        $this->assignRef('properties', $properties);
        $this->assignRef('agents', $agents);
        $this->assignRef('companies', $companies);
        $this->assignRef('ipauth', $ipauth);
        $this->assignRef('app', $app);
        $this->assignRef('settings', $settings);

        $this->_prepareDocument();
        parent::display($tpl);
    }

    protected function _prepareDocument() 
    {
        $app            = JFactory::getApplication();
        $document       = JFactory::getDocument();
        $menus          = $app->getMenu();
        $pathway        = $app->getPathway();
        $this->params   = $app->getParams();
        $title          = null;

        $menu = $menus->getActive();
        $this->params->def('page_heading', JText::_( 'COM_IPROPERTY_AGENT_MANAGE' ));

        $title = JText::_( 'COM_IPROPERTY_AGENT_MANAGE' );
        $this->iptitle = $title;
        $this->document->setTitle($title);

        // Set meta data according to menu params
        if ($this->params->get('menu-meta_description')) $this->document->setDescription($this->params->get('menu-meta_description'));
        if ($this->params->get('menu-meta_keywords')) $this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
        if ($this->params->get('robots')) $this->document->setMetadata('robots', $this->params->get('robots'));

        $jscript     = "\n\n";
        $jscript    .="window.addEvent('domready',function() {
          $$('a.alter').each(function(el) {
            el.addEvent('click',function(e) {
              e.stop();
              var parent    = el.getParent('tr');
              var type;
              var action;
              var tick;
              var tickimage = '".JHTML::_('image.site', 'tick.png','/components/com_iproperty/assets/images/','','')."';
              var ximage    = '".JHTML::_('image.site', 'publish_x.png','/components/com_iproperty/assets/images/','','')."';

              if (el.hasClass('tick')){
                tick = true;
              } else {
                tick = false;
              }

              if (el.hasClass('agent')){
                type = 'agent';
              } else if(el.hasClass('company')){
                type = 'company';
              } else if(el.hasClass('property')){
                type = 'property';
              }

              if (el.hasClass('publish')){
                action = tick ? 'unpublish' : 'publish';
              } else if(el.hasClass('feature')){
                action = tick ? 'unfeature' : 'feature';
              } else if(el.hasClass('approve')){
                action = tick ? 'unapprove' : 'approve';
              }

              var request = new Request.JSON({
                url: 'index.php?option=com_iproperty&task=ajax.alterObject',
                link: 'ignore',
                method: 'post',
                data: {
                    '".JUtility::getToken()."': '1',
                    'format': 'raw',
                    'id': parent.get('id').replace(type,''),
                    'type': type,
                    'action': action
                },
                onSuccess: function(response) {
                  if(response == true){
                      if (tick){
                        el.set('html', ximage);
                        el.removeClass('tick');
                      } else {
                        el.set('html', tickimage);
                        el.addClass('tick');
                      }
                  }else{
                      $('system-message-container').set('html', '<div class=\"ip_warning\">'+response+'</div>');
                  }
                },
                onFailure: function() {
                  $('system-message-container').set('html', '<div class=\"ip_warning\">".addslashes(JText::_( 'COM_IPROPERTY_IPUSER_FAIL' ))."</div>');
                }
              }).send();
            });
          });

        $$('a.delete').each(function(el) {
            el.addEvent('click',function(e) {
              e.stop();
              var parent = el.getParent('tr');
              if (el.hasClass('agent')){
                type = 'agent';
              } else if(el.hasClass('company')){
                type = 'company';
              } else if(el.hasClass('property')){
                type = 'property';
              }
            var confdelete = confirm('".JText::_( 'COM_IPROPERTY_CONFIRM_DELETE' )."');
            if (confdelete == true){
              var request = new Request.JSON({
                url: 'index.php?option=com_iproperty&task=ajax.alterObject',
                link: 'chain',
                method: 'post',
                    data: { 
                        '".JUtility::getToken()."':'1',
                        'format': 'raw',
                        'id': parent.get('id').replace(type,''),
                        'type': type,
                        'action': 'delete'
                    },
                onRequest: function() {
                  new Fx.Tween(parent,{
                    duration:300
                  }).start('background-color', '#fb6c6c');
                },
                onSuccess: function(response) {
                  if(response == true){
                      parent.getChildren('td, th').each(function(cell) {
                        var content = cell.get('html');
                        var wrap = new Element('div', { html: content });
                        wrap.setStyles({
                            'margin': 0,
                            'padding': 0,
                            'overflow': 'hidden'
                        });
                        cell.empty().adopt(wrap);
                          new Fx.Slide(wrap, { duration:500,
                            onComplete: function() {
                              parent.dispose();
                            }}).slideOut();
                      });

                    }else{
                        $('system-message-container').set('html', '<div class=\"ip_warning\">'+response+'</div>');
                    }
                },
                onFailure: function() {
                  $('system-message-container').set('html', '".addslashes(JText::_( 'COM_IPROPERTY_IPUSER_FAIL' ))."');
                }
              }).send();
            };
            });
        });
        });";

        $document->addScriptDeclaration($jscript);
    }    

    protected function _displayLogin($tpl = 'login')
    {
        $document               = JFactory::getDocument();
        $usersConfig            = JComponentHelper::getParams( 'com_users' );
        $settings               = ipropertyAdmin::config();
        $return                 = base64_encode(JRoute::_(ipropertyHelperRoute::getManageRoute(), false));

        $document->setTitle( JText::_( 'COM_IPROPERTY_PLEASE_LOG_IN' ) );

        $this->assignRef('return', $return);
        $this->assignRef('allowreg', $usersConfig->get( 'allowUserRegistration' ));
        $this->assignRef('settings', $settings);

        parent::display($tpl);
    }

    protected function _displayNoAccess($tpl = 'noaccess')
    {
        $app  = JFactory::getApplication();
        $option     = JRequest::getCmd('option');

        $this->ipbaseurl    = JURI::root(true);
        $document           = JFactory::getDocument();
        $settings           = ipropertyAdmin::config();
        $pathway            = $app->getPathway();

        // Get the menu item object
        $menus =JSite::getMenu();
        $menu  = $menus->getActive();

        $document->setTitle( JText::_( 'COM_IPROPERTY_NO_ACCESS' ));
        //set breadcrumbs
        if(is_object($menu) && $menu->query['view'] != 'ipuser') {
            $pathway->addItem(JText::_( 'COM_IPROPERTY_NO_ACCESS' ), '');
        }

        $this->assignRef('settings', $settings);

        parent::display($tpl);
    }
}

?>
