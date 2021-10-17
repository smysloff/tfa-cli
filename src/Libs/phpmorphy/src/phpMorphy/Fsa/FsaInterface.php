<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

interface phpMorphy_Fsa_FsaInterface {
    /**
     * Return root transition of fsa
     * @return int
     */
    function getRootTrans();

    /**
     * Returns root state object
     * @return phpMorphy_Fsa_State
     */
    function getRootState();

    /**
     * Returns alphabet i.e. all chars used in automat
     * @return string[]
     */
    function getAlphabet();

    /**
     * Return annotation for given transition(if annotation flag is set for given trans)
     *
     * @param array $trans
     * @return string|null
     */
    function getAnnot($trans);

    /**
     * Find word in automat
     *
     * @param int $trans starting transition
     * @param string $word
     * @param bool $readAnnot read annot or simple check if word exists in automat
     * @return bool TRUE if word is found, FALSE otherwise
     */
    function walk($trans, $word, $readAnnot = true);

    /**
     * Traverse automat and collect words
     * For each found words $callback function invoked with follow arguments:
     * call_user_func($callback, $word, $annot)
     * when $readAnnot is FALSE then $annot arg is always NULL
     *
     * @param int $startNode
     * @param mixed $callback callback function(in php format callback i.e. string or array(obj, method) or array(class, method)
     * @param bool $readAnnot read annot
     * @param string $path string to be append to all words
     */
    function collect($startNode, $callback, $readAnnot = true, $path = '');

    /**
     * Read state at given index
     *
     * @param int $index
     * @return array
     */
    function readState($index);

    /**
     * Unpack transition from binary form to array
     *
     * @param string|string[] $rawTranses may be array for convert more than one transitions
     * @return array
     */
    function unpackTranses($rawTranses);
}