<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */


class phpMorphy_Util_Iterator_Transform extends IteratorIterator {
    /** @var Closure */
    private $function;

    public function __construct(Traversable $iterator, $function) {
        parent::__construct($iterator);
        $this->function = $function;
    }

	function current() {
        $fn = $this->function;
		return $fn(parent::current());
	}
}