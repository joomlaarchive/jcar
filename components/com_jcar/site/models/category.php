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
 * Models an category from an archive.
 */
class JCarModelCategory extends JModelItem
{
    protected $item;

    protected function populateState()
    {
        parent::populateState();

        $app = JFactory::getApplication();

        $pk = $app->input->getString('id');
        $this->setState('category.id', $pk);

        $params = $app->getParams();
        $this->setState('params', $params);
    }

    public function getItem($pk = null)
    {
        $pk = (!empty($pk)) ? $pk : $this->getState('category.id');

        if ($this->item === null) {
            $this->item = array();
        }

        if (!JArrayHelper::getValue($this->item, $pk)) {
            $parts = explode(":", $pk, 2);

            $plugin = null;

            if (count($parts) == 2) {
                $plugin = JArrayHelper::getValue($parts, 0);
            } else {
                JLog::add('Invalid id format', JLog::CRITICAL, 'jcar');

                // if there are not two parts, we can assume that the id is
                // missing the plugin identifier prefix.
                throw new Exception('Invalid id format', 400);
            }

            $dispatcher = JEventDispatcher::getInstance();
            JPluginHelper::importPlugin('jcar', $plugin);

            // Trigger the data preparation event.
            $responses = $dispatcher->trigger('onJCarCategoryRetrieve', array($pk));

            // loop through responses until we find a valid one.
            $valid = false;

            $this->item[$pk] = null;

            while (($response = current($responses)) && !$valid) {
                if ($response !== null) {
                    $valid = true;

                    // if category has items, build urls for them.
                    if (property_exists($response, "items")) {
                        for ($i = 0; $i < count($response->items); $i++) {
                            $id = $response->items[$i]->id;
                            $url = JCarHelperRoute::getItemRoute($id);
                            $response->items[$i]->link = $url;
                        }
                    }

                    $this->item[$pk] = $response;
                }

                next($responses);
            }
        }

        return JArrayHelper::getValue($this->item, $pk);
    }
}
