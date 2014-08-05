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

class plgIpropertyGalleryForm extends JPlugin
{
	function plgIpropertyGalleryForm(&$subject, $config)  
    {
		parent::__construct($subject, $config);
        $this->loadLanguage();
	}
	
    function onBeforeRenderForms($property, $settings, $sidecol)
    {
		if ($this->params->get('before', false)) $this->doGallery($property, $settings, $sidecol);
    }
	
	function onAfterRenderForms($property, $settings, $sidecol)
    {
        if (!$this->params->get('before', false)) $this->doGallery($property, $settings, $sidecol);
    }    
    
	function doGallery($property, $settings, $sidecol)
	{
        $app = JFactory::getApplication();
        $document = JFactory::getDocument();
		if($app->getName() != 'site') return true;
        $use_slimbox        = $this->params->get('slimbox', 1);
        $g_columns          = $this->params->get('columns', 3);
        $g_thumb_width      = $this->params->get('thumb_width', 200);
        $g_thumb_height     = $this->params->get('thumb_height', 120);
        $maximgs            = $this->params->get('maximgs', false);
		//JHTML::_( 'behavior.mootools' );
	
		//	Add Javascript
		if($settings->gallerytype != 3 && $use_slimbox) {
			// only load slimbox js if it's not already being used
            $document->addScript(JURI::root(true) .'/components/com_iproperty/assets/galleries/slimbox/js/slimbox_1.2.js');
			$document->addStyleSheet( JURI::root(true) . '/components/com_iproperty/assets/galleries/slimbox/css/slimbox.css' ); // only load slimbox css if it's not already being used
		}		
		
		// load images for property
        $db = JFactory::getDBO();
		$query = "SELECT * FROM #__iproperty_images WHERE propid = ".(int)$property->id
                ." AND (type = '.jpg' OR type = '.jpeg' OR type = '.gif' OR type = '.png') ORDER BY ordering ASC";
        $query .= $maximgs ? ' LIMIT '.$maximgs : '';
        $db->setQuery($query);
        $images             = $db->loadObjectList();        
        if ( count($images) < 1 ) return;
        
        // create array of thumbs to use in gallery
        $thumbs             = array();
        foreach($images as $image) {
			$gpath          = ($image->remote == 1) ? $image->path : JURI::root(true).$settings->imgpath;
			$gthumbnail     = ($image->remote == 1) ? $gpath.$image->fname.$image->type : $gpath.$image->fname. '_thumb' . $image->type;
			$gfullsize      = ($image->remote == 1) ? $gpath.$image->fname.$image->type : $gpath.$image->fname.$image->type;
            $gtitle         = ($image->title) ? htmlspecialchars(trim($image->title)).':' : htmlspecialchars(trim($property->street_address)).':';
            $gdesc          = ($image->description) ? ' '.htmlspecialchars($image->description) : '';

			if($use_slimbox){
                $attributes = ' class="slimbox" rel="lightbox-gallery_plg"';
            }else{
                $attributes = ' class="modal"';
            }
			$thumbs[]	= '<a href="'.$gfullsize.'" title="'.$gtitle.$gdesc.'"'.$attributes.'><img src="' . $gthumbnail . '" border="0" alt="'.$gtitle.'" width="'.$g_thumb_width.'" /></a>';
		}
		
		$i = 1;
        $gallery_display  = '<div class="ip_spacer"></div>';
        $gallery_display .= '<table class="ptable ip_gallery" width="100%">';            
            foreach($thumbs as $thumb) {
                if($i == 1){ //begin row
                    $gallery_display .= '<tr>';
                }
                $gallery_display .= '<td align="center"><div class="property_thumb_holder" style="width: '.$g_thumb_width.'px; height: '.$g_thumb_height.'px;">'.$thumb.'</div></td>';
                if ($i == $g_columns){ //if max columns reached, end row
                    $gallery_display .= "</tr>";
                    $i = 1;
                }else{
                    $i++;
                }
            }
            //fill any leftover cells with blank space
            if($i != 1){
                for($z = ($g_columns - ($i - 1)); $z > 0; $z--){
                    $gallery_display .= "<td>&nbsp;</td>";
                }
                $gallery_display .= "</tr>";
            }
		$gallery_display .= "</table>";
			
		echo JHtml::_('tabs.panel', JText::_($this->params->get('tabtitle', 'PLG_IP_GALLERY_GALLERY')), 'ipgalleryform');
		echo $gallery_display;
		
		return true;		
	}	
} // end class

?>

