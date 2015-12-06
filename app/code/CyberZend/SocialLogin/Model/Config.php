<?php

/**
 * Magestore
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magestore.com license that is
 * available through the world-wide-web at this URL:
 * http://www.magestore.com/license-agreement.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Magestore
 * @package     Magestore_Storelocator
 * @copyright   Copyright (c) 2012 Magestore (http://www.magestore.com/)
 * @license     http://www.magestore.com/license-agreement.html
 */

namespace CyberZend\SocialLogin\Model;

/**
 *
 *
 * @category Magestore
 * @package  Magestore_Storelocator
 * @module   Storelocator
 * @author   Magestore Developer
 */
class Config extends \Magento\Framework\Config\Data implements \CyberZend\SocialLogin\Model\Config\ConfigInterface
{
    public function __construct(
        \CyberZend\SocialLogin\Model\Config\Reader $reader,
        \Magento\Framework\Config\CacheInterface $cache,
        $cacheId = 'cyberZend_sociallogin_config'
    ) {
        parent::__construct($reader, $cache, $cacheId);
    }

    /**
     * @return array|mixed|null
     */
    public function getServices() {
        return $this->get();
    }
}