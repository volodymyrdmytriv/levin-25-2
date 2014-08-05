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

<tr>
    <td colspan="2">
        <form action="<?php echo htmlspecialchars(JFactory::getURI()->toString()); ?>" method="post" name="ip_agent_search" class="ip_agentsearch_form">
            <div>
                <div class="ip_quicksearch_optholder">
                    <?php
                    echo '<strong>' . JText::_( 'COM_IPROPERTY_NAME' ) . ':</strong> <input type="text" class="inputbox" onclick="this.value=\'\'" name="search" value="' . $this->lists['search'] . '" /> ';
                    if( JRequest::getWord('view') != 'companyagents') echo '<strong>' . JText::_( 'COM_IPROPERTY_COMPANY' ) . ':</strong> ' . $this->lists['company'] . ' ';
                    ?>
                </div>
            </div>
            <div class="ip_quicksearch_sortholder">
                <?php
                echo '<div class="quicksearch_sortholder">';
                    echo '<strong>' . JText::_( 'COM_IPROPERTY_SORTBY' ) . ':</strong> ' . $this->lists['sort'] . ' ';
                    echo '<strong>' . JText::_( 'COM_IPROPERTY_ORDERBY' ) . ':</strong> ' . $this->lists['order'] . ' ';
                    echo '<input type="submit" class="ipbutton" value="'.JText::_( 'COM_IPROPERTY_GO' ).'" />';
                echo '</div>';
                ?>
            </div>
        </form>
    </td>
</tr>