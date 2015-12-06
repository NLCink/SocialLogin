<?php 

namespace CyberZend\SocialLogin\Block\Adminhtml;

/**
 * Collection Deal
 */
class Deal extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * {@inheritdoc}
     */
    public function _construct()
    {
        $this->_controller = 'adminhtml_Deal';
        $this->_blockGroup = 'CyberZend_SocialLogin';
        $this->_headerText = __('Deal grid');
        $this->_addButtonLabel = __('Add New Deal');

        parent::_construct();
    }
}
