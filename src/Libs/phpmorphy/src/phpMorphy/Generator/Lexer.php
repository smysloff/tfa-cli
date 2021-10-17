<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */


class phpMorphy_Generator_Lexer implements SeekableIterator, Countable {
    const FORWARD = 1;
    const BACKWARD = -1;

    /** @var array */
    private $tokens;
    /** @var int */
    private $position;
    /** @var int */
    private $line;
    /** @var int */
    private $offset;
    /** @var bool */
    private $cached_is_valid;
    /** @var int */
    private $direction;

    /**
     * @param array $tokens
     */
    function __construct(array $tokens) {
        $this->tokens = $tokens;
        $this->rewind();
    }

    /**
     * @return int
     */
    public function getDirection() {
        return $this->direction;
    }

    /**
     * @param int $direction 1 or -1 or self::FORWARD or self::BACKWARD
     * @return phpMorphy_Generator_Lexer
     */
    public function setDirection($direction) {
        $this->direction = $direction === -1 ? -1 : 1;

        return $this;
    }

    /**
     * @return phpMorphy_Generator_Lexer
     */
    public function toggleDirection() {
        $this->direction *= -1;
        return $this;
    }

    /**
     * @return phpMorphy_Generator_Lexer
     */
    public function forwardDirection() {
        $this->direction = 1;
        return $this;
    }

    /**
     * @return phpMorphy_Generator_Lexer
     */
    public function backwardDirection() {
        $this->direction = -1;
        return $this;
    }

    /**
     * Rewind the Iterator to the first element
     * @return void Any returned value is ignored.
     */
    public function rewind() {
        $this->position = 0;
        $this->line = 1;
        $this->offset = 0;
        $this->cached_is_valid = null;
        $this->direction = 1;
    }

    /**
     * Checks if current position is valid
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid() {
        if(null === $this->cached_is_valid) {
            if($this->position >= 0 && $this->position < $this->count()) {
                $token = $this->tokens[$this->position];
                $this->cached_is_valid = !(is_array($token) && $token[0] === T_HALT_COMPILER);
            } else {
                $this->cached_is_valid = false;
            }
        }

        return $this->cached_is_valid;
    }

    /**
     * Return the key of the current element
     * @return int
     */
    public function key() {
        return $this->position;
    }

    /**
     * Move forward to next element
     * @return phpMorphy_Generator_Lexer
     */
    public function next() {
        if($this->valid()) {
            $token = $this->tokens[$this->position];

            if(is_string($token)) {
                $text = $token;
                $this->line += substr_count($token, "\n");
            } else {
                $text = $token[1];
                $this->line = $token[2];
            }

            $this->offset += strlen($text);
        }

        $this->cached_is_valid = null;
        $this->position += $this->direction;

        return $this;
    }

    public function prev() {
        $this->toggleDirection();
        $this->next();
        $this->toggleDirection();
    }

    /**
     * Return the current element
     * @return array
     */
    public function current() {
        $token = $this->tokens[$this->position];

        if(is_string($token)) {
            $token = array(
                $token,
                $token,
                $this->line,
                $this->offset
            );
        } else {
            $token[3] = $this->offset;
        }

        return $token;
    }

    /**
     * @param int $count
     * @return false|mixed[]
     */
    public function getNextTokens($count) {
        $old_pos = $this->key();
        $result = array();

        for(; $count > 0 && $this->valid(); $count--, $this->next()) {
            $result[] = $this->current();
        }

        $this->seek($old_pos);

        return $count > 0 ? false : $result;
    }

    /**
     * @return false|mixed[]
     */
    public function getNextToken() {
        $result = $this->getNextTokens(1);

        return false === $result ? false : $result[0];
    }

    /**
     * Seeks to a position
     * @param int $position The position to seek to.
     * @return phpMorphy_Generator_Lexer
     */
    public function seek($position) {
        $this->cached_is_valid = null;
        $this->position = (int)$position;

        if(!$this->valid()) {
            throw new phpMorphy_Exception("Position '$position' out of bound");
        }

        return $this;
    }


    /**
     * Count elements of an object
     * @return int The custom count as an integer.
     */
    public function count() {
        return count($this->tokens);
    }

    /**
     * @return int
     */
    public function getLine() {
        return $this->line;
    }

    /**
     * @return int
     */
    public function getOffset() {
        return $this->offset;
    }

    /**
     * @static
     * @param array|string $token
     * @return string
     */
    public static function tokenName($token) {
        if(is_array($token)) {
            return is_int($token[0]) ? token_name($token[0]) : $token[0];
        } else  {
            return $token;
        }
    }
}