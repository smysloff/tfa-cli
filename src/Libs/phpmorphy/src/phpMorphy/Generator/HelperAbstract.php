<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

abstract class phpMorphy_Generator_HelperAbstract {
    /* @var phpMorphy_Generator_Template */
    protected $tpl;
    /* @var phpMorphy_Generator_StorageHelperInterface */
    protected $storage;

    /**
     * @param phpMorphy_Generator_Template $tpl
     * @param phpMorphy_Generator_StorageHelperInterface $storage
     */
    function __construct(phpMorphy_Generator_Template $tpl, phpMorphy_Generator_StorageHelperInterface $storage) {
        $this->tpl = $tpl;
        $this->storage = $storage;
    }

    /**
     * @return phpMorphy_Generator_StorageHelperInterface
     */
    function getStorage() {
        return $this->storage;
    }

    /**
     * @param string $str
     * @param string $suffix
     * @return void
     */
    function out($str, $suffix) {
        if(strlen($str)) {
            echo $str, $suffix;
        }
    }
}