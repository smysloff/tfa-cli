<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */


class phpMorphy_Util_Collection_ArrayBased implements phpMorphy_Util_Collection_CollectionInterface {
    protected
        /** @var array */
        $data;

    /**
     * @param Traversable|null $values
     */
    function __construct($values = null) {
        $this->clear();

        if(null !== $values) {
            $this->import($values);
        }
    }

    /**
     * @return array
     */
    function getData() {
        return $this->data;
    }

    /**
     * @return Iterator
     */
    function getIterator() {
        return new ArrayIterator($this->data);
    }

    /**
     * @throws phpMorphy_Exception
     * @param Traversable $values
     * @return void
     */
    function import($values) {
        if($values instanceof Traversable || is_array($values)) {
            foreach($values as $v) {
                $this->append($v);
            }
        } else {
            throw new phpMorphy_Exception("Vlues not implements Traversable interface");
        }
    }

    /**
     * @param mixed $value
     * @return void
     */
    function append($value) {
        $this->data[] = $value;
    }

    /**
     * @return void
     */
    function clear() {
        $this->data = array();
    }

    /**
     * @param int $offset
     * @return bool
     */
    function offsetExists($offset) {
        return array_key_exists($offset, $this->data);
    }

    /**
     * @throws phpMorphy_Exception
     * @param int $offset
     * @return mixed
     */
    function offsetGet($offset) {
        if(!$this->offsetExists($offset)) {
            throw new phpMorphy_Exception("Invalid offset($offset) given");
        }

        return $this->data[$offset];
    }

    /**
     * @param int $offset
     * @param mixed $value
     * @return void
     */
    function offsetSet($offset, $value) {
        if(null === $offset) {
            $this->append($value);
        } else {
            $this->data[$offset] = $value;
        }
    }

    /**
     * @param int $offset
     * @return void
     */
    function offsetUnset($offset) {
        array_splice($this->data, $offset, 1);
    }

    /**
     * @return int
     */
    function count() {
        return count($this->data);
    }
}