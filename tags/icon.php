<span aria-hiden="true" <?php if ($tooltip) {
    echo " data-toggle='tooltip' title='$tooltip'";
}?>><?php

use Symfony\Component\Yaml\Yaml;
$icons = Yaml::parse(file_get_contents(__DIR__.'/icons.yaml'));

if (isset($icons[$icon])) {
?>
  <svg class="icon" viewBox="0 0 24 24" version="1.1" width="16" height="16">
    <path d="M0 0h24v24H0z" fill="none"/>
    <path d="<?=$icons[$icon]?>"/>
  </svg>
<?php } ?>
</span>
