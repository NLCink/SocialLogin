<?php
/**
 * Created by PhpStorm.
 * User: zero
 * Date: 28/11/2015
 * Time: 20:47
 */

namespace CyberZend\SocialLogin\SocialNetwork;

interface SocialLoginInterface extends SocialInterface
{
    /**
     * Initializes service
     *
     * @return $this
     */
    public function initService();

    /**
     * Returns the login url for the social network.
     *
     * @return string
     */
    public function getLoginUrl();

    /**
     * Handles the login callback from the social network.
     *
     * @return SocialUserInterface
     */
    public function loginCallback();
}