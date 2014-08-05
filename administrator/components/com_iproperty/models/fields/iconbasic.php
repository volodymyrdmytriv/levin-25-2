<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.form.formfield');

class JFormFieldIconBasic extends JFormField
{
	protected $type = 'Iconbasic';

	protected function getInput()
    {
        $user       = JFactory::getUser();
        $document   = JFactory::getDocument();
        $folder     = $this->element['folder']; // agents or companies
        $id         = JRequest::getInt('id');
        $settings   = ipropertyAdmin::config();
        $database   = JFactory::getDBO();
               
        switch ($folder){
            case 'agents':
                $width = $settings->agent_photo_width;
                $table = '#__iproperty_agents';
            break;
            case 'companies':
                $width = $settings->company_photo_width;
                $table = '#__iproperty_companies';
            break;
            default:
                $width = $settings->agent_photo_width;
                $table = '#__iproperty_agents';
            break;
        }
        
        $sql = "SELECT icon FROM ".$table." WHERE id = ".(int)$id;
        $database->setQuery($sql);
        $icon = $database->loadResult();
        
        if (!$icon) $icon = 'nopic.png';
        
        
        $document->addScript( "http://bp.yahooapis.com/2.4.21/browserplus-min.js" );
        // check if jQuery is loaded before adding it
		if (!JFactory::getApplication()->get('jquery')) {
			JFactory::getApplication()->set('jquery', true);
			$document->addScript( "https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js" );
		}
        $document->addScript( JURI::root()."components/com_iproperty/assets/js/plupload/js/plupload.full.js" );
        
        $script = 
        "jQuery.noConflict();
        jQuery(document).ready(function($) {
            var uploader = new plupload.Uploader({
                runtimes : 'html5,flash,silverlight,browserplus',
                browse_button : 'pickfiles',
                container : 'pluploadcontainer',
                max_file_size : '2mb',
                unique_names : true,
                multipart: true,
                urlstream_upload: true,
                url : '".JURI::root()."index.php?option=com_iproperty&task=ajax.ajaxIconUpload&format=raw&".JUtility::getToken()."=1&target=".$folder."&id=".$id."',
                flash_swf_url : '".JURI::root()."components/com_iproperty/assets/js/plupload/js/plupload.flash.swf',
                silverlight_xap_url : '".JURI::root()."components/com_iproperty/assets/js/plupload/js/plupload.silverlight.xap',
                filters : [
                    {title : 'Image files', extensions : 'jpg,gif,png'}
                    //{title : '".JText::_('COM_IPROPERTY_IMAGE_TYPES')."', extensions : '".JText::_('COM_IPROPERTY_IMAGE_EXTENSIONS')."'}
                ],
                resize : {width : ".$width.", height : ".$width.", quality : 90} // we use the same value for width/height so it scales proportionally
            });

            $('#uploadfiles').click(function(e) {
                uploader.start();
                e.preventDefault();
            });

            uploader.init();

            uploader.bind('FilesAdded', function(up, files) {
                $.each(files, function(i, file) {
                    $('#filelist').append(
                        '<div id=\"' + file.id + '\">' +
                        file.name + ' (' + plupload.formatSize(file.size) + ') <b></b>' +
                    '</div>');
                });

                uploader.start(); // auto start when file added

                up.refresh(); // Reposition Flash/Silverlight
            });

            uploader.bind('UploadProgress', function(up, file) {
                $('#' + file.id + \" b\").html(file.percent + \"%\");
            });

            uploader.bind('Error', function(up, err) {
            console.log(err);
                $('#filelist').append(\"<div>Error: \" + err.code +
                    \", Message: \" + err.message +
                    (err.file ? \", File: \" + err.file.name : \"\") +
                    \"</div>\"
                );
                up.refresh(); // Reposition Flash/Silverlight
            });

            uploader.bind('FileUploaded', function(up, file, info) {
                var finfo = jQuery.parseJSON(info.response);
                if (finfo[0].status){ // successful image upload
                    var path = '".JURI::root()."media/com_iproperty/".$folder."/'+finfo[0].result;
                    $('#ip_photo_holder').attr('src', path);
                }
            });
        });"."\n";   

        // if no ID, can't upload image
		if ($id){ 
			$document->addScriptDeclaration($script);
			$imgdiv = '
                <div style="padding: 4px;" id="pluploadcontainer">
                    <div id="filelist"></div><br />
                    <a id="pickfiles" href="javascript:void(0);">[Select files]</a>
                    <a id="uploadfiles" href="javascript:void(0);">[Upload files]</a>
                </div>
                <div>
                    <img id="ip_photo_holder" src="'.JURI::root().'/media/com_iproperty/'.$folder.'/'.$icon.'" alt="" />
                </div>';
		} else {
			$imgdiv = '<div style="padding: 4px;">'.JText::_('COM_IPROPERTY_SAVE_FIRST').'</div>';
		}
        
		echo $imgdiv;
	}
}