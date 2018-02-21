<?php

require 'vendor/autoload.php';

$tags = new Tags('tags', ['a'=>4]);
echo join('|', $tags->names()).'\n';
echo $tags->call('php', ['content' => 'echo "$a$b";', 'b' => 2]);
