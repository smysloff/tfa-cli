<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */



class phpMorphy_Dict_Source_NormalizedAncodes
    extends phpMorphy_Dict_Source_Decorator
    implements phpMorphy_Dict_Source_NormalizedAncodesInterface
{
    protected
        $manager;

    static function wrap(phpMorphy_Dict_Source_SourceInterface $source) {
        if($source instanceof phpMorphy_Dict_Source_NormalizedAncodes) {
            return $source;
        }

        return new phpMorphy_Dict_Source_NormalizedAncodes($source);
    }

    function __construct(phpMorphy_Dict_Source_SourceInterface $inner) {
        parent::__construct($inner);

        $this->manager = $this->createManager($inner);
    }

    protected function createManager($inner) {
        return new phpMorphy_Dict_Source_NormalizedAncodes_AncodesManager($inner);
    }

    function getPoses() {
        return array_values($this->manager->getPosesMap());
    }

    function getGrammems() {
        return array_values($this->manager->getGrammemsMap());
    }

    function getAncodes() {
        return $this->manager->getAncodes();
    }

    function getFlexias() {
        return $this->createDecoratingIterator(parent::getFlexias(), 'phpMorphy_Dict_Source_NormalizedAncodes_FlexiaModel');
    }

    function getLemmas() {
        return $this->createDecoratingIterator(parent::getLemmas(), 'phpMorphy_Dict_Source_NormalizedAncodes_Lemma');
    }

    protected function createDecoratingIterator(Traversable $it, $newClass) {
        return new phpMorphy_Dict_Source_NormalizedAncodes_DecoratingIterator($it, $this->manager, $newClass);
    }
}