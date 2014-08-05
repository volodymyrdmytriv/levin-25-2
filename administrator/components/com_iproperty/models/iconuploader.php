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
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');

class ipropertyModelIconuploader extends JModel
{
	var $_pagination = null;

	function __construct()
	{
		parent::__construct();

		$app  = JFactory::getApplication();
        $option     = JRequest::getCmd('option');

		$task 		= JRequest::getVar( 'task' );
		$limit		= $app->getUserStateFromRequest( $option.'iconuploader'.$task.'limit', 'limit', $app->getCfg('list_limit'), 'int');
		$limitstart = $app->getUserStateFromRequest( $option.'iconuploader'.$task.'limitstart', 'limitstart', 0, 'int' );
		$search 	= $app->getUserStateFromRequest( $option.'iconuploader.search', 'search', '', 'string' );
		$search 	= trim(JString::strtolower( $search ) );
		
		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
		$this->setState('search', $search);

	}
	
	function getState($property = null)
	{
		static $set;

		if (!$set) {
			$folder = JRequest::getVar( 'folder' );
			$this->setState('folder', $folder);

			$set = true;
		}
		return parent::getState($property);
	}

	function getImages()
	{
		$list = $this->getList();	
		$listimg = array();
		
		$s = $this->getState('limitstart');
		
		for ( $i = $s; $i < $s + $this->getState('limit'); $i++ ) {
			if ($i+1 <= $this->getState('total') ) {
				
                $list[$i]->size = $this->_parseSize(filesize($list[$i]->path));

                $info = @getimagesize($list[$i]->path);
                $list[$i]->width		= @$info[0];
                $list[$i]->height	= @$info[1];

                if (($info[0] > 60) || ($info[1] > 60)) {
                    $dimensions = $this->_imageResize($info[0], $info[1], 60);
                    $list[$i]->width_60 = $dimensions[0];
                    $list[$i]->height_60 = $dimensions[1];
                } else {
                    $list[$i]->width_60 = $list[$i]->width;
                    $list[$i]->height_60 = $list[$i]->height;
                }	
				
    			$listimg[] = $list[$i];
			}
		}
		
		return $listimg;
	}

	function getList()
	{
		static $list;

		// Only process the list once per request
		if (is_array($list)) {
			return $list;
		}

		// Get folder from request
		$folder = $this->getState('folder');
		$search = $this->getState('search');

		// Initialize variables
		$basePath = JPATH_SITE.DS.'media'.DS.'com_iproperty'.DS.$folder;
		
		$images 	= array ();

		// Get the list of files and folders from the given folder
		$fileList 	= JFolder::files($basePath);

		// Iterate over the files if they exist
		if ($fileList !== false) {
			foreach ($fileList as $file)
			{
				if (is_file($basePath.DS.$file) && substr($file, 0, 1) != '.' && strtolower($file) !== 'index.html') {

					if ( $search == '') {
						$tmp = new JObject();
						$tmp->name = $file;
						$tmp->path = JPath::clean($basePath.DS.$file);
						
						$images[] = $tmp;
						
					} elseif(stristr( $file, $search)) {
						$tmp = new JObject();
						$tmp->name = $file;
						$tmp->path = JPath::clean($basePath.DS.$file);
							
						$images[] = $tmp;
					
					}
				}
			}
		}

		$list = $images;		
		$this->setState('total', count($list));
		return $list;
	}
	
	function getPagination()
	{
		if (empty($this->_pagination))
		{
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination( $this->getState('total'), $this->getState('limitstart'), $this->getState('limit') );
		}

		return $this->_pagination;
	}

	function _imageResize($width, $height, $target)
	{
		//takes the larger size of the width and height and applies the
		//formula accordingly...this is so this script will work
		//dynamically with any size image
		if ($width > $height) {
			$percentage = ($target / $width);
		} else {
			$percentage = ($target / $height);
		}

		//gets the new value and applies the percentage, then rounds the value
		$width = round($width * $percentage);
		$height = round($height * $percentage);

		return array($width, $height);
	}

	function _parseSize($size)
	{
		if ($size < 1024) {
			return $size . ' bytes';
		}
		else
		{
			if ($size >= 1024 && $size < 1024 * 1024) {
				return sprintf('%01.2f', $size / 1024.0) . ' Kb';
			} else {
				return sprintf('%01.2f', $size / (1024.0 * 1024)) . ' Mb';
			}
		}
	}
}
?>