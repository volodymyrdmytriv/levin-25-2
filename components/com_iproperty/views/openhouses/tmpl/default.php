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

<table class="ptable">
    <?php
        //display results for properties
        if( $this->properties ) :
            $enddate = $this->properties[0]->enddate;
            $i = false;
            echo
                '<tr>
                  <td colspan="2">
                    <div class="property_header">
                    ' . JText::_( 'COM_IPROPERTY_OPENHOUSES' ) . '
                    <div align="right" class="property_header_results">
                        ' . $this->pagination->getResultsCounter() . '
                    </div>
                    </div>
                  </td>
                </tr>';
                $this->k = 0;
                foreach($this->properties as $p) :
                    //echo $p->startdate;
                    if($p->enddate != $enddate || !$i) {
                        echo
                        '<tr>
                          <td colspan="2">
                            <div class="openhouse_header">
                            ' . JText::_( 'COM_IPROPERTY_ENDS' ) . ' ' . $p->enddate . '
                            </div>
                          </td>
                        </tr>';
                        $enddate = $p->enddate;
                        $i = true;
                    }

                    $this->p = $p;
                    echo $this->loadTemplate('openhouse');
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
    if ($this->params->get('show_ip_disclaimer') && $this->settings->disclaimer){
        echo '<div class="ip_disclamer">
                '.$this->settings->disclaimer.'
            </div>';
    }
    if( $this->settings->footer == 1):
        echo ipropertyHTML::buildThinkeryFooter();
    endif;
?>
