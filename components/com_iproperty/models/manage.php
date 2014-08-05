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

class IpropertyModelManage extends JModel
{	
	function __construct()
	{
		parent::__construct();
	}    
    
    // this will (un)publish, (un)feature or delete object
    function alterObject($id, $type, $action)
    {
        $table  	= false;
        $column 	= false;
		$authfunc 	= false;	
		$ipauth		= false;
		$value 		= false;
		$id			= (int) $id;
        
        switch ($type){
            case 'agent':
                $table = '#__iproperty_agents';
            break;
            case 'company':
                $table = '#__iproperty_companies';
            break;
            case 'property':
                $table = '#__iproperty';
            break;
            default:
                return 'INVALID TYPE';
            break;
        }
        
        switch ($action){
            case 'approve':
                $column = 'approved';
				$value	= '1';
            break;			
			case 'unapprove':
                $column = 'approved';
				$value	= '0';
            break;
            case 'feature':
                $column = 'featured';
				$value	= '1';
            break;			
			case 'unfeature':
                $column = 'featured';
				$value	= '0';
            break;
            case 'publish':
				$column = 'state';
				$value	= '1';
            break;
			case 'unpublish':
                $column = 'state';
				$value	= '0';
            break;
            default:
                $this->setError(JText::_('INVALID ACTION'));
                return false;
            break;
        }
		
		// get the right auth->function for the call
        switch ($type){
            case 'agent':
                $ipauth		= new ipropertyHelperAuth();
				switch ($action){
					case 'feature':
						$authfunc 	= $ipauth->canFeatureAgent($id, 1);
					break;
					case 'unfeature':
						$authfunc 	= $ipauth->canFeatureAgent($id);
					break;
					case 'publish':
                        $authfunc 	= $ipauth->canPublishAgent($id, 1);
                    break;    
					case 'unpublish':
						$authfunc 	= $ipauth->canEditAgent($id);
					break;
					default:
						$this->setError(JText::_('INVALID ACTION IN AGENT AUTH CHECK'));
                        return false;
					break;
				}
            break;
            case 'company':
                $ipauth		= new ipropertyHelperAuth();
                switch ($action){
					case 'feature':
						$authfunc 	= $ipauth->canFeatureCompany($id);
					break;
					case 'unfeature':
						$authfunc 	= $ipauth->canFeatureCompany($id);
					break;
					case 'publish':
					case 'unpublish':
						$authfunc 	= $ipauth->canEditCompany($id);
					break;
					default:
						$this->setError(JText::_('INVALID ACTION IN COMPANY AUTH CHECK'));
                        return false;
					break;
				}
            break;
            case 'property':
                $ipauth		= new ipropertyHelperAuth();
                switch ($action){
                    case 'approve':
						$authfunc 	= $ipauth->canApproveProp($id);
					break;
					case 'unapprove':
						$authfunc 	= $ipauth->canApproveProp($id);
					break;
					case 'feature':
						$authfunc 	= $ipauth->canFeatureProp($id, 1);
					break;
					case 'unfeature':
						$authfunc 	= $ipauth->canFeatureProp($id);
					break;
					case 'publish':
						$authfunc 	= $ipauth->canPublishProp($id, 1);
					break;
					case 'unpublish':
						$authfunc 	= $ipauth->canEditProp($id);
					break;
					default:
						$this->setError('INVALID ACTION IN PROPERTY AUTH CHECK');
                        return false;
					break;
				}
            break;
            default:
                $this->setError(JText::_('INVALID TYPE'));
                return false;
            break;
        }		     
               
        if ( $authfunc ){
            $query = $this->_db->getQuery(true);
            $query->update($table)
                    ->set($column.' = '.(int)$value)
                    ->where('id = '.(int)$id);
            
			$this->_db->setQuery($query);
            if( $this->_db->Query() ){
				return true;
            }else{
                $this->setError($this->_db->getErrorMsg());
                return false;
            }
        } else {
            $this->setError(JText::_('ACTION NOT SET OR UNAUTHORIZED')); 
            return false;
        }
    }
    
    public function iconUpload($file, $id, $folder)
    {
        $error = false;
        if (isset($file)) {
			// set an array of accepted mime types to check files against
			$accepted_mimetypes = array(
								'image/jpeg',
								'image/gif',
								'image/png'
								);

            $db         = JFactory::getDbo();
            $settings   = ipropertyAdmin::config();
            $path       = JPATH_SITE;
            $user       = JFactory::getUser();
            
            switch ($folder){
                case 'agents':
                    $table      = '#__iproperty_agents';
                    $imgfolder  = 'agents';
                break;
                case 'companies':
                    $table      = '#__iproperty_companies';
                    $imgfolder  = 'companies';
                break;
                default:
                    $table      = '#__iproperty_agents';
                    $imgfolder  = 'agents';
                break;
            }

            $src_file	= (isset($file['tmp_name']) ? $file['tmp_name'] : "");
            $dest_dir 	= $path.'/media/com_iproperty/'.$imgfolder.'/';
            // get the file extension_loaded
            $parts      = pathinfo($file['name']);
            $ext        = $parts['extension'];
            $vfilename  = uniqid().'.'.$ext;
            $dest_file  = $dest_dir.$vfilename;
            
            // we're going to make sure that the file's mime type is in the accepted group of mime types
			if (function_exists('mime_content_type')) {
				$mime_type = mime_content_type($src_file);
				if (strlen($mime_type) && !in_array($mime_type, $accepted_mimetypes)){
					$error = JText::_( 'COM_IPROPERTY_WRONG_FILETYPE' ). ' Error: 1';
					return $error;
				}
			} elseif (function_exists('finfo_file')) {
				$finfo = finfo_open(FILEINFO_MIME);
				$mime_type = finfo_file($finfo, $src_file);
				if (strlen($mime_type) && !in_array($mime_type, $accepted_mimetypes)){
					$error = JText::_( 'COM_IPROPERTY_WRONG_FILETYPE' ). ' Error: 2';
					return $error;
				}
			}
           
            // check if there's an existing image
            $query = $db->getQuery(true);
            $query->select('icon')
                    ->from($table)
                    ->where('id = '.(int)$id);
            
            $db->setQuery($query);
            $icon = $db->loadResult();
            
            if ($icon && $icon != 'nopic.png') JFile::delete($dest_dir.$icon); // delete the existing image

            if(filesize($src_file) > (intval($settings->maximgsize) * 1000)) {
                $error = sprintf(JText::_( 'COM_IPROPERTY_IMAGE_TOO_LARGE' ), (filesize($src_file)/1000).'KB', $cfg['maximgsize'].'KB', ini_get('upload_max_filesize'));
                return $error;
            }

            if (file_exists($dest_file)) {
                //$error = $dest_file;
                $error = JText::_( 'COM_IPROPERTY_FILE_EXISTS' );
                return $error;
            }

            if(@copy($src_file,$dest_file)){
                //continue
            }else{
                $error = JText::_( 'COM_IPROPERTY_IMAGE_NOT_COPIED' );
                return $error;
            }

            if(!$error) {
                // update the icon name in the appropriate table
                $query = $db->getQuery(true);
                $query->update($table)
                        ->set('icon = '.$db->Quote($vfilename))
                        ->where('id = '.(int)$id);
                
                $db->setQuery($query);
                $result = $db->Query();
                
                if($result) return $vfilename;
            }else{
                return $error;
            }
            return $error;
        } else {
            return JText::_( 'COM_IPROPERTY_NO_FILE_FOUND' );
        }    
    }
}

?>