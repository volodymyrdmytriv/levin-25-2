<?php
/**
 * $ModDesc
 * 
 * @version   $Id: $file.php $Revision
 * @package   modules
 * @subpackage  $Subpackage.
 * @copyright Copyright (C) November 2010 LandOfCoder.com <@emai:landofcoder@gmail.com>.All rights reserved.
 * @license   GNU General Public License version 2
 */
 
if( !class_exists("LofContentDataSource") ) {
// no direct access
defined('_JEXEC') or die;
require_once JPATH_SITE.'/components/com_content/helpers/route.php';
JModel::addIncludePath(JPATH_SITE.'/components/com_content/models');
require_once JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php';
if( !class_exists("LofContentDataSource") ) {
	/**
	 * class LofContentDataSource
	 */
	class LofContentDataSource extends LofDataSourceBase{
		/**
		 * Get instance of LofContentDataSource Object
		 */
		public static function getInstance(){
			static $_instance = null;
			if( !$_instance ){
				$_instance = new LofContentDataSource(); 
			}
			return $_instance;
		}
		
		/**
		 * Get List articles following to parameters
		 */
		function getList( $params ){
			
			$formatter           = $params->get( 'style_displaying', 'title' );
			$titleMaxChars       = $params->get( 'title_max_chars', '100' );
			$descriptionMaxChars = $params->get( 'description_max_chars', 100 );
			$isThumb       = $params->get( 'auto_renderthumb',1);
			$replacer      = $params->get('replacer','...'); 
			$navDescLimit = $params->get('navdesc_max_chars','0');
			$limitDescriptionBy = $params->get('limit_description_by','char'); 
			$isStriped = $params->get('auto_strip_tags',1);
			$ordering      = $params->get('ordering', 'created-asc');
			
			// Get the dbo
			$db = JFactory::getDbo();
			// Get an instance of the generic articles model
			$model = JModel::getInstance('Articles', 'ContentModel', array('ignore_request' => true));
			// Set application parameters in model
			$app = JFactory::getApplication();
			$appParams = $app->getParams();
			$model->setState('params', $appParams);
			$model->setState('list.select', 'a.fulltext, a.id, a.title, a.alias, a.title_alias, a.introtext, a.state, a.catid, a.created, a.created_by, a.created_by_alias,' .
									' a.modified, a.modified_by,a.publish_up, a.publish_down, a.attribs, a.images, a.metadata, a.metakey, a.metadesc, a.access,' .
									' a.hits, a.featured,' .
									' LENGTH(a.fulltext) AS readmore');
			// Set the filters based on the module params
			$model->setState('list.start', 0);
			$model->setState('list.limit', (int) $params->get('limit_items', 5));
			$model->setState('filter.published', 1);
		
			// Access filter
			$access = !JComponentHelper::getParams('com_content')->get('show_noauth');
			$authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
			$model->setState('filter.access', $access);
			
		   $source = trim($params->get( 'source', 'category' ) );
			if( $source == 'category' ){
			  // Category filter
			  $model->setState('filter.category_id', $params->get('category', array()));
			}else{
			  $ids = preg_split('/,/',$params->get( 'article_ids','')); 
			  $tmp = array();
			  foreach( $ids as $id ){
				$tmp[] = (int) trim($id);
			  }
			  $model->setState('filter.article_id', $tmp);  
			}
		
			// User filter
			$userId = JFactory::getUser()->get('id');
			switch ($params->get('user_id') ) {
			  case 'by_me':
				$model->setState('filter.author_id', (int) $userId);
				break;
			  case 'not_me':
				$model->setState('filter.author_id', $userId);
				$model->setState('filter.author_id.include', false);
				break;
			 case 0:
				break;
		
			  default:
				$model->setState('filter.author_id', (int) $params->get('user_id'));
				break;
			}
		
			// Filter by language
			$model->setState('filter.language',$app->getLanguageFilter());
			//  Featured switch
			switch ( $params->get('show_featured') )  {
			  case 1:
				$model->setState('filter.featured', 'only');
				break;
			  case 0:
				$model->setState('filter.featured', 'hide');
				break;
			  default:
				$model->setState('filter.featured', 'show');
				break;
			}
		
			// Set ordering
			$ordering = preg_split( '/-/', $ordering );
			if( trim($ordering[0]) == 'rand' ){
				$model->setState('list.ordering', ' RAND() '); 
			}
			else {
			  $model->setState('list.ordering', 'a.'.$ordering[0]);
			  $model->setState('list.direction', $ordering[1]);
			} 
		  
			$items = $model->getItems();
	
			foreach ($items as &$item) {
				$item->slug = $item->id.':'.$item->alias;
				$item->catslug = $item->catid.':'.$item->category_alias;
				
				if ($access || in_array($item->access, $authorised)) {
					// We know that user has the privilege to view the article
					$item->link = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catslug));
				}
				else {
					$item->link = JRoute::_('index.php?option=com_user&view=login');
				}
				$item->date = JHtml::_('date', $item->created, JText::_('DATE_FORMAT_LC2')); 
				$item = $this->generateImages( $item, $isThumb );
				$item->fulltext = $item->introtext;
				$item->introtext   = JHtml::_('content.prepare', $item->introtext);
				$item->navdesc    = self::substring( $item->introtext, $navDescLimit, ""  );
				$item->catlink 	 = JRoute::_(ContentHelperRoute::getCategoryRoute($item->catid));
				if( $limitDescriptionBy=='word' ){
					$string = preg_replace( "/\s+/", " ", strip_tags($item->introtext) );
					$tmp    = explode(" ", $string);
					$item->description = $descriptionMaxChars>count($tmp)?$string:implode(" ",array_slice($tmp, 0, $descriptionMaxChars)).$replacer;
				} else {
					$item->description = self::substring( $item->introtext, $descriptionMaxChars, $replacer,  $isStriped  );
				}
			}
		//	echo '<pre>'.print_r($items,1); die;
			return $items;
		}
	}
	}
}
?>