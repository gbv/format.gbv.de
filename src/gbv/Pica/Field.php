<?php
namespace GBV\Pica;

// imports
use GBV\Exception\HttpException;
use Re\Database\Database;

/**
 * Prepare pica+ field information for rest api.
 *
 * @package		PicaHelpRest
 * @author		Karsten Achterrath <karsten.achterrath@gbv.de>
 * @copyright	©$2018 GBV VZG <https://www.gbv.de>
 * @license		GPLv3 <https://www.gnu.org/licenses/gpl-3.0.txt>
 */
class Field {
	/**
	 * Pica+ field reg ex.
	 */
	const PICA_P = '#^(?P<field>[0-9]{3}[A-Z\@]{1})(?P<sub>\${1}[0-9A-Z]{1})*$#';

	/**
	 * Pica3 field reg ex.
	 */
	const PICA_3 = '#^(?P<field>[0-9]{4})#';

	/**
	 * @var \Re\Database\Database
	 */
	protected $db = null;

	/**
	 * @var string
	 */
	protected $path = '';

	/**
	 * @var bool
	 */
	protected $pica3 = false;

	/**
	 * @var string
	 */
	protected $name = '';

	/**
	 * @var string
	 */
	protected $pica3name = '';

	/**
	 * @var string
	 */
	protected $subFieldName = '';

	/**
	 * @var string[]
	 */
	protected $data = [];

	/**
	 * Field constructor.
	 *
	 * @param	string					$path
	 * @param	\Re\Database\Database	$db
	 * @throws \GBV\Exception\HttpException
	 */
	public function __construct(string $path, Database $db) {
		$this->path = $path;
		$this->db = $db;

		$this->checkPath();
		$this->loadData();
	}

	/**
	 * Given path is a pica3 field.
	 *
	 * @return	bool
	 */
	public function isPica3() {
		return $this->pica3;
	}

	/**
	 * Returns pica+
	 *
	 * @return	string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Returns data.
	 *
	 * @return	string[]
	 */
	public function getData() {
		return $this->data;
	}

	/**
	 * Check path.
	 *
	 * @throws \GBV\Exception\HttpException
	 */
	protected function checkPath() {
		$this->path = trim($this->path, '/');
		$this->preparePath();

		if (empty($this->name) && strlen($this->path) > 0) {
			throw new HttpException(404);
		}
	}

	/**
	 * Prepare path information.
	 *
	 * @param	bool	$pica3
	 */
	protected function preparePath(bool $pica3 = false) {
		$regEx = ($pica3) ? self::PICA_3 : self::PICA_P;
		if (preg_match($regEx, $this->path, $matches)) {
			if (isset($matches['field'])) $this->name = $matches['field'];
			if (isset($matches['sub'])) $this->subFieldName = strtolower($matches['sub']);
			$this->pica3 = $pica3;
		}
		else if ($this->pica3 !== true && $pica3 !== true) {
			$this->preparePath(true);
		}
	}

	/**
	 * Load data.
	 *
	 * @throws	\GBV\Exception\HttpException
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

	/**
	 * Load full pica+ list (only rda fields.)
	 */
	protected function loadList() {
		$sql = 'SELECT pica_p, pica_3, titel FROM hauptfeld';
		$statement = $this->db->query($sql);
		$fields = $statement->fetchAll();

		foreach ($fields as $field) {
			if (empty($field['titel'])) continue;

			$this->data[] = [
				'pica_p' => $field['pica_p'],
				'pica_3' => $field['pica_3'],
				'content' => $field['titel']
			];
		}
	}

	/**
	 * Load data from pica+ field.
	 *
	 * @throws \GBV\Exception\HttpException
	 */
	protected function loadField() {
		if ($this->isPica3()) {
			$this->loadPica3Field();
			return;
		}

		// sql
		$sql = 'SELECT * FROM hauptfeld WHERE pica_p = ?';
		$statement = $this->db->prepare($sql);
		$statement->execute([$this->name]);
		$field = $statement->fetch();

		// no field found.
		if (empty($field['titel'])) {
			throw new HttpException(404);
		}

		$this->data['pica_p'] = $field['pica_p'];
		$this->data['pica_3'] = $field['pica_3'];
		$this->data['content'] = $field['titel'];
		$this->data['repeatable'] = ($field['wiederholbar'] == 'Ja') ? true : false;
		$this->data['modified'] = $field['stand'];
		$this->loadSubFields();
	}

	/**
	 * Load pica_p field for pica3 field.
	 *
	 * @throws \GBV\Exception\HttpException
	 */
	protected function loadPica3Field() {
		$sql = 'SELECT pica_p FROM hauptfeld WHERE pica_3 = ?';
		$statement = $this->db->prepare($sql);
		$statement->execute([$this->name]);
		$field = $statement->fetch();

		if (!isset($field['pica_p'])) {
			throw new HttpException(404);
		}

		$this->name = $field['pica_p'];
	}

	/**
	 * Load sub field list.
	 */
	protected function loadSubFields() {
		$sql = 'SELECT * FROM unterfeld WHERE pica_p = ?';
		$statement = $this->db->prepare($sql);
		$statement->execute([$this->name]);
		$subFields = $statement->fetchAll();
		foreach ($subFields as $subField) {
			$data = [];
			$data['code_p'] = $subField['pica_p_uf'];
			$data['code_3'] = ($subField['pica_3_uf'] == 'Ohne') ? null : $subField['pica_3_uf'];
			$data['content'] = $subField['titel'];
			$data['repeatable'] = ($subField['wiederholbar'] == 'Ja') ? true : false;
			$data['modified'] = $subField['stand'];

			$this->data['subfields'][] = $data;
		}
	}

	/**
	 * Load a sub field.
	 *
	 * @throws \GBV\Exception\HttpException
	 */
	protected function loadSubField() {
		$sql = 'SELECT * FROM unterfeld WHERE pica_p = ? AND pica_p_uf = ?';
		$statement = $this->db->prepare($sql);
		$statement->execute([$this->name, $this->subFieldName]);
		$subField = $statement->fetch();

		if (!isset($subField['pica_p_uf'])) {
			throw new HttpException(404);
		}

		$this->data['pica_p'] = $subField['pica_3'];
		$this->data['pica_3'] = $subField['pica_p'];
		$this->data['code_p'] = $subField['pica_p_uf'];
		$this->data['code_3'] = ($subField['pica_3_uf'] == 'Ohne') ? null : $subField['pica_3_uf'];
		$this->data['content'] = $subField['titel'];
		$this->data['repeatable'] = ($subField['wiederholbar'] == 'Ja') ? true : false;
		$this->data['modified'] = $subField['stand'];
	}
}
