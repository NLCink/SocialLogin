<?php

namespace CyberZend\SocialLogin\Controller\Result;

use Magento\Framework\App\ResponseInterface;

class JsRedirectLogin extends \Magento\Framework\Controller\AbstractResult
{
    protected $_jsLoginSuccessFormat = '<script type="text/javascript">
            if(navigator.userAgent.match("CriOS")) {
                window.location.href = "{{url}}";
            } else {
                if(window.opener) {
                    window.close();
                    try {
                        window.opener.location.href = "{{url}}";
                    } catch (e) {
                        window.opener.location.reload(true);
                    }
                } else {
                    window.location.href = "{{url}}";
                }
            }
        </script>';

    /**
     * @var string
     */
    protected $_contents;

    /**
     * @var string
     */
    protected $_afterAuthorLoginUrl;

    /**
     * @param string $loginSuccessUrl
     *
     * @return JsRedirectLogin
     */
    public function setAfterAuthorLoginUrl($loginSuccessUrl)
    {
        $this->_afterAuthorLoginUrl = $loginSuccessUrl;

        return $this;
    }

    /**
     * @param string $_contents
     *
*@return $this
     */
    public function setContents($contents)
    {
        $this->_contents = $contents;
        return $this;
    }

    /**
     * Prepare render.
     *
     * @return $this
     */
    protected function _prepareRender() {
        $this->setHeader('Content-type', 'text/html');
        $this->setContents(
            str_replace('{{url}}', $this->_afterAuthorLoginUrl, $this->_jsLoginSuccessFormat)
        );

        return $this;
    }

    /**
     * @param ResponseInterface $response
     *
     * @return $this
     */
    protected function render(ResponseInterface $response)
    {
        $this->_prepareRender();
        $response->setBody($this->_contents);
        return $this;
    }
}