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
    const PICA_P = '#^(?P<field>[0-9]{3}[a-zA-Z\@]{1})(/(?P<occurrence>[0-9]{2}))?(?P<sub>\${1}[a-zA-Z0-9]{1})?$#';

    /**
     * Pica3 field reg ex.
     */
    const PICA_3 = '#^(?P<field>[0-9]{3,4})#';

    /**
     * Url to online help
     */
    const HELP_URL = 'http://swbtools.bsz-bw.de/cgi-bin/help.pl?cmd=kat&val={pica3}&regelwerk=RDA&verbund=GBV';

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
    protected $field = '';

    /**
     * @var string
     */
    protected $pica3field = '';

    /**
     * @var string
     */
    protected $subfield = '';

    /**
     * @var string[]
     */
    protected $data = [];

    /**
     * @var string
     */
    protected $type = 'T';

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
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * Return data.
     *
     * @return string[]
     * @throws NotFoundException
     */
    public function getData()
    {
        if (count($this->data) == 0) {
            throw new NotFoundException();
        }

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
        $this->setType();
        $this->preparePath();
        if (empty($this->field) && strlen($this->path) > 0) {
            throw new NotFoundException();
        }
    }

    public function setType()
    {
        $this->type = 'T';
        if (preg_match('#^authority/?#', $this->path)) {
            $this->type = 'N';
            $this->path = preg_replace('#^authority/?#', '', $this->path);
        }
    }

    /**
     * Prepare path information.
     *
     * @param   bool   $pica3
     */
    protected function preparePath(bool $pica3 = false)
    {
        $regEx = ($pica3) ? self::PICA_3 : self::PICA_P;
        if (preg_match($regEx, $this->path, $matches)) {
            $field = $matches['field'] ?? '';
            $sub = $matches['sub'] ?? '';
            $occurrence = $matches['occurrence'] ?? '';
            $authority = $matches['authority'] ?? '';
            $this->setParameters($field, $sub, $occurrence, $authority, $pica3);
        } elseif ($this->pica3 !== true && $pica3 !== true) {
            $this->preparePath(true);
        }
    }

    /**
     * Set parameters.
     *
     * @param string $field
     * @param string $sub
     * @param string $occurrence
     * @param string $authority
     * @param bool   $pica3
     */
    protected function setParameters(string $field, string $sub, string $occurrence, string $authority, bool $pica3)
    {
        if ($pica3 === true) {
            $this->field = $field;
            $this->pica3 = true;
            return;
        }

        $this->field = $field;
        $this->subfield = $sub;
        $this->type = (empty($authority)) ? 'T' : 'N';

        if (!empty($occurrence)) {
            $this->field .= '/' . $occurrence;
        } elseif (empty($sub)) {
            $this->field .= '%';
        }
    }

    /**
     * Load data.
     *
     * @throws NotFoundException
     */
    protected function loadData()
    {
        if (empty($this->field)) {
            $this->loadList();
            return;
        } elseif ($this->isPica3()) {
            $this->loadPica3Field();
            return;
        } elseif (!empty($this->subfield)) {
            $this->loadSubfield();
            return;
        }

        $this->loadField();
    }

    /**
     * Load full pica+ list (only api fields.)
     */
    protected function loadList()
    {
        $sql = 'SELECT pica_p, pica_3, titel FROM hauptfeld WHERE datentyp = ? ORDER BY pica_p ASC';
        $fields = $this->db->query($sql, [$this->type]);

        foreach ($fields->fetchAll(PDO::FETCH_ASSOC) as $field) {
            if (empty($field['titel'])) {
                continue;
            }
            $data = $this->fieldInfo($field);
            $this->data[$data['tag']] = $this->fieldInfo($field);
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
        $sql = 'SELECT * FROM hauptfeld WHERE pica_p LIKE ? AND datentyp = ?';
        $fields = $this->db->query($sql, [$this->field, $this->type])->fetchAll(PDO::FETCH_ASSOC);

        // no field found.
        foreach ($fields as $field) {
            if (empty($field['titel'])) {
                continue;
            }

            $data = $this->fieldInfo($field, true);
            $subfields = $this->loadSubfields($data['tag']);
            if (!empty($subfields)) {
                $data['subfields'] = $subfields;
            }
            $this->data[] = $data;
        }
    }

    /**
     * Load pica_p field for pica3 field.
     *
     * @throws NotFoundException
     */
    protected function loadPica3Field()
    {
        $sql = 'SELECT pica_p FROM hauptfeld WHERE pica_3 = ?';
        $field = $this->db->query($sql, [$this->field])->fetch(PDO::FETCH_ASSOC);
        if (!isset($field['pica_p'])) {
            throw new NotFoundException();
        }

        $this->field = $field['pica_p'];
    }

    /**
     * Load subfield list.
     */
    protected function loadSubfields(string $pica3)
    {
        $sql = 'SELECT * FROM unterfeld WHERE pica_p LIKE ? AND pica_3 = ? AND datentyp = ? ORDER BY nr ASC';
        $subfields = $this->db->query($sql, [$this->field, $pica3, $this->type]);

        $subfieldData = [];
        foreach ($subfields->fetchAll(PDO::FETCH_ASSOC) as $subfield) {
            if ($subfield['titel'] == 'In RDA-Sätzen nicht zugelassen') {
                continue; // simple but it works. ;)
            }
            $data = $this->subfieldInfo($subfield);
            $subfieldData[$data['code']] = $data;
        }

        return $subfieldData;
    }

    /**
     * Map subfield information from database format.
     *
     * @param   array $subfield
     * @return  array
     */
    protected function subfieldInfo(array $subfield): array
    {
        return [
            'code'       => $subfield['pica_p_uf'],
            'pica3'      => (
                preg_match('/^ohne$/i', $subfield['pica_3_uf'])
                ? null : $subfield['pica_3_uf']),
            'label'      => $subfield['titel'],
            'repeatable' => ($subfield['wiederholbar'] == 'Ja') ? true : false,
            'modified'   => $subfield['stand'],
            'position'   => $subfield['nr'],
        ];
    }

    /**
     * Load a subfield.
     *
     * @throws NotFoundException
     */
    protected function loadSubfield()
    {
        $sql = 'SELECT * FROM unterfeld WHERE pica_p = ? AND pica_p_uf = ? AND datentyp = ?';
        $subfield = $this->db->query($sql, [$this->field, $this->subfield, $this->type])->fetch(PDO::FETCH_ASSOC);

        if (!isset($subfield['pica_p_uf']) || $subfield['titel'] == 'In RDA-Sätzen nicht zugelassen') {
            throw new NotFoundException();
        }

        $this->data = array_merge(['tag' => $this->field], $this->subfieldInfo($subfield));
    }

    /**
     * Map field information from database format.
     *
     * @param   array   $field
     * @param   bool    $complex
     * @return  array
     */
    protected function fieldInfo(array $field, bool $complex = false): array
    {
        list($picap, $occurrence) = $this->splitPicaPField($field['pica_p']);

        $data = [
            'tag'   => $picap,
            'pica3' => $field['pica_3'],
            'label' => $field['titel']
        ];

        if ($occurrence != -1) {
            $data['occurrence'] = $occurrence;
        }

        if ($complex === true) {
            // url
            $data['url'] = str_replace('{pica3}', $field['pica_3'], static::HELP_URL);
            $data['repeatable'] = ($field['wiederholbar'] == 'Ja') ? true : false;
            $data['modified']   = $field['stand'];
        }

        return $data;
    }

    /**
     * Split field on occurence
     * @param   string  $field
     * @return  array
     */
    protected function splitPicaPField(string $field): array
    {
        $occurrence = -1;
        $picap = $field;
        if (strpos($field, '/') !== false) {
            list($picap, $occurrence) = explode('/', $field);
        }

        return [$picap, $occurrence];
    }
}
