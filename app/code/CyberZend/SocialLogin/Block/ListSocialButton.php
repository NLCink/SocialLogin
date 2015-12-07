<?php


namespace CyberZend\SocialLogin\Block;
use CyberZend\SocialLogin\SocialNetwork\AbstractSocialLogin;

class ListSocialButton extends \Magento\Framework\View\Element\Template
{
    /**
     * {@inheritdoc}
     */
    protected $_template = 'CyberZend_SocialLogin::list-social-button.phtml';

    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * @var \CyberZend\SocialLogin\Model\Config\ConfigInterface
     */
    protected $_socialConfig;

    /**
     * @var array
     */
    protected $_listServiceData = [];

    /**
     * Block constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \CyberZend\SocialLogin\Model\Config\ConfigInterface $socialConfig,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        array $data = array()
    ) {
        parent::__construct($context, $data);
        $this->_socialConfig = $socialConfig;
        $this->_objectManager = $objectManager;
    }

    /**
     * @param $serviceDataA
     * @param $serviceDataB
     *
     * @return mixed
     */
    public function compareServiceSortOrder($serviceDataA, $serviceDataB) {
        return $serviceDataA['service_login']->getSortOrder() - $serviceDataB['service_login']->getSortOrder();
    }

    /**
     * Prepare service data
     */
    protected function _prepareServiceData()
    {
        foreach ($this->_socialConfig->getServices() as $serviceId => $serviceData) {
            /** @var \CyberZend\SocialLogin\SocialNetwork\AbstractSocialLogin $serviceLogin */
            $serviceLogin = $this->_objectManager->create($serviceData['class_login']);
            if($serviceLogin->isActive()) {
                $serviceData['service_login'] = $serviceLogin->initService();
                $this->_listServiceData[$serviceId] = $serviceData;
            }
        }
        uasort($this->_listServiceData, [$this, "compareServiceSortOrder"]);

        return $this->_listServiceData;
    }

    /**
     * {@inheritdoc}
     */
    protected function _prepareLayout()
    {
        /** @var \Magento\Customer\Model\Session $customerSession */
        $customerSession = $this->_objectManager->create('Magento\Customer\Model\Session');

        if($customerSession->isLoggedIn()) {
            return parent::_prepareLayout();
        }

        foreach ($this->_prepareServiceData() as $serviceId => $serviceData) {
            $this->addChild(
                $this->getNameInLayout() . '_' . $serviceId,
                'CyberZend\SocialLogin\Block\SocialButton',
                $serviceData
            );
        }

        return parent::_prepareLayout();
    }
}