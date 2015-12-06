<?php
namespace CyberZend\SocialLogin\SocialNetwork\Google;

use CyberZend\SocialLogin\SocialNetwork\AbstractSocialLogin;
use CyberZend\SocialLogin\SocialNetwork\SocialLoginInterface;

class GoogleLogin extends AbstractSocialLogin implements SocialLoginInterface
{
    /**
     * {@inheritdoc}
     */
    protected $_userDataClass = 'CyberZend\\SocialLogin\\SocialNetwork\\GoogleUser';

    /**
     * @var array
     */
    protected $_oauthScopes = [
        'userinfo_email',
        'userinfo_profile'
    ];

    /**
     * {@inheritdoc}
     */
    public function getProviderName()
    {
        return 'Google';
    }

    /**
     * {@inheritdoc}
     */
    public function getProviderCode()
    {
        return 'google';
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
            $this->_socialService->request('https://www.googleapis.com/oauth2/v1/userinfo')
        );
        return $this->createSocialUserExtracter($userData);
    }
}