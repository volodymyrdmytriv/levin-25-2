<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>

<script language="javascript" type="text/javascript">
    Joomla.submitbutton = function(task)
	{
		if (task == 'company.cancel' || document.formvalidator.isValid(document.id('iproperty-form'))) {
            Joomla.submitform(task, document.getElementById('iproperty-form'));
		} else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_iproperty&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="iproperty-form" class="form-validate" enctype="multipart/form-data" >
    <div class="width-60 fltlft">
		<fieldset class="adminform">
            <legend><?php echo JText::_('COM_IPROPERTY_DETAILS'); ?></legend>
            <div class="width-50 fltlft">                
                <ul class="adminformlist">
                    <li><?php echo $this->form->getLabel('name'); ?>
                    <?php echo $this->form->getInput('name'); ?></li>
                    <li><?php echo $this->form->getLabel('alias'); ?>
                    <?php echo $this->form->getInput('alias'); ?></li>
                    <li><?php echo $this->form->getLabel('email'); ?>
                    <?php echo $this->form->getInput('email'); ?></li>
                    <li><?php echo $this->form->getLabel('phone'); ?>
                    <?php echo $this->form->getInput('phone'); ?></li>
                    <li><?php echo $this->form->getLabel('fax'); ?>
                    <?php echo $this->form->getInput('fax'); ?></li>
                    <li><?php echo $this->form->getLabel('website'); ?>
                    <?php echo $this->form->getInput('website'); ?></li>
                    <li><?php echo $this->form->getLabel('clicense'); ?>
                    <?php echo $this->form->getInput('clicense'); ?></li>
                </ul>
            </div>
            <div class="width-50 fltrt">
                <ul class="adminformlist">
                    <li><?php echo $this->form->getLabel('street'); ?>
                    <?php echo $this->form->getInput('street'); ?></li>
                    <li><?php echo $this->form->getLabel('city'); ?>
                    <?php echo $this->form->getInput('city'); ?></li>
                    <li><?php echo $this->form->getLabel('locstate'); ?>
                    <?php echo $this->form->getInput('locstate'); ?></li>
                    <li><?php echo $this->form->getLabel('province'); ?>
                    <?php echo $this->form->getInput('province'); ?></li>
                    <li><?php echo $this->form->getLabel('postcode'); ?>
                    <?php echo $this->form->getInput('postcode'); ?></li>
                    <li><?php echo $this->form->getLabel('country'); ?>
                    <?php echo $this->form->getInput('country'); ?></li>
                </ul>
            </div>
        </fieldset>
    </div>
    <div class="width-40 fltrt">
    	<fieldset class="adminform">
            <legend>PDF files</legend>
            <ul class="adminformlist">
                <li>
                	<label id="portfolio_avail_report-lbl" for="portfolio_avail_report" >Portfolio Availability Report</label>
                	
                	<?php if(count($this->portfolio_avail_report) > 0) : ?>
                	<div>
                		<?php 
                		$pdf_file = $this->portfolio_avail_report[0];
                		      
	                    $pdf_href = $this->folder . $pdf_file->fname . $pdf_file->type;
	                    
	                    echo '<a href="'.$pdf_href.'" target="_blank">Report.pdf</a>';
	                    ?>
	                </div>
                	<?php else: ?>
                	<div>No PDF Uploaded</div>
                	<?php endif; ?>
                	<input type="file" name="portfolio_avail_report" id="portfolio_avail_report" value="">
                </li>
            </ul>
        </fieldset>
        <fieldset class="adminform">
            <legend><?php echo JText::_('COM_IPROPERTY_IMAGE'); ?></legend>
            <ul class="adminformlist">
                <li><?php echo $this->form->getInput('icon'); ?></li>
            </ul>
        </fieldset>
        <?php if ($this->ipauth->getAdmin()): ?>
            <fieldset class="adminform">
                <legend><?php echo JText::_('COM_IPROPERTY_PUBLISHING'); ?></legend>
                <ul class="adminformlist">
                    <li><?php echo $this->form->getLabel('state'); ?>
                    <?php echo $this->form->getInput('state'); ?></li>
                    <li><?php echo $this->form->getLabel('featured'); ?>
                    <?php echo $this->form->getInput('featured'); ?></li>                    
                </ul>
            </fieldset>
            <fieldset class="adminform admin_params">
                <legend><?php echo JText::_('COM_IPROPERTY_COMPANY_PARAMETERS'); ?></legend>
                <ul class="adminformlist">
                    <?php foreach($this->form->getFieldset('admin_params') as $field) :?>
                        <li><?php echo $field->label; ?>
                        <?php echo $field->input; ?></li>
                    <?php endforeach; ?>
                </ul>
            </fieldset>
        <?php endif; ?>
    </div>
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>
<div class="clr"></div>
<p class="copyright"><?php echo ipropertyAdmin::footer( ); ?></p>