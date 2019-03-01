<?php
/**
 * PHP auto indexer: the tool against directory traversal security vulnerability.
 *
 * @author    Maksim T. <zapalm@yandex.com>
 * @copyright 2019 Maksim T.
 * @license   https://opensource.org/licenses/MIT MIT
 * @link      https://github.com/zapalm/autoIndexer GitHub
 * @link      https://prestashop.modulez.ru/en/tools-scripts/78-tool-against-directory-traversal-security-vulnerability.html Homepage
 */

namespace zapalm;

/**
 * Auto indexer.
 *
 * @version 1.0.0
 *
 * @author Maksim T. <zapalm@yandex.com>
 */
class AutoIndexer
{
    /** @var string The path to the source directory for recursively adding or removing the index.php file. */
    private $directoryPath;

    /** @var string|null The path to the template file (index.php) for adding. */
    private $templatePath;

    /**
     * Constructor.
     *
     * @param string      $directoryPath The path to the source directory for recursively adding or removing the index.php file.
     * @param string|null $templatePath  The path to the template file (index.php) for adding.
     *
     * @throws \LogicException
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function __construct($directoryPath, $templatePath = null)
    {
        $this->directoryPath = realpath($directoryPath);
        if (false === file_exists($this->directoryPath)) {
            throw new \LogicException('The source directory path is not exists: ' . $this->directoryPath);
        }

        if (null !== $templatePath) {
            $this->templatePath = realpath($templatePath);
            if (false === file_exists($this->templatePath)) {
                throw new \LogicException('The template path is not exists: ' . $this->templatePath);
            }
        }
    }

    /**
     * Adds index.php files to the configured path.
     *
     * It's do not replaces the existing index.php files.
     *
     * @see removeIndex()
     *
     * @throws \LogicException
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function addIndex()
    {
        if (null === $this->templatePath) {
            throw new \LogicException('The template path is not configured.');
        }

        $this->addIndexRecursively($this->directoryPath);
    }

    /**
     * Removes index.php files from the configured path.
     *
     * Useful for the cleaning a directory of old index.php files.
     *
     * @param array $skipDirectories Directories to skip.
     *
     * @see addIndex()
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    public function removeIndex(array $skipDirectories = array('vendor'))
    {
        $this->removeIndexRecursively($this->directoryPath, $skipDirectories);
    }

    /**
     * Adds index.php file recursively to a given path.
     *
     * @param string $path Path of the directory for recursively adding the index.php file.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    private function addIndexRecursively($path)
    {
        // Skip special directories such as .git, .idea and so on.
        if (0 === strpos(basename($path), '.')) {
            echo 'Skip: ' . $path . PHP_EOL;

            return;
        }

        $indexFilePath = $path . DIRECTORY_SEPARATOR . 'index.php';
        if (false === file_exists($indexFilePath)) {
            copy($this->templatePath, $path . DIRECTORY_SEPARATOR . 'index.php');
            echo 'Added to: ' . $path . PHP_EOL;
        } else {
            echo 'Exists in: ' . $path . PHP_EOL;
        }

        $directories = glob($path . DIRECTORY_SEPARATOR . '*', GLOB_ONLYDIR);
        if (false === $directories) {
            return;
        }

        foreach ($directories as $directory) {
            $this->addIndexRecursively($directory);
        }
    }

    /**
     * Removes the index.php file recursively from a given path.
     *
     * @param string $path            Path of the directory for recursively removing the index.php file.
     * @param array  $skipDirectories Directories to skip.
     *
     * @author Maksim T. <zapalm@yandex.com>
     */
    private function removeIndexRecursively($path, array $skipDirectories = array()) {
        $fileName = basename($path);

        // Skip special directories such as .git, .idea, vendor and so on.
        if (0 === strpos($fileName, '.') || in_array($fileName, $skipDirectories)) {
            echo 'Skip: ' . $path . PHP_EOL;

            return;
        }

        $indexFilePath = $path . DIRECTORY_SEPARATOR . 'index.php';
        if (file_exists($indexFilePath)) {
            unlink($indexFilePath);
            echo 'Removed from: ' . $path . PHP_EOL;
        }

        $directories = glob($path . DIRECTORY_SEPARATOR . '*', GLOB_ONLYDIR);
        if (false === $directories) {
            return;
        }

        foreach ($directories as $directory) {
            $this->removeIndexRecursively($directory, $skipDirectories);
        }
    }
}
