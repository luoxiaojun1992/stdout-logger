<?php

$cmd = $argv[1];
$logPath = $argv[2];

$output = shell_exec($cmd);

file_put_contents($logPath, $output, LOCK_EX | FILE_APPEND);
