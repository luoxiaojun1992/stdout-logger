<?php

$logPath = $argv[1];
$servoedExitIdentify = $argv[2] ?? '###exit###';
$logFlushInterval = $argv[3] ?? 100000000;
$logBufferFlushInterval = $argv[4] ?? 10000;

$logBuffer = [];
$logBufferSize = 0;

$receiveTimes = 0;

while(true) {
    ++$receiveTimes;
    if ($receiveTimes >= $logFlushInterval) {
        if ($logBufferSize > 0) {
            file_put_contents($logPath, implode('', $logBuffer), LOCK_EX | FILE_APPEND);
            $logBuffer = [];
            $logBufferSize = 0;
        }
    }

    $log = fgets(STDIN);
    if ($log === false) {
        continue;
    }

    $logWithoutEOL = rtrim($log, "\r\n");
    if ($logWithoutEOL === $servoedExitIdentify) {
        if ($logBufferSize > 0) {
            file_put_contents($logPath, implode('', $logBuffer), LOCK_EX | FILE_APPEND);
            $logBuffer = [];
            $logBufferSize = 0;
        }

        exit(0);
    }

    $logBuffer[] = $log;
    ++$logBufferSize;

    if ($logBufferSize >= $logBufferFlushInterval) {
        file_put_contents($logPath, implode('', $logBuffer), LOCK_EX | FILE_APPEND);
        $logBuffer = [];
        $logBufferSize = 0;
    }
}
