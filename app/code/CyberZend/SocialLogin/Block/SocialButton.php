<?php


namespace CyberZend\SocialLogin\Block;

class SocialButton extends \Magento\Framework\View\Element\Template
{
    /**
     * {@inheritdoc}
     */
    protected $_template = 'CyberZend_SocialLogin::social-button.phtml';

    /**
     * @var \CyberZend\SocialLogin\SocialNetwork\AbstractSocialLogin
     */
    protected $_serviceLogin;

    /**
     * @var string
     */
    protected $_loginUrl;

    /**
     * Block constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = array()
    ) {
        parent::__construct($context, $data);
    }

    /**
     * @param string $loginUrl
     *
     * @return SocialButton
     */
    public function setLoginUrl($loginUrl)
    {
        $this->_loginUrl = $loginUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getLoginUrl()
    {
        return $this->_loginUrl;
    }

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        parent::_construct();

        if($this->hasData('login_url')) {
            $this->setLoginUrl($this->getData('login_url'));
        }
    }

    /**
     * @param \CyberZend\SocialLogin\SocialNetwork\AbstractSocialLogin $socialService
     *
     * @return SocialButton
     */
    public function setServiceLogin($serviceLogin)
    {
        $this->_serviceLogin = $serviceLogin;

        return $this;
    }

    /**
     * @return \CyberZend\SocialLogin\SocialNetwork\AbstractSocialLogin
     */
    public function getServiceLogin()
    {
        return $this->_serviceLogin;
    }
}