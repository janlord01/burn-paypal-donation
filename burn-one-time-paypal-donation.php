<?php
/*
Plugin Name: Burn One Time PayPal Donation
Description: A simple plugin to add a one-time PayPal donation button.
Version: 1.0
Author: Janlord Luga
Author URI: https://janlordluga.com/
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Register settings
function burn_paypal_donation_register_settings() {
    register_setting('burn_paypal_donation_settings_group', 'burn_paypal_email');
    register_setting('burn_paypal_donation_settings_group', 'burn_min_donation_amount', 'absint');
    register_setting('burn_paypal_donation_settings_group', 'burn_currency_code');
}
add_action('admin_init', 'burn_paypal_donation_register_settings');

// Add settings page
function burn_paypal_donation_settings_page() {
    add_options_page('Burn PayPal Donation Settings', 'PayPal Donation', 'manage_options', 'burn-paypal-donation', 'burn_paypal_donation_settings_page_html');
}
add_action('admin_menu', 'burn_paypal_donation_settings_page');

// Settings page HTML
function burn_paypal_donation_settings_page_html() {
    ?>
    <div class="wrap">
        <h1>Burn PayPal Donation Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('burn_paypal_donation_settings_group'); ?>
            <?php do_settings_sections('burn_paypal_donation_settings_group'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">PayPal Email</th>
                    <td><input type="email" name="burn_paypal_email" value="<?php echo esc_attr(get_option('burn_paypal_email')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Minimum Donation Amount</th>
                    <td><input type="number" name="burn_min_donation_amount" value="<?php echo esc_attr(get_option('burn_min_donation_amount', '1')); ?>" min="1" step="1" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Currency Code</th>
                    <td><input type="text" name="burn_currency_code" value="<?php echo esc_attr(get_option('burn_currency_code', 'USD')); ?>" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Add shortcode
function burn_paypal_donation_button() {
    $paypal_url = "https://www.paypal.com/cgi-bin/webscr";
    $business_email = get_option('burn_paypal_email');
    $currency_code = get_option('burn_currency_code', 'USD');
    $min_donation_amount = get_option('burn_min_donation_amount', '1');

    if (!$business_email) {
        return '<p>Please configure the PayPal donation settings.</p>';
    }

    $html = '<div class="paypal-donation-form">
        <form action="' . esc_url($paypal_url) . '" method="post" target="_top" onsubmit="return validateDonationAmount();">
            <input type="hidden" name="cmd" value="_donations">
            <input type="hidden" name="business" value="' . esc_attr($business_email) . '">
            <input type="hidden" name="currency_code" value="' . esc_attr($currency_code) . '">
            <label for="donation_amount">Enter Your Donation Amount:</label><br>
            <div class="donation-amount-input">
                <span class="currency-symbol">' . esc_html($currency_code) . '</span>
                <input type="number" id="donation_amount" name="amount" min="' . esc_attr($min_donation_amount) . '" step="0.01" required>
            </div>
            <input type="hidden" name="button_subtype" value="services">
            <input type="hidden" name="no_note" value="0">
            <input type="hidden" name="cn" value="Add special instructions to the seller">
            <input type="hidden" name="no_shipping" value="2">
            <input type="hidden" name="rm" value="1">
            <input type="hidden" name="return" value="' . esc_url(home_url('/thank-you')) . '">
            <input type="hidden" name="cancel_return" value="' . esc_url(home_url('/donation-cancelled')) . '">
            <input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHosted">
            <button type="submit" name="submit" class="paypal-donation-button">Donate via PayPal</button>
            <div class="card-icons">
                <img src="' . plugin_dir_url(__FILE__) . 'images/card.png" alt="card">
            </div>
        </form>
    </div>
    <script>
        function validateDonationAmount() {
            var amount = parseFloat(document.getElementById("donation_amount").value);
            var minAmount = ' . esc_js($min_donation_amount) . ';
            if (isNaN(amount) || amount < minAmount) {
                alert("Please enter a donation amount of at least ' . esc_js($currency_code) . ' " + minAmount);
                return false;
            }
            return true;
        }
    </script>';

    return $html;
}
add_shortcode('burn_paypal_donation', 'burn_paypal_donation_button');

// Enqueue CSS
function burn_paypal_donation_enqueue_styles() {
    wp_enqueue_style('burn-paypal-donation-style', plugin_dir_url(__FILE__) . 'css/style.css');
}
add_action('wp_enqueue_scripts', 'burn_paypal_donation_enqueue_styles');
