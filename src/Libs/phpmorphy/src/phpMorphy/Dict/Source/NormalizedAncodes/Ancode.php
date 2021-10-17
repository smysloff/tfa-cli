<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */


class phpMorphy_Dict_Source_NormalizedAncodes_Ancode {
    private
        $id,
        $name,
        $pos_id,
        $grammems_ids
        ;

    function __construct($id, $name, $posId, $grammemsIds) {
        $this->id = (int)$id;
        $this->pos_id = (int)$posId;
        $this->grammems_ids = array_map('intval', (array)$grammemsIds);
        $this->name = (string)$name;
    }

    function getId() {
        return $this->id;
    }

    function getPartOfSpeechId() {
        return $this->pos_id;
    }

    function getGrammemsIds() {
        return $this->grammems_ids;
    }

    function getName() {
        return $this->name;
    }
}