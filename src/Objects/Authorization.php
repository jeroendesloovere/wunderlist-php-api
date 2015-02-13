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
 * Wunderlist Authorization
 *
 * @author Jeroen Desloovere <info@jeroendesloovere.be>
 */
class Authorization extends Object
{
    // OAUTH URLS
    const OAUTH_URL_STEP_1 = 'https://www.wunderlist.com/oauth/authorize';
    const OAUTH_URL_STEP_2 = 'https://www.wunderlist.com/oauth/access_token';

    /**
     * Get code - Authorize step 1
     *
     * @param string $redirectUrl
     */
    protected function getCode($redirectUrl)
    {
        // define auto-generated required random security token
        $randomSecurityToken = substr(md5(rand()), 0, 15);

        // init parameters
        $parameters = array();

        // define parameters
        $parameters['client_id'] = $this->api->getClientId();
        $parameters['redirect_uri'] = (string) $redirectUrl;
        $parameters['state'] = $randomSecurityToken;

        // define url
        $url = self::OAUTH_URL_STEP_1 . '?' . http_build_query($parameters);

        // redirect
        // @todo
    }

    /**
     * Get access token - Authorize step 2: we exchange our code for an access token
     *
     * @param string $redirectUrl
     * @param string $code The code you received from step one, ->getCode($redirectUrl);
     */
    protected function getAccessToken(
        $redirectUrl,
        $code
    ) {
        // init parameters
        $parameters = array();

        // define parameters
        $parameters['client_id'] = $this->api->getClientId();
        $parameters['client_secret'] = $this->api->getClientSecret();
        $parameters['code'] = $code;

        // define url
        $url = self::OAUTH_URL_STEP_2 . '?' . http_build_query($parameters);

        // redirect
        // @todo
        /*
        // the response will look like this
        {
          "access_token": "976d16a81ccf621a654fcc23193b09498b220e89eb72ced3",
          "token_type": "bearer"
        }
        */
    }
}
