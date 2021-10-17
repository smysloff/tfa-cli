<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

abstract class phpMorphy_Aot_Mrd_SectionAbstract implements Iterator, Countable {
	const INTERNAL_ENCODING = 'utf-8';

	protected
		$file_it,
		$encoding,
		$start_line,
		$current_line,
		$section_size;

	function __construct(SeekableIterator $file, $encoding, $startLine) {
		$this->file_it = $file;

		$this->encoding = $this->prepareEncoding($encoding);
		$this->start_line = $startLine;
		$this->section_size = $this->readSectionSize($file);
	}

	protected function prepareEncoding($encoding) {
		$encoding = strtolower($encoding);

		if($encoding == 'utf8') {
			$encoding = 'utf-8';
		}

		return $encoding;
	}

	protected function openFile($fileName) {
		return new SplFileObject($fileName);
	}

	function getSectionLinesCount() {
		return $this->count() + 1;
	}

	function count() {
		return $this->section_size;
	}

	function key() {
		return $this->current_line;
	}

	function getPosition() {
		return $this->current_line;
	}

	function rewind() {
		$this->current_line = 0;
		$this->file_it->seek($this->start_line + 1);
	}

	function valid() {
		if($this->current_line >= $this->section_size) {
			return false;
		}

		if(!$this->file_it->valid()) {
			throw new phpMorphy_Aot_Mrd_Exception(
				"Too small section {$this->current_line} lines gathered, $this->section_size expected"
			);
		}

		return true;
	}

	function current() {
		return $this->processLine(rtrim($this->file_it->current()));
	}

	function next() {
		$this->file_it->next();
		$this->current_line++;
	}

	protected function iconv($string) {
		if($this->encoding == self::INTERNAL_ENCODING) {
			return $string;
		}

		return iconv($this->encoding, self::INTERNAL_ENCODING, $string);
	}

	protected function readSectionSize(SeekableIterator $it) {
		$it->seek($this->start_line);

		if(!$it->valid()) {
			throw new phpMorphy_Aot_Mrd_Exception("Can`t read section size, iterator not valid");
		}

		$size = trim($it->current());

		if(!preg_match('~^[0-9]+$~', $size)) {
			throw new phpMorphy_Aot_Mrd_Exception("Invalid section size: $size");
		}

		return (int)$size;
	}

	protected function processLine($line) {
		return $line;
	}
}