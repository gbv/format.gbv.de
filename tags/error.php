<?php
$messages = [
    404 => 'Die angeforderte Seite ist nicht vorhanden!',
    500 => 'Es ist ein unerwarteter Fehler aufgetreten',
];
?>
<div class="alert alert-warning" role="alert">
    <?=@$messages[@$ERROR['code']] ?? $message[500]?>
</div>
