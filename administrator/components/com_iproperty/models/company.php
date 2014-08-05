<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.modeladmin');

class IpropertyModelCompany extends JModelAdmin
{
	
    protected $text_prefix = 'COM_IPROPERTY';

    public static $LEVIN_MANAGEMENT_ID = 1;
    
    public function sanitize($filename)
	{
		$filename	= str_replace(' ', '_', $filename);
        $filename	= str_replace('(', '_', $filename);
        $filename	= str_replace(')', '_', $filename);
        $filename	= str_replace('__', '_', $filename);
		$filename 	= JFile::makeSafe($filename);
		$ext		= JFile::getExt($filename);
		$fname		= JFile::stripExt($filename);

		//make a unique filename 
		$uniq = uniqid($fname);

		//create new filename
		$filename = $uniq;

		return $filename;
	}
	
	// File Upload
	// small sizes of images will be created...
    public function uploadCompanyFile($file, $company_id, $file_title)
    {
        // create result array to return-- initially it will be all false
        $result = array(
            'status'    => false,
            'fname'     => false,
            'message'   => false
        );
        
        
        if (isset($file)) {
        	
			// set an array of accepted mime types to check files against
			$accepted_mimetypes = array(
								'image/png',
								'application/pdf'
								);

            $db         = JFactory::getDBO();
            $settings   = ipropertyAdmin::config();
            $path       = JPATH_SITE;
            $user       = JFactory::getUser();
			$ipauth 	= new ipropertyHelperAuth();

            $src_file	= (isset($file['tmp_name']) ? $file['tmp_name'] : "");
            
            $result['fname'] = $src_file;

            $dest_dir 				= $path.'/media/com_iproperty/companies/';
            $ext                    = strtolower( strrchr($file['name'],'.'));

            $vfilename              = $this->sanitize($file['name']);
            $dest_file              = $dest_dir.$vfilename.$ext;
			
            if(@copy($src_file,$dest_file)){
                    //continue
            }else{
               $result['message'] = 'PDf not copied';
            }

            if(!$result['message']) {
            	// updating database
            	
	            $query = $this->_db->getQuery(true);
		        $query->insert('#__iproperty_companies_files')
		                ->set('title='.$this->_db->Quote($file_title))
		                ->set('description='.$this->_db->Quote(''))
		                ->set('fname='.$this->_db->Quote($vfilename))
		                ->set('type='.$this->_db->Quote($ext))
		                ->set('path='.$this->_db->Quote('/media/com_iproperty/companies/'))
		                ->set('company_id='.$company_id)
		                ->set('owner='.$user->id)
		                ->set('ordering=0')
		                ->set('state=1');
		        
		        $this->_db->setQuery($query);
		        $this->_db->execute();
		        
                $result['status']   = true;
                $result['message']  = JText::_( 'COM_IPROPERTY_FILE_UPLOAD_SUCCESSFUL' );
	            
	            
                return $result;

            }else{
                return $result;
            }
            return $result;
            
            
        }else{
            $result['message']  = JText::_( 'COM_IPROPERTY_NO_FILE_FOUND' );
            return $result;
        }
        // catch all return
        return $result;
    }
    
    public function getFilesByTitle($company_id, $title = '')
    {
    	
    	$query = $this->_db->getQuery(true);
        $query->select('*, title AS img_title, description AS img_description')
                ->from('#__iproperty_companies_files')
                ->where('company_id = '.(int)$company_id)
                ->where('title = '.$this->_db->Quote($title))
                ->order('id DESC');// getting the last uploaded one
        
        $this->_db->setQuery($query, 0, 1);

  		$result = $this->_db->loadObjectList();
  		return $result;
    }
    
    public function getTable($type = 'Company', $prefix = 'IpropertyTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

    public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_iproperty.company', 'company', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}

		// Modify the form based on access controls.
		if (!$this->canEditState((object) $data)) {
			// Disable fields for display.
			$form->setFieldAttribute('ordering', 'disabled', 'true');
			$form->setFieldAttribute('state', 'disabled', 'true');

			// Disable fields while saving.
			// The controller has already verified this is a record you can edit.
			$form->setFieldAttribute('ordering', 'filter', 'unset');
			$form->setFieldAttribute('state', 'filter', 'unset');
		}

		return $form;
	}

    protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_iproperty.edit.agent.data', array());

		if (empty($data)) {
			$data = $this->getItem();

			// Prime some default values.
			if ($this->getState('company.id') == 0) {
                $settings   = ipropertyAdmin::config();

                //Set defaults according to WF config
                //$data->company      = $settings->default_company;
			}
		}

		return $data;
	}

	protected function getReorderConditions($table)
	{
		$condition = array();
		$condition[] = 'state >= 0';
		return $condition;
	}
    
    function publishCompany($pks, $value = 0)
	{
		// Initialise variables.
		$table	= $this->getTable();
		$pks	= (array) $pks;
        $ipauth = new ipropertyHelperAuth();

		$successful = 0;
        // Access checks.
		foreach ($pks as $i => $pk) {
			if ($table->load($pk)) {
				if (!$ipauth->canPublishCompany($pk)){
					// Prune items that you can't change.
					unset($pks[$i]);
                    JError::raiseWarning(403, JText::_('JLIB_APPLICATION_ERROR_EDITSTATE_NOT_PERMITTED'));
				}else{
                    $successful++;
                }
			}
		}

		// Attempt to change the state of the records.
		if (!$table->publish($pks, $value)) {
			$this->setError($table->getError());
			return false;
		}

		return $successful;
	}
    
    function featureCompany($pks, $value = 0)
	{
		// Initialise variables.
		$table	= $this->getTable();
		$pks	= (array) $pks;
        $ipauth = new ipropertyHelperAuth();

		$successful = 0;
        // Access checks.
		foreach ($pks as $i => $pk) {
			if ($table->load($pk)) {
				if (!$ipauth->canFeatureCompany($pk)){
					// Prune items that you can't change.
					unset($pks[$i]);
                    JError::raiseWarning(403, JText::_('JLIB_APPLICATION_ERROR_EDITSTATE_NOT_PERMITTED'));
				}else{
                    // Attempt to change the state of the records.
                    if (!$table->feature($pk, $value)) {
                        $this->setError($table->getError());
                        return false;
                    }
                    $successful++;
                }
			}
		}
        return $successful;
	}
    
    function deleteCompany($pks)
	{
		// Initialise variables.
		$table	= $this->getTable();
		$pks	= (array) $pks;
        $ipauth = new ipropertyHelperAuth();

		$successful = 0;
        // Access checks.
		foreach ($pks as $i => $pk) {
			if ($table->load($pk)) {
				if (!$ipauth->canDeleteCompany($pk)){
					// Prune items that you can't change.
					unset($pks[$i]);
                    JError::raiseWarning(403, JText::_('JLIB_APPLICATION_ERROR_EDITSTATE_NOT_PERMITTED'));
				}else{
                    $successful++;
                }
			}
		}

		// Attempt to change the state of the records.
		if (!$table->delete($pks)) {
			$this->setError($table->getError());
			return false;
		}

		return $successful;
	}
}

?>