<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
$total = count( $this->catinfo[0]->children );
$cols = $this->settings->iplayout;
$colwidth = round(100/$cols);
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
if( $this->featured && $this->settings->featured_pos == 0 ){
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

<table class="ip_cat_overview">
    <tr>
    <?php
    $x = 0;
    $constant = 0;
    foreach( $this->catinfo[0]->children as $c) { // show maincategories
        $cat = $this->catinfo[strval($c)];
        if( $cat->entries + $cat->entriesR > 0 ){
            $catlink = JRoute::_(IpropertyHelperRoute::getCatRoute($cat->id.':'.$cat->alias));
            $catcount = ($this->settings->cat_entries==1) ? "<br /><strong>" . JText::_( 'COM_IPROPERTY_ENTRIES' ) . ":</strong> (" . $cat->entries . ")" : '';

            echo '
            <td class="ip_cat_entry" width="'.$colwidth.'%">
                <table class="ptable">
                    <tr>';
                    if($cat->icon && $cat->icon != 'nopic.png'){
                        echo '
                        <td width="10%" valign="top">
                            <a href="' . $catlink . '"><img src="'.$this->cat_folder.$cat->icon . '" align="middle" alt="' . $cat->title . '" title="' . $cat->title . '" border="0" /></a>
                        </td>';
                        $ipcolspan = '';
                        $ipcolwidth = '90%';
                    }else{
                        $ipcolspan = ' colspan="2"';
                        $ipcolwidth = '100%';
                    }
                    echo '
                    <td width="'.$ipcolwidth.'"'.$ipcolspan.' valign="top">
                        <a href="'. $catlink . '">' . $cat->title . '</a> ' . $catcount . '<br />
                        ' . strip_tags($cat->desc,'<br />,<strong><b>');
                        //show subcategories if any and set in admin
                        if( count( $this->catinfo[0]->children ) > 0 &&  $this->settings->show_scats == 1 && count(@$cat->children) > 0){
                            if(count(@$cat->children) > 0){ //check for subcategories
                                $valid_subcats = 0;
                                foreach($cat->children as $sc) { //check for entries in subcategories
                                    $scat= $this->catinfo[$sc];
                                    if(($scat->entries+$scat->entriesR) > 0){
                                        $valid_subcats++;
                                    }
                                }
                                if($valid_subcats > 0){ //if subcategories with entries show subcat title
                                    echo '<br /><div class="ip_subcattitle">' . $cat->title . ' ' . JText::_( 'COM_IPROPERTY_SUBCATEGORIES' ) . ':</div>';
                                }
                            }
                            $stotal = 0;
                            foreach($cat->children as $sc) {
                                $scat= $this->catinfo[$sc];
                                if($cat->id){
                                    if(($scat->entries+$scat->entriesR) > 0){
                                        //$scat->entries = ( $scat->entries + $scat->entriesR );
                                        $scat_name = (strlen($scat->title) > 30 ) ? (substr( $scat->title, 0, 27) . '...') : ($scat->title);
                                        if( $this->settings->cat_entries == 1 ) $scount = ' - <span class="ip_subcatlink_count"> (' . $scat->entries . ')</span>';
                                        $slink = JRoute::_(IpropertyHelperRoute::getCatRoute($scat->id.':'.$scat->alias));
                                        echo '<a href="' . $slink . '" class="ip_subcatlink">' . $scat_name . '</a>' . $scount;
                                        if($stotal < ($valid_subcats - 1)) echo ', ';
                                    }
                                }
                                $stotal++;
                           }
                       }
                echo '
                    </td>
                    </tr>
                </table>
            </td>';

            $x++;
            $constant++;

            // start a new row if column count is less than the total
            if( $x == $cols && ($constant != $total)){
                echo '</tr><tr>';
                $x = 0;
            }

            // complete row with empty td cells if needed
            if( $x < $cols && $constant == $total){
                while( $x < $cols){
                    echo '<td class="ip_cat_entry no_result" width="'.$colwidth.'%" valign="top">&nbsp;</td>';
                    $x++;
                }
            }
       }
    }
    ?>
    </tr>
</table>

<?php
if( $this->featured && $this->settings->featured_pos == 1 ){
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

if( $this->settings->footer == 1):
    echo ipropertyHTML::buildThinkeryFooter();
endif;