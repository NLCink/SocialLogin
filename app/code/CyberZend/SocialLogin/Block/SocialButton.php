<?php


namespace CyberZend\SocialLogin\Block;

class SocialButton extends \Magento\Framework\View\Element\Template
{
    /**
     * {@inheritdoc}
     */
    protected $_template = 'CyberZend_SocialLogin::social-button.phtml';

    /**
     * @var \CyberZend\SocialLogin\SocialNetwork\SocialLoginInterface
     */
    protected $_serviceLogin;

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
     * {@inheritdoc}
     */
    protected function _construct()
    {
        parent::_construct();

        if($this->hasData('service_login')) {
            $this->setServiceLogin($this->getData('service_login'));
        }
    }

    /**
     * @param \CyberZend\SocialLogin\SocialNetwork\SocialLoginInterface $socialService
     *
     * @return SocialButton
     */
    public function setServiceLogin($serviceLogin)
    {
        $this->_serviceLogin = $serviceLogin;

        return $this;
    }

    /**
     * @return \CyberZend\SocialLogin\SocialNetwork\SocialLoginInterface
     */
    public function getServiceLogin()
    {
        return $this->_serviceLogin;
    }
}