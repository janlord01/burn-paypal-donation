# Burn One Time PayPal Donation

A simple WordPress plugin to add a one-time PayPal donation button with a minimum donation amount and customizable settings.

## Description

This plugin allows you to easily add a one-time PayPal donation button to your WordPress site. You can set a minimum donation amount and allow donors to enter a custom amount above that minimum. The plugin includes an admin settings page where you can configure the PayPal email, minimum donation amount, and currency code.

### New Features in v1.1.0

- **Automatic Page Creation**: Upon plugin activation, the plugin automatically creates a "Thank You" page (`/thank-you`) and a "Donation Cancelled" page (`/donation-cancelled`) with default content.
- **Automatic Page Deletion**: Upon plugin deactivation, these pages are automatically removed from the site, ensuring a clean removal of all plugin-related data.
- **Improved Shortcode Logic**: The donation button will now work even if the pages are dynamically created.


## Installation

1. Download the plugin and unzip it.
2. Upload the `burn-one-time-paypal-donation` directory to the `/wp-content/plugins/` directory.
3. Activate the plugin through the 'Plugins' menu in WordPress.
4. Go to "Settings" > "PayPal Donation" to configure the plugin settings.

## Usage

1. Create or edit a page or post where you want to display the donation button.
2. Add the shortcode `[burn_paypal_donation]` to the content area.
3. Publish or update the page/post.

## Configuration

### Admin Settings

Navigate to "Settings" > "PayPal Donation" to configure the following settings:

- **PayPal Email**: Enter your PayPal email address where donations will be sent.
- **Minimum Donation Amount**: Set the minimum amount for donations.
- **Currency Code**: Set the currency code for donations (e.g., USD, EUR).

### Shortcode

Use the following shortcode to display the PayPal donation button on your site:

```text
[burn_paypal_donation]
```

## Development
### Plugin Structure
```text
burn-one-time-paypal-donation/
├── css
    ├── style.css
├── images
    ├── card.png
├── burn-one-time-paypal-donation.php
└── README.md
```

### burn-one-time-paypal-donation.php

This file contains the main code for the plugin, including the settings page and the shortcode functionality.

## Release Notes

### v1.1.0 (Current Release)

- Added automatic creation of /thank-you and /donation-cancelled pages upon activation.
- Added automatic deletion of these pages upon deactivation.
- Improved shortcode validation and page redirection for successful or cancelled donations.

### v1.0 (Initial Release)

- Added basic functionality for a one-time PayPal donation button.
- Admin settings to configure PayPal email, minimum donation amount, and currency code.
- Shortcode [burn_paypal_donation] to display the PayPal donation button.

## Author

## Janlord Luga
- [Website](https://janlordluga.com/)

## License

This plugin is licensed under the MIT License.


