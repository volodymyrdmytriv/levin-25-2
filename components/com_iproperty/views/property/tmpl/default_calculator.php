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

<div class="ip-slider-div">
    <form name="IPMortgageCalc" action="">
        <table width="100%" cellpadding="2" cellspacing="0" class="ip_form_table mtgform">
            <tr>
                <td width="50%" valign="top">
                    <table width="100%" cellpadding="0">
                        <tr>
                            <td align="right" width="50%">*<?php echo JText::_( 'COM_IPROPERTY_HOUSE_PRICE' ); ?>:</td>
                            <td width="50%"><input type="text" class="inputbox" name="price" value="<?php echo $this->p->price; ?>" size="10" /></td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo JText::_( 'COM_IPROPERTY_DOWN_PAYMENT' ); ?>:</td>
                            <td><input type="text" class="inputbox" name="dp" value="0" onchange="calculatePayment(this.form)" size="10" /></td>
                        </tr>
                        <tr>
                            <td align="right">*<?php echo JText::_( 'COM_IPROPERTY_ANNUAL_INTEREST' ); ?>:</td>
                            <td><input type="text" class="inputbox" name="ir" value="7.0" size="7" /> %</td>
                        </tr>
                        <tr>
                            <td align="right">*<?php echo JText::_( 'COM_IPROPERTY_TERM' ); ?>:</td>
                            <td><input type="text" class="inputbox" name="term" value="30" size="7" /> <?php echo JText::_( 'COM_IPROPERTY_YEARS' ); ?></td>
                        </tr>
                    </table>
                </td>
                <td width="10%"><input type="button" name="cmdCalc" value="<?php echo JText::_('>>'); ?>" onclick="cmdCalc_Click(this.form)" /></td>
                <td width="50%" valign="top">
                    <table width="100%" cellpadding="0">
                        <tr>
                            <td align="right" width="50%"><?php echo JText::_( 'COM_IPROPERTY_MTG_PRINCIPLE' ); ?>:</td>
                            <td width="50%"><input type="text" class="inputbox" name="principle" size="10" /></td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo JText::_( 'COM_IPROPERTY_TOTAL_PAYMENTS' ); ?>:</td>
                            <td><input type="text" class="inputbox" name="payments" size="10" /></td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo JText::_( 'COM_IPROPERTY_MONTHLY_PAYMENT' ); ?>:</td>
                            <td><input type="text" class="inputbox" name="pmt" size="10" /></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </form>
</div>