<?php
/*
Plugin Name: Burn One Time PayPal Donation
Description: A simple plugin to add a one-time PayPal donation button.
Version: 1.0
Author: Janlord Luga
Author URI: https://janlordluga.com/
*/

// Register settings
function burn_paypal_donation_register_settings() {
    register_setting('burn_paypal_donation_settings_group', 'burn_paypal_email');
    register_setting('burn_paypal_donation_settings_group', 'burn_min_donation_amount');
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
                    <td><input type="text" name="burn_min_donation_amount" value="<?php echo esc_attr(get_option('burn_min_donation_amount')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Currency Code</th>
                    <td><input type="text" name="burn_currency_code" value="<?php echo esc_attr(get_option('burn_currency_code')); ?>" /></td>
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
    $min_donation_amount = get_option('burn_min_donation_amount', '1.00');

    if (!$business_email) {
        return '<p>Please configure the PayPal donation settings.</p>';
    }

    $html = '<form action="' . esc_url($paypal_url) . '" method="post" target="_top" onsubmit="return validateDonationAmount();">
        <input type="hidden" name="cmd" value="_donations">
        <input type="hidden" name="business" value="' . esc_attr($business_email) . '">
        <input type="hidden" name="currency_code" value="' . esc_attr($currency_code) . '">
        <label for="donation_amount">Donation Amount (Minimum ' . esc_attr($currency_code) . ' ' . esc_attr($min_donation_amount) . '): </label>
        <input type="number" id="donation_amount" name="amount" min="' . esc_attr($min_donation_amount) . '" step="0.01" required>
        <input type="hidden" name="button_subtype" value="services">
        <input type="hidden" name="no_note" value="0">
        <input type="hidden" name="cn" value="Add special instructions to the seller">
        <input type="hidden" name="no_shipping" value="2">
        <input type="hidden" name="rm" value="1">
        <input type="hidden" name="return" value="' . esc_url(home_url('/thank-you')) . '">
        <input type="hidden" name="cancel_return" value="' . esc_url(home_url('/donation-cancelled')) . '">
        <input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHosted">
        <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
        <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
    </form>
    <script>
        function validateDonationAmount() {
            var amount = document.getElementById("donation_amount").value;
            var minAmount = ' . esc_js($min_donation_amount) . ';
            if (parseFloat(amount) < minAmount) {
                alert("The donation amount must be at least " + minAmount + " " + "' . esc_js($currency_code) . '");
                return false;
            }
            return true;
        }
    </script>';

    return $html;
}
add_shortcode('burn_paypal_donation', 'burn_paypal_donation_button');
