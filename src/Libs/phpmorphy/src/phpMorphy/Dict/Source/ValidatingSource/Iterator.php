<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */


class phpMorphy_Dict_Source_ValidatingSource_Iterator extends IteratorIterator {
    /** @var Closure */
    private $callback;

    function __construct($iterator, $callback) {
        parent::__construct(is_array($iterator) ? new ArrayIterator($iterator) : $iterator);
        $this->callback = $callback;
    }

    function current() {
        $value = parent::current();

        $fn = $this->callback;
        $fn($value);

        return $value;
    }
}