<?php

if (! defined('ABSPATH')) exit; // Exit if accessed directly

class WPLE_Mscan
{
    public function __construct()
    {
        $this->wple_run_mscsan();
    }

    private function wple_run_mscsan()
    {

        global $wp_version;
        $this->wple_check_integrity($wp_version);
    }

    private function wple_check_integrity($version)
    {
        //echo $version;
        $checksumUrl = "https://api.wordpress.org/core/checksums/1.0/?version={$version}";
        $response = file_get_contents($checksumUrl);

        if (!$response) {
            wp_die("Unable to fetch checksums from WordPress API.");
        }

        $checksums = json_decode($response, true);

        if (!isset($checksums['checksums'])) {
            wp_die("Invalid response from WordPress API.");
        }

        $wordpressRoot = ABSPATH;
        $failedFiles = [];
        $coreFiles = array_keys($checksums['checksums'][$version]);

        $ignorePaths = ['themes', 'plugins', '.well-known', '.htaccess', 'wp-config.php'];

        // Check for modified or missing core files
        foreach ($checksums['checksums'][$version] as $file => $expectedHash) {
            // Skip if file path contains any of the ignore paths
            foreach ($ignorePaths as $ignore) {
                if (strpos($file, $ignore) !== false) {
                    continue 2; // Skip to the next $file in outer loop
                }
            }

            $filePath = $wordpressRoot . $file;

            if (!file_exists($filePath)) {
                $failedFiles[] = "<b>Missing File</b>: $file";
                continue;
            }

            $fileHash = md5_file($filePath);
            if ($fileHash !== $expectedHash) {
                $failedFiles[] = "<b>Modified File</b>: $file";
            }
        }

        // Check for unexpected files
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($wordpressRoot));
        foreach ($iterator as $file) {

            $relativePath = str_replace($wordpressRoot, '', $file->getRealPath());

            foreach ($ignorePaths as $ignore) {
                if (stripos($relativePath, $ignore) !== false) {
                    continue 2; // Skip to the next $file in outer loop
                }
            }

            if (!in_array($relativePath, $coreFiles) && $file->isFile()) {
                $failedFiles[] = "<b>Extra File Found</b>: $relativePath";
            }
        }

        // echo '<pre>';
        // print_r($failedFiles);
        // echo '</pre>';
        // exit();

        // Output results
        if (empty($failedFiles)) {
            update_option('wple_mscan_integrity', []);
        } else {
            update_option('wple_mscan_integrity', $failedFiles);
        }
    }
}
