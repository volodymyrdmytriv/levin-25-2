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

<?php
    if( $this->company ):
        $this->k = 1;
        echo '<table class="ptable">';
        echo $this->loadTemplate('company');
        echo '</table>';
    endif;

    //display results for featured agents
    if( $this->featured && $this->settings->agent_feat_pos == 0 ){
        echo '<table class="ptable featured_table">
                <tr>
                  <td colspan="2">
                    <div class="property_header">
                    ' . JText::_( 'COM_IPROPERTY_FEATURED_AGENTS' ) . '
                    </div>
                  </td>
                </tr>';
                $this->k = 0;
                foreach( $this->featured as $f ){
                    $this->agent = $f;
                    echo $this->loadTemplate('agent');
                    $this->k = 1 - $this->k;
                }
        echo '</table>';
    }
?>
<table class="ptable">
	<?php
        //display quick search form
        echo $this->loadTemplate('quicksearch');

        //display results for agents
        if( $this->agents ) :
			echo
				'<tr>
				  <td colspan="2">
				  	<div class="property_header">
					' . JText::_( 'COM_IPROPERTY_AGENTS_OF' ) . ' ' . ipropertyHTML::getCompanyName($this->company->id) . '
					<div align="right" class="property_header_results">
						' . $this->pagination->getResultsCounter() . '
					</div>
					</div>
				  </td>
				</tr>';
				$this->k = 0;
                foreach($this->agents as $a) :
					$this->agent = $a;
					echo $this->loadTemplate('agent');
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
    if( $this->featured && $this->settings->agent_feat_pos == 1 ){
        echo '<table class="ptable featured_table">
                <tr>
                  <td colspan="2">
                    <div class="property_header">
                    ' . JText::_( 'COM_IPROPERTY_FEATURED_AGENTS' ) . '
                    </div>
                  </td>
                </tr>';
                $this->k = 0;
                foreach( $this->featured as $f ){
                    $this->agent = $f;
                    echo $this->loadTemplate('agent');
                    $this->k = 1 - $this->k;
                }
        echo '</table>';
    }

    if( $this->settings->footer == 1):
        echo ipropertyHTML::buildThinkeryFooter();
    endif;
?>
