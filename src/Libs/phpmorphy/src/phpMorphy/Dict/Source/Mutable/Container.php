<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Dict_Source_Mutable_Container implements IteratorAggregate, Countable {
    private
        $use_identity,
        $container = array(),
        $refcount = array(),
        $items_map;

    function __construct($useIdentity) {
        $this->use_identity = (bool)$useIdentity;
        $this->clear();
    }

    function append($model, $reuseIfExists) {
        if(null !== $this->items_map) {
            $identity_string = serialize($model);

            if($reuseIfExists) {
                if(isset($this->items_map[$identity_string])) {
                    $model = $this->items_map[$identity_string];
                    $this->refcount[$model->getId()]++;
                    return $model;
                }
            }
        }

        $new_model = clone $model;
        $id = count($this->container) + 1;
        $new_model->setId($id);

        $this->container[$id] = $new_model;
        $this->refcount[$id] = 1;

        if(null !== $this->items_map) {
            $this->items_map[$identity_string] = $new_model;
        }

        return $new_model;
    }

    function getById($id) {
        if(!$this->hasId($id)) {
            throw new phpMorphy_Exception("Can`t find model with '$id' id");
        }

        return $this->container[$id];
    }

    function deleteById($id, $holdUnused = true) {
        if(!$this->hasId($id)) {
            throw new phpMorphy_Exception("Can`t find model with '$id' id");
        }

        if($this->refcount[$id] > 0) {
            $this->refcount[$id]--;
        } else {
            if(!$holdUnused) {
                unset($this->container[$id]);
                unset($this->refcount[$id]);
            } else {
                throw new phpMorphy_Exception("Can`t delete model with '$id' id, while it in use");
            }
        }
    }

    function deleteUnused() {
        foreach($this->refcount as $id => $refcount) {
            if($refcount < 1) {
                $this->deleteById($id, false);
            }
        }
    }

    function clear() {
        $this->container = array();
        $this->refcount = array();
        $this->items_map = $this->use_identity ? array() : null;
    }

    function getIterator() {
        return new ArrayIterator($this->container);
    }

    function hasId($id) {
        return isset($this->container[$id]);
    }

    function count() {
        return count($this->container);
    }
}