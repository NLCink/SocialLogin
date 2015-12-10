<?php
namespace CyberZend\SocialLogin\SocialNetwork\Paypal;

use CyberZend\SocialLogin\SocialNetwork\AbstractSocialLogin;

class PaypalLogin extends AbstractSocialLogin
{
    /**
     * {@inheritdoc}
     */
    protected $_userDataClass = 'CyberZend\\SocialLogin\\SocialNetwork\\Paypal\\PaypalUser';

    /**
     * @var array
     */
    protected  $_oauthScopes= [
        'profile',
        'openid'
    ];

    /**
     * {@inheritdoc}
     */
    public function getProviderName()
    {
        return 'Paypal';
    }

    /**
     * {@inheritdoc}
     */
    public function getProviderCode()
    {
        return 'paypal';
    }

    /**
     * {@inheritdoc}
     */
    public function getLoginUrl()
    {

        return $this->_socialService->getAuthorizationUri();
    }

    /**
     * {@inheritdoc}
     */
    public function loginCallback()
    {
        $this->_socialService->requestAccessToken(
            $this->getRequest()->getParam('code')
        );

        $userData = $this->_jsonHelper->jsonDecode(
            $this->_socialService->request('/identity/openidconnect/userinfo/?schema=openid')
        );
        /** @var \CyberZend\SocialLogin\SocialNetwork\SocialUserInterface $socialUserExtracter */
        $socialUserExtracter = $this->createSocialUserExtracter($userData);

        return $this->_processSocialUserExtracter($socialUserExtracter);
    }
}