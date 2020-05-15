<?php

$begin = microtime(true);

for ($i = 0; $i < 10000000; ++$i) {
    echo 11111111, PHP_EOL;
}

var_dump(sys_getloadavg());
echo 'Duration:' . (string)(microtime(true) - $begin) . 's', PHP_EOL;

echo "###exit###";
