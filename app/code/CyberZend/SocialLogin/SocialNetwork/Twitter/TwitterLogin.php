<?php


namespace CyberZend\SocialLogin\SocialNetwork\Twitter;

use CyberZend\SocialLogin\SocialNetwork\AbstractSocialLogin;
use Magento\Framework\Exception\LocalizedException;

class TwitterLogin extends AbstractSocialLogin
{
    /**
     * {@inheritdoc}
     */
    protected $_userDataClass = 'CyberZend\\SocialLogin\\SocialNetwork\\Twitter\\TwitterUser';

    /**
     * {@inheritdoc}
     */
    public function getProviderName()
    {
        return 'Twitter';
    }

    /**
     * {@inheritdoc}
     */
    public function getProviderCode()
    {
        return 'twitter';
    }

    /**
     * {@inheritdoc}
     */
    public function getLoginUrl()
    {
        try {
            $token = $this->_socialService->requestRequestToken();
        } catch (\Exception $e) {
            $this->setAvailableService(false);
            return '';
        }
        return $this->_socialService->getAuthorizationUri(['oauth_token' => $token->getRequestToken()]);
    }

    /**
     * {@inheritdoc}
     */
    public function loginCallback()
    {
        /** @var \OAuth\Common\Storage\Session $storage */
        $storage = $this->_storageSessionFactory->create();
        $token = $storage->retrieveAccessToken('Twitter');

        $this->_socialService->requestAccessToken(
            $this->getRequest()->getParam('oauth_token'),
            $this->getRequest()->getParam('oauth_verifier'),
            $token->getRequestTokenSecret()
        );

        $userData = $this->_jsonHelper->jsonDecode(
            $this->_socialService->request('account/verify_credentials.json')
        );

        /** @var \CyberZend\SocialLogin\SocialNetwork\SocialUserInterface $socialUserExtracter */
        $socialUserExtracter = $this->createSocialUserExtracter($userData);

        return $this->_processSocialUserExtracter($socialUserExtracter);
    }
}