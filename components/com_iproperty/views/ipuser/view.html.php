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

class IpropertyViewIPuser extends JView
{
    public function display($tpl = null)
    {
        $app        = JFactory::getApplication();
        $option     = JRequest::getCmd('option');

        JHTML::_('behavior.tooltip');
        JPluginHelper::importPlugin( 'iproperty' );
        $dispatcher = JDispatcher::getInstance();

        $this->ipbaseurl    = JURI::root(true);
        $user               = JFactory::getUser();
        $userid             = $user->get('id');

        $document           = JFactory::getDocument();
        $settings           = ipropertyAdmin::config();
        $this->ipauth       = new ipropertyHelperAuth();

        $model      = $this->getModel();
        $properties = $this->get('properties');
        $searches   = $this->get('searches');

        //create toolbar
        $dispatcher->trigger( 'onBeforeRenderToolbar', array( &$settings ) );
        echo ipropertyHTML::buildToolbar('user');

        $this->assignRef('settings', $settings);
        $this->assignRef('properties', $properties);
        $this->assignRef('searches', $searches);
        $this->assignRef('user', $user);
        $this->assignRef('dispatcher', $dispatcher);

        if( !$settings->show_saveproperty && !$settings->show_savesearch ){
            $this->_displayNoAccess();
            return;
        }else if( !$userid ){
            $this->_displayLogin();
            return;
        }

        $this->_prepareDocument();

        // we got here so it's a logged in end user, not an agent
        $delete_script = "\n\n";
        $delete_script.= "window.addEvent('domready',function() {"."\n";
        $delete_script.= "$$('a.delete').each(function(el) {
            el.addEvent('click',function(e) {
              e.stop();
              var parent = el.getParent('tr');
              var confdelete = confirm('".JText::_( 'COM_IPROPERTY_CONFIRM_DELETE' )."');
              if (confdelete == true){
                  var request = new Request.JSON({
                    url: 'index.php?option=com_iproperty&task=ajax.deleteSaved',
                    link: 'chain',
                    method: 'post',
                        data: { '".JUtility::getToken()."':'1',
                            'format': 'raw',
                            'editid': parent.get('id')
                        },
                    onRequest: function() {
                      new Fx.Tween(parent,{
                        duration:300
                      }).start('background-color', '#fb6c6c');
                    },
                    onSuccess: function(response) {
                      if(response){
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
                        }
                    },
                    onFailure: function() {
                      $('system-message-container').set('html', '<div class=\"ip_warning\">".JText::_( 'COM_IPROPERTY_IPUSER_FAIL' )."</div>');
                    }
                  }).send();
                }
            });
        });
                    });";

        $document->addScriptDeclaration($delete_script);

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
        if ($menu) {
            $this->params->def('page_heading', $this->params->get('page_title', $menu->title));
        } else {
            $this->params->def('page_heading', JText::_( 'COM_IPROPERTY_MY_FAVORITES' ));
        }

        $title = JText::_( 'COM_IPROPERTY_MY_FAVORITES' );
        $this->iptitle = $title;
        if (empty($title)) {
            $title = $app->getCfg('sitename');
        }
        elseif ($app->getCfg('sitename_pagetitles', 0) == 1) {
            $title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
        }
        elseif ($app->getCfg('sitename_pagetitles', 0) == 2) {
            $title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));
        }
        $this->document->setTitle($title);

        // Set meta data according to menu params
        if ($this->params->get('menu-meta_description')) $this->document->setDescription($this->params->get('menu-meta_description'));
        if ($this->params->get('menu-meta_keywords')) $this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
        if ($this->params->get('robots')) $this->document->setMetadata('robots', $this->params->get('robots'));

        // Breadcrumbs TODO (Add the whole tree)
        if(is_object($menu) && $menu->query['view'] != 'ipuser') {
            $pathway->addItem($title);
        }

        if($this->searches){
            $jscript     = "\n\n";
            $jscript    .= "window.addEvent('domready',function() {"."\n";
            $jscript    .= "  var ipsearchcookies = new Array();"."\n";
            $jscript    .= "  var ipadvsearchpath = '".IpropertyHelperRoute::getAdvsearchRoute()."';"."\n";
            // build hash cookie objects for the saved search
            foreach($this->searches as $s){
                $jscript    .= '  ipsearchcookies['.$s->id.'] = "'.$s->search_string.'".parseQueryString();'."\n";
            }
            $jscript    .= "  setCookieRedirect = function(id) {
                var ipSearchCookie = new Hash.Cookie('ipAdvSearch'+id);
                ipSearchCookie.extend(ipsearchcookies[id]);
                window.location = ipadvsearchpath+'&recallSearch='+id;
            };
            });";

            $document->addScriptDeclaration($jscript);
        }
    }

    protected function _displayLogin($tpl = 'login')
    {
        $document               = JFactory::getDocument();
        $usersConfig            = JComponentHelper::getParams( 'com_users' );
        $settings               = ipropertyAdmin::config();
        $return                 = base64_encode(JRoute::_(ipropertyHelperRoute::getIpuserRoute(), false));

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
