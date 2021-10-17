<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

interface phpMorphy_Generator_StorageHelperInterface {
    /**
     * @return string
     */
    function getType();

    /**
     * @return string
     */
    function prolog();

    /**
     * @return string
     */
    function seek($offset);

    /**
     * @return string
     */
    function read($offset, $len);
}