<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

/**
 * @decorator-auto-regenerate TRUE
 * @decorator-generated-at Thu, 23 Jun 2011 05:28:55 +0400
 * @decorator-decoratee-class phpMorphy_Util_Collection_CollectionInterface
 * @decorator-decorator-class phpMorphy_Util_Collection_Decorator
 */

abstract class phpMorphy_Util_Collection_Decorator implements phpMorphy_Util_Collection_CollectionInterface, phpMorphy_DecoratorInterface {
    /** @var phpMorphy_Util_Collection_CollectionInterface */
    private $object;
    /** @var Closure|null */
    private $on_instantiate;
    
    /**
     * @param $object phpMorphy_Util_Collection_CollectionInterface
     */
    function __construct(phpMorphy_Util_Collection_CollectionInterface $object) {
        $this->setDecorateeObject($object);
    }
    
    /**
     * Set current decorator behaviour to proxy model
     * @param Closure|null $onInstantiate
     */
    protected function actAsProxy(/*TODO: uncomment for php >= 5.3 Closure */$onInstantiate = null) {
        unset($this->object);
        $this->on_instantiate = $onInstantiate;
    }
    
    /**
     * @param $object phpMorphy_Util_Collection_CollectionInterface
     * @return phpMorphy_Util_Collection_Decorator
     */
    protected function setDecorateeObject(phpMorphy_Util_Collection_CollectionInterface $object) {
        $this->object = $object;
        return $this;
    }
    
    /**
     * @return phpMorphy_Util_Collection_CollectionInterface
     */
    public function getDecorateeObject() {
        return $this->object;
    }
    
    /**
     * @param string $class
     * @param array $ctorArgs
     * @return phpMorphy_Util_Collection_CollectionInterface
     */
    static protected function instantiateClass($class, $ctorArgs) {
        $ref = new ReflectionClass($class);
        return $ref->newInstanceArgs($ctorArgs);
    }
    
    /**
     * @param string $propName
     * @return phpMorphy_Util_Collection_CollectionInterface
     */
    public function __get($propName) {
        if('object' === $propName) {
            $obj = $this->proxyInstantiate();
            $this->setDecorateeObject($obj);
            return $obj;
        }
    
        throw new phpMorphy_Exception("Unknown property '$propName'");
    }
    
    /**
     * This method invoked by __get() at first time access to proxy object
     * Must return instance of 'phpMorphy_Util_Collection_CollectionInterface'
     * @abstract
     * @return object
     */
    protected function proxyInstantiate() {
        if(!isset($this->on_instantiate)) {
            throw new phpMorphy_Exception('You must implement phpMorphy_Util_Collection_Decorator::proxyInstantiate or pass \$onInstantiate to actAsProxy() method');
        }
    
        $fn = $this->on_instantiate;
        unset($this->on_instantiate);
    
        return $fn();
    }
    
    /**
     * Implement deep copy paradigm
     */
    function __clone() {
        if(isset($this->object)) {
            $this->object = clone $this->object;
        }
    }

    /**
    * @abstract
    * @param Traversable $values
    * @return void
    */
    public function import($values) {
        $result = $this->object->import($values);
        return $result === $this->object ? $this : $result;
    }

    /**
    * @abstract
    * @param mixed $value
    * @return void
    */
    public function append($value) {
        $result = $this->object->append($value);
        return $result === $this->object ? $this : $result;
    }

    /**
    * @abstract
    * @return void
    */
    public function clear() {
        $result = $this->object->clear();
        return $result === $this->object ? $this : $result;
    }

    public function getIterator() {
        $result = $this->object->getIterator();
        return $result === $this->object ? $this : $result;
    }

    public function offsetExists($offset) {
        $result = $this->object->offsetExists($offset);
        return $result === $this->object ? $this : $result;
    }

    public function offsetGet($offset) {
        $result = $this->object->offsetGet($offset);
        return $result === $this->object ? $this : $result;
    }

    public function offsetSet($offset, $value) {
        $result = $this->object->offsetSet($offset, $value);
        return $result === $this->object ? $this : $result;
    }

    public function offsetUnset($offset) {
        $result = $this->object->offsetUnset($offset);
        return $result === $this->object ? $this : $result;
    }

    public function count() {
        $result = $this->object->count();
        return $result === $this->object ? $this : $result;
    }

}
