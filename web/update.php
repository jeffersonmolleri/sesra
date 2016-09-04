<?php

$out = shell_exec('svn up ..');

echo '<h1>Sincronizando com repositório</h1>';
echo "<pre>$out</pre>";

$out = shell_exec('php ../symfony cc');

echo '<h1>Reiniciando cache</h1>';
echo "<pre>$out</pre>";
