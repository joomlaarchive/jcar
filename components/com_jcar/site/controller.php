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
 * The root controller.
 */
class JCarController extends JControllerLegacy
{
    public function display($cachable = false, $urlparams = array())
    {
        if (JFactory::getApplication()->input->getCmd('view') == 'item') {
            $model = $this->getModel('item');

            if (!$model->doesRouteExist()) {
                $this->setRedirect(JRoute::_($model->generateSefRoute()));
            }
        }

        parent::display($cachable, $urlparams);
    }
}
