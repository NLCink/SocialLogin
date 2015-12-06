<?php
/**
 * Created by PhpStorm.
 * User: zero
 * Date: 28/11/2015
 * Time: 20:49
 */

namespace CyberZend\SocialLogin\SocialNetwork;


interface SocialInterface
{
    /**
     * Get the provider name
     *
     * @return string
     */
    public function getProviderName();
}