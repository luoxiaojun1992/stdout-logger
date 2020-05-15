<?php

declare(ticks=1);

$logPath = $argv[1];
$logBufferFlushInterval = $argv[2] ?? 10000;

$logBuffer = [];
$logBufferSize = 0;

$logCounter = 0;

while(true) {
    $log = fgets(STDIN);
    if ($log === false) {
        continue;
    }

    if ($log === '###exit###') {
        exit(0);
    }

    shell_exec('clear');

    echo 'Received Log:' . $log;
    $logBuffer[] = $log;
    ++$logBufferSize;
    echo 'Log buffer size:' . ((string)$logBufferSize), PHP_EOL;

    if ($logBufferSize >= $logBufferFlushInterval) {
        file_put_contents($logPath, implode('', $logBuffer), LOCK_EX | FILE_APPEND);
        $logBuffer = [];
        $logBufferSize = 0;
        echo 'Log buffer flushed', PHP_EOL;
    }

    ++$logCounter;

    echo 'Log count:' . ((string)$logCounter), PHP_EOL;
}
