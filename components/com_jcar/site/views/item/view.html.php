<?php
/**
 * @package     JCar.Component
 * @subpackage  Site
 *
 * @copyright   Copyright (C) 2015-2017 KnowledgeArc Ltd. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

/**
 * Displays an item from an archive.
 */
class JCarViewItem extends JViewLegacy
{
    protected $item;

    protected $params;

    /**
     * Display an item.
     *
     * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
     *
     * @return  mixed  A string if successful, otherwise a Error object.
     */
    public function display($tpl = null)
    {
        $this->item = $this->get('Item');
        $this->state = $this->get('State');
        $this->params = $this->state->get('params');

        parent::display($tpl);
    }
}
