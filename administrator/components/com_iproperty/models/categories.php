<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.modellist');

class IpropertyModelCategories extends JModelList
{
    protected $_escape  = 'htmlspecialchars';
    protected $_charset = 'UTF-8';
    
	public function __construct()
	{
		parent::__construct();
	}
    
    protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id	.= ':'.$this->getState('filter.search');

		return parent::getStoreId($id);
	}
    
    public function getTable($type = 'Category', $prefix = 'IpropertyTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}
    
    protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app = JFactory::getApplication('administrator');

		// Load the filter state.
		$search = $app->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		// List state information.
		parent::populateState('ordering', 'asc');
	}
	
	public function catLoop(&$i, $parent, $spcr, $published, $settings, $ipauth)
    {
        $query = $this->_db->getQuery(true);

        $query->select('c.*, c.state AS state, c.alias AS alias, ag.title AS groupname, u.name AS editor, (SELECT COUNT(id) FROM #__iproperty_propmid WHERE cat_id = c.id) AS entries')
            ->from('#__iproperty_categories AS c')
            ->leftJoin('#__viewlevels AS ag ON ag.id = c.access')
            ->leftJoin('#__users AS u ON u.id = c.checked_out')
            ->where('parent = '.(int)$parent)
            ->group('c.id')
            ->order('c.ordering ASC');

        $this->_db->setQuery($query);
   		$items = $this->_db->loadObjectList();

        $c      = 0;
		$count  = count($items);
		//echo $count;
        if($count){
            foreach($items as $item){                
                $up     = ($c == 0) ? false : true;
                $down   = ($c + 1 == $count) ? false : true;

                $this->catOverview($i, $spcr, $item, $up, $down, $published, $settings, $ipauth);

                $i++;
                $c++;

                $this->catLoop( $i, $item->id, $spcr."<span class=\"gi\">|&mdash;</span>", ($published == 0) ? $published : $item->state, $settings, $ipauth );                
            }
        } else if($parent == 0){
            echo '<tr><td colspan="9" style="text-align: center;">'.JText::_( 'COM_IPROPERTY_NO_RESULTS' ).'</td></tr>';
        }
	}   
	
	public function catOverview($i, $spcr, $item, $up, $down, $published, $settings, $ipauth)
    {
        $user           = JFactory::getUser();
        $canCheckin     = $user->authorise('core.manage',		'com_checkin') || $item->checked_out == $user->get('id') || $item->checked_out == 0;
        $canEdit        = $ipauth->getAdmin();
		?>
   			 <tr class="row<?php echo $i % 2; ?>">				
				<td class="center">
                    <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                </td>
                <td align="center"><?php echo ($item->icon) ? '<a href="../media/com_iproperty/categories/'.$item->icon. '" class="modal">'.ipropertyHTML::getCatIcon($item->id, 20, true).'</a>' : '--'; ?></td>
                <td>
					<?php
                        echo $spcr;
                        if(!$item->state){
                            $item->title='<strong style="color:#999999">'.$item->title.'</strong>';
                            if($item->entries > 0){
                                $item->entries = '<strong style="color:#ff0000;">'.$item->entries.'</strong>';
                            }
                        }else if(!$published){
                            $item->title='<strong style="color:#ff0000;">'.$item->title.'</strong>';
                            if($item->entries > 0){
                                $item->entries = '<strong style="color:#ff0000;">'.$item->entries.'</strong>';
                            }
                        }

                        if ($item->checked_out){
                            echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'categories.', $canCheckin);
                        }
                        if ($canEdit){
                            echo '
                                <a href="'.JRoute::_('index.php?option=com_iproperty&task=category.edit&id='.(int) $item->id).'">
                                    '.$item->title.'
                                </a>';
                        }else{
                            echo $item->title;
                        }
					?> 
                    <p class="smallsub">
                        <?php echo $spcr.JText::sprintf('JGLOBAL_LIST_ALIAS', $item->alias);?></p>
                    <p class="smallsub">
				</td>				
				<td><?php echo ipropertyHTML::snippet($item->desc, 150); ?></td>
				<td align="center"><?php echo $item->groupname;?></td>
                <td class="order" align="center">
                    <?php
                    if($up) {
                        echo '<span><a class="jgrid" href="#reorder" onClick="return listItemTask(\'cb'.$i.'\',\'categories.orderup\')" title="' . JText::_( 'COM_IPROPERTY_MOVE_UP' ) . '">';
                        echo '<span class="state uparrow"><span class="text">'.JText::_( 'COM_IPROPERTY_MOVE_UP' ).'</span></span>';
                        echo '</a></span>';
                    }

                    if($down) {
                        echo '<span><a class="jgrid" href="#reorder" onClick="return listItemTask(\'cb'.$i.'\',\'categories.orderdown\')" title="' . JText::_( 'COM_IPROPERTY_MOVE_DOWN' ) . '">';
                        echo '<span class="state downarrow"><span class="text">'.JText::_( 'COM_IPROPERTY_MOVE_DOWN' ).'</span></span>';
                        echo '</a></span>';
                    }
                    ?>
                </td>
				<td align="center"><?php echo $item->entries; ?></td>
				<td align="center"><?php echo JHtml::_('jgrid.published', $item->state, $i, 'categories.', true, 'cb'); ?></td>
                <td><?php echo $item->id ;?></td>
			</tr>   
    	<?php	
	}
}//Class end
?>