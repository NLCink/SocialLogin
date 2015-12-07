<?php

namespace CyberZend\SocialLogin\Model\Config;

class Converter implements \Magento\Framework\Config\ConverterInterface
{
    /**
     * Convert dom node tree to array
     *
     * @param \DOMDocument $source
     * @return array
     * @throws \InvalidArgumentException
     */
    public function convert($source)
    {
        $output = [];
        /** @var $node \DOMElement */
        foreach ($source->getElementsByTagName('service') as $node) {
            $output[$node->getAttribute('id')] = [
                'id' => $node->getAttribute('id'),
                'label' => $node->getAttribute('label'),
                'title' => $node->getAttribute('title') ? $node->getAttribute('title') : $node->getAttribute('label'),
                'html_class' => $node->getAttribute('htmlClass'),
                'class_login' => $node->getAttribute('classLogin'),
            ];
        }

        return $output;
    }
}