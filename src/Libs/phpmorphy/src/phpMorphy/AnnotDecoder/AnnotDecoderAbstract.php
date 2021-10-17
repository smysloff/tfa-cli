<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

abstract class phpMorphy_AnnotDecoder_AnnotDecoderAbstract implements phpMorphy_AnnotDecoder_AnnotDecoderInterface {
    const INVALID_ANCODE_ID = 0xFFFF;
    protected
        /** @var string */
        $end_of_string,
        /** @var string */
        $unpack_str,
        /** @var int */
        $block_size;

    /**
     * @param string $endOfString
     */
    function __construct($endOfString) {
        $this->end_of_string = (string)$endOfString;

        $this->unpack_str = $this->getUnpackString();
        $this->block_size = $this->getUnpackBlockSize();
    }

    /**
     * @abstract
     * @return string
     */
    abstract protected function getUnpackString();

    /**
     * @abstract
     * @return string
     */
    abstract protected function getUnpackBlockSize();

    /**
     * @throws phpMorphy_Exception
     * @param string $annotRaw
     * @param bool $withBase
     * @return array
     */
    function decode($annotRaw, $withBase) {
        if(empty($annotRaw)) {
            throw new phpMorphy_Exception("Empty annot given");
        }

        $unpack_str = $this->unpack_str;
        $unpack_size = $this->block_size;

        $result = unpack("Vcount/$unpack_str", $annotRaw);

        if(false === $result) {
            throw new phpMorphy_Exception("Invalid annot string '$annotRaw'");
        }

        if($result['common_ancode'] == self::INVALID_ANCODE_ID) {
            $result['common_ancode'] = null;
        }

        $count = $result['count'];
        $result = array($result);

        if($count > 1) {
            for($i = 0; $i < $count - 1; $i++) {
                $res = unpack($unpack_str, $GLOBALS['__phpmorphy_substr']($annotRaw, 4 + ($i + 1) * $unpack_size, $unpack_size));

                if($res['common_ancode'] == self::INVALID_ANCODE_ID) {
                    $res['common_ancode'] = null;
                }

                $result[] = $res;
            }
        }

        if($withBase) {
            $items = explode($this->end_of_string, $GLOBALS['__phpmorphy_substr']($annotRaw, 4 + $count * $unpack_size));
            for($i = 0; $i < $count; $i++) {
                $result[$i]['base_prefix'] = $items[$i * 2];
                $result[$i]['base_suffix'] = $items[$i * 2 + 1];
            }
        }

        return $result;
    }
}