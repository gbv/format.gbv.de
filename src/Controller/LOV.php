<?php declare(strict_types=1);

namespace Controller;

class LOV extends HTML
{

    public function page($f3, $params)
    {
        $path = $params['*'] ?? '';

        if (!preg_match('/^[a-zA-Z]+$/', $path)) {
            $this->indexPage($f3);
            return;
        }

        $url = 'http://lov.okfn.org/dataset/lov/api/v2/vocabulary/info?vocab='.$path;
        $data = @file_get_contents($url);
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

    public function indexPage($f3)
    {
        $url = 'http://lov.okfn.org/dataset/lov/api/v2/vocabulary/list';
        $data = @file_get_contents($url);
        $data = json_decode($data, true);
        $vocables = [];
        foreach ($data as $entry) {
            $vocables[] = ['prefix' => $entry['prefix'], 'title' => $entry['titles'][0]['value']];
        }

        $f3->set('breadcrumb', [
            $f3->get('BASE') => 'Formate',
            '../../rdf' => 'RDF'
        ]);
        $f3->set('VIEW', 'rdf-lov.php');
        $f3->mset([
            'title' => 'Linked Open Vocabularies',
            'wikidata' => 'Q39392701',
            'homepage' => 'http://lov.okfn.org/',
            'vocables' => $vocables
        ]);
    }
}
