<?php
namespace CyberZend\SocialLogin\SocialNetwork\Facebook;

use CyberZend\SocialLogin\SocialNetwork\SocialUserInterface;

class FacebookUser extends \Magento\Framework\DataObject implements SocialUserInterface
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
        return 'Facebook';
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
        return $this->getData('first_name');
    }

    /**
     * {@inheritdoc}
     */
    public function getLastname()
    {
        return $this->getData('last_name');
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        if($this->hasData('name')) {
            return str_replace(" ", "_", $this->getData('name'));
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmailAddress()
    {
        return $this->getData('email');
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
        return $this->getData('birthday');
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