<?php
namespace GBV\Pica;

// imports
use Re\Database\Database;
use Re\Util\StringUtil;

class Field {
	const PICA_PLUS = '#^(:P<field>[0-9]{3}[a-z]{1})(:P<sub>\${1}[0-9]{1})*$#';
	const PICA3 = '#^(:P<field>[0-9]{4})(:P<sub>\${1}[0-9]{1})*$#';
	protected $db = null;
	protected $path = '';
	protected $pica3 = false;

	protected $name = '';
	protected $pica3name = '';
	protected $subFieldName = '';
	protected $data = [];

	public function __construct($path, Database $db) {
		$this->path = strtolower(StringUtil::trim($path));
		$this->db = $db;

		$this->preparePath();
		$this->checkPath();
		$this->loadData();
	}

	public function isPica3() {
		return $this->pica3;
	}

	public function getName() {
		return $this->name;
	}

	public function getData() {
		return $this->data;
	}

	protected function preparePath() {
		$this->path = trim($this->path, '/');

		if (empty($this->path)) {
			return;
		}

		$this->checkPath();
	}

	protected function checkPath(bool $pica3 = false) {
		$regEx = ($pica3) ? self::PICA_PLUS : self::PICA3;

		if (preg_match($regEx, $this->path, $matches)) {
			if (isset($matches['field'][0])) $this->name = $matches['field'][0];
			if (isset($matches['sub'][0])) $this->subFieldName = $matches['field'][0];
			$this->pica3 = $pica3;
		}
		else if ($this->pica3 !== true) {
			$this->checkPath(true);
		}

	}

	protected function loadData() {

	}
}
