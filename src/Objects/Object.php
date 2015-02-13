<?php

namespace JeroenDesloovere\Wunderlist\Objects;

/*
 * This file is part of the Wunderlist PHP class from Jeroen Desloovere.
 *
 * For the full copyright and license information, please view the license
 * file that was distributed with this source code.
 */

use JeroenDesloovere\Wunderlist\Wunderlist;

/**
 * Wunderlist Object
 *
 * @author Jeroen Desloovere <info@jeroendesloovere.be>
 */
class Object
{
    /**
     * @var Wunderlist
     */
    public $api;

    /**
     * Construct
     *
     * @param Wunderlist $api
     */
    public function __construct(Wunderlist $api)
    {
        $this->api = $api;
    }
}
