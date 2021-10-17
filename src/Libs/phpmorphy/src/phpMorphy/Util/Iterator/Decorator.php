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
 * @decorator-decoratee-class Iterator
 * @decorator-decorator-class phpMorphy_Util_Iterator_Decorator
 */

abstract class phpMorphy_Util_Iterator_Decorator implements Iterator, phpMorphy_DecoratorInterface {
    /** @var Iterator */
    private $object;
    /** @var Closure|null */
    private $on_instantiate;
    
    /**
     * @param $object Iterator
     */
    function __construct(Iterator $object) {
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
     * @param $object Iterator
     * @return phpMorphy_Util_Iterator_Decorator
     */
    protected function setDecorateeObject(Iterator $object) {
        $this->object = $object;
        return $this;
    }
    
    /**
     * @return Iterator
     */
    public function getDecorateeObject() {
        return $this->object;
    }
    
    /**
     * @param string $class
     * @param array $ctorArgs
     * @return Iterator
     */
    static protected function instantiateClass($class, $ctorArgs) {
        $ref = new ReflectionClass($class);
        return $ref->newInstanceArgs($ctorArgs);
    }
    
    /**
     * @param string $propName
     * @return Iterator
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
     * Must return instance of 'Iterator'
     * @abstract
     * @return object
     */
    protected function proxyInstantiate() {
        if(!isset($this->on_instantiate)) {
            throw new phpMorphy_Exception('You must implement phpMorphy_Util_Iterator_Decorator::proxyInstantiate or pass \$onInstantiate to actAsProxy() method');
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

    public function current() {
        $result = $this->object->current();
        return $result === $this->object ? $this : $result;
    }

    public function next() {
        $result = $this->object->next();
        return $result === $this->object ? $this : $result;
    }

    public function key() {
        $result = $this->object->key();
        return $result === $this->object ? $this : $result;
    }

    public function valid() {
        $result = $this->object->valid();
        return $result === $this->object ? $this : $result;
    }

    public function rewind() {
        $result = $this->object->rewind();
        return $result === $this->object ? $this : $result;
    }

}
