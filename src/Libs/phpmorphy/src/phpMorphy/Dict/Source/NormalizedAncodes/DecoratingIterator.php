<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */


class phpMorphy_Dict_Source_NormalizedAncodes_DecoratingIterator extends IteratorIterator {
    protected
        $manager,
        $new_class;

    function __construct(Traversable $it, phpMorphy_Dict_Source_NormalizedAncodes_AncodesManager $manager, $newClass) {
        parent::__construct($it);

        $this->manager = $manager;
        $this->new_class = $newClass;
    }

    function current() {
        return $this->decorate(parent::current());
    }

    protected function decorate($object) {
        $new_class = $this->new_class;

        return new $new_class($this->manager, $object);
    }
};