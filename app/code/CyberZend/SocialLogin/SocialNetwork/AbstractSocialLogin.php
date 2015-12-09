<?php

namespace CyberZend\SocialLogin\SocialNetwork;
use Magento\Framework\Exception\LocalizedException;

abstract class AbstractSocialLogin extends \Magento\Framework\DataObject
{
    /**
     * param name provider code for call back url
     */
    const PARAM_NAME_PROVIDER_CODE = 'provider_code';

    /**
     * @var string
     */
    protected $_sectionConfig = 'cyberzend_sociallogin';

    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;

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
     * @var \Magento\Customer\Model\CustomerFactory
     */
    protected $_customerFactory;

    /**
     * @var \CyberZend\SocialLogin\Controller\Result\JsRedirectLogin
     */
    protected $_jsRedirectLoginFactory;

    /**
     * @var bool
     */
    protected $_availableService = true;

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
        $this->_storeManager = $context->getStoreManager();
        $this->_customerSession = $context->getCustomerSession();
        $this->_socialServiceFactory = $context->getOauthServiceFactory();
        $this->_storageSessionFactory = $context->getStorageSessionFactory();
        $this->_credentialsFactory = $context->getCredentialsFactory();
        $this->_jsonHelper = $context->getJsonHelper();
        $this->_scopeConfig = $context->getScopeConfig();
        $this->_request = $context->getRequest();
        $this->_urlBuilder = $context->getUrlBuilder();
        $this->_customerFactory = $context->getCustomerFactory();
        $this->_jsRedirectLoginFactory = $context->getJsRedirectLoginFactory();
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
     * Check service is active or not
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->_getConfig('enable');
    }

    /**
     * Get sort order of service login
     *
     * @return bool
     */
    public function getSortOrder()
    {
        return $this->_getConfig('sort_order');
    }

    /**
     * Initializes social service.
     *
     * @return $this
     */
    public function initService()
    {
        try {
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
        } catch (\Exception $e) {
            $this->setAvailableService(false);
        }

        return $this;
    }

    /**
     * Get the provider name
     *
     * @return string
     */
    abstract public function getProviderName();

    /**
     * Get group config.
     *
     * @return string
     */
    abstract public function getProviderCode();

    /**
     * Returns the login url for the social network.
     *
     * @return string
     */
    abstract public function getLoginUrl();

    /**
     * Handles the login callback from the social network.
     *
     * @return SocialUserInterface
     */
    abstract public function loginCallback();

    /**
     * @param boolean $availableService
     *
     * @return AbstractSocialLogin
     */
    public function setAvailableService($availableService)
    {
        $this->_availableService = $availableService;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isAvailableService()
    {
        return $this->_availableService;
    }

    /**
     * Check is new Customer
     *
     * @param SocialUserInterface $socialUserExtracter
     *
     * @return bool
     */
    protected function _isNewCustomer(
        \CyberZend\SocialLogin\SocialNetwork\SocialUserInterface $socialUserExtracter
    ) {
        /** @var \Magento\Customer\Model\Customer $customer */
        $customer = $this->_customerFactory->create();
        $customer->loadByEmail($socialUserExtracter->getEmailAddress());

        return $customer->getId() ? false : true;
    }

    /**
     * Create new customer
     *
     * @param SocialUserInterface $socialUserExtracter
     *
     * @return mixed
     */
    protected function _createCustomer(
        \CyberZend\SocialLogin\SocialNetwork\SocialUserInterface $socialUserExtracter
    ) {
        /** @var \Magento\Customer\Model\Customer $customer */
        $customer = $this->_customerFactory->create([
            'data' => [
                'firstname' => $socialUserExtracter->getFirstname(),
                'lastname' => $socialUserExtracter->getLastname(),
                'email' => $socialUserExtracter->getEmailAddress(),
                'website_id' => $this->_storeManager->getStore()->getWebsiteId(),
                'store_id' => $this->_storeManager->getStore()->getId(),
                'password' => 'xinchaocacban'
            ]
        ]);

        return $customer->save();
    }

    /**
     * @param SocialUserInterface $socialUserExtracter
     *
     * @return \CyberZend\SocialLogin\Controller\Result\JsRedirectLogin
     * @throws \Magento\Framework\Exception\LocalizedExceptio
     */
    protected function _processSocialUserExtracter(
        \CyberZend\SocialLogin\SocialNetwork\SocialUserInterface $socialUserExtracter
    ) {
        if($socialUserExtracter->getEmailAddress()) {
            /** @var \Magento\Customer\Model\Customer $customer */
            $customer = $this->_customerFactory->create([
                'data' => [
                    'website_id' => $this->_storeManager->getStore()->getWebsiteId()
                ]
            ]);

            $customer->loadByEmail($socialUserExtracter->getEmailAddress());
            try {
                if(!$customer->getId()) {
                    $customer = $this->_createCustomer($socialUserExtracter);
                    $customer->sendPasswordReminderEmail();
                }

                if($customer->getConfirmation()) {
                    $customer->setConfirmation(null);
                    $customer->save();
                }

                $this->_customerSession->setCustomerAsLoggedIn($customer);
                /** @var \CyberZend\SocialLogin\Controller\Result\JsRedirectLogin $jsRedirectLogin */
                $jsRedirectLogin = $this->_jsRedirectLoginFactory->create();

                return $jsRedirectLogin->setAfterAuthorLoginUrl($this->_urlBuilder->getUrl('customer/account'));
            } catch (\Exception $e) {
                throw new LocalizedException(__($e->getMessage()), $e);
            }
        } else {
            throw new LocalizedException(__('Login failed!'));
        }
    }

    /**
     * Get call back url.
     *
     * @return string
     */
    public function getCallbackUrl()
    {
        return $this->_urlBuilder->getUrl(
            'cyberzendsociallogin/index/index',
            [self::PARAM_NAME_PROVIDER_CODE => $this->getProviderCode()]
        );
    }

    /**
     * Get config.
     *
     * @param $field
     *
     * @return mixed
     */
    protected function _getConfig($field)
    {
        $store = $this->_storeManager->getStore()->getId();
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