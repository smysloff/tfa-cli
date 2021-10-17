<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

interface phpMorphy_AncodesResolver_AncodesResolverInterface {
    /**
     * @abstract
     * @param int|string $ancodeId
     * @return string
     */
    function resolve($ancodeId);

    /**
     * @abstract
     * @param string $ancode
     * @return string
     */
    function unresolve($ancode);
}