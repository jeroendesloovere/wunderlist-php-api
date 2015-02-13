<?php

namespace JeroenDesloovere\Wunderlist\tests;

// required to load
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../examples/credentials.php';

/*
 * This file is part of the HiAnt PHP class from SIESQO.
 *
 * For the full copyright and license information, please view the license
 * file that was distributed with this source code.
 */

use JeroenDesloovere\Wunderlist\Wunderlist;

/**
 * Cache Test.
 *
 * @author Jeroen Desloovere <jeroen@siesqo.be>
 */
class CacheTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->api = new Wunderlist(
            WUNDERLIST_CLIENT_ID,
            WUNDERLIST_OAUTH_TOKEN
        );
    }

    public function tearDown()
    {
        $this->api = null;
    }

    /**
     * Test authentication
     */
    public function testAuthentication()
    {
        $cookie = $this->api->getAuthenticatedCookie();
        $this->assertEquals('ASPXAUTH=', substr($cookie, 1, 9));
    }
}
