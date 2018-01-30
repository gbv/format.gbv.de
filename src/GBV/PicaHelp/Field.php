<?php declare(strict_types=1);

namespace GBV\PicaHelp;

use GBV\PicaHelp\NotFoundException;
use GBV\PicaHelp\Database;
use PDO;

/**
 * Prepare PICA+ field and subfield information.
 *
 * @package     PicaHelp
 * @author      Karsten Achterrath <karsten.achterrath@gbv.de>
 * @copyright   GBV VZG <https://www.gbv.de>
 * @license     GPLv3 <https://www.gnu.org/licenses/gpl-3.0.txt>
 */
class Field
{
    /**
     * Pica+ field reg ex.
     */
    const PICA_P = '#^(?P<field>[0-9]{3}[a-zA-Z\@]{1})(?P<sub>\${1}[a-zA-Z0-9]{1})*$#';

    /**
     * Pica3 field reg ex.
     */
    const PICA_3 = '#^(?P<field>[0-9]{4})#';

    /**
     * @var \GBV\PicaHelp\Database
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
     * @param   string  $path
     * @param   \PDO    $db
     * @throws NotFoundException
     */
    public function __construct(string $path, Database $db)
    {
        $this->path = $path;
        $this->db = $db;

        $this->checkPath();
        $this->loadData();
    }

    /**
     * Given path is a pica3 field.
     *
     * @return boolean
     */
    public function isPica3()
    {
        return $this->pica3;
    }

    /**
     * Return PICA+
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Return data.
     *
     * @return string[]
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Check path.
     *
     * @throws NotFoundException
     */
    protected function checkPath()
    {
        $this->path = trim($this->path, '/');
        $this->preparePath();

        if (empty($this->name) && strlen($this->path) > 0) {
            throw new NotFoundException();
        }
    }

    /**
     * Prepare path information.
     *
     * @param   bool    $pica3
     */
    protected function preparePath(bool $pica3 = false)
    {
        $regEx = ($pica3) ? self::PICA_3 : self::PICA_P;
        if (preg_match($regEx, $this->path, $matches)) {
            if (isset($matches['field'])) {
                $this->name = $matches['field'];
            }
            if (isset($matches['sub'])) {
                $this->subFieldName = $matches['sub'];
            }
            $this->pica3 = $pica3;
        } elseif ($this->pica3 !== true && $pica3 !== true) {
            $this->preparePath(true);
        }
    }

    /**
     * Load data.
     *
     * @throws  NotFoundException
     */
    protected function loadData()
    {
        if (empty($this->name)) {
            $this->loadList();
            return;
        } elseif ($this->isPica3()) {
            $this->loadPica3Field();
        } elseif (!empty($this->subFieldName)) {
            $this->loadSubField();
            return;
        }

        $this->loadField();
    }

    /**
     * Load full pica+ list (only rda fields.)
     */
    protected function loadList()
    {
        $sql = 'SELECT pica_p, pica_3, titel FROM hauptfeld';
        $fields = $this->db->query($sql);

        foreach ($fields->fetchAll(PDO::FETCH_ASSOC) as $field) {
            if (empty($field['titel'])) {
                continue;
            }

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
     * @throws NotFoundException
     */
    protected function loadField()
    {
        // sql
        $sql = 'SELECT * FROM hauptfeld WHERE pica_p = ?';
        $field = $this->db->query($sql, [$this->name])->fetch(PDO::FETCH_ASSOC);

        // no field found.
        if (empty($field['titel'])) {
            throw new NotFoundException();
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
     * @throws NotFoundException
     */
    protected function loadPica3Field()
    {
        $sql = 'SELECT pica_p FROM hauptfeld WHERE pica_3 = ?';
        $field = $this->db->query($sql, [$this->name])->fetch(PDO::FETCH_ASSOC);

        if (!isset($field['pica_p'])) {
            throw new NotFoundException();
        }

        $this->name = $field['pica_p'];
    }

    /**
     * Load subfield list.
     */
    protected function loadSubFields()
    {
        $sql = 'SELECT * FROM unterfeld WHERE pica_p = ? ORDER BY nr ASC';
        $subfields = $this->db->query($sql, [$this->name]);

        foreach ($subfields->fetchAll(PDO::FETCH_ASSOC) as $subField) {
            if ($subField['titel'] == 'In RDA-Sätzen nicht zugelassen') {
                continue; // simple but it works. ;)
            }
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
     * Load a subfield.
     *
     * @throws NotFoundException
     */
    protected function loadSubField()
    {
        $sql = 'SELECT * FROM unterfeld WHERE pica_p = ? AND pica_p_uf = ?';
        $subfield = $this->db->query($sql, [$this->name, $this->subFieldName])->fetch(PDO::FETCH_ASSOC);

        if (!isset($subfield['pica_p_uf']) || $subfield['titel'] == 'In RDA-Sätzen nicht zugelassen') {
            throw new NotFoundException();
        }

        $this->data['pica_p'] = $subfield['pica_p'];
        $this->data['pica_3'] = $subfield['pica_3'];
        $this->data['code_p'] = $subfield['pica_p_uf'];
        $this->data['code_3'] = ($subfield['pica_3_uf'] == 'Ohne') ? null : $subfield['pica_3_uf'];
        $this->data['no'] = $subfield['nr'];
        $this->data['content'] = $subfield['titel'];
        $this->data['repeatable'] = ($subfield['wiederholbar'] == 'Ja') ? true : false;
        $this->data['modified'] = $subfield['stand'];
    }
}
