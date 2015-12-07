<?php


namespace CyberZend\SocialLogin\SocialNetwork;

class Context
{
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
     * @var \OAuth\ServiceFactory
     */
    protected $_oauthServiceFactory;

    /**
     * @var \OAuth\Common\Storage\SessionFactory
     */
    protected $_storageSessionFactory;

    /**
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
     * Context constructor.
     *
     * @param \Magento\Framework\ObjectManagerInterface          $objectManager
     * @param \Magento\Store\Model\StoreManagerInterface         $storeManager
     * @param \Magento\Framework\App\RequestInterface            $request
     * @param \OAuth\ServiceFactory                              $oauthServiceFactory
     * @param \OAuth\Common\Storage\SessionFactory               $storageSessionFactory
     * @param \OAuth\Common\Consumer\CredentialsFactory          $credentialsFactory
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Framework\Json\Helper\Data                $jsonHelper
     * @param \Magento\Framework\UrlInterface                    $urlBuilder
     * @param \Magento\Customer\Model\CustomerFactory            $customerFactory
     */
    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\App\RequestInterface $request,
        \OAuth\ServiceFactory $oauthServiceFactory,
        \OAuth\Common\Storage\SessionFactory $storageSessionFactory,
        \OAuth\Common\Consumer\CredentialsFactory $credentialsFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \CyberZend\SocialLogin\Controller\Result\JsRedirectLoginFactory $jsRedirectLoginFactory
    ) {
        $this->_objectManager = $objectManager;
        $this->_storeManager = $storeManager;
        $this->_customerSession = $customerSession;
        $this->_request = $request;
        $this->_oauthServiceFactory = $oauthServiceFactory;
        $this->_storageSessionFactory = $storageSessionFactory;
        $this->_credentialsFactory = $credentialsFactory;
        $this->_scopeConfig = $scopeConfig;
        $this->_jsonHelper = $jsonHelper;
        $this->_urlBuilder = $urlBuilder;
        $this->_customerFactory = $customerFactory;
        $this->_jsRedirectLoginFactory = $jsRedirectLoginFactory;
    }

    /**
     * @return \OAuth\ServiceFactory
     */
    public function getOauthServiceFactory()
    {
        return $this->_oauthServiceFactory;
    }

    /**
     * @return \OAuth\Common\Storage\SessionFactory
     */
    public function getStorageSessionFactory()
    {
        return $this->_storageSessionFactory;
    }

    /**
     * @return \OAuth\Common\Consumer\CredentialsFactory
     */
    public function getCredentialsFactory()
    {
        return $this->_credentialsFactory;
    }

    /**
     * @return \Magento\Framework\Json\Helper\Data
     */
    public function getJsonHelper()
    {
        return $this->_jsonHelper;
    }

    /**
     * @return \Magento\Framework\App\Config\ScopeConfigInterface
     */
    public function getScopeConfig()
    {
        return $this->_scopeConfig;
    }

    /**
     * @return \Magento\Framework\ObjectManagerInterface
     */
    public function getObjectManager()
    {
        return $this->_objectManager;
    }

    /**
     * @return \Magento\Framework\App\RequestInterface
     */
    public function getRequest()
    {
        return $this->_request;
    }

    /**
     * @return \Magento\Framework\UrlInterface
     */
    public function getUrlBuilder()
    {
        return $this->_urlBuilder;
    }

    /**
     * @return \Magento\Framework\StoreManagerInterface
     */
    public function getStoreManager()
    {
        return $this->_storeManager;
    }

    /**
     * @return mixed
     */
    public function getCustomerFactory()
    {
        return $this->_customerFactory;
    }

    /**
     * @return \Magento\Customer\Model\Session
     */
    public function getCustomerSession()
    {
        return $this->_customerSession;
    }

    /**
     * @return \CyberZend\SocialLogin\Controller\Result\JsRedirectLogin
     */
    public function getJsRedirectLoginFactory()
    {
        return $this->_jsRedirectLoginFactory;
    }
}