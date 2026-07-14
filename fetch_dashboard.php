<?php
$opts = ['http' => ['method' => 'GET', 'ignore_errors' => true]];
$ctx = stream_context_create($opts);
echo file_get_contents('http://127.0.0.1:8001/admin/dashboard', false, $ctx);
