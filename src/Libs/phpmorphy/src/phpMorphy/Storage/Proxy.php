<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Storage_Proxy extends phpMorphy_Storage_Decorator {
    protected
        /** @var string */
        $file_name,
        /** @var string */
        $type,
        /** @var phpMorphy_Storage_Factory */
        $factory;

    /**
     * @param string $type
     * @param string $fileName
     * @param phpMorphy_Storage_Factory $factory
     */
    function __construct($type, $fileName, phpMorphy_Storage_Factory $factory) {
        $this->file_name = (string)$fileName;
        $this->type = $type;
        $this->factory = $factory;

        $this->actAsProxy(
            /*
            function() use ($type, $fileName, $factory) {
                return $factory->create($type, $fileName, false);
            }
             */
        );
    }

    protected function proxyInstantiate() {
        $result = $this->factory->create($this->type, $this->file_name, false);

        unset($this->file_name);
        unset($this->type);
        unset($this->factory);

        return $result;
    } 
}