<?php


namespace CyberZend\SocialLogin\SocialNetwork\Twitter;

use CyberZend\SocialLogin\SocialNetwork\AbstractSocialLogin;
use CyberZend\SocialLogin\SocialNetwork\SocialLoginInterface;

class TwitterLogin extends AbstractSocialLogin implements SocialLoginInterface
{
    /**
     * {@inheritdoc}
     */
    protected $_userDataClass = 'CyberZend\\SocialLogin\\SocialNetwork\\TwitterUser';

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
//        $token = $this->_socialService->requestRequestToken();
        return '';
//        return $this->_socialService->getAuthorizationUri(['oauth_token' => $token->getRequestToken()]);
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
            $this->_socialService->request('https://www.googleapis.com/oauth2/v1/userinfo')
        );
        return $this->createSocialUserExtracter($userData);
    }
}