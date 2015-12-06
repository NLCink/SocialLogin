<?php 

namespace CyberZend\SocialLogin\Controller\Index;

/**
 * Action Index
 */
class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * Action constructor
     *
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context
    ) {
        parent::__construct($context);
    }

    /**
     * Execute action
     */
    public function execute()
    {
        $resultPage = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_PAGE);

        return $resultPage;
    }
}
