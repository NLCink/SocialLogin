<?php

namespace CyberZend\SocialLogin\SocialNetwork;

abstract class AbstractSocialLogin extends \Magento\Framework\DataObject
{
    /**
     * @var string
     */
    protected $_sectionConfig = 'cyberzend_sociallogin';

    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * Request object
     *
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $_request;

    /**
     * Social service.
     *
     * @var \OAuth\Common\Service\ServiceInterface
     */
    protected $_socialService;

    /**
     * OAuth client ID.
     *
     * @var string
     */
    protected $_consumerId;

    /**
     * OAuth key.
     *
     * @var string
     */
    protected $_consumerSecret;

    /**
     * If creating an oauth2 service, array of scopes.
     *
     * @var array|null
     */
    protected $_oauthScopes = [];

    /**
     * OAuth service factory.
     *
     * @var \OAuth\ServiceFactory
     */
    protected $_socialServiceFactory;

    /**
     * Session Factory.
     *
     * @var \OAuth\Common\Storage\SessionFactory
     */
    protected $_storageSessionFactory;

    /**
     * Credentials Factory.
     *
     * @var \OAuth\Common\Consumer\CredentialsFactory
     */
    protected $_credentialsFactory;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * Json Helper.
     *
     * @var \Magento\Framework\Json\Helper\Data
     */
    protected $_jsonHelper;

    /**
     * @var string
     */
    protected $_userDataClass;

    /**
     * Url builder
     *
     * @var \Magento\Framework\UrlInterface
     */
    protected $_urlBuilder;

    /**
     * AbstractSocialLogin constructor.
     *
     * @param Context $context
     * @param         $data
     */
    public function __construct(
        \CyberZend\SocialLogin\SocialNetwork\Context $context,
        array $data = []
    ) {
        parent::__construct($data);
        $this->_objectManager = $context->getObjectManager();
        $this->_socialServiceFactory = $context->getOauthServiceFactory();
        $this->_storageSessionFactory = $context->getStorageSessionFactory();
        $this->_credentialsFactory = $context->getCredentialsFactory();
        $this->_jsonHelper = $context->getJsonHelper();
        $this->_scopeConfig = $context->getScopeConfig();
        $this->_request = $context->getRequest();
        $this->_urlBuilder = $context->getUrlBuilder();
        $this->_construct();
    }

    /**
     * @return $this
     */
    protected function _construct() {
        if($this->hasData('consumer_id')) {
            $this->setConsumerId($this->getData('consumer_id'));
        }

        if($this->hasData('consumer_secret')) {
            $this->setConsumerSecret($this->getData('consumer_secret'));
        }

        if($this->hasData('oauth_scopes')) {
            $this->setOauthScopes($this->getData('oauth_scopes'));
        }

        return $this;
    }

    /**
     * Initializes social service.
     *
     * @return $this
     */
    public function initService()
    {
        $storage = $this->_storageSessionFactory->create();
        $credentials = $this->_credentialsFactory->create([
            'consumerId' => $this->getConsumerId(),
            'consumerSecret' => $this->getConsumerSecret(),
            'callbackUrl' => $this->getCallbackUrl()
        ]);

        $this->_socialService = $this->_socialServiceFactory->createService(
            $this->getProviderCode(),
            $credentials,
            $storage,
            $this->getOauthScopes()
        );

        return $this;
    }

    /**
     * Get group config.
     *
     * @return string
     */
    abstract public function getProviderCode();

    /**
     * Get call back url.
     *
     * @return string
     */
    public function getCallbackUrl()
    {
        return $this->_urlBuilder->getUrl(
            'cyberzendsociallogin/index/index',
            ['provider_code' => $this->getProviderCode()]
        );
    }

    /**
     * Get config by path
     *
     * @param      $path
     * @param null $store
     *
     * @return mixed
     */
    protected function _getConfig($field, $store = null)
    {
        return $this->_scopeConfig->getValue(
            implode('/', [$this->_sectionConfig, $this->getProviderCode(), $field]),
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * @param string $consumerId
     *
     * @return AbstractSocialLogin
     */
    public function setConsumerId($consumerId)
    {
        $this->_consumerId = $consumerId;

        return $this;
    }

    /**
     * @return string
     */
    public function getConsumerId()
    {
        if(!$this->_consumerId) {
            $this->setConsumerId($this->_getConfig('consumer_id'));
        }

        return $this->_consumerId;
    }

    /**
     * @param string $consumerSecret
     *
     * @return AbstractSocialLogin
     */
    public function setConsumerSecret($consumerSecret)
    {
        $this->_consumerSecret = $consumerSecret;

        return $this;
    }

    /**
     * @return string
     */
    public function getConsumerSecret()
    {
        if(!$this->_consumerSecret) {
            $this->setConsumerSecret($this->_getConfig('consumer_secret'));
        }

        return $this->_consumerSecret;
    }

    /**
     * @param array|null $scopes
     *
     * @return AbstractSocialLogin
     */
    public function setOauthScopes($scopes)
    {
        $this->_oauthScopes = $scopes;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getOauthScopes()
    {
        return $this->_oauthScopes;
    }

    /**
     * @param array $userData
     *
     * @return SocialUserInterface
     */
    public function createSocialUserExtracter(array $userData = [])
    {
        return $this->_objectManager->create($this->_userDataClass, ['data' => $userData]);
    }

    /**
     * @return \Magento\Framework\App\RequestInterface
     */
    public function getRequest()
    {
        return $this->_request;
    }
}