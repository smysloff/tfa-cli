<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_AncodesResolver_Proxy extends phpMorphy_AncodesResolver_Decorator {
    private
        /** @var string */
        $class,
        /** @var array */
        $args;

    /**
     * @param string $class
     * @param array $ctorArgs
     */
    function __construct($class, array $ctorArgs) {
        $this->class = (string)$class;
        $this->args = $ctorArgs;

        $this->actAsProxy();
    }

    protected function proxyInstantiate() {
        $result = $this->instantiateClass($this->class, $this->args);
        unset($this->args);
        unset($this->class);
        return $result;
    }
}