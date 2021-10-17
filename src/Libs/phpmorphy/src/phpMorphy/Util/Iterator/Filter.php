<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */



class phpMorphy_Util_Iterator_Filter extends FilterIterator {
    /** @var Closure */
    private $callback;

    /**
     * @param Iterator $iterator
     * @param  $function
     */
    public function __construct(Iterator $iterator, $function) {
        parent::__construct($iterator);
        $this->callback = $function;
    }

    public function accept() {
        $fn = $this->callback;
        return $fn(parent::current(), parent::key());
    }
}