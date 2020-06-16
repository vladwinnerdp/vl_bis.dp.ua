<?php
/**
 * @author          Tassos Marinos <info@tassos.gr>
 * @link            http://www.tassos.gr
 * @copyright       Copyright © 2018 Tassos Marinos All Rights Reserved
 * @license         GNU GPLv3 <http://www.gnu.org/licenses/gpl.html> or later
 */

defined('_JEXEC') or die;

require_once __DIR__ . '/treeselect.php';

class JFormFieldNRVirtueMartCategories extends JFormFieldNRTreeSelect
{
	/**
	 * Indicates whether the options array should be sorted before render.
	 *
	 * @var boolean
	 */
    protected $sortTree = true;
    
	/**
	 * Indicates whether the options array should have the levels re-calculated
	 * 
	 * @var boolean
	 */
	protected $fixLevels = true;

	/**
	 * Get a list of all EventBooking Categories
	 *
	 * @return void
	 */
	protected function getOptions()
	{
		// Get a database object.
        $db = $this->db;
        
		$query = $db->getQuery(true)
			->select('a.virtuemart_category_id as value, b.category_name as text, c.category_parent_id as parent, IF (a.published=1, 0, 1) as disable')
			->from('#__virtuemart_categories as a')
            ->join('LEFT', '#__virtuemart_categories_en_gb AS b on a.virtuemart_category_id = b.virtuemart_category_id')
			->join('LEFT', '#__virtuemart_category_categories AS c on a.virtuemart_category_id = c.id')
			->order('c.id desc');

		$db->setQuery($query);

		return $db->loadObjectList();
	}
}
