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

class plgIpropertyWalkscoreForm extends JPlugin
{
	function plgIpropertyWalkscoreForm(&$subject, $config)  
    {
		parent::__construct($subject, $config);
        $this->loadLanguage();
	}

    function onBeforeRenderForms($property, $settings, $sidecol)
    {
		if ($this->params->get('before', false)) $this->doWalkscoreForm($property, $settings, $sidecol);
    }
	
	function onAfterRenderForms($property, $settings, $sidecol)
    {
        if (!$this->params->get('before', false)) $this->doWalkscoreForm($property, $settings, $sidecol);
    } 
    
	function doWalkscoreForm($property, $settings, $sidecol)
	{
        $app = JFactory::getApplication();
        $document = JFactory::getDocument();
		if($app->getName() != 'site') return true;
        if(!$this->params->get('walkscore-id')) return false;

		$address	= $property->street_address . " " . $property->zip;		
		$latitude	= $property->lat_pos;
		$longitude	= $property->long_pos;
		
		$ws_script = "
                var ws_wsid    = '" . $this->params->get('walkscore-id') . "';
                var ws_address = '" . urlencode($address) . "';
                var ws_lat     = '" . $latitude . "';
                var ws_lon     = '" . $longitude . "';
                var ws_width   = '" . $this->params->get('width') . "';
                var ws_height  = '" . $this->params->get('height') . "';
                var ws_layout  = 'horizontal';
                var ws_distance_units = '" . $this->params->get('unit') . "';
                var toggler    = 0;

                window.addEvent('domready', function() {						
                    $$('.ipwalkscore').addEvent('click', function(e){
                        if (!toggler){
                            var headID = document.getElementsByTagName(\"head\")[0];
                            var newScript = document.createElement('script');
                            newScript.type = 'text/javascript';
                            newScript.src = 'http://www.walkscore.com/tile/show-walkscore-tile.php';
                            headID.appendChild(newScript);
                            toggler = 1;
                        }
                    });
                });";
        $document->addScriptDeclaration($ws_script);
        
        $ws_style = "
                #ws-walkscore-tile{position:relative;text-align:left}
                #ws-walkscore-tile *{float:none;}
                #ws-footer a,
                #ws-footer a:link{font:11px Verdana,Arial,Helvetica,sans-serif;margin-right:6px;white-space:nowrap;padding:0;color:#000;font-weight:bold;text-decoration:none}
                #ws-footer a:hover{color:#777;text-decoration:none}
                #ws-footer a:active{color:#b14900}";
        $document->addStyleDeclaration($ws_style);

        
        $ws_panel =	'
            <div style="padding: 10px 0px !important;">
                <div id="ws-walkscore-tile">
                    <div id="ws-footer">
                        <form id="ws-form">
                            <a id="ws-a" href="http://www.walkscore.com/" target="_blank">Find out your home\'s Walk Score:</a>
                            <input type="text" id="ws-street" class="inputbox ipwalkscore" />
                            <input type="image" id="ws-go" src="http://www2.walkscore.com/images/tile/go-button.gif" border="0" alt="Walk Score" />
                        </form>
                    </div>
                </div>
            </div>';
                    
		echo JHtml::_('tabs.panel', JText::_($this->params->get('tabtitle', 'PLG_IP_WS_WALKSCORE')), 'ipwalkscore');
		echo $ws_panel;
		
		return true;
	}	
}
