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

class IpropertyControllerAjax extends JController
{
	protected $text_prefix = 'COM_IPROPERTY';
    
	public function googleMapAjaxSearch()
	{
		JRequest::checkToken('get') or die( 'Invalid Token!' );
        
		$model = $this->getModel('foundproperties');
		
		$properties = $model->getGoogleMapProperties();
        $properties[0]->totalcount = count($properties);
		
		echo json_encode($properties);
	}
	
	public function ajaxSearch2()
	{
		JRequest::checkToken() or die( 'Invalid Token!' );
		
		//$result = array('abc' => 'helloabc', '111');
		$result['result'] = true;
		
		$return_states = JRequest::getBool('return_states', false);
		$return_cities = JRequest::getBool('return_cities', false);
		
		$model = $this->getModel('foundproperties');
		
		if($return_states)
		{
			$result['states'] = $model->getAvailStates();
		}
		if($return_cities)
		{
			$result['cities'] = $model->getAvailCities();
		}
		
		//$result['space_available'] = $model->getSpaceAvailable();
		
		echo json_encode($result);
	}
	
    public function ajaxSearch()
    {
        JRequest::checkToken('get') or die( 'Invalid Token!' );
        $search_vars    = JRequest::get( 'GET' );
        $itemid         = $search_vars['Itemid'];

        $session = JFactory::getSession();
        foreach($search_vars as $key=>$value){
            $session->set($key.$itemid, $value);
        }
        
        if (isset($search_vars['geopoint'])){
            $point = json_decode($search_vars['geopoint']);        
        } else {
            $point = false;
        } 

        $model = $this->getModel('advsearch');
        $properties = $model->getdata($point);
        $totalprops = $model->gettotal();
        $properties[0]->totalcount = $totalprops;

        if(ipropertyHTML::isMobileRequest()){
            foreach($properties as $p){
                $p->description = strip_tags($p->description);
                $p->thumb = htmlentities($p->thumb);
                $p->caticons = array('test', 'test2');
                $p->banner = 'banner here';              
            }
        }

        echo json_encode($properties);
        return;
    }
    
    public function alterObject()
    {
        JRequest::checkToken() or jexit('Invalid Token');
        $vars   = JRequest::get( 'POST' );
        $id     = (int) $vars['id']; // id of object to change
        $type   = $vars['type']; // type of object to change
        $action = $vars['action']; // publish, feature, delete
        
        // if deleting - call model and delete appropriate object
        if($action == 'delete'){
            switch($type){
                case 'agent':
                    $model = $this->getModel('agentform');
                    $action = 'deleteAgent';
                break;
                case 'company':
                    $model = $this->getModel('companyform');
                    $action = 'deleteCompany';
                break;
                case 'property':
                    $model = $this->getModel('propform');
                    $action = 'deleteProp';
                break;
            }
            
            if($model->$action(array($id))){
                echo json_encode(true);
            }else{
                echo json_encode($model->getError());
            }
            return;
        }
        
        if (!$id || !$type) {
            echo json_encode(JText::_('INVALID ID OR TYPE PASSED'));
            return false;
        }
        
        $model  = $this->getModel('manage');
        if($model->alterObject($id, $type, $action)){
            echo json_encode(true);
        }else{
            echo json_encode($model->getError());
        }
    }
    
    public function deleteSaved()
    {
        JRequest::checkToken() or die( 'Invalid Token!' );
        
        $post   = JRequest::get('post');
        $id     = $post['editid'];
        
        if (!$id) {
            echo 'INVALID ID OR TYPE PASSED';
            return false;
        }

        $model = $this->getModel('ipuser');
        if($model->deleteSaved($id)){
            echo json_encode('true');
        }else{
            return false;
        }
    }
    
    public function filterCity()
    {
        JRequest::checkToken() or jexit('Invalid Token');
        $width = JRequest::getInt('width');
        $state = JRequest::getInt('ipstate');

        echo json_encode(ipropertyHTML::city_select_list('city','class="inputbox" style="width: '.$width.'px;"', '', true, $state));
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
    
    public function checkUserEmail()
    {
        JRequest::checkToken() or die( 'Invalid Token' );
        $email = JRequest::getString('email');
        $agent_id = JRequest::getInt('agent_id', 0);
        if(!$email) return false;

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select('id');
        $query->from('#__iproperty_agents');
        $query->where('email = '.$db->Quote($email));
        $query->where('id != '.(int)$agent_id);
        $db->setQuery($query);

        echo $db->loadResult();
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
            $result[]     = $model->uploadIMG($file, $propid);
        }
        echo json_encode($result); 
	} 
    
    function ajaxIconUpload()
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
 
		$folder		= JRequest::getVar('target');
		$files		= JRequest::get('FILES'); // this should be an array
        $id         = JRequest::getInt('id');
		$status     = array();

        if (!isset($_FILES['file']['tmp_name']) && !is_uploaded_file($_FILES['file']['tmp_name'])) {
            $error = 'Invalid Upload';
            echo $error;
            die(JText::_( 'INVALID UPLOAD' ));
        } 
        
		if (!$id || !count($files)){
			//JError::raiseError(500, JText::_( 'NO ID INCLUDED OR NO FILE ARRAY FOUND' ) );
            $status[0] = array( 'status' => 0,
                                'id' => $id,
                                'result' => 'id or no file found'
                                );
            echo json_encode($files); 
            die(JText::_( 'NO ID INCLUDED OR NO FILE ARRAY FOUND' ));
		}
        
        foreach($files as $file){
            $fstatus    = array();
            $model      = $this->getModel('manage');
            $result     = $model->iconUpload($file, $id, $folder);

            if(!$result){
                $fstatus['status']  = 0;
                $fstatus['fname']   = $file['tmp_name'];
                $fstatus['result']  = $folder;
                $fstatus['id']      = $id;
            } else {
                $fstatus['status']  = 1;
                $fstatus['fname']   = $file['tmp_name'];
                $fstatus['result']  = $result;
            }
            $status[] = $fstatus;
        }
        echo json_encode($status); 
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
