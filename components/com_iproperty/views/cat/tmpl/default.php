<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

$advanced_link  = JRoute::_(ipropertyHelperRoute::getAdvsearchRoute());
$this->children = ($this->catinfo) ? ipropertyHelperProperty::getChildren($this->catinfo->id) : '';
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

<table class="ptable">
    <tr>
        <?php if($this->catinfo->icon && $this->catinfo->icon != 'nopic.png'): ?>
        <td width="10%" valign="top">
            <?php  echo ($this->catinfo->icon) ? '<img src="'.$this->ipbaseurl.'/media/com_iproperty/categories/'. $this->catinfo->icon . '" alt="' . $this->catinfo->title . '" border="0" />' : '';?>
        </td>
        <?php endif; ?>
        <td valign="top" width="90%">
            <?php 
                //echo '<strong>'.$this->catinfo->title.'</strong>' . '<br />'.
                echo $this->catinfo->desc;

                if($this->settings->cat_recursive == 1 && $this->children):
                    foreach($this->children as $scat):
                        $valid_scats = (ipropertyHelperProperty::countObjects($scat->id) > 0) ? 1 : '';
                    endforeach;

                    if($valid_scats == 1): //if subcategories have entries, display
                        echo '<div class="ip_subcattitle">' . JText::_( 'COM_IPROPERTY_SUBCATEGORIES' ) . '</div>';
                        $stotal=0;
                        foreach($this->children as $scat): //foreach subcategory, show title and entries
                            $scat_name = (strlen($scat->title) > 30 ) ? (substr( $scat->title, 0, 27) . '...') : ($scat->title);
                            $scat_entries = ipropertyHelperProperty::countObjects($scat->id);
                            if( $this->settings->cat_entries == 1 ) $scount = ' - <span class="ip_subcatlink_count"> (' . $scat_entries . ')</span>';
                            $slink = JRoute::_(ipropertyHelperRoute::getCatRoute($scat->id.':'.$scat->alias));

                            echo '<a href="' . $slink . '" class="ip_subcatlink">' . $scat_name . '</a>' . $scount;
                            if($stotal < (count($this->children)-1)) echo ', ';

                            $stotal++;
                        endforeach;
                    endif;
                endif;
            ?>
        </td>
    </tr>
</table>
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