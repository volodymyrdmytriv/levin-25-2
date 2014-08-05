<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

$advanced_link = JRoute::_(ipropertyHelperRoute::getAdvsearchRoute());
?>

<?php if ($this->params->get('show_page_heading', 1)) : ?>
	<h1>
	<?php echo $this->escape($this->params->get('page_heading')); ?>
	</h1>
<?php endif; ?>
<?php if ($this->params->get('show_ip_title') && $this->iptitle) : ?>
<div class="ip_mainheader">
	<h2><?php echo $this->iptitle; ?></h2>
</div>
<?php endif; ?>

<?php if ($this->params->get('show_ip_gmap', 0) && $this->properties) : ?>
    <?php
        echo '<div id="ip_catmap"></div>';
    ?>
<?php endif; ?>

<?php
    if( $this->featured && $this->settings->cat_featured_pos == 0 ){
        echo '<table class="ptable featured_table">
                <tr>
                  <td colspan="2">
                    <div class="property_header">
                    ' . JText::_( 'COM_IPROPERTY_FEATURED_PROPERTIES' ) . '
                    </div>
                  </td>
                </tr>';
                $this->k = 0;
                foreach( $this->featured as $f ){
                    $this->p = $f;
                    echo $this->loadTemplate('property');
                    $this->k = 1 - $this->k;
                }
        echo '</table>';
    }
?>

<table class="ptable">
	<?php
        //display quick search form
        echo $this->loadTemplate('quicksearch');
		
		//display results for properties
		if( $this->properties ) :
			echo 
				'<tr>
				  <td colspan="2">
				  	<div class="property_header">
					' . JText::_( 'COM_IPROPERTY_PROPERTIES' ) . '
					<div align="right" class="property_header_results">
						' . $this->pagination->getResultsCounter() . '
					</div>
					</div>
				  </td>			
				</tr>';
				$this->k = 0;
                foreach($this->properties as $p) :
					$this->p = $p;
					echo $this->loadTemplate('property');
                    $this->k = 1 - $this->k;
				endforeach;
			echo
				'<tr>
					<td colspan="2" align="center">
						<div class="pagination">
                            ' . $this->pagination->getPagesLinks() . '<br />
                            ' . $this->pagination->getPagesCounter() . '
                        </div>
					</td>
				</tr>';
		else :
			
			echo ipropertyHTML::buildNoResults();
		
		endif;  	
    ?>
</table>

<?php
    if( $this->featured && $this->settings->cat_featured_pos == 1 ){
        echo '<table class="ptable featured_table">
                <tr>
                  <td colspan="2">
                    <div class="property_header">
                    ' . JText::_( 'COM_IPROPERTY_FEATURED_PROPERTIES' ) . '
                    </div>
                  </td>
                </tr>';
                $this->k = 0;
                foreach( $this->featured as $f ){
                    $this->p = $f;
                    echo $this->loadTemplate('property');
                    $this->k = 1 - $this->k;
                }
        echo '</table>';
    }
    if ($this->params->get('show_ip_disclaimer') && $this->settings->disclaimer){
        echo '<div class="ip_disclamer">
                '.$this->settings->disclaimer.'
            </div>';
    }
    if( $this->settings->footer == 1):
        echo ipropertyHTML::buildThinkeryFooter();
    endif;
?>