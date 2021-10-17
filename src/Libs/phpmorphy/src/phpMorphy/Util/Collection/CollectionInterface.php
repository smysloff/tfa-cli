<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */


interface phpMorphy_Util_Collection_CollectionInterface extends
    IteratorAggregate, ArrayAccess, Countable
{
    /**
     * @abstract
     * @param Traversable $values
     * @return void
     */
    function import($values);

    /**
     * @abstract
     * @param mixed $value
     * @return void
     */
    function append($value);

    /**
     * @abstract
     * @return void
     */
    function clear();
}