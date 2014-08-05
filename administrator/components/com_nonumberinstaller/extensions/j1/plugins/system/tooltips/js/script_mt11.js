/**
 * Main JavaScript file
 *
 * @package         Tooltips (MooTools 1.1 compatible)
 * @version         2.2.1
 *
 * @author          Peter van Westen <peter@nonumber.nl>
 * @link            http://www.nonumber.nl
 * @copyright       Copyright © 2012 NoNumber All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

function tooltips_init(tip)
{
	var tip = tip;
	tip.fade_in = new Fx.Styles(tip, {
		'duration': tooltips_fade_in_speed
	});
	tip.fade_out = new Fx.Styles(tip, {
		'duration': tooltips_fade_out_speed,
		onComplete: function(tip) { tooltips_hide_complete(tip) }
	});
	tip.initialized = 1;
}
function tooltips_show(tip)
{
	if (typeof( tip.initialized ) == 'undefined') {
		tooltips_init(tip);
	}
	$$('.tooltips-tip').each(function(el)
	{
		el.setStyle('display', 'none');
	});
	if (( tip.getElement('img') && tip.getElement('img').getStyle('width').toInt() > tooltips_max_width )
		|| ( tip.getElement('table') && tip.getElement('table').getStyle('width').toInt() > tooltips_max_width )
		) {
		tip.getChildren()[0].setStyle('max-width', 'none');
	} else {
		tip.getChildren()[0].setStyle('max-width', tooltips_max_width);
	}
	tip.setStyle('display', 'block');
	tip.fade_in.stop();
	tip.fade_out.stop();
	tip.fade_in.start({ 'opacity': 1 });
}
function tooltips_hide(tip)
{
	tip.fade_in.stop();
	tip.fade_out.stop();
	tip.fade_out.start({ 'opacity': 0 });
}
function tooltips_hide_complete(tip)
{
	tip.setStyle('display', 'none');
}