<?php
function run() {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/reminder");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_exec($ch);
    curl_close($ch);
}
run();
while(file_get_contents(__DIR__ . '/kill') != 'kill') {
    run();
    sleep(5);
}

echo 'Kill reminder script' . PHP_EOL;