<?php

namespace JeroenDesloovere\Wunderlist\Objects;

/*
 * This file is part of the Wunderlist PHP class from Jeroen Desloovere.
 *
 * For the full copyright and license information, please view the license
 * file that was distributed with this source code.
 */

use JeroenDesloovere\Wunderlist\Objects\Object as Object;

/**
 * Wunderlist Tasks
 *
 * @author Jeroen Desloovere <info@jeroendesloovere.be>
 */
class Tasks extends Object
{
    const ENDPOINT_TASKS = 'tasks';

    /**
     * Delete task
     *
     * @param  string $taskId
     * @return bool
     */
    public function delete($taskId)
    {
        // delete list
        $result = $this->api->doCall(ENDPOINT_TASKS . '/:' . $taskId, null, 'DELETE');

        // if delete was successfull an empty result is return
        return (is_array($result) && count($result) == 0);
    }

    /**
     * Get a task
     *
     * @param  string $taskId
     * @return array
     */
    public function get($taskId)
    {
        return $this->api->doCall(ENDPOINT_TASKS . '/:' . $taskId);
    }

    /**
     * Get all tasks
     *
     * @return array
     */
    public function getAll()
    {
        return $this->api->doCall(ENDPOINT_TASKS);
    }

    /**
     * Insert task
     *
     * @param  string $title
     * @param  string $listId
     * @param  string $parentId[optional]
     * @param  string $dueDate[optional]
     * @param  bool   $starred[optional]
     * @return array
     */
    public function insert(
        $title,
        $listId,
        $parentId = null,
        $dueDate = null,
        $starred = false
    ) {
        // init parameters
        $parameters = array();

        // build parameters
        $parameters['title'] = (string) $title;
        $parameters['list_id'] = (string) $listId;
        $parameters['starred'] = ((bool) $starred) ? 1 : 0;

        // we have a parent id
        if ($parentId !== null) {
            // add to parameters
            $parameters['parent_id'] = $parentId;
        }

        // we have a due date
        if ($dueDate !== null) {
            // is no time
            if (!strtotime($dueDate)) {
                // throw error
                throw new WunderlistException('Parameters dueDate is invalid.');
            }

            // add parameter
            $parameters['due_date'] = date('Y-m-d', strtotime($dueDate));
        }

        // return insert task
        return $this->api->doCall(ENDPOINT_TASKS, $parameters, 'POST');
    }
}
