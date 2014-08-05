<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.controller');
jimport('joomla.log.log');

class IpropertyControllerAjax extends JController
{
	protected $text_prefix = 'COM_IPROPERTY';
	
	public function saveTenants()
	{
		
		// Check for request forgeries
        JRequest::checkToken() or die( 'Invalid Token' );
        
        $prop_id = JRequest::getInt('prop_id');
		$tenants_data_str = JRequest::getString('tenants_data');
		$tenants_data = json_decode($tenants_data_str, true);
        
		if(count($tenants_data) == 0)
		{
			return 'no rows to save';
		}
		
		$db = JFactory::getDbo();
		
		for($i=0; $i<count($tenants_data); $i++)
		{
			
			$id = intval($tenants_data[$i]['id']);
			$space_id = intval($tenants_data[$i]['space_id']);
			$tenant = $tenants_data[$i]['tenant'];
			//$available = intval($tenants_data[$i]['available']);
			$available = 1;
			
			if($id > 0)
			{
				
				// update row
				$query = $db->getQuery(true);
				$query->update('#__iproperty_tenants')
		        	->set('space_id = '.$space_id)
		        	->set('tenant = ' . $db->Quote($tenant))
		        	->set('available = ' . $available)
		        	->where('id = '.$id);
		        
		        $db->setQuery($query);
		        
		        if(!$db->execute())
		        {
		        	echo 'sql update error ' . $id . ' ';		        	
		        }
		        
			}
			else
			{
				
				// insert row
				$query = $db->getQuery(true);
				$query->insert('#__iproperty_tenants')
					->set('prop_id = ' . $prop_id)
					->set('space_id = ' . $space_id)
					->set('tenant = ' . $db->Quote($tenant))
		        	->set('available = ' . $available);
		        
		        $db->setQuery($query);
		        if(!$db->execute())
		        {
		        	echo 'sql insert error';
		        	
		        }
		        
			}
			
		}
		
		echo 'result';
		
	}
	
	public function removeTenant()
	{
		// Check for request forgeries
        JRequest::checkToken() or die( 'Invalid Token' );
        $tenant_id = JRequest::getInt('tenant_id');
		
        $result = 'result. ';
        
        if($tenant_id > 0)
        {
	        $db = JFactory::getDbo();
	        $query = $db->getQuery(true);
	        $query->delete('#__iproperty_tenants')
	        	->where('id = ' . $tenant_id);
	        
	       	$db->setQuery($query, 0, 1);
	       	
	       	$result .= 'deleting tenant '.$tenant_id.' . ';
		}
       	
        if(!$db->execute())
        {
       		$result .= 'delete error';
        }
        
       	return $result;
		
	}
	
	public function getTenantsTableData()
	{
		// Check for request forgeries
        JRequest::checkToken() or die( 'Invalid Token' );
        $prop_id = JRequest::getInt('prop_id');
		
        $db = JFactory::getDbo();
        
        $query_tenants = $db->getQuery(true);
        $query_tenants->select('*')
        	->from('#__iproperty_tenants')
        	->where('prop_id = '.$prop_id);
        
        $query_spaces = $db->getQuery(true);
        $query_spaces->select('*')
        	->from('#__iproperty_spaces')
        	->where('prop_id = '.$prop_id);
        
        $query = $db->getQuery(true);
        $query->select('t.*, s.space_id2')
        	->from('('.$query_tenants.') AS t LEFT JOIN ('.$query_spaces.') AS s ON (t.space_id=s.id)')
        	->order('s.space_id2 ASC');
        
       	$db->setQuery($query);
       	
        $result['tenants'] = $db->loadAssocList();
        
        // get all spaces for property
       	$db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*')
        	->from('#__iproperty_spaces')
        	->where('prop_id = '.$prop_id)
        	->order('space_id2 ASC');
        
       	$db->setQuery($query);
        
       	$spaces = $db->loadObjectList();
       	
       	$result['spaces_selector'][0] = 'None';
       	
       	for($i=0; $i<count($spaces); $i++)
       	{
       		$space_item = $spaces[$i];
       		
       		$result['spaces_selector'][$space_item->id] = $space_item->space_id2 . ' (' . number_format($space_item->space_sqft) . ' sq. ft.)';
       		
       	}
       	
       	echo json_encode($result);
	}
	
	
	
	public function saveSpaces()
	{
		
		// Check for request forgeries
        JRequest::checkToken() or die( 'Invalid Token' );
        
        $prop_id = JRequest::getInt('prop_id');
		$spaces_data_str = JRequest::getString('spaces_data');
		$spaces_data = json_decode($spaces_data_str, true);
        
		if(count($spaces_data) == 0)
		{
			return 'no rows to save';
		}
		
		$db = JFactory::getDbo();
		
		
		// checking entered statistics
		for($i=0; $i<count($spaces_data); $i++)
		{
			
			$id = intval($spaces_data[$i]['id']);
			$space_id2 = strtoupper( $spaces_data[$i]['space_id2'] );
			$space_name = $spaces_data[$i]['space_name'];
			$space_sqft = $spaces_data[$i]['space_sqft'];
			
			if($id > 0)
			{
				// update row
				$query = $db->getQuery(true);
				$query->update('#__iproperty_spaces')
		        	->set('space_id2 = ' . $db->Quote($space_id2))
		        	->set('space_name = ' . $db->Quote($space_name))
		        	->set('space_sqft = ' . $space_sqft);
		        $query->where('id = '.$id);
		        
		        $db->setQuery($query);
		        
		        if(!$db->execute())
		        {
		        	echo 'sql update error ' . $id . ' ';
		        	
		        }
			}
			else
			{
				
				// insert row
				$query = $db->getQuery(true);
				$query->insert('#__iproperty_spaces')
					->set('prop_id = ' . $prop_id)
					->set('space_id2 = ' . $db->Quote($space_id2))
		        	->set('space_name = ' . $db->Quote($space_name))
		        	->set('space_sqft = ' . $space_sqft);
		        
		        $db->setQuery($query);
		        if(!$db->execute())
		        {
		        	echo 'sql insert error';
		        	
		        }
			}
			
		}
		
		echo 'result';
	}
	
	public function getSpacesTableData()
	{
		// Check for request forgeries
        JRequest::checkToken() or die( 'Invalid Token' );
        $prop_id = JRequest::getInt('prop_id');
		
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*')
        	->from('#__iproperty_spaces')
        	->where('prop_id = ' . $prop_id)
        	->order('space_id2 ASC');
        
       	$db->setQuery($query);
        $result = $db->loadAssocList();
       	
       	echo json_encode($result);
	}
	
	public function removeSpace()
	{
		// Check for request forgeries
        JRequest::checkToken() or die( 'Invalid Token' );
        $space_id = JRequest::getInt('space_id');
		
        $result = 'result. ';
        
        if($space_id > 0)
        {
	        $db = JFactory::getDbo();
	        $query = $db->getQuery(true);
	        $query->delete('#__iproperty_spaces')
	        	->where('id = ' . $space_id);
	        
	       	$db->setQuery($query, 0, 1);
	       	
	       	$result .= 'deleting space '.$space_id.' . ';
		}
       	
        if(!$db->execute())
        {
       		$result .= 'delete error';
        }
        
       	return $result;
	}
	
	public function saveDemographics()
	{
		
		// Check for request forgeries
        JRequest::checkToken() or die( 'Invalid Token' );
        
        $prop_id = JRequest::getInt('prop_id');
		$stat_data_str = JRequest::getString('stat_data');
		$stat_data = json_decode($stat_data_str, true);
        
		if(count($stat_data) == 0)
		{
			return 'no statistics to save';
		}
		
		$db = JFactory::getDbo();
		
		
		// checking entered statistics
		for($i=0; $i<count($stat_data); $i++)
		{
			
			$id = intval($stat_data[$i]['id']);
			$stat_id = intval($stat_data[$i]['stat_id']);
			$miles1_value = floatval($stat_data[$i]['miles1_value']);
			$miles2_value = floatval($stat_data[$i]['miles2_value']);
			$miles3_value = floatval($stat_data[$i]['miles3_value']);
			
			if($id > 0)
			{
				
				// update row
				$query = $db->getQuery(true);
				$query->update('#__iproperty_demographics')
		        	->set('miles1_value = ' . $miles1_value)
		        	->set('miles2_value = ' . $miles2_value)
		        	->set('miles3_value = ' . $miles3_value);
		        $query->where('id = '.$id);
		        
		        $db->setQuery($query);
		        
		        if(!$db->execute())
		        {
		        	echo 'sql update error ' . $id . ' ';
		        	
		        }
			}
			else
			{
				
				// insert row
				$query = $db->getQuery(true);
				$query->insert('#__iproperty_demographics')
					->set('prop_id = ' . $prop_id)
					->set('stat_id = ' . $stat_id)
		        	->set('miles1_value = ' . $miles1_value)
		        	->set('miles2_value = ' . $miles2_value)
		        	->set('miles3_value = ' . $miles3_value);
		        
		        $db->setQuery($query);
		        if(!$db->execute())
		        {
		        	echo 'sql insert error';
		        	
		        }
			}
			
		}
		
		echo 'result';
		
	}
	
	function getDemographicsTableData()
	{
		// Check for request forgeries
        JRequest::checkToken() or die( 'Invalid Token' );
        $prop_id = JRequest::getInt('prop_id');
        
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*')
        	->from('#__iproperty_demographics')
        	->where('prop_id = ' . $prop_id)
        	->group('stat_id')
        	->order('stat_id ASC');
        
        $query2 = $db->getQuery(true);
        $query2->select('IFNULL(d.id, 0) as id, IFNULL(d.miles1_value, 0) as miles1_value, IFNULL(d.miles2_value, 0) as miles2_value, IFNULL(d.miles3_value, 0) as miles3_value, ds.id as stat_id, ds.stat_name, ds.stat_value_type')
        	->from('('.$query->__toString().') as d RIGHT JOIN #__iproperty_demographics_stats as ds ON d.stat_id = ds.id ')
        	->order('ds.order ASC');
        
        $db->setQuery($query2);
        $result = $db->loadAssocList();
        
        $result2 = array();
        
        foreach($result as $row)
        {
          if($row['stat_value_type'] == 'currency')
          {
            $row['stat_name'] .= ' ($)';
          }
          else if($row['stat_value_type'] == 'percent')
          {
            $row['stat_name'] .= ' (%)';
          }
          
          if($row['stat_value_type'] == 'percent')
          {
            
          }
          else
          {
            $row['miles1_value'] = intval($row['miles1_value']);
            $row['miles2_value'] = intval($row['miles2_value']);
            $row['miles3_value'] = intval($row['miles3_value']);
          }
          $result2[] = $row;
        }
        
        echo json_encode($result2);
	}
	
    public function resetHits()
    {
        // Check for request forgeries
        JRequest::checkToken() or die( 'Invalid Token' );
        $prop_id = JRequest::getInt('prop_id');

        $db     = JFactory::getDbo();
        $query  = 'UPDATE #__iproperty SET hits = 0 WHERE id = '.(int)$prop_id.' LIMIT 1';
        $db->setQuery($query);

        if($db->Query()){
            echo JText::_('COM_IPROPERTY_COUNTER_RESET');
        }else{
            return false;
        }
    }

    public function checkUserAgent()
    {
        // Check for request forgeries
        JRequest::checkToken() or die( 'Invalid Token' );
        $user_id = JRequest::getInt('user_id');
        $agent_id = JRequest::getInt('agent_id', 0);

        if(!$user_id) return false;

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select('id');
        $query->from('#__iproperty_agents');
        $query->where('user_id = '.(int)$user_id);
        $query->where('id != '.(int)$agent_id);
        $db->setQuery($query);

        echo $db->loadResult();
    }

    function displayStypes()
    {
        JRequest::checkToken('get') or die( 'Invalid Token' );
        JHTML::_('behavior.tooltip');
        $model = $this->getModel('settings');

        $i = 0;
        $html = '';
        if ($stypes = $model->getStypes()) {
            $k = 0;
            for($i = 0, $n = count( $stypes ); $i < $n; $i++){
                $stype = $stypes[$i];
                $pchecked = ($stype->state) ? ' checked="checked"' : '';
                $bchecked = ($stype->show_banner) ? ' checked="checked"' : '';

                $html .= '
                <tr class="stype_row row'.$k.'">
                    <td><input type="hidden" id="ipstype" value="'.$stype->id.'" class="s'.$i.'"/><input type="text" id="name" class="inputbox s'.$i.'" value="'.JText::_($stype->name).'" style="width: 100%;" /></td>
                    <td><input type="text" id="banner_image" class="inputbox s'.$i.'" value="'.$stype->banner_image.'" style="width: 100%;" /></td>
                    <td><input type="text" id="banner_color" class="inputbox s'.$i.'" value="'.$stype->banner_color.'" style="width: 100%;" /></td>
                    <td align="center"><input type="checkbox" id="state" class="inputbox s'.$i.'" value="1"'.$pchecked.' /></td>
                    <td align="center"><input type="checkbox" id="show_banner" class="inputbox s'.$i.'" value="1"'.$bchecked.' /></td>
                    <td align="center">'.$stype->id.'</td>
                    <td><a href="javascript:void(0);" onclick="if(confirm(\''.JText::_( 'COM_IPROPERTY_CONFIRM_DELETE' ).'\')){deleteStype('.$stype->id.');}">delete</a></td>
                </tr>';
                $k = 1 - $k;
            }
        }else{
            $html .= '<tr><td class="center" colspan="7">'.JText::_('COM_IPROPERTY_NO_RESULTS').'</td></tr>';
        }
        $html .= '
            <tr><td colspan="7">&nbsp;</td></tr>
            <tr><td colspan="7" style="background: #0093D4 !important; color: #fff !important;"><b>Add new:</b></td></tr>
            <tr class="stype_row">
                <td><input type="hidden" id="ipstype" value="new" class="s'.$i.'"/><input type="text" id="name" class="inputbox s'.$i.'" value="" style="width: 100%;" /></td>
                <td><input type="text" id="banner_image" class="inputbox s'.$i.'" value="" style="width: 100%;" /></td>
                <td><input type="text" id="banner_color" class="inputbox s'.$i.'" value="" style="width: 100%;" /></td>
                <td align="center"><input type="checkbox" id="state" class="inputbox s'.$i.'" value="1" checked="checked" /></td>
                <td align="center"><input type="checkbox" id="showbanner" class="inputbox s'.$i.'" value="1" /></td>
                <td colspan="2"><input type="button" onclick="saveStypes(); return false;" value="'.JText::_( 'COM_IPROPERTY_ADD' ).'" /></td>
            </tr>';
        echo $html;
    }

    function saveStypes()
    {
        JRequest::checkToken() or die( 'Invalid Token' );
        $data  = JRequest::get( 'post' );
        if(!$stypes = json_decode($data['stypes'])){
            //die( 'Invalid Data' );
            echo '
                <dl id="system-message">
                    <dt class="error">Error</dt>
                    <dd class="error message">
                        <ul>
                            <li>Invalid Data: '.$data['stypes'].'</li>
                        </ul>
                    </dd>
                </dl>';
            return;
        }

        $model = $this->getModel('settings');
        if($model->saveStypes( $stypes )){
            echo '
                <dl id="system-message">
                    <dt class="message">Message</dt>
                    <dd class="message message">
                        <ul>
                            <li>Success</li>
                        </ul>
                    </dd>
                </dl>';
        }else{
            echo '
                <dl id="system-message">
                    <dt class="error">Error</dt>
                    <dd class="error message">
                        <ul>
                            <li>'.$model->getError().'</li>
                        </ul>
                    </dd>
                </dl>';
        }
    }

    function deleteStype()
    {
        JRequest::checkToken() or die( 'Invalid Token' );
        $stypeid    = JRequest::getInt('id');
        $model      = $this->getModel('settings');
        if($model->deleteStype($stypeid)){
            echo '
                <dl id="system-message">
                    <dt class="message">Message</dt>
                    <dd class="message message">
                        <ul>
                            <li>Success</li>
                        </ul>
                    </dd>
                </dl>';
        }else{
            echo '
                <dl id="system-message">
                    <dt class="error">Error</dt>
                    <dd class="error message">
                        <ul>
                            <li>'.$model->getError().'</li>
                        </ul>
                    </dd>
                </dl>';
        }
    }




    /**********************
     * Gallery functions
     **********************/

    function ajaxLoadGallery()
    {
		/**
		* Pulls images from IP images table
		*
		* @param integer $propid ID of property
		* @param integer $own Whether we want only our own images or all avail
		* @param integer $limitstart Starting record id
		* @param integer $limit Max rows to return
		* @param string $token Joomla token
		* @return JSON encoded image data
		*/
		// Check for request forgeries
		JRequest::checkToken('get') or die( 'Invalid Token' );

		$propid 	= JRequest::getInt('propid');
		$own		= JRequest::getInt('own');
		$limitstart	= JRequest::getInt('limitstart');
		$limit		= JRequest::getInt('limit');

		if (!$propid ){
			JError::raiseError(500, JText::_( 'NO PROPID SELECTED' ) );
		}
		$model = $this->getModel('gallery');
		echo json_encode($model->loadGallery($propid, $own, $limitstart, $limit));
	}

    function ajaxLoadFiles()
    {
		/**
		* Pulls files from IP images table
		*
		* @param integer $propid ID of property
		* @param string $token Joomla token
		* @return JSON encoded image data
		*/
		// Check for request forgeries
		JRequest::checkToken('get') or die( 'Invalid Token' );

        $propid 	= JRequest::getInt('propid');
        $own		= JRequest::getBool('own');

		if (!$propid ){
			JError::raiseError(500, JText::_( 'NO PROPID SELECTED' ) );
		}
		$model = $this->getModel('gallery');
		echo json_encode($model->loadFiles($propid, $own));
	}
	
	function ajaxDelete()
    {
		/**
		* Deleted image from IP images table, and deleted image file if it's not in use with other listing
		*
		* @param integer $rowid ID of image
		* @param string $token Joomla token
		* @return true or false
		*/
		// Check for request forgeries
		JRequest::checkToken('get') or die( 'Invalid Token' );
		
		$rowid		= JRequest::getInt('imgid');
		
		if (!$rowid ){
			JError::raiseError(500, JText::_( 'NO IMAGE ID SELECTED' ) );
		}
		$model = $this->getModel('gallery');
		echo $model->delete($rowid);	
	}
	
	function ajaxAdd()
    {
		/**
		* Add existing image to IP listing
		*
		* @param integer $propid ID of property
		* @param integer $rowid ID of image
		* @param string $token Joomla token
		* @return true or false
		*/
		// Check for request forgeries
		JRequest::checkToken('get') or die( 'Invalid Token' );
		
		$propid		= JRequest::getInt('propid');
		$rowid		= JRequest::getInt('imgid');
		
		if (!$propid ){
			JError::raiseError(500, JText::_( 'NO LISTING ID SELECTED' ) );
		}
		$model = $this->getModel('gallery');
		echo json_encode($model->ajaxAddImage($propid, $rowid));	
	}

	function ajaxSort()
    {
		/**
		* Save image order/titles/desc for listing
		*
		* @param string $data JSON encoded sort data for property
		* @param string $token Joomla token
		* @return true or false
		*/
		// Check for request forgeries
		JRequest::checkToken('get') or die( 'Invalid Token' );
		
		$data		= JRequest::getVar('data');
		$data		= json_decode($data);
		
		if (!$data ){
			JError::raiseError(500, JText::_( 'NO SORT DATA INCLUDED' ) );
		}
		$model = $this->getModel('gallery');
		echo $model->ajaxSort($data);
	}
	
	function ajaxUploadRemote()
    {
		/**
		* Save remote image for listing
		*
		* @param int $propid ID of property
		* @param string $path Remote file location
		* @param string $token Joomla token
		* @return true or false
		*/
		// Check for request forgeries
		JRequest::checkToken('get') or die( 'Invalid Token' );
		
		$propid		= JRequest::getInt('propid');
		$path		= JRequest::getString('path');
		
		if (!$propid ){
			JError::raiseError(500, JText::_( 'NO PROPID INCLUDED' ) );
		}
		$model = $this->getModel('gallery');
		echo json_encode($model->uploadRemote($propid, $path));
	}	

    function ajaxUpload()
    {
		/**
		* Upload image for listing, resize, rename, move
		*
		* @param int $propid ID of property
		* @param string $file Local file info array
		* @param string $token Joomla token
		* @return success or failure message
		*/
		// Check for request forgeries
		JRequest::checkToken('get') or die( 'Invalid Token' );

		$propid		= JRequest::getInt('propid');
		$image_type = JRequest::getString('image_type', 'property');
		$files		= JRequest::get('FILES'); // this should be an array
        $model      = $this->getModel('gallery');
		$result     = array();
		
        if (!isset($_FILES['file']['tmp_name']) && !is_uploaded_file($_FILES['file']['tmp_name'])) {
            $result[] = array( 'status' => 0,
                               'fname' => $_FILES['file']['tmp_name'],
                               'message' => 'INVALID UPLOAD- NO FILES FOUND'
                                );
            echo json_encode($result);
            die(JText::_( 'INVALID UPLOAD' ));
        }

		if (!$propid || !count($files)){
			//JError::raiseError(500, JText::_( 'NO PROPID INCLUDED OR NO FILE ARRAY FOUND' ) );
            $result[] = array( 'status' => 0,
                               'fname' => $_FILES['file']['tmp_name'],
                               'message' => 'NO PROPID INCLUDED OR NO FILE ARRAY FOUND'
                                );
            echo json_encode($result);
            die(JText::_( 'NO PROPID INCLUDED OR NO FILE ARRAY FOUND' ));
		}
		
		foreach($files as $file){
            $result[]     = $model->uploadPropertyIMG($file, $propid, $image_type);
        }
        
        echo json_encode($result);
	}

    /**********************
     * Autocomplete function
     **********************/
		
	function ajaxAutocomplete()
    {
		/**
		* Get filtered list of DB values
		*
		* @param string $search Search string
		* @param string $field BD field to filter
		* @param string $token Joomla token
		* @return json_encoded list of values
		*/
		// Check for request forgeries
		JRequest::checkToken('get') or die( 'Invalid Token' );
		
		$search		= JRequest::getString('value');
		$field		= JRequest::getString('field');
		
		$db         = JFactory::getDBO();
		
		$query 		= $db->getQuery(true);
		$query->select('DISTINCT '.$db->nameQuote($field))
			->from('#__iproperty')
			->where($db->nameQuote($field).' LIKE '.$db->Quote($search.'%'))
			->groupby($db->nameQuote($field));

		$db->setQuery($query);
		$data = $db->loadObjectList();
		
		echo json_encode($data);
	}	
}
?>
