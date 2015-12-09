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
        return $serviceDataA['sort_order'] - $serviceDataB['sort_order'];
    }

    /**
     * Prepare service data
     */
    protected function _prepareServiceData()
    {
        $this->_listServiceData = [];

        foreach ($this->_socialConfig->getServices() as $serviceId => $serviceData) {
            /** @var \CyberZend\SocialLogin\SocialNetwork\AbstractSocialLogin $serviceLogin */
            $serviceLogin = $this->_objectManager->create($serviceData['class_login']);

            if($serviceLogin->isActive()) {
                $serviceData['login_url'] = $serviceLogin->initService()->getLoginUrl();
                $serviceData['sort_order'] = $serviceLogin->getSortOrder();
                if($serviceLogin->isAvailableService()) {
                    $this->_addService($serviceId, $serviceData);
                }
            }
        }
        uasort($this->_listServiceData, [$this, "compareServiceSortOrder"]);

        return $this->_listServiceData;
    }

    /**
     * @param $serviceId
     * @param $serviceData
     *
     * @return $this
     */
    protected function _addService($serviceId, $serviceData)
    {
        if(!array_key_exists($serviceId, $this->_listServiceData)) {
            $this->_listServiceData[$serviceId] = $serviceData;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function _prepareLayout()
    {
        /** @var \Magento\Customer\Model\Session $customerSession */
        $customerSession = $this->_objectManager->get('Magento\Customer\Model\Session');

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