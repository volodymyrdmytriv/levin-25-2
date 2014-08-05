<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2009 Andy Sharman @ udjamaflip.com
 * @modified and rewritten by the Thinkery
 * @license see LICENSE.php
 */

//no direct access
defined('_JEXEC') or die('Restricted Access');

// Include the syndicate functions only once
require_once (dirname(__FILE__).DS.'helper.php');

$moduleclass_sfx    = htmlspecialchars($params->get('moduleclass_sfx'));

$data = modIpTagCloudHelper::getWords($params);
if(!$data) return false;

//The magic..
$realWordList   = modIpTagCloudHelper::filterWords($data, $params->get('excludelist'), $params->get('exclude_nonalph'));
$wordArray      = modIpTagCloudHelper::parseString($realWordList, $params->get('tagcount'));
?>

<div class="iptagcloud<?php echo $moduleclass_sfx; ?>">
    <?php modIpTagCloudHelper::outputWords($wordArray, $params->get('minsize'), $params->get('maxsize'), $params->get('fontcolor')); ?>
</div>