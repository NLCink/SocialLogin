<?php


namespace CyberZend\SocialLogin\SocialNetwork\Google;

use CyberZend\SocialLogin\SocialNetwork\SocialUserInterface;

class GoogleUser extends \Magento\Framework\DataObject implements SocialUserInterface
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
        return 'Google';
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
        return $this->getData('given_name');
    }

    /**
     * {@inheritdoc}
     */
    public function getLastname()
    {
        return $this->getData('family_name');
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        if($this->hasData('family_name')) {
            return str_replace(" ", "_", $this->getData('family_name'));
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
        return null;
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
        return $this->getData('gender');
    }
}