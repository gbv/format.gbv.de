<?php
namespace GBV\Pica;

// imports
use Re\Database\Database;
use Re\Util\StringUtil;

class Field {
	const PICA_P = '#^(?P<field>[0-9]{3}[A-Z\@]{1})(?P<sub>\${1}[0-9A-Z]{1})*$#';
	const PICA_3 = '#^(?P<field>[0-9]{4})#';
	protected $db = null;
	protected $path = '';
	protected $pica3 = false;

	protected $name = '';
	protected $pica3name = '';
	protected $subFieldName = '';
	protected $data = [];

	public function __construct($path, Database $db) {
		$this->path = strtoupper(StringUtil::trim($path));
		$this->db = $db;

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

	protected function checkPath() {
		$this->path = trim($this->path, '/');
		$this->preparePath();

		if (empty($this->name) && strlen($this->path) > 0) {
			throw new \Exception(404);
		}
	}

	protected function preparePath(bool $pica3 = false) {
		$regEx = ($pica3) ? self::PICA_3 : self::PICA_P;
		if (preg_match($regEx, $this->path, $matches)) {
			if (isset($matches['field'])) $this->name = $matches['field'];
			if (isset($matches['sub'])) $this->subFieldName = strtolower($matches['field']);
			$this->pica3 = $pica3;
		}
		else if ($this->pica3 !== true && $pica3 !== true) {
			$this->preparePath(true);
		}
	}

	/**
	 * @throws \Exception
	 */
	protected function loadData() {
		if (empty($this->name)) {
			$this->loadList();
			return;
		}
		else if (!empty($this->subFieldName)) {
			$this->loadSubField();
			return;
		}

		$this->loadField();
	}

	protected function loadField() {
		$sql = 'SELECT * FROM hauptfeld WHERE pica_p = ?';
		$statement = $this->db->prepare($sql);
		$statement->execute([$this->name]);
		$field = $statement->fetch();

		if (empty($field['titel'])) {
			throw new \Exception('', 404);
		}

		$this->data['pica+'] = $field['pica_p'];
		$this->data['pica3'] = $field['pica_3'];
		$this->data['content'] = $field['titel'];
		$this->data['repeatable'] = ($field['wiederholbar'] == 'Ja') ? true : false;
		$this->data['modified'] = $field['stand'];
		$this->loadSubFields();
	}

	protected function loadList() {
		$sql = 'SELECT pica_p, pica_3, titel FROM hauptfeld';
		$statement = $this->db->query($sql);
		$fields = $statement->fetchAll();

		foreach ($fields as $field) {
			if (empty($field['titel'])) continue;

			$this->data[] = [
				'pica+' => $field['pica_p'],
				'pica3' => $field['pica_3'],
				'content' => $field['titel']
			];
		}
	}

	protected function loadSubField() {
	}

	protected function loadSubFields() {
		$sql = 'SELECT * FROM unterfeld WHERE pica_p = ?';
		$statement = $this->db->prepare($sql);
		$statement->execute([$this->name]);
		$subFields = $statement->fetchAll();
		foreach ($subFields as $subField) {
			$data = [];
			$data['code'] = $subField['pica_p_uf'];
			$data['pica3'] = ($subField['pica_3_uf'] == 'Ohne') ? null : $subField['pica_3_uf'];
			$data['content'] = $subField['titel'];
			$data['repeatable'] = ($subField['wiederholbar'] == 'Ja') ? true : false;
			$data['modified'] = $subField['stand'];

			$this->data['subfields'][] = $data;
		}
	}
}
