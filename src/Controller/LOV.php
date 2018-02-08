<?php declare(strict_types=1);

namespace Controller;

class LOV extends HTML
{

    public function page($f3, $params)
    {
        $path = $params['*'] ?? '';

        if (!preg_match('/^[a-zA-Z-]+$/', $path)) {
            if ($path == '') {
                $this->index($f3);
            } else {
                $f3->error(404);
            }
            return;
        }

        $url = 'http://lov.okfn.org/dataset/lov/api/v2/vocabulary/info?vocab='.$path;
        $data = file_get_contents($url);
        $data = json_decode($data, true);

        if (!$data || !isset($data['prefix'])) {
            $f3->error(404);
        }

        $f3->set('breadcrumb', [
            $f3->get('BASE') => 'Formate',
            '../../rdf' => 'RDF',
            '../lov' => 'LOV',
        ]);
        $f3->set('VIEW', 'lov.php');

        $title = $data['titles'][0]['value'] ?? $data['prefix'];
        $prefix = $data['prefix'];

        // publisher
        if (isset($data['publisherIds'])) {
            foreach ($data['publisherIds'] as $publisher) {
                $publishers[] = $publisher['name'];
            }
        }

        $f3->mset([
            'prefix'    => $prefix,
            'title'     => $prefix,
            'fulltitle' => $title == $prefix ? $title : "$title ($prefix)",
            'url'       => $data['homepage'] ?? null,
            'uri'       => $data['uri'] ?? null,
            'description' => $data['descriptions'][0]['value'] ?? null,
            'publishers' => $publishers ?? null
        ]);

        // TODO: add incoming and outgoing links
        // TODO: add equivalence to Wikidata and BARTOC
    }

    public function index($f3)
    {
        $url = 'http://lov.okfn.org/dataset/lov/api/v2/vocabulary/list';
        $data = file_get_contents($url);
        $data = json_decode($data, true);

        $vocabularies = [];
        foreach ($data as $voc) {
            $prefix = $voc['prefix'];
            $vocabularies[$prefix] = [
                'prefix' => $prefix,
                'title' => $voc['titles'][0]['value']
            ];
        }
        ksort($vocabularies);

        $f3['breadcrumb'] = [
            $f3->get('BASE') => 'Formate',
            '../../rdf' => 'RDF'
        ];
        $f3['VIEW'] = 'rdf/lov.php';

        $f3->mset([
            'title' => 'Linked Open Vocabularies',
            'wikidata' => 'Q39392701',
            'homepage' => 'http://lov.okfn.org/',
            'vocabularies' => $vocabularies
        ]);
    }
}
