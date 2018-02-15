<?php declare(strict_types=1);

/**
 * Custom F3 Template tags.
 */
class Tags
{

    const NAMES = ['codelist', 'codetable', 'schemalist', 'phtml', 'php' ];

    public static function exists($name)
    {
        return in_array($name, self::NAMES);
    }

    /**
     * Execute defined tag by calling its template.
     */
    public static function __callStatic($name, $args = [])
    {
        if (self::exists($name)) {
            $vars = $args[0]['@attrib'];
            $vars['content'] = $args[0][0] ?? '';
            return \View::instance()->render("$name.php", "text/html", $vars);
        }
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
