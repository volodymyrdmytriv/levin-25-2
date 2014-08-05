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
	<h2><?php echo 'Property Search'; //echo $this->iptitle; ?></h2>
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
    
    //display quick search form
	echo $this->loadTemplate('propertysearch');
	
	echo '<div style="clear: both"></div>';
	echo '<div class="separator" style="height: 20px; "></div>';
	
	// displays pages information
	if( $this->properties ) {
			
			echo '<div class="property_header">' . 
					JText::_( 'COM_IPROPERTY_PROPERTIES' ) . '
					<div align="right" class="property_header_results">
						' . $this->pagination->getResultsCounter() . '
					</div>
				</div>';
	}
	
?>

<table class="ptable">
<thead> 
	<tr class="search-results-table-header">
		<th width="12%" class="header"><span class="search-results-table-header-title">PROPERTY</span> <span class="sortUp-icon"></span><span class="sortDown-icon"></span><span class="unsort-icon"></span></th>
		<th width="23%"></th>
		<th width="15%" class="header"><span class="search-results-table-header-title">LOCATION</span><span class="sortUp-icon"></span><span class="sortDown-icon"></span><span class="unsort-icon"></span></th>
		<th width="10%" class="header"><span class="search-results-table-header-title">GLA</span><span class="sortUp-icon"></span><span class="sortDown-icon"></span><span class="unsort-icon"></span></th>
		<th width="17%" class="header"><span class="search-results-table-header-title">STATUS</span><span class="sortUp-icon"></span><span class="sortDown-icon"></span><span class="unsort-icon"></span></th>
		<th width="23%" class="header"><span class="search-results-table-header-title">ANCHOR TENANT(S)</span><span class="sortUp-icon"></span><span class="sortDown-icon"></span><span class="unsort-icon"></span></th>
	</tr>
</thead>
<tbody>
	<?php
        
		//display results for properties
		if( $this->properties ) :
				$this->k = 0;
                foreach($this->properties as $p) :
					$this->p = $p;
					echo $this->loadTemplate('property');
                    $this->k = 1 - $this->k;
				endforeach;
			
		else :
			
			echo ipropertyHTML::buildNoResults();
		
		endif;  	
    ?>
</tbody>
</table>
<?php 
	echo
				'<tr>
					<td colspan="2" align="center">
						<div class="pagination">
                            ' . $this->pagination->getPagesLinks() . '<br />
                            ' . $this->pagination->getPagesCounter() . '
                        </div>
					</td>
				</tr>';

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