<?php
namespace CyberZend\SocialLogin\SocialNetwork\Facebook;

use CyberZend\SocialLogin\SocialNetwork\AbstractSocialLogin;
use OAuth\OAuth2\Service\Facebook;

class FacebookLogin extends AbstractSocialLogin
{
    protected $_userDataClass = 'CyberZend\\SocialLogin\\SocialNetwork\\Facebook\\FacebookUser';

    /**
     * @var array
     */
    protected $_oauthScopes = [
        Facebook::SCOPE_EMAIL,
        Facebook::SCOPE_USER_BIRTHDAY,
        Facebook::SCOPE_USER_LOCATION
    ];

    /**
     * {@inheritdoc}
     */
    public function getProviderName()
    {
        return 'Facebook';
    }

    /**
     * {@inheritdoc}
     */
    public function getProviderCode()
    {
        return 'facebook';
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

        $userData = $this->_jsonHelper->jsonDecode($this->_socialService->request('/me'));

        /** @var \CyberZend\SocialLogin\SocialNetwork\SocialUserInterface $socialUserExtracter */
        $socialUserExtracter = $this->createSocialUserExtracter($userData);

        return $this->_processSocialUserExtracter($socialUserExtracter);
    }
}