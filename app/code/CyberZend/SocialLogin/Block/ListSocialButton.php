<?php


namespace CyberZend\SocialLogin\Block;

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
     * {@inheritdoc}
     */
    protected function _prepareLayout()
    {
        foreach ($this->_socialConfig->getServices() as $serviceId => $serviceData) {
            /** @var TYPE_NAME $serviceData */
            $serviceData['service_login'] = $this->_objectManager->create($serviceData['class_login'])->initService();
            $this->addChild(
                $this->getNameInLayout() . '_' . $serviceId,
                'CyberZend\\SocialLogin\\Block\\SocialButton',
                $serviceData
            );
        }
        return parent::_prepareLayout();
    }
}