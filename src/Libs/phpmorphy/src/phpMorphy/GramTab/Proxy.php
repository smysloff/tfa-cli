<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_GramTab_Proxy extends phpMorphy_GramTab_Decorator {
    /** @var phpMorphy_Storage_StorageInterface */
    private $storage;

    /**
     * @param phpMorphy_Storage_StorageInterface $storage
     */
    function __construct(phpMorphy_Storage_StorageInterface $storage) {
        $this->storage = $storage;
        $this->actAsProxy();
    }

    protected function proxyInstantiate() {
        $result = phpMorphy_GramTab_GramTab::create($this->storage);
        unset($this->storage);
        
        return $result;
    }
}