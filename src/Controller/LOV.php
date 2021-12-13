<?php declare(strict_types=1);

namespace Controller;

class LOV extends HTML
{

    public function data(string $id)
    {
        if (!preg_match('/^[a-zA-Z-]+$/', $id)) {
            return;
        }

        $url = "https://lov.linkeddata.es/dataset/lov/api/v2/vocabulary/info?vocab=$id";
        $data = file_get_contents($url);
        $data = json_decode($data, true);

        if (!$data || !isset($data['prefix'])) {
            return;
        }

        $title = $data['titles'][0]['value'] ?? $data['prefix'];
        $prefix = $data['prefix'];

        // publisher
        if (isset($data['publisherIds'])) {
            foreach ($data['publisherIds'] as $publisher) {
                $publishers[] = $publisher['name'];
            }
        }

        $description = $data['descriptions'][0]['value'];

        $data['short'     ] = $prefix;
        $data['title'     ] = $title == $prefix ? $title : "$title ($prefix)";
        $data['homepage'  ] = $data['homepage'] ?? null;
        $data['uri'       ] = $data['uri'] ?? null;
        $data['BODY'      ] = $description ? "<p>$description</p>" : '';
        $data['publisher' ] = $publishers ?? null;
        $data['base']       = 'rdf';
        $data['lov']        = "https://lov.linkeddata.es/dataset/lov/vocabs/$id";

        # TODO: add schemas (Expressivity)

        # TODO: adjust source to LOV

        // TODO: include information from local knowledge base (#10)

        // TODO: add incoming and outgoing links
        // TODO: add equivalence to Wikidata and BARTOC

        return $data;
    }

    public function page($f3, string $path)
    {
        if ($path == '') {
            return parent::page($f3, 'rdf/lov');
        } else {
            $data = $this->data($path);
            if ($data) {
                return $data;
            } else {
                $f3->error(404);
            }
        }
    }
}
