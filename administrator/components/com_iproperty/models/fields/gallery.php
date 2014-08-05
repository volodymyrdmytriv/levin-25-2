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

class JFormFieldGallery extends JFormField
{
    protected $type = 'Gallery';

	protected function getInput()
	{
        ?>
        <div class="ipgallerycontainer">
            <div class="width-100 image-uploader">
                <div class="width-100 fltlft">
                    <fieldset class="adminform" id="ipuploader">
                    <legend><?php echo JText::_( 'COM_IPROPERTY_UPLOAD' ); ?></legend>
                     	 	<div>Caution For Images! You should upload only full size images!</div>
                     	 	<div>After uploading you can change order of the images.</div>
                     	 	<div>Caution For Documents! After uploading of any document the site will be using the last one.</div>
                     		<div><br></div>
                     		<div>Select file type to upload:<span>  
		                     	<select name="image_type" style="float: none" onchange="uploadForm(this.value)" >
			                     		<option value="property" default>Property Image</option>
			                     		<option value="tradearea">Trade Area Image</option>
			                     		<option value="leasingplan">Leasing Plan Image</option>
			                     		<option value="marketing_flyer_pdf">Marketing flyer PDF</option>
			                     		<option value="leasing_plan_pdf">Leasing Plan PDF</option>
			                     		<option value="aerial_pdf">Aerial PDF</option>
			                     		
			                    </select>
			                    </span>
		                    </div>
                        <div id="ipUploader" style="height: 330px">
                            <!-- ADD STANDARD UPLOADER HERE AS FALLBACK -->
                            <?php echo JText::_( 'COM_IPROPERTY_FLASH_DISABLED' ); ?>
                        </div>
                        <div class="remote_container"> 
                            <ul class="adminformlist">
                                <li>
                                    <fieldset class="radio inputbox">
                                        <label class="hasTip" title="<?php echo JText::_( 'COM_IPROPERTY_REMOTE' ); ?>::<?php echo JText::_( 'COM_IPROPERTY_UPLOAD_REMOTE' ); ?>"><?php echo JText::_( 'COM_IPROPERTY_REMOTE' ); ?></label>
                                        <input type="text" id="uploadRemote" class="inputbox" maxlength="150" value="" />
                                        <label class="uploadRemotebtn"><div id="uploadRemoteGo"></div></label>
                                    </fieldset>
                                </li>
                            </ul>			
                        </div>
                    </fieldset>
                </div>
            </div>  
            <?php
                echo JHtml::_('tabs.start', 'image_tabs', array('useCookie' => false));
                echo JHtml::_('tabs.panel', JText::_( 'COM_IPROPERTY_IMAGES' ), 'images_panel');
            ?>
            <div class="width-100 image-sortables" style="clear: both;">
                <fieldset class="adminform">
                <legend><?php echo JText::_( 'COM_IPROPERTY_IMAGES' ); ?></legend>
                    <div id="ip_gallery_message"></div>
                    <div class="width-50 fltlft">
                        <div class="available_header"><?php echo JText::_('COM_IPROPERTY_AVAILABLE_IMAGES'); ?></div>
                        <div id="ip_gallery_av_pagination"></div>
                        <div id="ip_gallery_available"></div>
                    </div>
                    <div class="width-50 fltlft">
                        <div class="current_header"><?php echo JText::_('COM_IPROPERTY_CURRENT_IMAGES'); ?></div>
                        <div id="ip_gallery_sel_pagination"></div>
                        <div id="ip_gallery_selected"></div>
                    </div>                     
                </fieldset>  
            </div>
            <?php
                echo JHtml::_('tabs.panel', JText::_( 'COM_IPROPERTY_DOCUMENTS' ), 'documents_panel');
            ?>
            <div class="width-100" style="clear: both;">
                <fieldset class="adminform">
                <legend><?php echo JText::_( 'COM_IPROPERTY_DOCUMENTS' ); ?></legend>
                    <div id="ip_documents_message"></div>
                    <div class="width-50 fltlft">
                        <div class="available_header"><?php echo JText::_('COM_IPROPERTY_AVAILABLE_DOCS'); ?></div>
                        <div id="ip_gallery_av_pagination_doc"></div>
                        <div id="ip_gallery_available_doc"></div>
                    </div>
                    <div class="width-50 fltlft">
                        <div class="current_header"><?php echo JText::_('COM_IPROPERTY_CURRENT_DOCS'); ?></div>
                        <div id="ip_gallery_sel_pagination_doc"></div>
                        <div id="ip_gallery_selected_doc"></div>
                    </div>                      
                </fieldset>  
            </div>
            <?php echo JHtml::_('tabs.end'); ?>
        </div>
        <?php        
	}
}


