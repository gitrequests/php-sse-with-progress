<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

function send_message($event, $message, $progress = 1) {
    $d = array('message' => $message, 'progress' => $progress);

    echo "event: $event" . PHP_EOL;
    echo "data: " . json_encode($d) . PHP_EOL;
    echo PHP_EOL;

    ob_flush();
    flush();
}


//LONG RUNNING TASK
$counter = 10;
for($i = 1; $i <= $counter; $i++) {
    send_message('progress', "Iteration $i of $counter" , $i/$counter);
    if ( connection_aborted() ) break;
    sleep(1);
}

send_message('close', 'Process complete');
