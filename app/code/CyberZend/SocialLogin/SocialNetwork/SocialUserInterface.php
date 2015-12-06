<?php
/**
 * Created by PhpStorm.
 * User: zero
 * Date: 28/11/2015
 * Time: 20:47
 */

namespace CyberZend\SocialLogin\SocialNetwork;


interface SocialUserInterface extends SocialInterface
{
    /**
     * Get the UID of the user
     *
     * @return string
     */
    public function getUid();

    /**
     * Get the first name of the user
     *
     * @return string
     */
    public function getFirstname();

    /**
     * Get the last name of the user
     *
     * @return string
     */
    public function getLastname();

    /**
     * Get the username
     *
     * @return string
     */
    public function getUsername();

    /**
     * Get the emailaddress
     *
     * @return string
     */
    public function getEmailAddress();

    /**
     * Get the city
     *
     * @return string
     */
    public function getCity();

    /**
     * Get the birthday
     *
     * @return string
     */
    public function getBirthDay();

    /**
     * Get the gender
     *
     * @return string
     */
    public function getGender();
}