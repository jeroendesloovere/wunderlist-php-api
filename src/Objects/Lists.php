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
 * Wunderlist Lists
 *
 * @author Jeroen Desloovere <info@jeroendesloovere.be>
 */
class Lists extends Object
{
    /**
     * Delete list
     *
     * @param  string $listId
     * @return bool
     */
    public function delete($listId)
    {
        // delete list
        $result = $this->api->doCall('lists/:' . $listId, null, 'DELETE');

        // if delete was successfull an empty result is return
        return (is_array($result) && count($result) == 0);
    }

    /**
     * Get a list
     *
     * @param  string $listId
     * @return array
     */
    public function get($listId)
    {
        return $this->api->doCall('lists/:' . $listId);
    }

    /**
     * Get all lists
     *
     * @return array
     */
    public function getAll()
    {
        return $this->api->doCall('lists');
    }

    /**
     * Insert list
     *
     * @param  string $title
     * @return array
     */
    public function insert($title)
    {
        // init parameters
        $parameters = array();

        // build parameters
        $parameters['title'] = (string) $title;

        // insert list
        return $this->api->doCall('lists', $parameters, 'POST');
    }
}
