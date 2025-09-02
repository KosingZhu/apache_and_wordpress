<?php

/**
 * @package WP Encryption
 *
 * @author     WP Encryption
 * @copyright  Copyright (C) 2019-2024, WP Encryption
 * @license    http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License, version 3
 * @link       https://wpencryption.com
 * @since      Class available since Release 1.1.0
 *
 *
 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with this program.  If not, see <https://www.gnu.org/licenses/>.
 *
 */
/**
 * WPLE_Security Class
 * Handles all the security actions
 * 
 * @since 7.0.0
 */
if ( !class_exists( 'WPLE_Security' ) ) {
    class WPLE_Security {
        private $enabledSettings;

        public function __construct() {
            $this->enabledSettings = ( get_option( 'wple_security_settings' ) ? get_option( 'wple_security_settings' ) : array() );
            add_action( 'init', [$this, 'wple_security_inits'] );
        }

        public function wple_security_inits() {
            if ( in_array( 'hide_wp_version', $this->enabledSettings ) ) {
                $this->wple_remove_wp_versions();
            }
            if ( in_array( 'stop_user_enumeration', $this->enabledSettings ) ) {
                $this->wple_stop_user_enumeration();
            }
            if ( in_array( 'hide_login_error', $this->enabledSettings ) ) {
                add_filter( 'wp_login_errors', [$this, 'wple_hide_login_error'] );
            }
            if ( in_array( 'disable_pingback', $this->enabledSettings ) ) {
                add_filter( 'xmlrpc_methods', array($this, 'wple_disable_pingback_methods') );
                add_filter( 'wp_headers', array($this, 'wple_disable_pingback_header') );
            }
            if ( in_array( 'remove_feeds', $this->enabledSettings ) ) {
                $this->wple_remove_feeds();
            }
        }

        /**
         * Stop user enumeration   
         */
        public function wple_stop_user_enumeration() {
            if ( !is_admin() && isset( $_SERVER['REQUEST_URI'] ) ) {
                if ( preg_match( '/(wp-comments-post)/', sanitize_text_field( $_SERVER['REQUEST_URI'] ) ) === 0 && !empty( $_REQUEST['author'] ) ) {
                    wp_die( esc_html__( 'Author info access is forbidden', 'wp-letsencrypt-ssl' ), 403 );
                }
            }
            add_filter(
                'oembed_response_data',
                array($this, 'wple_oembed_user_enumeration'),
                10,
                1
            );
            add_filter(
                'rest_request_before_callbacks',
                array($this, 'wple_rest_user_enumeration'),
                10,
                1
            );
        }

        public function wple_oembed_user_enumeration( $response ) {
            unset($response['author_name']);
            unset($response['author_url']);
            return $response;
        }

        public function wple_rest_user_enumeration( $response ) {
            $rest_route = ( !empty( $_GET['rest_route'] ) ? sanitize_text_field( $_GET['rest_route'] ) : (( empty( $_SERVER['REQUEST_URI'] ) ? '' : (string) parse_url( urldecode( sanitize_text_field( $_SERVER['REQUEST_URI'] ) ), PHP_URL_PATH ) )) );
            $rest_route = trim( $rest_route, '/' );
            if ( '' != $rest_route && !current_user_can( 'edit_others_posts' ) ) {
                if ( preg_match( '/wp\\/v2\\/users$/i', $rest_route ) ) {
                    $error = new WP_Error('wple_users_list_forbidden', 'Access to users list is forbidden');
                    $response = rest_ensure_response( $error );
                } elseif ( preg_match( '/wp\\/v2\\/users\\/+(\\d+)$/i', $rest_route, $matches ) ) {
                    $id = ( empty( $matches ) ? 0 : (int) $matches[1] );
                    if ( get_current_user_id() !== $id ) {
                        $error = new WP_Error('wple_user_details_forbidden', 'Access to user details is forbidden', array(
                            'status' => 403,
                        ));
                        $response = rest_ensure_response( $error );
                    }
                }
            }
            return $response;
        }

        /**
         * Remove WP version info
         */
        public function wple_remove_wp_versions() {
            add_filter( 'the_generator', array($this, 'wple_remove_wp_meta') );
            add_filter( 'style_loader_src', array($this, 'wple_replace_wpver_with_hash') );
            add_filter( 'script_loader_src', array($this, 'wple_replace_wpver_with_hash') );
        }

        public function wple_remove_wp_meta() {
            return '';
        }

        public function wple_replace_wpver_with_hash( $src ) {
            global $wp_version;
            static $wp_hash = null;
            if ( empty( $src ) ) {
                return '';
            }
            if ( stripos( $src, 'ver=' . $wp_version ) !== false ) {
                if ( !$wp_hash ) {
                    $wp_hash = wp_hash( $wp_version );
                }
                $src = add_query_arg( 'ver', $wp_hash, $src );
            }
            return $src;
        }

        /**
         * Disallow File Edit
         * 
         * @param boolean $disallow
         */
        public function wple_disallow_file_edit( $disallow = 'true' ) {
            $disallow = sanitize_text_field( $disallow );
            $conf = ABSPATH . "wp-config.php";
            if ( is_writable( $conf ) ) {
                $config = file_get_contents( ABSPATH . "wp-config.php" );
                if ( FALSE == strpos( $config, 'DISALLOW_FILE_EDIT' ) ) {
                    $newconfig = preg_replace( "/^([\r\n\t ]*)(\\<\\?)(php)?/i", "<?php " . "\n" . "define('DISALLOW_FILE_EDIT', {$disallow});" . "\n", $config );
                } else {
                    //already defined
                    $newconfig = preg_replace( "/define\\(['\"]DISALLOW_FILE_EDIT.*\\)/i", "define('DISALLOW_FILE_EDIT', {$disallow})", $config );
                }
                file_put_contents( ABSPATH . "wp-config.php", $newconfig );
            }
        }

        /**
         * Hide login error feedback
         */
        public function wple_hide_login_error( $errors ) {
            $arr = ['invalid_username', 'incorrect_password'];
            if ( is_wp_error( $errors ) && in_array( $errors->get_error_code(), $arr ) ) {
                $errors = new WP_Error('invalid', sprintf( __( '%sError:%s Incorrect login credentials', 'wp-letsencrypt-ssl' ), '<strong>', '</strong>' ));
            }
            return $errors;
        }

        /**
         * Control anyone can register option
         * @param bool $enable
         */
        public function wple_anyone_can_register( $enable = true ) {
            update_option( 'users_can_register', $enable );
        }

        /**
         * Disable XMLRPC Pingbacks
         */
        public function wple_disable_pingback_methods( $methods ) {
            unset($methods['pingback.ping']);
            unset($methods['pingback.extensions.getPingbacks']);
            return $methods;
        }

        public function wple_disable_pingback_header( $headers ) {
            unset($headers['X-Pingback']);
            return $headers;
        }

        /**
         * Remove RSS & Atom feeds
         */
        public function wple_remove_feeds() {
            remove_action( 'wp_head', 'feed_links_extra', 3 );
            remove_action( 'wp_head', 'feed_links', 2 );
            add_action( 'do_feed', array($this, 'wp_redirect_home'), 1 );
            add_action( 'do_feed_rdf', array($this, 'wp_redirect_home'), 1 );
            add_action( 'do_feed_rss', array($this, 'wp_redirect_home'), 1 );
            add_action( 'do_feed_rss2', array($this, 'wp_redirect_home'), 1 );
            add_action( 'do_feed_rss2_comments', array($this, 'wp_redirect_home'), 1 );
            add_action( 'do_feed_atom', array($this, 'wp_redirect_home'), 1 );
            add_action( 'do_feed_atom_comments', array($this, 'wp_redirect_home'), 1 );
        }

        public function wp_redirect_home() {
            wp_redirect( home_url() );
        }

        /**
         * Deny php execution in uploads folder
         */
        public function wple_deny_php_in_uploads( $enable = true ) {
            $uploads_htaccess = ABSPATH . 'wp-content/uploads/.htaccess';
            if ( $enable ) {
                $rules = "#BEGIN WP_ENCRYPTION_SECURITY" . "\n" . "<Files *.php>" . "\n" . "deny from all" . "\n" . "</Files>" . "\n" . "# END WP_ENCRYPTION_SECURITY" . "\n";
                $backup = '';
                if ( file_exists( $uploads_htaccess ) ) {
                    $backup = file_get_contents( $uploads_htaccess );
                }
                if ( stripos( $backup, 'WP_ENCRYPTION_SECURITY' ) === FALSE ) {
                    //dont repeat
                    file_put_contents( $uploads_htaccess, $rules . $backup );
                }
            } else {
                //remove the rules
                if ( file_exists( $uploads_htaccess ) ) {
                    $htaccess = file_get_contents( $uploads_htaccess );
                    $group = "/#\\s?BEGIN\\s?WP_ENCRYPTION_SECURITY.*?#\\s?END\\s?WP_ENCRYPTION_SECURITY/s";
                    if ( preg_match( $group, $htaccess ) ) {
                        $modhtaccess = preg_replace( $group, "", $htaccess );
                        file_put_contents( $uploads_htaccess, $modhtaccess );
                    }
                }
            }
        }

        public function wple_disable_directory_listing( $enable = true ) {
            if ( !is_writable( ABSPATH . '.htaccess' ) ) {
                echo 0;
                //alert Could not update setting! Please try again.
                exit;
            }
            if ( $enable ) {
                //add request
                if ( is_writable( ABSPATH . '.htaccess' ) ) {
                    WPLE_Trait::wple_remove_directory_listing();
                    $getrules = WPLE_Trait::compose_directory_listing_rules();
                    // $wpruleset = "# BEGIN WordPress";
                    // if (strpos($htaccess, $wpruleset) !== false) {
                    //   $newhtaccess = str_replace($wpruleset, $getrules . $wpruleset, $htaccess);
                    // } else {
                    //   $newhtaccess = $htaccess . $getrules;
                    // }
                    insert_with_markers( ABSPATH . '.htaccess', 'WP_Encryption_Disable_Directory_Listing', $getrules );
                }
            } else {
                //remove request
                WPLE_Trait::wple_remove_directory_listing();
            }
        }

        /**
         * security score section render
         * 
         * @since 7.8.0
         * @return html
         */
        public static function wple_security_score() {
            $scorecard = array(
                'https_enforced'           => 20,
                'critical_issues'          => 10,
                'disable_register'         => 10,
                'disable_directory'        => 10,
                'latest_vulnerability'     => 20,
                'daily_vulnerability_scan' => 10,
                'daily_malware_scan'       => 20,
            );
            $scoredefinitions = array(
                'https_enforced'           => 'Valid SSL certificate installed and HTTPS enforced',
                'critical_issues'          => 'Make sure no critical issues exists in <a href="' . admin_url( '/site-health.php' ) . '">site health</a>',
                'disable_register'         => 'Disable "anyone can register"',
                'disable_directory'        => 'Disable directory listing',
                'latest_vulnerability'     => 'Latest vulnerability scan was performed within last 7 days',
                'daily_vulnerability_scan' => 'Enable daily vulnerability scanning (<a href="https://wpencryption.com/?utm_source=wordpress&utm_medium=security&utm_campaign=wpencryption#pricing">Premium</a>)',
                'daily_malware_scan'       => 'Enable daily malware scanning (<a href="https://wpencryption.com/?utm_source=wordpress&utm_medium=security&utm_campaign=wpencryption#pricing">Premium</a>)',
            );
            $score = 0;
            $featurelist = '<ul>';
            $error_count = 0;
            foreach ( $scoredefinitions as $key => $desc ) {
                $isenabled = false;
                $security_opts = ( get_option( 'wple_security_settings' ) ?: array() );
                if ( $key == 'https_enforced' ) {
                    if ( WPLE_Security::wple_feature_check( 'valid_ssl' ) && WPLE_Security::wple_feature_check( 'ssl_redirect' ) ) {
                        $isenabled = true;
                    }
                } else {
                    if ( $key == 'disable_register' ) {
                        if ( !get_option( 'users_can_register' ) ) {
                            $isenabled = true;
                        }
                    } else {
                        if ( $key == 'critical_issues' ) {
                            $site_health = get_transient( 'health-check-site-status-result' );
                            if ( $site_health !== false ) {
                                $issues = json_decode( $site_health, true );
                                $critical_count = ( isset( $issues['critical'] ) ? $issues['critical'] : 0 );
                                if ( $critical_count == 0 ) {
                                    $isenabled = true;
                                }
                            } else {
                                $isenabled = true;
                            }
                        } else {
                            if ( $key == 'disable_directory' ) {
                                if ( in_array( 'disable_directory_listing', $security_opts ) ) {
                                    $isenabled = true;
                                }
                            } else {
                                if ( $key == 'latest_vulnerability' ) {
                                    if ( $lastscan = get_option( 'wple_vulnerability_lastscan' ) ) {
                                        $sevenDaysFromScan = $lastscan + 7 * 24 * 60 * 60;
                                        if ( time() < $sevenDaysFromScan ) {
                                            //last scan was within last 7 days
                                            $isenabled = true;
                                        }
                                    }
                                } else {
                                    if ( $key == 'daily_vulnerability_scan' || $key == 'daily_malware_scan' ) {
                                    }
                                }
                            }
                        }
                    }
                }
                $sayyesno = '<span class="wple-no">no</span>';
                if ( $isenabled ) {
                    $sayyesno = '<span class="wple-yes">Yes</span>';
                    $score += (int) $scorecard[$key];
                } else {
                    $error_count++;
                }
                $featurelist .= '<li class="' . esc_attr( $key ) . '">' . $sayyesno . WPLE_Trait::wple_kses( $desc, 'a' ) . (( $key == 'tls_version' ? '<span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="TLS version should be 1.2 or above. Contact your hosting support to update TLS version or our Annual PRO plan can offer TLS1.2 protocol."></span>' : (( $key == 'security_headers' ? '<span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="X-XSS and X-Content-Type-Options header"></span>' : '' )) )) . '</li>';
            }
            ///update_option("wple_ssl_errors", $error_count);
            $featurelist .= '</ul>';
            $scorecolor = ( $score >= 30 && $score <= 70 ? 'e2d754' : (( $score > 70 ? '67d467' : 'ff5252' )) );
            $output = '<div class="wple-ssl-score">
            <h2 style="color:#444">Security Score</h2>';
            $output .= '<div class="wple-score">' . (int) $score . '</div>
            <div class="wple-scorebar"><span data-width="' . (int) $score . '" style="width:' . (int) $score . '%;background:#' . esc_attr( $scorecolor ) . '"></span></div>';
            if ( $score == 70 ) {
                $output .= '<h3 class="score-prom" style="margin-bottom:30px">You still have major task pending!</h3>';
            }
            $output .= $featurelist;
            ///$output .= WPLE_Trait::wple_other_plugins(true);
            $output .= '</div>';
            return $output;
        }

        public static function wple_feature_check( $key ) {
            switch ( $key ) {
                case 'valid_ssl':
                    $rootdomain = WPLE_Trait::get_root_domain( false );
                    $client = WPLE_Trait::wple_verify_ssl( $rootdomain );
                    if ( $client || is_ssl() ) {
                        update_option( 'wple_ssl_valid', true );
                        return 1;
                    }
                    update_option( 'wple_ssl_valid', false );
                    break;
                case 'ssl_redirect':
                    $rootdomain = WPLE_Trait::get_root_domain( false );
                    $gethead = wp_remote_head( 'http://' . $rootdomain, array(
                        'sslverify'   => false,
                        'redirection' => 0,
                        'timeout'     => 10,
                    ) );
                    if ( is_wp_error( $gethead ) ) {
                        return 0;
                    }
                    $privatearray = $gethead['headers']->getAll();
                    if ( isset( $privatearray['location'] ) && untrailingslashit( $privatearray['location'] ) == 'https://' . $rootdomain ) {
                        return 1;
                    }
                    $opts = get_option( 'wple_opts' );
                    if ( FALSE !== $opts && isset( $opts['force_ssl'] ) && $opts['force_ssl'] >= 1 ) {
                        return 1;
                    }
                    break;
                case 'httponly_cookies':
                    if ( get_option( 'wple_' . $key ) ) {
                        return 1;
                    }
                    $arr = session_get_cookie_params();
                    if ( $arr['httponly'] ) {
                        return 2;
                    }
                    break;
                case 'mixed_content_fixer':
                case 'hsts':
                case 'ssl_monitoring':
                    if ( get_option( 'wple_' . $key ) ) {
                        return 1;
                    }
                    break;
                case 'security_headers':
                    if ( get_option( 'wple_xxss' ) && get_option( 'wple_xcontenttype' ) ) {
                        return 1;
                    }
                    break;
                case 'advanced_security':
                    break;
                case 'tls_version':
                    $tls = '1.2';
                    if ( function_exists( 'curl_init' ) ) {
                        $ch = curl_init( 'https://www.howsmyssl.com/a/check' );
                        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
                        curl_setopt( $ch, CURLOPT_TIMEOUT, 5 );
                        $json = curl_exec( $ch );
                        curl_close( $ch );
                        $json = json_decode( $json );
                        if ( !empty( $json->tls_version ) ) {
                            $tls = str_replace( "TLS ", "", $json->tls_version );
                        }
                    }
                    if ( version_compare( $tls, '1.2', '>=' ) ) {
                        return 1;
                    }
                    break;
                case 'ssl_auto_renew':
                    break;
                case 'improve_security':
                    break;
            }
            return 0;
        }

    }

}