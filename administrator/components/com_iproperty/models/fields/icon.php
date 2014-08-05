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
JHtml::_('behavior.modal');

class JFormFieldIcon extends JFormField
{
	protected $type = 'Icon';

	protected function getInput()
    {
        $user       = JFactory::getUser();
        $document   = JFactory::getDocument();
        $folder     = $this->element['folder'];

        // Build image select js and load the view
        $img_path   = JURI::root(true).'/media/com_iproperty/'.$folder.'/';
        $img_upload = $folder.'img';
        $img_select = 'select'.$folder.'img';

        // Add js function to switch icon image
		$js = "
            function ipSwitchIcon(image) {
                $('live_image').value = image;
                $('image_name').value = image;
                $('imagepreview').src = '".$img_path."' + image;
                window.parent.SqueezeBox.close();
            }";
        $document->addScriptDeclaration($js);

		$upload_link = 'index.php?option=com_iproperty&amp;view=iconuploader&amp;layout=uploadicon&amp;task='.$img_upload.'&amp;tmpl=component';
		$select_link = 'index.php?option=com_iproperty&amp;view=iconuploader&amp;task='.$img_select.'&amp;tmpl=component';		
        ?>
        <div style="padding: 4px;">
            <!-- physical input to show user which file has been selected -->
            <input type="text" class="inputbox" id="image_name" value="<?php echo $this->value; ?>" disabled="disabled" />&nbsp;

            <!-- Buttons to upload, select, or reset image -->
            <div class="button2-left"><div class="blank"><a class="modal" title="<?php echo JText::_('COM_IPROPERTY_UPLOAD'); ?>" href="<?php echo $upload_link; ?>" rel="{handler: 'iframe', size: {x: 400, y: 270}}"><?php echo JText::_('COM_IPROPERTY_UPLOAD'); ?></a></div></div>
            <?php if($user->authorise('core.admin')): ?>
                <div class="button2-left"><div class="blank"><a class="modal" title="<?php echo JText::_('COM_IPROPERTY_SELECTIMAGE'); ?>" href="<?php echo $select_link; ?>" rel="{handler: 'iframe', size: {x: 650, y: 375}}"><?php echo JText::_('COM_IPROPERTY_SELECTIMAGE'); ?></a></div></div>
            <?php endif; ?>
            <div class="button2-left"><div class="blank"><a href="javascript:void(0);" onclick="ipSwitchIcon('nopic.png');" title="<?php echo JText::_('COM_IPROPERTY_RESET'); ?>"><?php echo JText::_('COM_IPROPERTY_RESET'); ?></a></div></div>

            <!-- hidden field to store the actual value of the image name -->
            <input type="hidden" id="live_image" name="<?php echo $this->name; ?>" value="<?php echo $this->value; ?>" />

            <!-- image preview display and script to swap image with live image -->
            <div style="clear: both; margin-top: 20px; border-top: solid 1px #ccc; padding: 5px;">
                <img src="<?php echo JURI::root(true); ?>/media/com_iproperty/nopic.png" id="imagepreview" style="padding: 2px; border: solid 1px #ccc;" width="100" alt="Preview" />
                <script language="javascript" type="text/javascript">
                    //<!CDATA[
					var imprefix = '<?php echo JURI::root(true); ?>/media/com_iproperty/<?php echo $folder; ?>/';
                    if ($('image_name').value != ''){
                        var imname = $('image_name').value;
						if (imname.indexOf('http') !== -1){
							// set prefix to nothing if it's a remote image
							imprefix = '';
						}
                    }else{
                        var imname = 'nopic.png';
                        $('live_image').value = imname;
                        $('image_name').value = imname;
                    }
                    jsimg = imprefix + imname;
                    $('imagepreview').src = jsimg;
                    //]]>
                </script>
            </div>
        </div>
        <?php
	}
}