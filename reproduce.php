<?php

require_once 'vendor/autoload.php';

$kernel = new AppKernel('test', true);
$kernel->boot();

$client = $kernel->getContainer()->get('test.client');

$baseMemory = memory_get_usage();
$prev = 0;
for ($i = 1; $i < 200; $i++) {
    $client->request(
        'GET',
        '/api/article',
        [],
        [],
        ['HTTP_X-USR-ID' => '065169ec-cb23-4fe1-93c3-2df255055da5']
    );

    if (!$client->getResponse()->isOk()) {
        echo $client->getResponse()->getContent();
        exit;
    }

    $n = memory_get_usage() - $baseMemory;
    if ($n < $prev) {
        echo "------------\n";
    }
    $prev = $n;

    printf("%2d  %8d\n", $i, $n);
}