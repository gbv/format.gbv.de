<?php declare(strict_types=1);

/**
 * Custom F3 Template tags.
 */
class Tags
{

    const NAMES = ['codelist', 'phtml', 'php' ];

    public static function codelist($args)
    {
        return \View::instance()->render(
            'codelist.php',
            'text/html',
            [ 'select' => $args['@attrib'] ]
        );
    }

    public static function phtml($args)
    {
        $html = $args[0] ?? '';
        return static::php([ 0 => "?>$html<?php " ]);
    }

    public static function php($args)
    {
        $php = $args[0] ?? '';
        ob_start();
        eval($php); // EVIL!
        return ob_get_clean();
    }
}
