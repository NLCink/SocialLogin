<?php


namespace CyberZend\SocialLogin\SocialNetwork;

class Context
{
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
     * Context constructor.
     *
     * @param \Magento\Framework\ObjectManagerInterface          $objectManager
     * @param \OAuth\ServiceFactory                              $oauthServiceFactory
     * @param \OAuth\Common\Storage\SessionFactory               $storageSessionFactory
     * @param \OAuth\Common\Consumer\CredentialsFactory          $credentialsFactory
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Framework\Json\Helper\Data                $jsonHelper
     */
    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\App\RequestInterface $request,
        \OAuth\ServiceFactory $oauthServiceFactory,
        \OAuth\Common\Storage\SessionFactory $storageSessionFactory,
        \OAuth\Common\Consumer\CredentialsFactory $credentialsFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Magento\Framework\UrlInterface $urlBuilder
    ) {
        $this->_objectManager = $objectManager;
        $this->_request = $request;
        $this->_oauthServiceFactory = $oauthServiceFactory;
        $this->_storageSessionFactory = $storageSessionFactory;
        $this->_credentialsFactory = $credentialsFactory;
        $this->_scopeConfig = $scopeConfig;
        $this->_jsonHelper = $jsonHelper;
        $this->_urlBuilder = $urlBuilder;
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
}