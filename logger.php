<?php

declare(ticks=1);

$servoed = $argv[1];;
$logPath = $argv[2];
$logBufferFlushInterval = $argv[3] ?? 10000;

$logBuffer = [];
$logBufferSize = 0;

$logCounter = 0;

while(true) {
    $log = fgets(STDIN);
    if ($log === false) {
        var_dump('ps aux | grep "' . $servoed . '" | grep -v grep | wc -l');
        $psCheckResult = shell_exec('ps aux | grep "' . $servoed . '" | grep -v grep | wc -l');
        $psCheckResult = str_replace(' ', '', $psCheckResult);
        $psCheckResult = str_replace("\r", '', $psCheckResult);
        $psCheckResult = str_replace("\n", '', $psCheckResult);
        var_dump($psCheckResult);
        if ($psCheckResult === '0') {
            exit(0);
        } else {
            continue;
        }
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
