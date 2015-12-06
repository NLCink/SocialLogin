<?php 

namespace CyberZend\SocialLogin\Block;

/**
 * Block BlockTest
 */
class BlockTest extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * Block constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        array $data = array()
    ) {
        parent::__construct($context, $data);
        $this->_objectManager = $objectManager;
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return $this->_cache->load('cyberZend_sociallogin_config');
    }

    public function showButton()
    {
        /** @var \CyberZend\SocialLogin\Model\Config\ConfigInterface $config */
        $config = $this->_objectManager->get('CyberZend\SocialLogin\Model\Config\ConfigInterface');

        foreach ($config->getServices() as $serviceData) {
            /** @var \CyberZend\SocialLogin\SocialNetwork\SocialLoginInterface $serviceLogin */
            $serviceLogin = $this->_objectManager->create($serviceData['class_login']);
            $serviceLogin->initService();
            try {
                echo $serviceData['label'] . ' ' . sprintf('<a href="%s">%s</a>', $serviceLogin->getLoginUrl(), $serviceData['label']) . '<br>';
            } catch (\Exception $e){
                echo $serviceData['label'] . ' ';
                echo $e->getMessage();
            }
        }
    }
}
