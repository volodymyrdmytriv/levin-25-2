<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Iproperty
 * @copyright (C) 2013 the Thinkery
 * @license see LICENSE.php
 */

//no direct access
defined('_JEXEC') or die('Restricted access');
$uri 		= JFactory::getURI();
$action     = str_replace('&', '&amp;', $uri->toString());
?>
<form action="<?php echo $action; ?>" method="post" class="ipmlssearch_form">
	<div class="ipmlssearch<?php echo $moduleclass_sfx; ?>">
		<?php
		    $output = '<input name="ip_mls_search" id="mod_mls_searchword" maxlength="'.$maxlength.'" alt="'.$button_text.'" class="inputbox'.$moduleclass_sfx.'" type="text" size="'.$width.'" value="'.$text.'"  onblur="if(this.value==\'\') this.value=\''.$text.'\';" onfocus="if(this.value==\''.$text.'\') this.value=\'\';" />';			
			$button = ( $showbutton == 1 ) ? '<input type="submit" value="'.$button_text.'" class="button'.$moduleclass_sfx.'" onclick="this.form.ip_mls_search.focus();" />' : '';

			switch ($button_pos) :
			    case 'top' :
				    $button = $button.'<br />';
				    $output = $button.$output;
				    break;

			    case 'bottom' :
				    $button = '<br />'.$button;
				    $output = $output.$button;
				    break;

			    case 'right' :
				    $output = $output.' '.$button;
				    break;

			    case 'left' :
			    default :
				    $output = $button.' '.$output;
				    break;
			endswitch;

			echo $output;
		?>
	</div>
    <input type="hidden" name="task" value="ip_mls_search" />
</form>