<?php
/**
 * SubscriberConfirmationEmail class file.
 *
 * @package Notifima
 */

namespace Notifima\Emails;

defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

if ( ! class_exists( 'SubscriberConfirmationEmail' ) ) :

    /**
     * Email for Notifima
     *
     * An confirmation email will be sent to the customer when they subscribe product.
     *
     * @version     3.0.0
     * @author      MultiVendorX
     * @extends     \WC_Email
     */
    class SubscriberConfirmationEmail extends \WC_Email {

        /**
         * The product associated with the subscription.
         *
         * @var WC_Product|int|null
         */
        public $product;

        /**
         * The email recipient. Can be overridden manually.
         *
         * @var string
         */
        public $recipient = '';

        /**
         * Constructor
         *
         * @access public
         * @return void
         */
        public function __construct() {
            $this->id             = 'notifima_subscriber_confirmation';
            $this->title          = __( 'Confirm subscriber', 'notifima' );
            $this->description    = __( 'Confirm customer when they subscribe a product', 'notifima' );
            $this->template_html  = 'emails/html/SubscriberConfirmationEmail.php';
            $this->template_plain = 'emails/plain/SubscriberConfirmationEmail.php';
            $this->template_base  = Notifima()->plugin_path . 'templates/';

            // Call parent constuctor.
            parent::__construct();
        }

        /**
         * Trigger function.
         *
         * @param string     $recipient      The recipient's email address.
         * @param WC_Product $product        The WooCommerce product object.
         * @return void
         */
        public function trigger( $recipient, $product ) {

            $this->recipient = $recipient;
            $this->product   = $product;

            if ( ! $this->is_enabled() || ! $this->get_recipient() ) {
                return;
            }

            $this->send( $this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments() );
        }

        /**
         * Get email subject.
         *
         * @since  1.4.7
         * @return string
         */
        public function get_default_subject() {
            return apply_filters( 'notifima_customer_subscription_email_subject', __( 'You have subscribed to a product on {site_title} ', 'notifima' ), $this->object );
        }

        /**
         * Get email heading.
         *
         * @since  1.4.7
         * @return string
         */
        public function get_default_heading() {
            return apply_filters( 'notifima_customer_subscription_email_heading', __( 'Welcome to {site_title} ', 'notifima' ), $this->object );
        }

        /**
         * Get content html function.
         *
         * @access public
         * @return string
         */
        public function get_content_html() {
            ob_start();
            Notifima()->util->get_template(
                $this->template_html,
                array(
					'email_heading'  => $this->get_heading(),
					'product'        => $this->product,
					'customer_email' => $this->recipient,
					'sent_to_admin'  => false,
					'plain_text'     => false,
					'email'          => $this,
				)
            );

            return ob_get_clean();
        }

        /**
         * Get content plain function.
         *
         * @access public
         * @return string
         */
        public function get_content_plain() {
            ob_start();
            Notifima()->util->get_template(
                $this->template_plain,
                array(
					'email_heading'  => $this->get_heading(),
					'product'        => $this->product,
					'customer_email' => $this->recipient,
					'sent_to_admin'  => false,
					'plain_text'     => false,
					'email'          => $this,
				)
            );

            return ob_get_clean();
        }
    }
endif;
