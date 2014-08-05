<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.model' );
//jimport( 'joomla.filesystem.file' );
//jimport( 'joomla.filesystem.folder' );

class IpropertyModelGallery extends JModel
{
    protected $text_prefix = 'COM_IPROPERTY';
    //var $_pagination = null;
    
    public function getTable($type = 'Image', $prefix = 'IpropertyTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}   

    public function loadGallery($propid = false, $own = false, $limitstart = 0, $limit = 50)
    {
        $db     = JFactory::getDbo();
        $ipauth = new ipropertyHelperAuth();

        if($own){ //images belonging to this listing
            $query = $db->getQuery(true);
            $query->select('SQL_CALC_FOUND_ROWS *')
                    ->from('#__iproperty_images')
                    ->where('propid = '.(int)$propid)
                    ->where('(type = ".jpg" OR type = ".jpeg" OR type = ".gif" OR type = ".png")')
                    ->group('fname')
                    ->order('id ASC');
        }else{        
            if(!$ipauth->getAdmin()) {
                switch($ipauth->getAuthLevel()){
                    case 1: // only company images
                        $query = $db->getQuery(true);
                        $query->select('SQL_CALC_FOUND_ROWS *')
                                ->from('#__iproperty_images')
                                ->where('propid != '.(int)$propid)
                                ->where('propid IN (SELECT id FROM #__iproperty WHERE listing_office = '.(int)$ipauth->getUagentCid().')')
                                ->where('(type = ".jpg" OR type = ".jpeg" OR type = ".gif" OR type = ".png")')
                                ->group('fname')
                                ->order('id ASC');
                        break;
                    case 2: // only the agents own images
                        $query = $db->getQuery(true);
                        $query->select('SQL_CALC_FOUND_ROWS *')
                                ->from('#__iproperty_images')
                                ->where('propid != '.(int)$propid)
                                ->where('propid IN (SELECT prop_id FROM #__iproperty_agentmid WHERE agent_id = '.(int)$ipauth->getUagentId().' GROUP BY prop_id)')
                                ->where('(type = ".jpg" OR type = ".jpeg" OR type = ".gif" OR type = ".png")')
                                ->group('fname')
                                ->order('id ASC');
                        break;
                }
            }else{
                $query = $db->getQuery(true);
                $query->select('SQL_CALC_FOUND_ROWS *')
                        ->from('#__iproperty_images')
                        ->where('propid != '.(int)$propid)
                        ->where('(type = ".jpg" OR type = ".jpeg" OR type = ".gif" OR type = ".png")')
                        ->group('fname')
                        ->order('id ASC');
            }
        }
		$db->setQuery($query, $limitstart, $limit);		
        $result = $db->loadObjectList();
		
        // get the total # of rows pulled
		$db->setQuery('SELECT FOUND_ROWS();');
        array_unshift($result, $this->_db->loadResult());
        return $result;
  	}

	public function loadFiles($propid = null, $own = false) 
    {
        $db     = JFactory::getDBO();
        $ipauth = new ipropertyHelperAuth();

        if($own){
            $query = $db->getQuery(true);
            $query->select('SQL_CALC_FOUND_ROWS *')
                    ->from('#__iproperty_images')
                    ->where('propid = '.(int)$propid)
                    ->where('(type != ".jpg" AND type != ".jpeg" AND type != ".gif" AND type != ".png")')
                    ->order('type, ordering ASC');
        } else {
            if(!$ipauth->getAdmin()) {
                switch($ipauth->getAuthLevel()){
                    case 1: // only company docs
                        $query->select('SQL_CALC_FOUND_ROWS *')
                                ->from('#__iproperty_images')
                                ->where('propid != '.(int)$propid)
                                ->where('propid IN (SELECT id FROM #__iproperty WHERE listing_office = '.(int)$ipauth->getUagentCid().')')
                                ->where('(type != ".jpg" AND type != ".jpeg" AND type != ".gif" AND type != ".png")')
                                ->group('fname')
                                ->order('ordering ASC');
                        break;
                    case 2: // only the agents own docs
                        $query = $db->getQuery(true);
                        $query->select('SQL_CALC_FOUND_ROWS *')
                                ->from('#__iproperty_images')
                                ->where('propid != '.(int)$propid)
                                ->where('propid IN (SELECT prop_id FROM #__iproperty_agentmid WHERE agent_id = '.(int)$ipauth->getUagentId().' GROUP BY prop_id)')
                                ->where('(type != ".jpg" AND type != ".jpeg" AND type != ".gif" AND type != ".png")')
                                ->group('fname')
                                ->order('ordering ASC');
                        break;
                }
            }else{
                $query = $db->getQuery(true);
                $query->select('SQL_CALC_FOUND_ROWS *')
                        ->from('#__iproperty_images')
                        ->where('propid != '.(int)$propid)
                        ->where('(type != ".jpg" AND type != ".jpeg" AND type != ".gif" AND type != ".png")')
                        ->group('fname')
                        ->order('ordering ASC');
            }
        }

        $db->setQuery($query);		
        $result = $db->loadObjectList();
        
        // get the total # of rows pulled
        $db->setQuery('SELECT FOUND_ROWS();');
        array_unshift($result, $this->_db->loadResult());
        return $result;
  	}

    public function resizeIMG($is_thmb, $src_file, $dest_file, $width, $height, $prop, $quality)
    {
        $settings   = ipropertyAdmin::config();
        $path       = JPATH_SITE;
        $imagetype  = array( 1 => 'GIF', 2 => 'JPG', 3 => 'PNG' );
        $imginfo    = getimagesize($src_file);
        if ($imginfo == null) {
            $error = JText::_( 'COM_IPROPERTY_NO_FILE_FOUND' );
            return $error;
        }

        $imginfo[2] = $imagetype[$imginfo[2]];

        // GD can only handle JPG & PNG images
        if ($imginfo[2] != 'JPG' && $imginfo[2] != 'GIF' &&  $imginfo[2] != 'PNG' ) {
            $error = "GDERROR1";
            return $error;
        }

        // source height/width
        $srcWidth = $imginfo[0];
        $srcHeight = $imginfo[1];

        // if $prop, maintain proportions
        if($prop == 1) {
            $wantratio= $height ? $width/$height : 0;
            $haveratio= $srcWidth/$srcHeight;
            if($wantratio<$haveratio){
                if($srcWidth > $srcHeight){
                    $destWidth= $width;
                    $destHeight= $width/$haveratio;
                } else {
                    $destHeight= $width;
                    $destWidth= $width*$haveratio;
                }
            } else {
                $destWidth= $height*$haveratio;
                $destHeight= $height;
            }
        } else {
            $destWidth = (int)($width);
            $destHeight = (int)($height);
        }

    	if (!function_exists('imagecreatefromjpeg')) {
            return JText::_('GDERROR2');
    	}
    	if ($imginfo[2] == 'JPG'){
            $src_img = imagecreatefromjpeg($src_file);
        } else if($imginfo[2] == 'GIF') {
            $src_img = imagecreatefromgif($src_file);
        } else if($imginfo[2] == 'PNG'){
            $src_img = imagecreatefrompng($src_file);
        }

    	if (!$src_img) return JText::_('GDERROR3');

    	if(function_exists("imagecreatetruecolor")){
            $dst_img = imagecreatetruecolor($destWidth, $destHeight);
		} else {
		   	$dst_img = imagecreate($destWidth, $destHeight);
        }

		if(function_exists("imagecopyresampled")){
			imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, (int)$destWidth, (int)$destHeight, $srcWidth, $srcHeight);
		} else {
			imagecopyresized($dst_img, $src_img, 0, 0, 0, 0,(int) $destWidth, (int)$destHeight, $srcWidth, $srcHeight);
        }

		if(!$is_thmb && $settings->watermark){
            /* drop shadow watermark thanks to hkingman */
            $wmstr = $settings->watermark_text;
            $wmstr = "(c)" . date("Y") . " " . $wmstr;
            $ftcolor2 = imagecolorallocate($dst_img,239,239,239);
            $ftcolor = imagecolorallocate($dst_img,15,15,15);
            // imagestring ($dst_img, 2,10, $destHeight-20, $wmstr, $ftcolor);
            imagestring ($dst_img, 2,11, $destHeight-20, $wmstr, $ftcolor);
            imagestring ($dst_img, 2,10, $destHeight-21, $wmstr, $ftcolor2);
    	}
		imagejpeg($dst_img, $dest_file, $quality);
    	imagedestroy($src_img);
    	imagedestroy($dst_img);

  		// Set mode of uploaded picture
  		chmod($dest_file, octdec('644'));

  		// We check that the image is valid
  		$imginfo = getimagesize($dest_file);
  		if ($imginfo == null){
    		return JText::_( 'COM_IPROPERTY_IMAGE_INFO_NOT_RETURNED' );
  		}else{
            //return true;
        }
  	}

	// File Upload
	// small sizes of images will be created...
    public function uploadPropertyIMG($file, $propid, $image_type)
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
								'image/jpeg',
								'image/gif',
								'image/png',
								'application/pdf'
								);

            $db         = JFactory::getDBO();
            $settings   = ipropertyAdmin::config();
            $path       = JPATH_SITE;
            $user       = JFactory::getUser();
			$ipauth 	= new ipropertyHelperAuth();
			$coparams	= $ipauth->getCompanyParams();
			$maximgs	= $coparams->get('maximgs', 0);

            // is this the first image of this object?
            $query = $db->getQuery(true);
            $query->select('count(id)')
                    ->from('#__iproperty_images')
                    ->where('propid = '.(int)$propid);
            
            $db->setQuery($query);
            $imgcount = $db->loadResult();
			$imglimit = $imgcount + 1;
			
			
            if(	($imglimit > $settings->maximgs && $settings->maximgs!=0) || ($imglimit > $maximgs && $maximgs!=0) ){
                $result['message'] = 'overlimit';
                return $result;
            }
            $src_file	= (isset($file['tmp_name']) ? $file['tmp_name'] : "");
            
            $result['fname'] = $src_file;

            // check individual settings
            $cfg = array();
            $cfg['imgpath']			= $settings->imgpath;
            $cfg['maximgsize'] 	    = $settings->maximgsize;

            $cfg['imgwidth']		= $settings->imgwidth;
            $cfg['imgheight']		= $settings->imgheight;
            $cfg['imageprtn']		= $settings->imgproportion;
            $cfg['imgquality']		= $settings->imgquality;

            $cfg['createTb']		= 1;
            $cfg['thumbwidth']      = $settings->thumbwidth;
            $cfg['thumbheight']		= $settings->thumbheight;
            $cfg['thumbprtn']		= $settings->thumbproportion;
            $cfg['thumbquality']    = $settings->thumbquality;

            $dest_dir 				= $path.$cfg['imgpath'];
            $ext                    = strtolower( strrchr($file['name'],'.'));

            $vfilename              = $this->sanitize($file['name']);
            $dest_file              = $dest_dir.$vfilename.$ext;

            $vthumbname             = $vfilename . "_thumb";
            $dest_thmb              = $dest_dir.$vthumbname.'.jpg';

			// we're going to make sure that the file's mime type is in the accepted group of mime types
			if (function_exists('mime_content_type')) {
				$mime_type = mime_content_type($src_file);
				if (strlen($mime_type) && !in_array($mime_type, $accepted_mimetypes)){
					$result['message'] = JText::_( 'COM_IPROPERTY_WRONG_FILETYPE' ). ' Error: 1';
					return $result;
				}
			} elseif (function_exists('finfo_file')) {
				$finfo = finfo_open(FILEINFO_MIME);
				$mime_type = finfo_file($finfo, $src_file);
                
                /* workaround for mime type returning charset */
                $mime_type = explode(';', $mime_type);
                $mime_type = $mime_type[0];
                /* end workaround */
                
				if (strlen($mime_type) && !in_array($mime_type, $accepted_mimetypes)){
					$result['message'] = JText::_( 'COM_IPROPERTY_WRONG_FILETYPE' ). ' Error: 2';
					return $result;
				}
			} // else you're pretty much out of luck since we need to access filesystem functions if you don't have these.

            if(filesize($src_file) > (intval($cfg['maximgsize']) * 1000)) {
                $result['message'] = sprintf(JText::_( 'COM_IPROPERTY_IMAGE_TOO_LARGE' ), (filesize($src_file)/1000).'KB', $cfg['maximgsize'].'KB', ini_get('upload_max_filesize'));
                return $result;
            }

            if (file_exists($dest_file)) {
                $result['message'] = JText::_( 'COM_IPROPERTY_FILE_EXISTS' );
                return $result;
            }

            if ((strcasecmp($ext, ".gif")) && (strcasecmp($ext, ".jpg")) && (strcasecmp($ext, ".jpeg")) && (strcasecmp($ext, ".png")) &&(strcasecmp($ext, ".doc")) && (strcasecmp($ext, ".xls")) && (strcasecmp($ext, ".ppt")) && (strcasecmp($ext, ".odt")) && (strcasecmp($ext, ".odp")) && (strcasecmp($ext, ".ods")) && (strcasecmp($ext, ".swf")) && (strcasecmp($ext, ".pdf")) && (strcasecmp($ext, ".mpg")) && (strcasecmp($ext, ".mov")) && (strcasecmp($ext, ".avi")) && (strcasecmp($ext, ".zip"))) {
                $result['message'] = JText::_( 'COM_IPROPERTY_WRONG_FILETYPE' ). ' Error: 3';
                return $result;
            }

            $error = false;
            
            if($ext == ".jpg" || $ext == ".jpeg" || $ext == ".png" || $ext == ".gif" ) {

                // adding check to make sure it's really an image
				if ( !function_exists( 'exif_imagetype' ) ) {
                    // exif function doesn't exist so we'll build one
					function exif_imagetype ( $filename ) {
						if ( ( list($width, $height, $type, $attr) = getimagesize( $filename ) ) !== false ) {
							return $type;
						}
                        return false;
					}
				} 
                
                if (!exif_imagetype($src_file)){
                    $result['message']  = JText::_( 'COM_IPROPERTY_WRONG_FILETYPE' ). ' Error: 5';;
                    return $result;
                }

                //$dest_file          = $dest_dir.$vfilename.'.jpg';
                
                // creating small images...
                $imginfo = getimagesize($src_file);
                $srcWidth = $imginfo[0];
        		$srcHeight = $imginfo[1];
                
                if($image_type == "property")
                {
                	
                	// DB contains FULLSCREEN images as original
		            $dest_file          = $dest_dir.$vfilename.'.jpg';
		            // converting every image to JPEG format
	                $result['message']  = $this->resizeIMG(0, $src_file, $dest_file, $srcWidth, $srcHeight, $cfg['imageprtn'], $cfg['imgquality']);
					
	                // creating NORMAL image
	                $dest_file              = $dest_dir. $vfilename . '_normal.jpg';
	                //445, 278
	                $result['message']  .= $this->resizeIMG(0, $src_file, $dest_file, 480, 310, $cfg['imageprtn'], $cfg['imgquality']);
	                
	                // creating jpeg THUMBNAIL
	                $vthumbname             = $vfilename . "_thumb";
	            	$dest_thmb              = $dest_dir.$vthumbname.'.jpg';
	            	
	                //if($cfg['createTb'] == 1) {
	                	//117, 73
	                    $result['message'] .= $this->resizeIMG(1, $src_file, $dest_thmb, $cfg['thumbwidth'], $cfg['thumbheight'], $cfg['thumbprtn'], $cfg['thumbquality']);
	                //}
	                $ext = ".jpg";
            		
                }
                else if($image_type == "tradearea")
                {
                	$dest_file = $dest_dir. $vfilename . '.jpg';
                	$result['message']  = $this->resizeIMG(0, $src_file, $dest_file, $srcWidth, $srcHeight, $cfg['imageprtn'], $cfg['imgquality']);
                	
	            	$dest_file              = $dest_dir. $vfilename . '_normal.jpg';
	            	//639, 432
	            	$result['message']  .= $this->resizeIMG(0, $src_file, $dest_file, 665, 450, $cfg['imageprtn'], $cfg['imgquality']);
	            	
                }
                else if($image_type == "leasingplan")
                {
                	$dest_file = $dest_dir. $vfilename . '.jpg';
                	$result['message']  = $this->resizeIMG(0, $src_file, $dest_file, $srcWidth, $srcHeight, $cfg['imageprtn'], $cfg['imgquality']);
                	
	            	$dest_file              = $dest_dir. $vfilename . '_normal.jpg';
	            	//639, 432
	            	$result['message']  .= $this->resizeIMG(0, $src_file, $dest_file, 750, 560, $cfg['imageprtn'], $cfg['imgquality']);
	            	
                }
                
                
                
                $ext = ".jpg";
            } else {
                if(@copy($src_file,$dest_file)){
                    //continue
                }else{
                    $result['message'] = JText::_( 'COM_IPROPERTY_IMAGE_NOT_COPIED' ) .' ; ' . $src_file . ' ; ' . $dest_file;
                }
            }

            if(!$result['message']) {
            	// updating database
            	
	            
	            $pic = $this->getTable();
                
                $pic->title			= $image_type;
                $pic->description	= '';
                $pic->fname			= $vfilename;
                $pic->type			= $ext;
                $pic->path			= trim($cfg['imgpath']);
				$pic->propid		= (int) $propid;
                $pic->owner			= $user->id;
                $pic->ordering		= 1000;
                $pic->state         = 1;
                //$pic->title         = trim(preg_replace( '/\s+/', ' ', $pic->title));
                //$pic->description   = trim(preg_replace( '/\s+/', ' ', $pic->description));
                //$pic->fname         = trim(preg_replace( '/\s+/', ' ', $pic->fname));
                //$pic->type          = trim(preg_replace( '/\s+/', ' ', $pic->type));
				/*
                if (!$pic->check()) {
                    $result['message'] = $pic->getError();
                    return $result;
                }
                */
                if (!$pic->store()) {
                    $result['message'] = $pic->getError();
                    return $result;
                }
                $pic->checkin();
                $pic->reorder( "propid = ".(int)$propid." AND type = ".$db->Quote($pic->type) );

                $result['status']   = true;
                $result['message']  = JText::_( 'COM_IPROPERTY_FILE_UPLOAD_SUCCESSFUL' );
	            
	            
	            /////////////////////////////////
	            /*
	            $query = $db->getQuery(true);
           		$query->insert('#__iproperty_images')
            		->set('propid = ' . $propid)
            		->set('title = ' . $db->quote($imgtitle))
            		->set('description = ' . $db->quote(''))
            		->set('fname = ' . $db->quote($fname))
            		->set('type = ' . $db->quote($ext))
            		->set('path = ' . $db->quote(trim($cfg['imgpath'])))
            		->set('remote = 0')
            		->set('owner = ' . $user->id)
            		->set('ordering = 0')
            		->set('language = ' . $db->quote(''))
            		->set('state = 1');
	            
                $db->setQuery($query);
	            $result['message'] .= $db->Query();
	            
	            $result['status']   = true;
	            */
	            
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
  	
    // File Upload
    public function uploadIMG($file, $propid)
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
								'image/jpeg',
								'image/gif',
								'image/png',
								'application/pdf',
								'application/msword',
								'application/vnd.ms-excel',
								'application/vnd.ms-powerpoint',
								'application/vnd.oasis.opendocument.text',
								'application/vnd.oasis.opendocument.presentation',
								'application/vnd.oasis.opendocument.spreadsheet',
								'application/x-shockwave-flash',
								'video/mpeg',
								'video/x-msvideo',
								'application/zip'
								);

            $db         = JFactory::getDBO();
            $settings   = ipropertyAdmin::config();
            $path       = JPATH_SITE;
            $user       = JFactory::getUser();
			$ipauth 	= new ipropertyHelperAuth();
			$coparams	= $ipauth->getCompanyParams();
			$maximgs	= $coparams->get('maximgs', 0);

            // is this the first image of this object?
            $query = $db->getQuery(true);
            $query->select('count(id)')
                    ->from('#__iproperty_images')
                    ->where('propid = '.(int)$propid);
            
            $db->setQuery($query);
            $imgcount = $db->loadResult();
			$imglimit = $imgcount + 1;
			

            if(	($imglimit > $settings->maximgs && $settings->maximgs!=0) || ($imglimit > $maximgs && $maximgs!=0) ){
                $result['message'] = 'overlimit';
                return $result;
            }
            $src_file	= (isset($file['tmp_name']) ? $file['tmp_name'] : "");
            
            $result['fname'] = $src_file;

            // check individual settings
            $cfg = array();
            $cfg['imgpath']			= $settings->imgpath;
            $cfg['maximgsize'] 	    = $settings->maximgsize;

            $cfg['imgwidth']		= $settings->imgwidth;
            $cfg['imgheight']		= $settings->imgheight;
            $cfg['imageprtn']		= $settings->imgproportion;
            $cfg['imgquality']		= $settings->imgquality;

            $cfg['createTb']		= 1;
            $cfg['thumbwidth']      = $settings->thumbwidth;
            $cfg['thumbheight']		= $settings->thumbheight;
            $cfg['thumbprtn']		= $settings->thumbproportion;
            $cfg['thumbquality']    = $settings->thumbquality;

            $dest_dir 				= $path.$cfg['imgpath'];
            $ext                    = strtolower( strrchr($file['name'],'.'));

            $vfilename              = $this->sanitize($file['name']);
            $dest_file              = $dest_dir.$vfilename.$ext;

            $vthumbname             = $vfilename . "_thumb";
            $dest_thmb              = $dest_dir.$vthumbname.'.jpg';

			// we're going to make sure that the file's mime type is in the accepted group of mime types
			if (function_exists('mime_content_type')) {
				$mime_type = mime_content_type($src_file);
				if (strlen($mime_type) && !in_array($mime_type, $accepted_mimetypes)){
					$result['message'] = JText::_( 'COM_IPROPERTY_WRONG_FILETYPE' ). ' Error: 1';
					return $result;
				}
			} elseif (function_exists('finfo_file')) {
				$finfo = finfo_open(FILEINFO_MIME);
				$mime_type = finfo_file($finfo, $src_file);
                
                /* workaround for mime type returning charset */
                $mime_type = explode(';', $mime_type);
                $mime_type = $mime_type[0];
                /* end workaround */
                
				if (strlen($mime_type) && !in_array($mime_type, $accepted_mimetypes)){
					$result['message'] = JText::_( 'COM_IPROPERTY_WRONG_FILETYPE' ). ' Error: 2';
					return $result;
				}
			} // else you're pretty much out of luck since we need to access filesystem functions if you don't have these.

            if(filesize($src_file) > (intval($cfg['maximgsize']) * 1000)) {
                $result['message'] = sprintf(JText::_( 'COM_IPROPERTY_IMAGE_TOO_LARGE' ), (filesize($src_file)/1000).'KB', $cfg['maximgsize'].'KB', ini_get('upload_max_filesize'));
                return $result;
            }

            if (file_exists($dest_file)) {
                $result['message'] = JText::_( 'COM_IPROPERTY_FILE_EXISTS' );
                return $result;
            }

            if ((strcasecmp($ext, ".gif")) && (strcasecmp($ext, ".jpg")) && (strcasecmp($ext, ".jpeg")) && (strcasecmp($ext, ".png")) &&(strcasecmp($ext, ".doc")) && (strcasecmp($ext, ".xls")) && (strcasecmp($ext, ".ppt")) && (strcasecmp($ext, ".odt")) && (strcasecmp($ext, ".odp")) && (strcasecmp($ext, ".ods")) && (strcasecmp($ext, ".swf")) && (strcasecmp($ext, ".pdf")) && (strcasecmp($ext, ".mpg")) && (strcasecmp($ext, ".mov")) && (strcasecmp($ext, ".avi")) && (strcasecmp($ext, ".zip"))) {
                $result['message'] = JText::_( 'COM_IPROPERTY_WRONG_FILETYPE' ). ' Error: 3';
                return $result;
            }

            $error = false;
            if($ext == ".jpg" || $ext == ".jpeg" || $ext == ".png" || $ext == ".gif" ) {

                // adding check to make sure it's really an image
				if ( !function_exists( 'exif_imagetype' ) ) {
                    // exif function doesn't exist so we'll build one
					function exif_imagetype ( $filename ) {
						if ( ( list($width, $height, $type, $attr) = getimagesize( $filename ) ) !== false ) {
							return $type;
						}
                        return false;
					}
				} 
                
                if (!exif_imagetype($src_file)){
                    $result['message']  = JText::_( 'COM_IPROPERTY_WRONG_FILETYPE' ). ' Error: 5';;
                    return $result;
                }

                $dest_file          = $dest_dir.$vfilename.'.jpg';
                $result['message']  = $this->resizeIMG(0, $src_file, $dest_file, $cfg['imgwidth'], $cfg['imgheight'], $cfg['imageprtn'], $cfg['imgquality']);

                if($cfg['createTb'] == 1) {
                    $result['message'] .= $this->resizeIMG(1, $src_file, $dest_thmb, $cfg['thumbwidth'], $cfg['thumbheight'], $cfg['thumbprtn'], $cfg['thumbquality']);
                }
                $ext = ".jpg";
            } else {
                if(@copy($src_file,$dest_file)){
                    //continue
                }else{
                    $result['message'] = JText::_( 'COM_IPROPERTY_IMAGE_NOT_COPIED' );
                }
            }

            if(!$result['message']) {
                $pic = $this->getTable();
                
                $pic->title			= isset($cfg['title']) ? trim($cfg['title']) : '';
                $pic->description	= isset($cfg['description']) ? trim($cfg['description']) : '';
                $pic->fname			= $vfilename;
                $pic->type			= $ext;
                $pic->path			= trim($cfg['imgpath']);
				$pic->propid		= (int) $propid;
                $pic->owner			= $user->id;
                $pic->ordering		= 0;
                $pic->state         = 1;
                $pic->title         = trim(preg_replace( '/\s+/', ' ', $pic->title));
                $pic->description   = trim(preg_replace( '/\s+/', ' ', $pic->description));
                $pic->fname         = trim(preg_replace( '/\s+/', ' ', $pic->fname));
                $pic->type          = trim(preg_replace( '/\s+/', ' ', $pic->type));

                if (!$pic->check()) {
                    $result['message'] = $pic->getError();
                    return $result;
                }
                if (!$pic->store()) {
                    $result['message'] = $pic->getError();
                    return $result;
                }
                $pic->checkin();
                $pic->reorder( "propid = ".(int)$propid." AND type = ".$db->Quote($pic->type) );

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
	
    
    public function orderImages($pid, $inc)
    {
        $img  = $this->getTable();
        $img->load($pid);
        $img->move( $inc, "propid = $img->propid AND type = '$img->type'");
        $img->reorder( "propid = $img->propid AND type = '$img->type'" );
        return true;
    }

	public function delete($pks)
    {
		// Initialise variables.
		$table	= $this->getTable();
		$pks	= (array) $pks;
        $ipauth = new ipropertyHelperAuth();

		$successful = 0;
        // Access checks.
		foreach ($pks as $i => $pk) {
			if ($table->load($pk)) {
				if (!$ipauth->canEditProp($pk)){
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
	
	// AJAX SPECIFIC FUNCTIONS
    public function ajaxAddImage($prop_id, $image_id)
    {
        $db         = JFactory::getDBO();
        $settings 	= ipropertyAdmin::config();
		$image_id	= (int) $image_id;
        $user = JFactory::getUser();
        $ipauth 	= new ipropertyHelperAuth();
		$coparams	= $ipauth->getCompanyParams();
		$maximgs	= $coparams->get('maximgs', 0);

		// is this the first image of this object?
		$query = $db->getQuery(true);
		$query->select('count(id)')
				->from('#__iproperty_images')
				->where('propid = '.(int)$prop_id);
		
		$db->setQuery($query);
		$imgcount = $db->loadResult();
		$imglimit = $imgcount + 1;
		

		if(	($imglimit > $settings->maximgs && $settings->maximgs!=0) || ($imglimit > $maximgs && $maximgs!=0) ){
			$error = 'overlimit';
			return $error;
		}

        // link new image to object
		$currimg  = $this->getTable();
		$currimg->load($image_id);

		$linkimg = $this->getTable();
		$linkimg->propid 		    = $prop_id;
		$linkimg->title				= '';
		$linkimg->description       = '';
		$linkimg->fname             = $currimg->fname;
		$linkimg->type              = substr($currimg->type, 0, 4); // in case any junk is attached
		$linkimg->path              = $currimg->path;
		$linkimg->remote            = $currimg->remote;
		$linkimg->owner				= $user->id;
		$linkimg->state             = 1;

		if (!$linkimg->check()) {
			echo $linkimg->getError();
			return false;
		}
		if (!$linkimg->store()) {
			echo $linkimg->getError();
			return false;
		}

		$linkimg->checkin();
		//$linkimg->reorder( "propid = ".(int)$propid." AND type = ".$db->Quote($linkimg->type) );

        if($linkimg->id){
            return $linkimg->id;
        } else {
            return 0;
        }
    }		
	
    public function ajaxSort($data)
    {
		foreach($data as $index => $tr){
            // get the actual ID of the image
            $imId = str_replace('ipImage', '', $tr[0]);
            if (!is_numeric($imId)) return false;
			// index is sort position, row is id, title, desc
			$im['ordering'] = (int) $index;
			// get instance of table obj
			$row = $this->getTable();
			$im['id'] 			= (int) $imId;
			$im['title'] 		= $tr[1] ? (string) $tr[1] : '';
			$im['description']	= $tr[2] ? (string) $tr[2] : '';
			// do the bind and store
			if (!$row->bind( $im )) {
				return JError::raiseWarning( 500, $row->getError() );
			}	
			if (!$row->store()) {
				return JError::raiseError( 500, $row->getError() );
			}
		}
		$row->reorder();
		
		return true;
	}
	
	function uploadRemote($propid, $path)
    {		
		
        $db         = JFactory::getDBO();	
		$pathinfo 	= pathinfo(json_decode(urldecode($path)));
		$user 		= JFactory::getUser();
		$ipauth 	= new ipropertyHelperAuth();
		$coparams	= $ipauth->getCompanyParams();
		$maximgs	= $coparams->get('maximgs', 0);
        $settings 	= ipropertyAdmin::config();
        
        // only accept jpg and png as remote images
        // this is ugly but needed to trim off all extra stuff after extension
        $ext        = pathinfo(parse_url(json_decode(urldecode($path)),PHP_URL_PATH),PATHINFO_EXTENSION);
        $types      = array ('jpeg', 'jpg', 'jpe', 'png'); 
        if ( !in_array($ext, $types) ) return false;
        
        // check if this is a valid image path
        if (!$this->checkRemoteImage(json_decode(urldecode($path)))) return false;

		// is this the first image of this object?
		$query = $db->getQuery(true);
		$query->select('count(id)')
				->from('#__iproperty_images')
				->where('propid = '.(int)$propid);
		
		$db->setQuery($query);
		$imgcount = $db->loadResult();
		$imglimit = $imgcount + 1;
		

		if(	($imglimit > $settings->maximgs && $settings->maximgs!=0) || ($imglimit > $maximgs && $maximgs!=0) ){
			$error = 'overlimit';
			return $error;
		}
		
		$row = $this->getTable();
		$im['propid'] 		= (int) $propid;
		$im['owner'] 		= $user->id;
		$im['created']		= JFactory::getDate()->toMySQL();
		$im['fname']		= $pathinfo['filename'];
		$im['type']			= substr('.' . $pathinfo['extension'], 0, 4); // in case any junk is attached
		$im['remote']		= 1;
		$im['path']			= $pathinfo['dirname'] . '/'; // need to add a trailing slash
        $im['ordering']     = 9999; // set to last
        $im['title']        = '';
        $im['description']  = '';
        
		// do the bind and store
		if (!$row->bind( $im )) {
			return JError::raiseWarning( 500, $row->getError() );
		}	
		if (!$row->store()) {
			return JError::raiseError( 500, $row->getError() );
		}
		$row->reorder();
		
        // return the whole object just inserted to be parsed and added to list
        if($row->id){
            $im['id'] = $row->id;
        }
		return $im;
	}
    
    // function to verify remote path is valid and is valid image type
    function checkRemoteImage($path)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$path);
        // only grab headers
        curl_setopt($ch, CURLOPT_NOBODY, 1);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if(curl_exec($ch)!==FALSE){
            if (curl_getinfo($ch, CURLINFO_HTTP_CODE) != '200') return false;
            // don't accept gifs due to known security exploits
            if (curl_getinfo($ch, CURLINFO_CONTENT_TYPE) != 'image/jpeg' && curl_getinfo($ch, CURLINFO_CONTENT_TYPE) != 'image/png') return false;
            return true;
        } else {
            return false;
        }
    }   
}
?>