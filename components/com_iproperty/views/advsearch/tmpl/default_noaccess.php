<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
?>

<div class="ip_mainheader">
    <h1 class="componentheading">
        <?php echo JText::_( 'COM_IPROPERTY_NO_ACCESS' ); ?>
    </h1>
</div>
<table class="ptable">	
    <tr>
      <td colspan="2">
        <div class="property_header">
            <?php echo JText::_( 'COM_IPROPERTY_NO_ACCESS' ); ?>
        </div>
      </td>
    </tr>
    <tr>
       <td colspan="2" align="center">
        <div class="ip_noaccess">
            <div>
                <?php echo JText::_( 'COM_IPROPERTY_SORRY_NO_ACCESS' ); ?>
            </div>
        </div>
       </td>
    </tr>    
</table>
<?php
    if( $this->settings->footer == 1):
        echo ipropertyHTML::buildThinkeryFooter();
    endif;
?>

