<?php 

namespace CyberZend\SocialLogin\Controller\Index;

use CyberZend\SocialLogin\SocialNetwork\AbstractSocialLogin;
use Magento\Framework\Controller\ResultFactory;

/**
 * Action Index
 */
class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \CyberZend\SocialLogin\Model\Config\ConfigInterface
     */
    protected $_socialConfig;

    /**
     * Action constructor
     *
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \CyberZend\SocialLogin\Model\Config\ConfigInterface $socialConfig
    ) {
        parent::__construct($context);
        $this->_socialConfig = $socialConfig;
    }

    /**
     * Execute action
     */
    public function execute()
    {
        $services = $this->_socialConfig->getServices();
        $providerCode = $this->getRequest()->getParam(AbstractSocialLogin::PARAM_NAME_PROVIDER_CODE);

        if(isset($services[$providerCode]['class_login'])) {
            /** @var \CyberZend\SocialLogin\SocialNetwork\AbstractSocialLogin $serviceLogin */
            $serviceLogin = $this->_objectManager->create($services[$providerCode]['class_login']);
            return $serviceLogin->initService()->loginCallback();
        }

        /* @var \Magento\Framework\Controller\Result\Redirect $resultLayout */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('cms/noroute');
    }
}
