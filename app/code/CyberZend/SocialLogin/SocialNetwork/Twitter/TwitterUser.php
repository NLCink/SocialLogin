<?php
namespace CyberZend\SocialLogin\SocialNetwork\Twitter;

use CyberZend\SocialLogin\SocialNetwork\SocialUserInterface;

class TwitterUser extends \Magento\Framework\DataObject implements SocialUserInterface
{
    /**
     * FacebookUser constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }

    /**
     * {@inheritdoc}
     */
    public function getProviderName()
    {
        return 'Twitter';
    }

    /**
     * {@inheritdoc}
     */
    public function getUid()
    {
        return $this->getData('id');
    }

    /**
     * {@inheritdoc}
     */
    public function getFirstname()
    {
        if($this->hasData('name')) {
            list($firstname, $lastname) = explode(" ", $this->getData('name'));
            return $firstname;
        }
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getLastname()
    {
        if($this->hasData('name')) {
            list($firstname, $lastname) = explode(" ", $this->getData('name'));
            return $lastname;
        }
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->getData('screen_name');
    }

    /**
     * {@inheritdoc}
     */
    public function getEmailAddress()
    {
        return $this->getUsername() . '@twitter.com';
    }

    /**
     * {@inheritdoc}
     */
    public function getCity()
    {
        return $this->getData('location');
    }

    /**
     * {@inheritdoc}
     */
    public function getBirthDay()
    {
        return null;
    }

    /**
     * Get the gender
     *
     * @return string
     */
    public function getGender()
    {
        return null;
    }
}