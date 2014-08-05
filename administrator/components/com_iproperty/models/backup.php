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

class IpropertyModelBackup extends JModel
{
    public function backupNow()
	{
        $app  = JFactory::getApplication();
        $option     = JRequest::getCmd('option');

        $CONFIG         = new JConfig();
        $database 		= JFactory::getDBO();
        $host		    = $app->getCfg( 'host' );
        $user		    = $app->getCfg( 'user' );
        $password	    = $app->getCfg( 'password' );
        $db			    = $app->getCfg( 'db' );
        $mailfrom	    = $app->getCfg( 'mailfrom' );
        $fromname	    = $app->getCfg( 'fromname' );
        $livesite	    = $app->getCfg( 'live_site' );
        $pluginParams   = '';
        $testing		= false;

        // You can manually set the production flag here if you don't want the "testing" option to kick in
        // at any point. Effectively it means that the query will not be run until $okToContinue is true, which
        // only occurs if today's checkFile doesn't exist.
        // If you DO manually set this flag, then of course none of the testing data will be echoed to your browser

        $mediaPath		= JPATH_ROOT.DS.'media'.DS.'com_iproperty';
        $checkfileName	= 'ip_checkfile_';
        $today 			= date("Y-m-d");
        $dateCheckFile	= $checkfileName.$today;
        $okToContinue	= true;

        if (is_writable($mediaPath) )  // a couple of simple checks to see if we need to actually do anything
        {
            if (!$testing)
            {
                if (!touch($mediaPath.DS.$dateCheckFile)) // Oops, we can't create the date check file, no point in continuing
                {
                    $this->setError(sprintf(JText::_( 'COM_IPROPERTY_CHECK_FILE_NOT_CREATED' ), $mediaPath));
                    $okToContinue = false;
                    return false;
                }
            }
        }else{
            $this->setError(sprintf(JText::_( 'COM_IPROPERTY_BACKUP_NOT_CREATED' ), $mediaPath));
            $okToContinue = false;
            return false;
        }

        if ($okToContinue)
        {
            // No need to do the require beforehand if not ok to continue, so we'll do it here to save an eeny weeny amount of time
            require_once (JPATH_COMPONENT_ADMINISTRATOR.DS.'classes'.DS.'mysql_db_backup.class.php');
            JFile::delete($mediaPath.DS.$dateCheckFile);
            $deletefile		= false;
            $compress		= 1;
            $backuppath		= 0;
            $verbose		= 1;

            // Ok, let's keep going. First we want to get rid of yesterday's jombackup_checkfile, no need to have that lying around now
            // Now we need to create the backup
            $backup_obj 	= new ip_MySQL_DB_Backup();
            $dp             = $database->getPrefix();
            $backup_obj->tablesToInclude = array(
                    $dp.'iproperty',
                    $dp.'iproperty_agentmid',
                    $dp.'iproperty_agents',
                    $dp.'iproperty_amenities',
                    $dp.'iproperty_categories',
                    $dp.'iproperty_companies',
                    $dp.'iproperty_countries',
                    $dp.'iproperty_currency',
                    $dp.'iproperty_images',
                    $dp.'iproperty_openhouses',
                    $dp.'iproperty_propmid',
                    $dp.'iproperty_saved',
                    $dp.'iproperty_settings',
                    $dp.'iproperty_states',
                    $dp.'iproperty_stypes'
                    );

            $result		       = $this->ipBackup($backup_obj, $host, $user, $password, $db, $pluginParams, $mediaPath, $fromname, $compress, $backuppath);
            $backupFile		   = $backup_obj->ip_file_name;

            if($deletefile == "1" && !empty($backupFile) )
            {
                if ($testing){
                    echo "Deleting backup file $backupFile";
                    unlink($backupFile);
                }
            }else if($testing){
                echo "Not deleting backup file $backupFile";
            }
            return JText::_( 'COM_IPROPERTY_BACKUP_FILE_READY_TO_DOWNLOAD' ).' - '.$backup_obj->ip_file_name;
        }else{
            $this->setError($this->getError());
            return false;
        }        
    }

    protected function ipBackup($backup_obj, $host, $user, $password, $db, $pluginParams, $mediaPath, $fromname, $compress, $backuppath)
    {
        $Body 				= 'Mysql backup from'.$fromname;
        $drop_tables 		= 0;
        $create_tables 		= 0;
        $struct_only 		= 0;
        $locks 				= 1;
        $comments 			= 1;

        // Let's set the tables to ignore array.
        if(!empty($backuppath) && is_dir($backuppath) && @is_writable($backuppath)){
            $backup_dir = $backuppath;
        }else{
            $backup_dir = $mediaPath;
        }

        //----------------------- EDIT - REQUIRED SETUP VARIABLES -----------------------
        $backup_obj->server 	= $host;
        $backup_obj->port 		= 3306;
        $backup_obj->username 	= $user;
        $backup_obj->password 	= $password;
        $backup_obj->database 	= $db;
        //Tables you wish to backup. All tables in the database will be backed up if this array is null.
        $backup_obj->tables = array();
        //------------------------ END - REQUIRED SETUP VARIABLES -----------------------

        //-------------------- OPTIONAL PREFERENCE VARIABLES ---------------------
        //Add DROP TABLE IF EXISTS queries before CREATE TABLE in backup file.
        $backup_obj->drop_tables 	= $drop_tables;
        //No table structure will be backed up if false
        $backup_obj->create_tables 	= $create_tables;
        //Only structure of the tables will be backed up if true.
        $backup_obj->struct_only 	= $struct_only;
        //Add LOCK TABLES before data backup and UNLOCK TABLES after
        $backup_obj->locks 			= $locks;
        //Include comments in backup file if true.
        $backup_obj->comments 		= $comments;
        //Directory on the server where the backup file will be placed. Used only if task parameter equals MSX_SAVE.
        $backup_obj->backup_dir 	= $backup_dir.DS;
        //Default file name format.
        $backup_obj->fname_format 	= 'm_d_Y__H_i_s';
        //Values you want to be intrerpreted as NULL
        $backup_obj->null_values 	= array( );

        $savetask = MSX_SAVE;
        //Optional name of backup file if using 'MSX_APPEND', 'MSX_SAVE' or 'MSX_DOWNLOAD'. If nothing is passed, the default file name format will be used.
        $filename = '';
        //--------------------- END - REQUIRED EXECUTE VARIABLES ----------------------
        $result_bk = $backup_obj->Execute($savetask, $filename, $compress);
        if (!$result_bk)
        {
            $output = $backup_obj->error;
        }else{
            $output = $Body.': ' . strftime('%A %d %B %Y  - %T ') . ' ';
        }
        return array('result' => $result_bk, 
                     'output' => $output);
    }
    
    public function restoreNow($bak_file, $prefix = '')
    {
        jimport('joomla.filesystem.archive');
        $database      = JFactory::getDBO();
        
        //if can't extract file, return with error
        if(!JArchive::extract($bak_file, JPATH_SITE.DS.'media'.DS.'com_iproperty')){
            $this->setError(sprintf(JText::_('COM_IPROPERTY_COULD_NOT_EXTRACT_FILE'), $bak_file));
            return false;
        }
        
        // confirm that we're able to read back up file
        $text_bak_file = substr($bak_file, 0, strlen($bak_file)-3);
        if(!$bquery = JFile::read($text_bak_file)){
            $this->setError(sprintf(JText::_('COM_IPROPERTY_COULD_NOT_READ_BACKUP'), $text_bak_file));
            return false;
        }
        
        // if a prefix was entered, make sure that the prefix exists in the backup file content before executing any changes
        if($prefix && !strpos($bquery, $prefix.'iproperty')){
            $this->setError(sprintf(JText::_('COM_IPROPERTY_DB_PREFIX_NOT_FOUND'), $prefix));
            return false;
        }else if(!$prefix && !strpos($bquery, $database->getPrefix().'iproperty')){ // if no prefix was entered, make sure that current db prefix exists in the backup file content before executing any changes
            $this->setError(sprintf(JText::_('COM_IPROPERTY_DB_PREFIX_NOT_FOUND'), $database->getPrefix()));
            return false;
        }
            
        JFile::delete($text_bak_file);

        $backup_version = substr(strrchr($text_bak_file, '_v'), 2, 3);
        
        if($backup_version < '2.0'){            
            $bquery = str_replace('`state`', '`locstate`',$bquery);
            $bquery = str_replace('`published`', '`state`', $bquery);            
        }
        $bquery = str_replace('`agent_show_social1`', '`agent_show_social`', $bquery); 
        if($prefix) $bquery = str_replace($prefix, $database->getPrefix(), $bquery);
        
        // check if pro_last_run exists
        $database->setQuery('SELECT pro_last_run FROM #__iproperty LIMIT 1');
        $last_run = ($database->Query()) ? true : false;
        // check if pro_api_key exists
        $database->setQuery('SELECT pro_api_key FROM #__iproperty LIMIT 1');
        $api_key = ($database->Query()) ? true : false;
        // check if ip_source index exists in property table
        $database->setQuery('SHOW INDEX FROM #__iproperty WHERE Key_name = "ip_source"');
        $ip_source_prop = $database->loadObjectList();
        // check if ip_source index exists in agents table
        $database->setQuery('SHOW INDEX FROM #__iproperty_agents WHERE Key_name = "ip_source"');
        $ip_source_agents = $database->loadObjectList();
        // check if ip_source index exists in companies table
        $database->setQuery('SHOW INDEX FROM #__iproperty_companies WHERE Key_name = "ip_source"');
        $ip_source_company = $database->loadObjectList();
        // end pre-restore checks

        $emptying_query = '';
        
        // Temp solution for deprecated settings
        // Any time we remove or change a settings field on updates
        // we need to add it to this array to prevent breaking backups from earlier versions
        $deprecated_settings = array('agent_show_social1', 'agent_show_msn', 'agent_show_skype', 
                                    'agent_show_gtalk', 'agent_show_linkedin', 
                                    'agent_show_facebook', 'agent_show_twitter', 
                                    'adv_slider_length', 'adv_map_width', 'adv_map_height', 
                                    'googlemap_key', 'css_file', 'adv_show_radius');
        foreach($deprecated_settings as $d){
            if(strpos($bquery, $d)){
                $emptying_query .= 'ALTER TABLE #__iproperty_settings ADD `'.$d.'` VARCHAR(255);';
            }
        }
        // end temp solution
        
        if(!$last_run) $emptying_query .= 'ALTER TABLE #__iproperty ADD `pro_last_run` TIMESTAMP;'; // 1.5.4
        if(!$api_key) $emptying_query .= 'ALTER TABLE #__iproperty ADD `pro_api_key` VARCHAR(255);'; // 1.5.4
        if(!empty($ip_source_prop)) $emptying_query .= 'ALTER IGNORE TABLE #__iproperty DROP INDEX ip_source;'; // 1.5.4
        if(!empty($ip_source_agents)) $emptying_query .= 'ALTER IGNORE TABLE #__iproperty_agents DROP INDEX ip_source;'; // 1.5.4
        if(!empty($ip_source_company)) $emptying_query .= 'ALTER IGNORE TABLE #__iproperty_companies DROP INDEX ip_source;'; // 1.5.4

        $emptying_query .= 'TRUNCATE TABLE #__iproperty;';
        $emptying_query .= 'TRUNCATE TABLE #__iproperty_agentmid;';
        $emptying_query .= 'TRUNCATE TABLE #__iproperty_agents;';
        $emptying_query .= 'TRUNCATE TABLE #__iproperty_amenities;';
        $emptying_query .= 'TRUNCATE TABLE #__iproperty_categories;';
        $emptying_query .= 'TRUNCATE TABLE #__iproperty_companies;';
        $emptying_query .= 'TRUNCATE TABLE #__iproperty_countries;';
        $emptying_query .= 'TRUNCATE TABLE #__iproperty_currency;'; //1.5.5
        $emptying_query .= 'TRUNCATE TABLE #__iproperty_images;';
        $emptying_query .= 'TRUNCATE TABLE #__iproperty_openhouses;'; // 1.5.4
        $emptying_query .= 'TRUNCATE TABLE #__iproperty_propmid;';
        $emptying_query .= 'TRUNCATE TABLE #__iproperty_saved;';
        $emptying_query .= 'TRUNCATE TABLE #__iproperty_settings;';
        $emptying_query .= 'TRUNCATE TABLE #__iproperty_states;';
        $emptying_query .= 'TRUNCATE TABLE #__iproperty_stypes;'; //1.5.5

        // Truncate tables to prepare for backup data
        $database->setQuery ($emptying_query);
        if(!$database->QueryBatch()) {
            $this->setError(JText::_( 'COM_IPROPERTY_QUERIES_EXECUTION_FAILED' ).' IP Error1 - '.$database->getErrorMsg());
            return false;
        }

        // set char set to utf8 just in case
        $database->setQuery("SET CHARACTER SET 'utf8'");
        if(!$database->Query()){
            $this->setError(JText::_( 'COM_IPROPERTY_QUERIES_EXECUTION_FAILED' ).' IP Error2 - '.$database->getErrorMsg());
            return false;
        }

        $database->setQuery("SET NAMES 'utf8'");
        if(!$database->Query()){
            $this->setError(JText::_( 'COM_IPROPERTY_QUERIES_EXECUTION_FAILED' ).' IP Error3 - '.$database->getErrorMsg());
            return false;
        }

        // set backup sql from restore file
        $database->setQuery(utf8_decode($bquery));
        if(!$database->QueryBatch()) {
            $this->setError(JText::_( 'COM_IPROPERTY_QUERIES_EXECUTION_FAILED' ).' IP Error4 - '.$database->getErrorMsg());
            return false;
        }

        // now that data is restored from backup, do some cleanup
        // drop old pro columns
        $update_query = '';
        $update_query .= 'ALTER TABLE #__iproperty DROP `pro_last_run`;';
        $update_query .= 'ALTER TABLE #__iproperty DROP `pro_api_key`;';
        
        // Temp solution for deprecated settings
        foreach($deprecated_settings as $d){
            if(strpos($bquery, $d)){
                $update_query .= 'ALTER TABLE #__iproperty_settings DROP `'.$d.'`;';
            }
        }
        
        // update any 0 values where key needs to be unique
        $update_query .= 'UPDATE #__iproperty SET ip_source = NULL WHERE ip_source = 0;';
        $update_query .= 'UPDATE #__iproperty_agents SET ip_source = NULL WHERE ip_source = 0;';
        $update_query .= 'UPDATE #__iproperty_companies SET ip_source = NULL WHERE ip_source = 0;';
        // add the unique keys to table that require unique
        $update_query .= 'ALTER TABLE #__iproperty ADD UNIQUE ( ip_source );';
        $update_query .= 'ALTER TABLE #__iproperty_agents ADD UNIQUE ( ip_source );';
        $update_query .= 'ALTER TABLE #__iproperty_companies ADD UNIQUE ( ip_source );';
        // might as well set the rest of ip_source null
        $update_query .= 'UPDATE #__iproperty_agentmid SET ip_source = NULL WHERE ip_source = 0;';
        $update_query .= 'UPDATE #__iproperty_images SET ip_source = NULL WHERE ip_source = 0;';
        $update_query .= 'UPDATE #__iproperty_propmid SET ip_source = NULL WHERE ip_source = 0;';
        $update_query .= 'UPDATE #__iproperty SET access = 1 WHERE access = 0;';
        $update_query .= 'UPDATE #__iproperty_categories SET access = 1 WHERE access = 0;';

        $database->setQuery ($update_query);
        if(!$database->QueryBatch()) {
            $this->setError(JText::_( 'COM_IPROPERTY_QUERIES_EXECUTION_FAILED' ).' IP Error5 - '.$database->getErrorMsg());
            return false;   
        }
        
        // Seems the restore has executed succesfully at this point. return message.
        return JText::_('COM_IPROPERTY_QUERIES_EXECUTED_SUCCESSFULLY');
    }
}
?>