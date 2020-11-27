<?php
/**
 * PHP auto indexer: the tool against directory traversal security vulnerability.
 *
 * @author    Maksim T. <zapalm@yandex.com>
 * @copyright 2019 Maksim T.
 * @license   https://opensource.org/licenses/MIT MIT
 * @link      https://github.com/zapalm/auto-indexer GitHub
 * @link      https://prestashop.modulez.ru/en/tools-scripts/78-tool-against-directory-traversal-security-vulnerability.html Homepage
 */

use zapalm\AutoIndexer;

require __DIR__ . DIRECTORY_SEPARATOR . 'AutoIndexer.php';

if ('cli' !== php_sapi_name()) {
    exit(1);
}

if ($argc >= 3) {
    array_shift($argv);
    $command = trim(array_shift($argv));
    if ('--add' === $command) {
        $autoIndexer = new AutoIndexer(array_shift($argv), array_shift($argv));
        $autoIndexer->addIndex();
        exit(0);
    } elseif ('--remove' === $command) {
        $autoIndexer = new AutoIndexer(array_shift($argv));
        $autoIndexer->removeIndex();
        exit(0);
    }
}

echo 'php index.php (--add or --remove) (The directory path for recursively adding or removing the index.php) [The template path for adding the index.php file]' . PHP_EOL;
exit(1);
