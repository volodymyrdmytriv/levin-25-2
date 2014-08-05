<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.error.log');

class ipropertyController extends JController
{
    var $log;
    var $debug;

    function __construct()
    {
        $this->debug = false;
        if($this->debug) $this->log =JLog::getInstance('iproperty.log.php'); // create the logfile TODO: maybe add a debug switch to the admin to turn this off or on
        if($this->debug) $this->log->addEntry(array('COMMENT' => 'Constructing IProperty'));
        
        parent::__construct();       
    }
    
    public function display($cachable = false, $urlparams = false)
	{
		$app            = JFactory::getApplication();
        $document       = JFactory::getDocument();
        $settings       = ipropertyAdmin::config();
        ipropertyHTML::includeIpScripts(true, true);
        
        if( $settings->offline == 1 ){
            echo '
                <div align="center" class="ipoffline">
                    '.JHTML::_('image.site', 'iproperty1.png','/components/com_iproperty/assets/images/','','','').'
                    <div>' . $settings->offmessage . '</div>
                </div>';
        }else{
            // Set predefined 'get' vars from menu item params
            $pdarray = array('cat', 'stype', 'city', 'locstate', 'province', 'county', 'region', 'country', 'beds', 'baths', 'price_low', 'price_high', 'filter_order', 'filter_order_dir', 'hoa', 'reo', 'waterfront');
            foreach($pdarray as $pd){
                if($app->getParams()->get($pd) && !JRequest::getInt('ipquicksearch')){
                    JRequest::setVar($pd, $app->getParams()->get($pd), 'get');
                }
            }
            // end predefined vars           
        
            $cachable       = true;
            $editid         = JRequest::getInt('id');
            $vName          = JRequest::getCmd('view', 'foundproperties');
            
            JRequest::setVar('view', $vName);

            $safeurlparams = array('cat'=>'INT','id'=>'INT','cid'=>'ARRAY','limit'=>'INT','limitstart'=>'INT',
                'showall'=>'INT','return'=>'BASE64','search'=>'STRING','filter_order'=>'CMD','filter_order_dir'=>'CMD',
                'stype'=>'INT','print'=>'BOOLEAN','city'=>'STRING','locstate'=>'INT','province'=>'STRING','county'=>'STRING',
                'region'=>'STRING','country'=>'INT','beds'=>'INT','baths'=>'INT','price_low'=>'INT','price_high'=>'INT',
                'hoa'=>'INT','reo'=>'INT','waterfront'=>'INT','print'=>'BOOLEAN','lang'=>'CMD');

            parent::display($cachable, $safeurlparams);

            return $this;
        }
	}
}
?>