<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

$munits     = (!$this->settings->measurement_units) ? JText::_( 'COM_IPROPERTY_SQFT' ) : JText::_( 'COM_IPROPERTY_SQM' );
$border     = ($this->p->featured) ? ' style="border: solid 1px ' . $this->settings->featured_accent . ';"' : '';
$span_style = ($this->p->featured) ? ' style="color: ' . $this->settings->featured_accent . ';"' : '';
?>

<tr class="iprow<?php echo $this->k; ?>">
    <td width="10%" valign="top">
        <div class="property_thumb_holder"<?php echo $border; ?>>
            <?php echo ipropertyHTML::displayBanners($this->p->stype, $this->p->new, $this->ipbaseurl, $this->settings, $this->p->updated); ?>
            <?php echo ipropertyHTML::getThumbnail($this->p->id, $this->p->proplink, $this->p->street_address, $this->thumb_width, 'class="ip_overview_thumb"'); ?>
        </div>
        <div class="prop_overview_price" align="right">
            <?php echo $this->p->formattedprice; ?>
        </div>
    </td>
    <td width="90%" valign="top">
        <div class="property_overview_mlstitle">
            <?php if( $this->p->featured ): ?>
            <div class="property_overview_bannerright" align="right">
                <img src="<?php echo $this->ipbaseurl; ?>/components/com_iproperty/assets/images/banners/banner_hot.png" alt="<?php echo JText::_( 'COM_IPROPERTY_FEATURED' ); ?>" title="<?php echo JText::_( 'COM_IPROPERTY_FEATURED' ); ?>" />
            </div>
            <?php endif; ?>
        </div>
        <div class="property_overview_title">
            <a href="<?php echo $this->p->proplink; ?>"<?php echo $span_style; ?> class="property_header_accent"><?php echo $this->p->street_address; ?></a>
            <?php
                if( $this->p->city ) echo ' - '.$this->p->city;
                if( $this->p->locstate ) echo ', ' . ipropertyHTML::getstatename($this->p->locstate);
                if( $this->p->province ) echo ', ' . $this->p->province;
                if( $this->p->country ) echo ' ' . ipropertyHTML::getcountryname($this->p->country);
                echo '<br />';

                echo '<em>';
                if( $this->p->beds ) echo '<strong>' .JText::_( 'COM_IPROPERTY_BEDS' ).':</strong> ' . $this->p->beds . ' &nbsp;&nbsp;';
                if( $this->p->baths && $this->p->baths != '0.00' ) echo '<strong>' .JText::_( 'COM_IPROPERTY_BATHS' ).':</strong> ' . $this->p->baths . ' &nbsp;&nbsp;';
                if( $this->p->sqft ) echo '<strong>' .$munits.':</strong> ' . $this->p->sqft . ' &nbsp;&nbsp;';
                if( $this->p->lotsize ) echo '<strong>' .JText::_( 'COM_IPROPERTY_LOT_SIZE' ).':</strong> ' . $this->p->lotsize . ' &nbsp;&nbsp;';
                if( $this->p->lot_acres ) echo '<strong>' .JText::_( 'COM_IPROPERTY_LOT_ACRES' ).':</strong> ' . $this->p->lot_acres . ' &nbsp;&nbsp;';
                if( $this->p->county ) echo '<strong>' .JText::_( 'COM_IPROPERTY_COUNTY' ).':</strong> ' . $this->p->county . ' &nbsp;&nbsp;';
                if( $this->p->region ) echo '<strong>' .JText::_( 'COM_IPROPERTY_REGION' ).':</strong> ' . $this->p->region . ' &nbsp;&nbsp;';
                echo '</em>';
            ?>
        </div>

        <div id="ip_ohdetails" class="ip_openhouse">
            <?php
                if( $this->p->ohname ) echo '<em>' .$this->p->ohname . '</em><br />';
                if( $this->p->ohstart ) echo $this->p->ohstart . ' - ';
                if( $this->p->ohend ) echo $this->p->ohend;
                if( $this->p->comments ) echo '<p class="ip_openhouse_desc">' . $this->p->comments . '</p>';
            ?>
        </div>
        <?php if($this->p->listing_info) echo '<div class="ip_smallfont">'.$this->p->listing_info.'</div>'; ?>
    </td>
</tr>
