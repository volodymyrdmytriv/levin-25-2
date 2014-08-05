<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.filesystem.folder' );
jimport( 'joomla.filesystem.file' );

class com_ipropertyInstallerScript
{
    private $tmppath;
    private $ipmedia;
    private $installed_mods             = array();
    private $installed_plugs            = array();
    private $release                    = '2.0.3';
    private $minimum_joomla_release     = '2.5';
    private $preflight_message          = null;
    private $install_message            = null;
    private $uninstall_message          = null;
    private $update_message             = null;
    private $db                         = null;
    private $iperror                    = array();

    /*
     * Preflight method-- return false to abort install
     */
    function preflight($action, $parent)
    {
        $jversion = new JVersion();

        // get new version of IP from manifest and define class variables
        $this->release = $parent->get("manifest")->version;
        $this->tmppath  = JPATH_ROOT.DS.'media'.DS.'iptmp';
        $this->ipmedia  = JPATH_ROOT.DS.'media'.DS.'com_iproperty';
        $this->db       = JFactory::getDBO();       

        // Find mimimum required joomla version
        $this->minimum_joomla_release = $parent->get("manifest")->attributes()->version;

        if( version_compare( $jversion->getShortVersion(), $this->minimum_joomla_release, 'lt' ) ) {
            Jerror::raiseWarning(null, 'Cannot install Intellectual Property '.$this->release.' in a Joomla release prior to '.$this->minimum_joomla_release);
            return false;
        }
        
        // Make sure the extension name is 'com_iproperty' and not just 'iproperty'
        $this->db->setQuery('UPDATE #__extensions SET name = "com_iproperty" WHERE name = "iproperty" AND type = "component"');
        if(!$this->db->Query()){
            JError::raiseWarning(null, 'Could not update extensions table - version compare and sql updates may not execute');
        }

        // abort if the component being installed is not newer than the currently installed version
        switch ($action){
            case 'update':                
                $oldRelease = $this->getParam('version');
                $rel = $oldRelease . ' to ' . $this->release;
                if ( version_compare( $this->release, $oldRelease, 'lt' ) ) {
                    Jerror::raiseWarning(null, 'Incorrect version sequence. Cannot upgrade Intellectual Property ' . $rel);
                    return false;
                }
                
                // If the currently installed release is v2.0 or older
                // must make some mods to schema table for update sql execution
                if($oldRelease && $oldRelease <= 2){
                    $this->_prepareLegacy($oldRelease); 
                }
                $this->installModsPlugs($parent);
            break;
            case 'install':
                $this->installModsPlugs($parent);
                $rel = $this->release;                
            break;
        }

        // check for required libraries
        $curl_exists        = (extension_loaded('curl') && function_exists('curl_init')) ? '<span class="green">Enabled</span>' : '<span class="red">Disabled</span>';
        $gd_exists          = (extension_loaded('gd') && function_exists('gd_info')) ? '<span class="green">Enabled</span>' : '<span class="red">Disabled</span>';
        $php_version        = (PHP_VERSION >= 5.2) ? '<span class="green">'.PHP_VERSION.'</span>' : '<span class="red">'.PHP_VERSION.'</span>';
        $php_calendar       = extension_loaded('calendar') ? '<span class="green">Enabled</span>' : '<span class="red">Disabled</span>';
        $php_simplexml      = extension_loaded('simplexml') ? '<span class="green">Enabled</span>' : '<span class="red">Disabled</span>';

        // Set preflight message
        $this->preflight_message .=  '
            <h3>Preflight Status: ' . $action . ' - ' . $rel . '</h3>
            <ul>
                <li>Current IP version: <span class="green">'.$this->release.'</span></li>
                <li>PHP Version: '.$php_version.'</li>
                <li>cURL Support: '.$curl_exists.'</li>
                <li>GD Support: '.$gd_exists.'</li>
                <li>SimpleXML: '.$php_simplexml.'</li>
                <li>Calendar Extension: '.$php_calendar.'</li>
            </ul>';
    }

    function install($parent)
    {
        // Define vars
        $sample_data_file       = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_iproperty'.DS.'assets'.DS.'install.sampledata.sql';
        $sample_data_rslt       = '<span class="green">Sample data installed</span>';

        // Check if sample data file exists and execute query
        if(JFile::exists($sample_data_file)){
            if(!$samplequery = JFile::read($sample_data_file)){ // Can't read sample data file - set error
                $sample_data_rslt        = '<span class="red">Sample data not installed</span>';
                $this->iperror[]               = 'Cannot read sample data file - please check your folder permission: '.$sample_data_file;
            }else{ // Install sample data from file
                $this->db->setQuery($samplequery);
                if(!$this->db->QueryBatch()) {
                    $sample_data_rslt    = '<span class="red">Sample data not installed</span>';
                    $this->iperror[]           = 'Sample data execution failed with the following error(s) - '.$this->db->getErrorMsg();
                }
            }
        }else{ // Could not find sample data file
            $sample_data_rslt       = '<span class="red">Sample data not installed</span>';
            $this->iperror[]              = 'Could not find sample data file - '.$sample_data_file;
        }

        // Set installation message
        $this->install_message .= '
            <h3>Installation Status:</h3>
            <p>Congratulations on your install of Intellectual Property! The first thing to do to get started with Intellectual Property
            is to go into the settings area and configure your component. When you have your configuration done,
            start by adding a property category, then company, then agents, and finally properties! Please post issues to the support forums at
            extensions.thethinkery.net</p>

            <ul>
                <li>Sample data execution: '.$sample_data_rslt.'</li>
            </ul>

            <h3>Media Status:</h3>
            <ul>';
                //create media folders
                $folder_array       = array('', 'agents', 'categories', 'companies', 'pictures');
                $default_files      = JFolder::files($this->tmppath);
                foreach($folder_array as $folder){
                    if(!JFolder::exists($this->ipmedia.DS.$folder)){
                        if(!JFolder::create($this->ipmedia.DS.$folder, 0755) ) {
                            $this->iperror[] = 'Could not create the <em>'.$this->ipmedia.DS.$folder.'</em> folder. Please check your media folder permissions';
                            $this->install_message .= '<li>media/com_iproperty/'.$folder.': <span class="red">Not created</span></li>';
                        }else{
                            $folderpath = $this->ipmedia.DS.$folder;
                            foreach( $default_files as $file ){
                                if(JFile::getExt($file) != 'csv'){
                                    JFile::copy($this->tmppath.DS.$file, $folderpath.DS.$file);
                                }
                            }
                            $this->install_message .= '<li>media/com_iproperty/'.$folder.': <span class="green">Created</span></li>';
                        }
                    }else{
                        $this->install_message .= '<li>media/com_iproperty/'.$folder.': <span class="green">Exists from previous install</span></li>';
                    }                        
                }
                // copy csv import sample to iproperty media root
                if(JFile::copy($this->tmppath.DS.'iprop_export_sample.csv', $this->ipmedia.DS.'iprop_export_sample.csv')){
                    $this->install_message .= '<li>Sample csv import file <span class="green">Successfully installed</span><br />(<em>'.$this->ipmedia.DS.'iprop_export_sample.csv</em>)</li>';
                }else{
                    $this->install_message .= '<li>Sample csv import file <span class="red">NOT successfully installed</span><br />(<em>'.$this->ipmedia.DS.'iprop_export_sample.csv</em>)</li>';
                }  
                // copy xml import sample to iproperty media root
                if(JFile::copy($this->tmppath.DS.'iprop_export_sample.xml', $this->ipmedia.DS.'iprop_export_sample.xml')){
                    $this->install_message .= '<li>Sample xml import file <span class="green">Successfully installed</span><br />(<em>'.$this->ipmedia.DS.'iprop_export_sample.xml</em>)</li>';
                }else{
                    $this->install_message .= '<li>Sample xml import file <span class="red">NOT successfully installed</span><br />(<em>'.$this->ipmedia.DS.'iprop_export_sample.xml</em>)</li>';
                } 
        $this->install_message .= '
            </ul>';           
    }

     /**
     * method to update the component
     *
     * @return void
     */
    function update($parent)
    {
        // copy csv import sample to iproperty media root
        if(JFile::copy($this->tmppath.DS.'iprop_export_sample.csv', $this->ipmedia.DS.'iprop_export_sample.csv')){
            $csv_copy = 'Sample csv import file <span class="green">Successfully updated</span><br />(<em>'.$this->ipmedia.DS.'iprop_export_sample.csv</em>)';
        }else{
            $csv_copy = 'Sample csv import file <span class="red">Update FAILED</span><br />(<em>'.$this->ipmedia.DS.'iprop_export_sample.csv</em>)';
        }
        // copy xml import sample to iproperty media root
        if(JFile::copy($this->tmppath.DS.'iprop_export_sample.xml', $this->ipmedia.DS.'iprop_export_sample.xml')){
            $xml_copy = 'Sample xml import file <span class="green">Successfully installed</span><br />(<em>'.$this->ipmedia.DS.'iprop_export_sample.xml</em>)';
        }else{
            $xml_copy = 'Sample xml import file <span class="red">NOT successfully installed</span><br />(<em>'.$this->ipmedia.DS.'iprop_export_sample.xml</em>)';
        } 

        // Set update message
        $this->update_message .=  '
            <h3>Update Status</h3>
            <p>Congratulations on your update of Intellectual Property! Please take a look at the changelog to the right
            to see what\'s new! Please post issues to the support forums at extensions.thethinkery.net</p>

            <ul class="checklist">
                <li>'.$csv_copy.'</li>
                <li>'.$xml_copy.'</li>';
                // delete old my_iproperty.css file if it exists since this is no longer a feature as of 2.0.1
                if(JFile::exists(JPATH_ROOT.DS.'components'.DS.'com_iproperty'.DS.'assets'.DS.'css'.DS.'my_iproperty.css')){
                    if(JFile::delete(JPATH_ROOT.DS.'components'.DS.'com_iproperty'.DS.'assets'.DS.'css'.DS.'my_iproperty.css')){
                        $this->update_message .= '<li>my_iproperty.css file deleted successfully</li>';
                    }
                }
        $this->update_message .= '
            </ul>';
    }

    function uninstall($parent)
    {
        $this->db       = JFactory::getDBO();
        $drop_results   = array();
        $ip_uninstall_error = 0;

        $drop_array = array('ipcategories'=>'iproperty_categories',
                            'ipproperties'=>'iproperty',
                            'ipimages'=>'iproperty_images',
                            'ipcompanies'=>'iproperty_companies',
                            'ipagents'=>'iproperty_agents',
                            'ipamenities'=>'iproperty_amenities',
                            'ipcountries'=>'iproperty_countries',
                            'ipstates'=>'iproperty_states',
                            'ipopenhouses'=>'iproperty_openhouses',
                            'ipsettings'=>'iproperty_settings',
                            'ipsaved'=>'iproperty_saved',
                            'ipcurrency'=>'iproperty_currency',
                            'ipagentmid'=>'iproperty_agentmid',
                            'ippropmid'=>'iproperty_propmid',
                            'ipstypes'=>'iproperty_stypes');

        foreach($drop_array AS $key => $value){
            $this->db->setQuery("DROP TABLE IF EXISTS #__".$value);
            if($this->db->query()){
                $drop_results[$key] = '<span class="green">Removed Successfully</span>';
            }else{
                $drop_results[$key] = '<span class="red">Not Removed</span>';
                $ip_uninstall_error++;
            }
        }

        if(!$ip_uninstall_error){
            $ip_overall = 'Successfully Uninstalled';
            $ip_status  = 'green';
        }else{
            $ip_overall = 'Error Removing IP Tables!';
            $ip_status  = 'red';
        }

        echo '
        <style type="text/css">
            .ipmessage{text-align: center; border: solid #84a7db; border-width: 2px 0px; padding: 5px;}
            .green{color: #00CC00 !important; font-weight: bold;}
            .red{color: #CC0000 !important; font-weight: bold;}
        </style>
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td width="50%" valign="top">
                    <table class="adminlist" cellspacing="1">
                        <thead>
                            <tr>
                                <th>Table</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                        </tfoot>
                        <tbody>
                            <tr><td class="key">Categories Table</td><td style="text-align: center !important;">'.$drop_results['ipcategories'].'</td></tr>
                            <tr><td class="key">Properties Table</td><td style="text-align: center !important;">'.$drop_results['ipproperties'].'</td></tr>
                            <tr><td class="key">Images Table</td><td style="text-align: center !important;">'.$drop_results['ipimages'].'</td></tr>
                            <tr><td class="key">Companies Table</td><td style="text-align: center !important;">'.$drop_results['ipcompanies'].'</td></tr>
                            <tr><td class="key">Agents Table</td><td style="text-align: center !important;">'.$drop_results['ipagents'].'</td></tr>
                            <tr><td class="key">Amenities Table</td><td style="text-align: center !important;">'.$drop_results['ipamenities'].'</td></tr>
                            <tr><td class="key">Countries Table</td><td style="text-align: center !important;">'.$drop_results['ipcountries'].'</td></tr>
                            <tr><td class="key">States Table</td><td style="text-align: center !important;">'.$drop_results['ipstates'].'</td></tr>
                            <tr><td class="key">Open Houses Table</td><td style="text-align: center !important;">'.$drop_results['ipopenhouses'].'</td></tr>
                            <tr><td class="key">Settings Table</td><td style="text-align: center !important;">'.$drop_results['ipsettings'].'</td></tr>
                            <tr><td class="key">Saved Properties Table</td><td style="text-align: center !important;">'.$drop_results['ipsaved'].'</td></tr>
                            <tr><td class="key">Currencies Table</td><td style="text-align: center !important;">'.$drop_results['ipcurrency'].'</td></tr>
                            <tr><td class="key">Agents Mid Table</td><td style="text-align: center !important;">'.$drop_results['ipagentmid'].'</td></tr>
                            <tr><td class="key">Properties Mid Table</td><td style="text-align: center !important;">'.$drop_results['ippropmid'].'</td></tr>
                            <tr><td class="key">Sale Types Table</td><td style="text-align: center !important;">'.$drop_results['ipstypes'].'</td></tr>
                        </tbody>
                    </table>
                </td>
                <td width="50%" valign="top">
                    <table class="adminlist">
                        <tr><td valign="top"><h3>Thank you for using IProperty!</h3></td></tr>
                        <tr>
                            <td valign="top">
                                <p>Thank you for using Intellectual Property. If you have any new feature requests we would love to hear
                                them! Please post requests in the forums at <a href="http://extensions.thethinkery.net" target="_blank">http://extensions.thethinkery.net</a>. Ideas for
                                new component features, modules, and plugins are welcome. If you have questions please post to the support forum or email
                                us at <a href="mailto:iproperty@thethinkery.net">iproperty@thethinkery.net</a>.</p>

                                <h4>Upgrade Instructions:</h4>
                                <p>If you are upgrading to a newer version of Intellectual Property, please visit <a href="http://extensions.thethinkery.net" target="_blank">http://extensions.thethinkery.net</a>
                                to review upgrade instructions. All media folders and files have been preserved for use in future upgrades and can be located in your site/media/com_iproperty folder.</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>';
    }

    /**
     * method to run after an install/update/uninstall method
     *
     * @return void
     */
    function postflight($action, $parent)
    {
        echo '
        <style type="text/css">
            .green{color: #00CC00 !important; font-weight: bold;}
            .red{color: #CC0000 !important; font-weight: bold;}
            .iplogoheader{background: #f4f4f4; border-bottom: solid 1px #ccc; margin-bottom: 8px;}
            .ipleftcol{color: #808080; padding: 0px 10px;}
            .iplogfile{background: #ffffff !important; border: solid 1px #cccccc; padding: 5px 10px; height: 500px; overflow: auto;}
            dl.tabs dt{background: #377391 !important;}
            dl.tabs a{color: #fff !important;}
            dl.tabs dt.open {background: #F9F9F9 !important;}
            dl.tabs dt.open a{color: #222 !important;}
        </style>
        
        <script src="'.JURI::root(true).'/media/system/js/tabs.js" type="text/javascript"></script>        
        <script type="text/javascript">
            window.addEvent(\'domready\', function(){
                $$(\'dl#installPane.tabs\').each(function(tabs){
                    new JTabs(tabs, {useStorage: false,titleSelector: \'dt.tabs\',descriptionSelector: \'dd.tabs\'});
                });
            });
        </script>
        

        <div class="width-100 fltlft iplogoheader">
            '.JHTML::_('image', 'administrator/components/com_iproperty/assets/images/iproperty_admin_logo.gif', 'Intellectual Property :: By The Thinkery' ).'
        </div>
        <div class="clear"></div>
        <div class="width-45 fltlft ipleftcol">
            '.$this->preflight_message;

            switch ($action){
                case "install":
                    /* Update existing IP menu items if necessary */
                    $this->db->setQuery('SELECT extension_id FROM #__extensions WHERE name = '.$this->db->Quote('com_iproperty').' AND type = '.$this->db->Quote('component').' LIMIT 1');
                    $iprop_id = $this->db->loadResult();

                    if($iprop_id){
                        $this->db->setQuery('UPDATE #__menu SET component_id = '.(int)$iprop_id.' WHERE link LIKE '.$this->db->Quote( '%'.$this->db->getEscaped( 'com_iproperty', true ).'%', false ).' AND type = '.$this->db->Quote('component'));
                        if(!$this->db->Query()){
                            $this->iperror[] = JText::_("Could not fix menu items! If you have current IP menu items please make sure the type is an IProperty menu type.");
                        }else{
                            $this->install_message .= '
                                <h3>Menu Item Status</h3>
                                <ul>
                                    <li>IProperty menu items <span class="green">Successfully updated</span></li>
                                </ul>';
                        }
                    }                    
                    echo $this->install_message;
                break;
                case "update":
                    echo $this->update_message;
                break;
                case "uninstall":
                    echo $this->uninstall_message;
                break;
            }               
            
            if(count($this->iperror)){
                JError::raiseWarning(123, 'Component was installed but some errors occurred. Please check install status below for details');
                echo '
                    <h3>Error Status</h3>
                    <ul>';
                        foreach($this->iperror as $error){
                            echo '<li><span class="red">'.$error.'</span></li>';
                        }
               echo '
                    </ul>';
            }
        echo '
        </div>
        <div class="width-50 fltrt">';
            echo JHtml::_('tabs.start', 'installPane', array('useCookie' => false));
                echo JHtml::_('tabs.panel', JText::_('Changelog'), 'chngpanel');            
                    echo '
                    <div class="iplogfile">';
                        $logfile            = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_iproperty'.DS.'assets'.DS.'CHANGELOG.TXT';
                        if(JFile::exists($logfile)){
                            $logcontent     = JFile::read($logfile);
                            $logcontent     = htmlspecialchars($logcontent, ENT_COMPAT, 'UTF-8');
                            echo '<pre style="font-size: 11px !important; color: #666;">'.$logcontent.'</pre>';
                        }else{
                            echo 'Could not find changelog content - '.$logfile;
                        }
                    echo '
                    </div>';
                    
                if (count($this->installed_plugs)){
                    echo JHtml::_('tabs.panel', JText::_('Plugins'), 'plgpanel');
                    echo '<div>
                          <table class="adminlist" cellspacing="1">
                            <thead>
                                <tr>
                                    <th>'.JText::_('Plugin').'</th>
                                    <th>'.JText::_('Group').'</th>
                                    <th>'.JText::_('Status').'</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <td colspan="3">&nbsp;</td>
                                </tr>
                            </tfoot>
                            <tbody>';
                                foreach ($this->installed_plugs as $plugin) :
                                    $pstatus    = ($plugin['upgrade']) ? JHtml::_('image','admin/tick.png', '', NULL, true) : JHtml::_('image','admin/publish_x.png', '', NULL, true);
                                    echo '<tr>
                                            <td>'.$plugin['plugin'].'</td>
                                            <td>'.$plugin['group'].'</td>
                                            <td style="text-align: center;">'.$pstatus.'</td>
                                          </tr>';
                                endforeach;
                   echo '   </tbody>
                         </table>
                         </div>';
                }

                if (count($this->installed_mods)){
                    echo JHtml::_('tabs.panel', JText::_('Modules'), 'modpanel');
                    echo '<div>
                          <table class="adminlist" cellspacing="1">
                            <thead>
                                <tr>
                                    <th>'.JText::_('Module').'</th>
                                    <th>'.JText::_('Status').'</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                </tr>
                            </tfoot>
                            <tbody>';
                                foreach ($this->installed_mods as $module) :
                                    $mstatus    = ($module['upgrade']) ? JHtml::_('image','admin/tick.png', '', NULL, true) : JHtml::_('image','admin/publish_x.png', '', NULL, true);
                                    echo '<tr>
                                            <td>'.$module['module'].'</td>
                                            <td style="text-align: center;">'.$mstatus.'</td>
                                          </tr>';
                                endforeach;
                   echo '   </tbody>
                         </table>
                         </div>';
                }
            
            echo JHtml::_('tabs.end');
        echo ' 
        </div>';
    }

    function getParam( $name ) 
    {
        $this->db = JFactory::getDbo();
        $this->db->setQuery('SELECT manifest_cache FROM #__extensions WHERE name = "com_iproperty" AND type="component"');
        $manifest = json_decode( $this->db->loadResult(), true );
        return $manifest[ $name ];
    }
    
    function installModsPlugs($parent)
    {
        $manifest       = $parent->get("manifest");
        $parent         = $parent->getParent();
        $source         = $parent->getPath("source");

        //**********************************************************************
        // DO THIS IF WE DECIDE TO AUTOINSTALL PLUGINS/MODULES
        //**********************************************************************
        // install plugins and modules
        $installer = new JInstaller();

        // Install plugins
        foreach($manifest->plugins->plugin as $plugin) {
            $attributes                 = $plugin->attributes();
            $plg                        = $source . DS . $attributes['folder'].DS.$attributes['plugin'];
            $new                        = ($attributes['new']) ? '&nbsp;(<span class="green">New in v.'.$attributes['new'].'!</span>)' : '';
            if($installer->install($plg)){
                $this->installed_plugs[]    = array('plugin' => $attributes['plugin'].$new, 'group'=> $attributes['group'], 'upgrade' => true);
            }else{
                $this->installed_plugs[]    = array('plugin' => $attributes['plugin'], 'group'=> $attributes['group'], 'upgrade' => false);
                $this->iperror[] = JText::_('Error installing plugin').': '.$attributes['plugin'];
            }
        }

        // Install modules
        foreach($manifest->modules->module as $module) {
            $attributes             = $module->attributes();
            $mod                    = $source . DS . $attributes['folder'].DS.$attributes['module'];
            $new                    = ($attributes['new']) ? '&nbsp;(<span class="green">New in v.'.$attributes['new'].'!</span>)' : '';
            if($installer->install($mod)){
                $this->installed_mods[] = array('module' => $attributes['module'].$new, 'upgrade' => true);
            }else{
                $this->installed_mods[] = array('module' => $attributes['module'], 'upgrade' => false);
                $this->iperror[] = JText::_('Error installing module').': '.$attributes['module'];
            }
        }
    }
    
    protected function _prepareLegacy($release = '1.6')
    {
        $db = JFactory::getDbo();       
        
        //Check for an old release and update the schema in order to trigger sql updates
        $db->setQuery('SELECT extension_id FROM #__extensions WHERE name = "com_iproperty" AND type = "component" LIMIT 1');
        if($ipid = $db->loadResult()){
            $query = $db->getQuery(true);
            $query->select('version_id');
            $query->from('#__schemas');
            $query->where('extension_id = '.(int)$ipid);
            $db->setQuery($query);
            if (!$db->loadResult())
            {
                $query = $db->getQuery(true);
                $query->insert('#__schemas');
                $query->set('extension_id = '.(int)$ipid.', version_id='.$db->quote($release));
                $db->setQuery($query);
                $db->query();
            }
        }        
    }
}