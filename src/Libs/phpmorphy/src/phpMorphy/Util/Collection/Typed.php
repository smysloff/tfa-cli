<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */


class phpMorphy_Util_Collection_Typed extends phpMorphy_Util_Collection_Decorator {
    /**
     * @var array
     */
    static private $INTERNAL_TYPES = array(
        'int'   => 'integer', 'integer' => 'integer',
        'bool'  => 'boolean', 'boolean' => 'boolean',
        'float' => 'double', 'double'   => 'double',
        'string'=> 'string',
        'array' => 'array',
        'null' => 'NULL'
    );

    private
        /** @var string */
        $valid_type,
        /** @var boool */
        $is_pod,
        /** @var bool */
        $allow_null
        ;

    /**
     * @param phpMorphy_Util_Collection_CollectionInterface $inner
     * @param string $validType
     *
     */
    function __construct(phpMorphy_Util_Collection_CollectionInterface $inner, $validType, $allowNull = false) {
        parent::__construct($inner);

        $this->allow_null = (bool)$allowNull;

        $lower_type = strtolower((string)$validType);

        if(isset(self::$INTERNAL_TYPES[$lower_type])) {
            $this->is_pod = true;
            $this->valid_type = self::$INTERNAL_TYPES[$lower_type];
        } else {
            $this->is_pod = false;
            $this->valid_type = $validType;
        }
    }

    /**
     * @param mixed $value
     * @return void
     */
    function append($value) {
        $this->assertType($value);
        parent::append($value);
    }

    function offsetSet($offset, $value) {
        $this->assertType($value);
        parent::offsetSet($offset, $value);
    }

    protected function assertType($value) {
        if($this->is_pod) {
            if(gettype($value) === $this->valid_type || (null === $value && $this->allow_null)) {
                return true;
            }
        } else {
            if($value instanceof $this->valid_type || (null === $value && $this->allow_null)) {
                return true;
            }
        }

        throw new phpMorphy_Exception(
            "Invalid type '" . gettype($value) . "', expected '" . $this->valid_type . "'"
        );
    }
}