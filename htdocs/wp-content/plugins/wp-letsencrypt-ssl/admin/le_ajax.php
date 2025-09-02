<?php

use WPLEClient\LEFunctions;

require_once WPLE_DIR . 'classes/le-trait.php';

class WPLE_Ajax
{

    public function __construct()
    {

        add_action('wp_ajax_wple_admin_httpverify', [$this, 'wple_ajx_verify_http']);

        add_action('wp_ajax_wple_admin_dnsverify', [$this, 'wple_ajx_verify_dns']);

        add_action('wp_ajax_wple_validate_ssl', [$this, 'wple_validate_nocp_ssl']);

        add_action('wp_ajax_wple_getcert_for_copy', [$this, 'wple_retrieve_certs_forcopy']);

        add_action('wp_ajax_wple_include_www', [$this, 'wple_include_www_check']);

        add_action('wp_ajax_wple_backup_ignore', [$this, 'wple_ignore_backup_suggest']);

        //since 7.8.0
        add_action('wp_ajax_wple_mscan_ignorefile', [$this, 'wple_malware_ignorefile']);

        add_action('wp_ajax_wple_dismiss_notice', [$this, 'wple_dismiss_notice']);

        //since 7.8.2
        add_action('wp_ajax_wple_wizard_sslscan', [$this, 'wple_wizard_sslscan']);
        add_action('wp_ajax_wple_wizard_enable_https', [$this, 'wple_wizard_enable_https']);
    }

    /**
     * Local check HTTP records via Ajax for subdir sites
     * 
     * @since 4.7.0
     * @return void
     */
    public function wple_ajx_verify_http()
    {

        if (isset($_POST['nc'])) {

            if (!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nc'])), 'verifyhttprecords')) {
                exit('Unauthorized');
            }

            $domain = str_ireplace(array('https://', 'http://'), '', site_url());

            if (stripos($domain, '/') !== false) { //subdir site
                $domain = substr($domain, 0, stripos($domain, '/'));
            }

            $opts = get_option('wple_opts');
            $httpch = $opts['challenge_files'];

            if (empty($httpch)) {
                echo 'empty';
                exit();
            }

            $counter = get_option('wple_failed_verification');
            $curl_exists = function_exists('curl_init');

            if ($curl_exists) {
                foreach ($httpch as $index => $ch) {
                    $chfile = sanitize_file_name($ch['file']);
                    $chval = esc_html($ch['value']);

                    $first_letter = substr($ch['file'], 0, 1);
                    if ($first_letter == '_') {
                        $chfile = '_' . $chfile; //there was underscore at beginning
                    } else if ($first_letter == '-') {
                        $chfile = '-' . $chfile; //there was underscore at beginning
                    }

                    $fpath = trailingslashit(ABSPATH) . '.well-known/acme-challenge/';

                    if (stripos(site_url(), '/', 10) !== false) { //its from sub-dir site            
                        $fpath = trailingslashit(dirname(ABSPATH, 1)) . '.well-known/acme-challenge/';
                    }

                    if ($counter >= 5) {
                        if (!file_exists($fpath)) {
                            mkdir($fpath, 0775, true);
                        }
                        WPLE_Trait::wple_logger(' -> Helping with HTTP challenge file', 'success', 'a');
                        file_put_contents($fpath . $chfile, trim($chval));
                    }

                    $acmefilepath = $fpath . $chfile;
                    if (file_exists($acmefilepath . '.txt')) {
                        unlink($acmefilepath . '.txt');
                        file_put_contents($acmefilepath, trim($chval));
                    }

                    //cleanup htaccess files
                    $ABS = trailingslashit(ABSPATH);
                    if (file_exists($ABS . '.well-known/.htaccess')) unlink($ABS . '.well-known/.htaccess');
                    if (file_exists($ABS . '.well-known/acme-challenge/.htaccess')) unlink($ABS . '.well-known/acme-challenge/.htaccess');

                    $check = LEFunctions::checkHTTPChallenge($domain, $chfile, $chval, false);

                    $chfileexists = file_exists($fpath . $chfile);

                    if (!$check && $chfileexists) {

                        if (!file_exists($fpath)) {
                            mkdir($fpath, 0775, true);
                        }
                        if (!file_exists($fpath . $chfile)) {
                            file_put_contents($fpath . $chfile, trim($chval));
                        }

                        WPLE_Trait::wple_logger('Local acme-challenge file exists - Proceeding to verification', 'success', 'a');

                        //re-check once
                        // $check = LEFunctions::checkHTTPChallenge($domain, $chfile, $chval, false);
                        // if (!$check) {
                        //   echo 'not_possible';
                        //   exit();
                        // }
                        $check = true;
                    }

                    // if ($check === true) {
                    //   //skip
                    // } else if ($check == 200 && $chfileexists) {
                    //   $check = 2;
                    // } else {
                    if (!$check) {

                        if (FALSE === $counter) {
                            $newcount = 1;
                        } else {
                            $newcount = $counter + 1;
                        }
                        update_option('wple_failed_verification', $newcount);

                        update_option('wple_stage', 'failed_httpverification_' . intval($newcount)); //pro

                        WPLE_Trait::wple_logger("HTTP challenge file (" . $domain . "/.well-known/acme-challenge/" . $chfile . ") checked locally - found invalid ($chfileexists)", 'success', 'a', false);
                        WPLE_Trait::wple_send_log_data();

                        echo 'fail';
                        exit();
                    }
                }
            }

            // if ($check == 2) {
            //   WPLE_Trait::wple_logger("Local check - Found challenge file in acme-challenge => proceeding to ACME verification\n", 'success', 'a', false);
            //   delete_option('wple_failed_verification');
            //   echo 1;
            //   exit();
            // }

            if (!$curl_exists) {
                WPLE_Trait::wple_logger("HTTP local verification skipped due to non-availability of CURL\n", 'success', 'a', false);
            }

            WPLE_Trait::wple_logger("Local check - All HTTP challenges verified\n", 'success', 'a', false);

            delete_option('wple_failed_verification');

            echo 1;
            exit();
        }
    }

    /**
     * Local check DNS records via Ajax
     * 
     * @since 4.6.0
     * @return void
     */
    public function wple_ajx_verify_dns()
    {

        if (isset($_POST['nc'])) {
            if (!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nc'])), 'verifydnsrecords')) {
                exit('Unauthorized');
            }
            $toVerify = get_option('wple_opts');

            if (array_key_exists('dns_challenges', $toVerify) && !empty($toVerify['dns_challenges'])) {
                $toVerify = $dnspendings = $toVerify['dns_challenges'];
                //array

                foreach ($toVerify as $index => $item) {
                    $domain_code = explode('||', $item);
                    $acme = '_acme-challenge.' . esc_html($domain_code[0]);
                    $requestURL = 'https://dns.google.com/resolve?name=' . addslashes($acme) . '&type=TXT';
                    $handle = curl_init();
                    curl_setopt($handle, CURLOPT_URL, $requestURL);
                    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($handle, CURLOPT_FOLLOWLOCATION, true);
                    $response = json_decode(trim(curl_exec($handle)));

                    if ($response->Status === 0 && isset($response->Answer)) {

                        //if ($answer->type == 16) {            
                        $found = 'Pending';
                        foreach ($response->Answer as $answer) {
                            $livecode = str_ireplace('"', '', $answer->data);
                            if ($livecode == $domain_code[1]) {
                                unset($dnspendings[$index]);
                                $found = 'OK';
                                continue;
                            }
                        }

                        WPLE_Trait::wple_logger("\n" . esc_html($requestURL . ' should return ' . $domain_code[1] . ' -> ' . $found) . "\n");
                    } else {

                        WPLE_Trait::wple_logger("\n" . esc_html($requestURL . ' should return ' . $domain_code[1] . ' -> No records found yet') . "\n");

                        echo  'fail';
                        exit();
                    }
                }

                if (empty($dnspendings)) {
                    WPLE_Trait::wple_logger("Local check - All DNS challenges verified\n", 'success', 'a', false);

                    echo  1;
                    exit;
                } else {
                    update_option('wple_stage', 'failed_dns_verification');

                    echo  'fail';
                    exit();
                }
            } else if (empty($toVerify['dns_challenges'])) {
                WPLE_Trait::wple_logger("Local check - DNS challenges empty\n", 'success', 'a', false);

                echo  1;
                exit();
            }
        }

        WPLE_Trait::wple_send_log_data();

        echo  'fail';
        exit();
    }

    /**
     * Validate SSL button for non-cpanel
     *
     * @since 5.2.6
     * @return void
     */
    public function wple_validate_nocp_ssl()
    {
        if (!current_user_can('manage_options')) {
            exit('Unauthorized');
        }

        $basedomain = str_ireplace(array('http://', 'https://'), array('', ''), addslashes(site_url()));

        //4.7
        if (false !== stripos($basedomain, '/')) {
            $basedomain = substr($basedomain, 0, stripos($basedomain, '/'));
        }

        $client = WPLE_Trait::wple_verify_ssl($basedomain);

        if ($client || is_ssl()) {
            $reverter = uniqid('wple');

            $savedopts = get_option('wple_opts');
            $savedopts['force_ssl'] = 1;
            $savedopts['revertnonce'] = $reverter;

            ///WPLE_Trait::wple_send_reverter_secret($reverter);

            update_option('wple_opts', $savedopts);
            delete_option('wple_error'); //complete
            update_option('wple_ssl_screen', 'success');

            update_option('siteurl', str_ireplace('http:', 'https:', get_option('siteurl')));
            update_option('home', str_ireplace('http:', 'https:', get_option('home')));
            echo 1;
        } else {
            echo 0;
        }

        exit();
    }


    /**
     * Ajax Get cert contents for copy
     *
     * @since 5.3.16
     * @return void
     */
    public function wple_retrieve_certs_forcopy()
    {

        if (!wp_verify_nonce(sanitize_text_field(wp_unslash($_GET['nc'])), 'copycerts') || !current_user_can('manage_options')) {
            exit('Authorization Failure');
        }

        $ftype = sanitize_text_field($_GET['gettype']);
        $output = '';
        $keypath = WPLE_Trait::wple_cert_directory();

        switch ($ftype) {
            case 'cert':
                if (file_exists($keypath . 'certificate.crt')) $output = file_get_contents($keypath . 'certificate.crt');
                break;
            case 'key':
                $output = WPLE_Trait::wple_get_private_key();
                break;
            case 'cabundle':
                // if (file_exists(ABSPATH . 'keys/cabundle.crt')) {
                $output = file_get_contents($keypath . 'cabundle.crt');
                // } else {
                ///$output = file_get_contents(WPLE_DIR . 'cabundle/ca.crt');
                //}
                break;
        }

        echo esc_html($output);

        exit();
    }

    /**
     * Ajax check if both www & non-www domain accessible
     *
     * @since 5.6.2
     * @return void
     */
    public function wple_include_www_check()
    {

        if (!current_user_can('manage_options') || !wp_verify_nonce(sanitize_text_field(wp_unslash($_GET['nc'])), 'legenerate')) {
            exit('Unauthorized request');
        }

        $maindomain = WPLE_Trait::get_root_domain(false);

        $errcode = 'www';

        if (stripos($maindomain, 'www') === false) {
            $altdomain = 'www.' . $maindomain;
        } else {
            $errcode = 'nonwww';
            $altdomain = str_ireplace('www.', '', $maindomain);
        }

        $altdomaintest = wp_remote_head('http://' . $altdomain, array('sslverify' => false, 'timeout' => 30));

        $rescode = wp_remote_retrieve_response_code($altdomaintest);

        if (!is_wp_error($altdomaintest) || $rescode == 301 || $rescode == 302) {
            echo 1;
            exit();
        }

        echo esc_html($errcode);
        exit();
    }

    public function wple_ignore_backup_suggest()
    {

        if (!current_user_can('manage_options')) {
            exit();
        }

        update_option('wple_backup_suggested', true);
        echo 1;
        exit();
    }

    public function wple_malware_ignorefile()
    {

        if (!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nc'])), 'wplemalwareignore') || !current_user_can('manage_options')) {
            exit('Authorization Failure');
        }

        $ignoreFile = esc_url_raw($_POST['fyle']);
        $ignoreFile = str_ireplace(['http://', 'https://'], '', $ignoreFile);
        $ignoreList = get_option('wple_malware_ignorelist');

        $removeFromList = sanitize_text_field($_POST['remove']);

        if (!$removeFromList) { //add to list
            if (is_array($ignoreList)) {
                if (!in_array($ignoreFile, $ignoreList)) {
                    $ignoreList[] = $ignoreFile;
                }
            } else { //1st item
                $ignoreList[] = $ignoreFile;
            }
        } else { //remove from list
            if (is_array($ignoreList)) {
                // Look for and remove the item
                $index = array_search($ignoreFile, $ignoreList);
                if ($index !== false) {
                    unset($ignoreList[$index]);
                    // Reindex to avoid gaps
                    $ignoreList = array_values($ignoreList);
                }
            } else {
                $ignoreList = array(); // No array exists, start fresh
            }
        }

        echo update_option('wple_malware_ignorelist', $ignoreList);

        exit();
    }

    public function wple_dismiss_notice()
    {

        if (!current_user_can('manage_options')) {
            exit('Authorization Failure');
        }

        $dismissed = get_option('wple_dismissed_notices');

        $dismissed = is_array($dismissed) ? $dismissed : array();

        $to_dimiss = sanitize_text_field($_POST['context']);

        if (array_search($to_dimiss, $dismissed) === false) {
            $dismissed[] = $to_dimiss;
        }

        echo update_option('wple_dismissed_notices', $dismissed);


        exit();
    }

    public function wple_wizard_sslscan()
    {
        if (!current_user_can('manage_options') || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nc'])), 'wple-wizard')) {
            exit('Unauthorized request');
        }

        $newscan = isset($_POST['recheck']) ? false : true;

        $result = WPLE_Trait::wple_ssllabs_scan($newscan, false);

        if (!$newscan) {
            echo json_encode($result);
        } else { //scan started flag
            echo 1;
        }

        exit();
    }
    public function wple_wizard_enable_https()
    {
        if (!current_user_can('manage_options') || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nc'])), 'wple-wizard')) {
            exit('error');
        }

        if (is_writable(ABSPATH . '.htaccess')) {

            $htaccess = file_get_contents(ABSPATH . '.htaccess');

            if (stripos($htaccess, 'WP_Encryption_Force_SSL') === false) {
                $getrules = WPLE_Trait::compose_htaccess_rules();

                $wpruleset = "# BEGIN WordPress";

                if (strpos($htaccess, $wpruleset) !== false) {
                    $newhtaccess = str_replace($wpruleset, $getrules . $wpruleset, $htaccess);
                } else {
                    $newhtaccess = $htaccess . $getrules;
                }

                ///insert_with_markers(ABSPATH . '.htaccess', '', $newhtaccess);
                file_put_contents(ABSPATH . '.htaccess', $newhtaccess);
            }

            echo 'success';
        } else {
            echo 'notwritable';
        }
        exit();
    }
}
