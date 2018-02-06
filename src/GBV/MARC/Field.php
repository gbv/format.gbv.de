<?php
namespace GBV\MARC;

use GBV\NotFoundException;

/**
 * Handle marc information.
 *
 * @package   PicaHelpRest
 * @author    Karsten (Teralios) Achterrath
 * @copyright ©2017 - 2018 Teralios.de
 * @license   GPLv3 <https://github.com/Teralios/commentarius/blob/master/LICENSE>
 */
class Field
{
    /**
     * @var string
     */
    protected $jsonUrl = 'https://raw.githubusercontent.com/pkiraly/metadata-qa-marc/master/src/main/resources/marc-schema.json';

    /**
     * @var string
     */
    protected $path = '';

    /**
     * @var string
     */
    protected $cacheFile = '';

    /**
     * @var int
     */
    protected $lifetime = 86400;

    /**
     * @var array
     */
    protected $fields = [];

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var bool
     */
    protected $unavailable = false;

    /**
     * Field constructor.
     *
     * @param   string  $path
     * @throws  NotFoundException
     */
    public function __construct(string $path)
    {
        $this->path = $path;
        $this->cacheFile = dirname(__FILE__) . '/marc.json';
        $this->checkPath();
        $this->loadFile();
        $this->loadData();
    }

    /**
     * Returns data
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Load data.
     */
    protected function loadData()
    {
        if ($this->path != 'schema') {
            if (isset($this->fields[$this->path])) {
                $this->data = array_merge(['tag' => (string) $this->path], $this->fields[$this->path]);
            }

            return;
        }

        foreach ($this->fields as $field) {
            $field['tag'] = (string) $field['tag'];
            $this->data[] = $field;
        }
    }

    /**
     * Check path.
     *
     * @throws NotFoundException
     */
    protected function checkPath()
    {
        if (!preg_match('#^([0-9]{3}|schema)$#', $this->path)) {
            throw new NotFoundException();
        }
    }

    /**
     * Load cached file.
     */
    protected function loadFile()
    {
        if (file_exists($this->cacheFile) && (filemtime($this->cacheFile) + $this->lifetime) > time()) {
            $content = file_get_contents($this->cacheFile);
            $this->fields = json_decode($content, true, 1024, JSON_FORCE_OBJECT);
            return;
        }

        if ($this->unavailable === false) {
            $this->loadSource();
        }
    }

    /**
     * Load source file.
     */
    protected function loadSource()
    {
        $curl = curl_init($this->jsonUrl);
        curl_setopt($curl, CURLOPT_FILETIME, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($curl);

        if (curl_errno($curl) && file_exists($this->cacheFile)) {
            touch($this->cacheFile);
            $this->unavailable = true;
            $this->loadFile();
            return;
        }

        $fields = json_decode($content, true, 1024, JSON_FORCE_OBJECT);
        $this->cleanData($fields);

        file_put_contents($this->cacheFile, json_encode($this->fields, JSON_FORCE_OBJECT, 1024));
    }

    /**
     * Clean data from source.
     *
     * @param array $fields
     */
    protected function cleanData(array $fields)
    {
        foreach ($fields as $key => $field) {
            if ($key == 'Leader') {
                continue;
            }
            $key = (string) $key;

            $this->fields[$key] = [
                'tag' => $key,
                'label' => $field['label'],
                'repeatable' => $field['repeatable']
            ];
        }
    }
}
