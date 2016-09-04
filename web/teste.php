<?php

header('Content-Type: application/vnd.ms-word');
header('Content-Disposition: attachment; Filename=arquivo.doc');

readfile('modeloProtocolo.xhtml');