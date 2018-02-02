<?php
namespace GBV;

interface ControllerInterface
{
    public function handle(string $path, DB $db);
}
