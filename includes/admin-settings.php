<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Add the admin menu page
add_action('admin_menu', 'mdonation_settings_menu');
function mdonation_settings_menu() {
    add_options_page(
        'Manual Donation Settings',
        'Manual Donations',
        'manage_options',
        'manual-donations',
        'mdonation_settings_page'
    );
}

// Register settings, sections, and fields
add_action('admin_init', 'mdonation_settings_init');
function mdonation_settings_init() {
    register_setting('mdonation_settings_group', 'mdonation_options');

    add_settings_section(
        'mdonation_settings_section',
        'Donation Information',
        null,
        'manual-donations'
    );

    $fields = [
        'md_mtn' => 'MTN Number',
        'md_airtel' => 'Airtel Number',
        'md_recipient' => 'Recipient Name',
        'md_bank_name' => 'Bank Name',
        'md_account_name' => 'Account Name',
        'md_account_number' => 'Account Number',
        'md_swift_code' => 'SWIFT Code',
        'md_additional_info' => 'Additional Info (HTML allowed)'
    ];

    foreach ($fields as $id => $label) {
        add_settings_field(
            $id,
            $label,
            function() use ($id) {
                $options = get_option('mdonation_options');
                if ($id === 'md_additional_info') {
                    $value = isset($options[$id]) ? esc_textarea($options[$id]) : '';
                    echo "<textarea name='mdonation_options[{$id}]' rows='4' class='large-text'>{$value}</textarea>";
                } else {
                    $value = isset($options[$id]) ? esc_attr($options[$id]) : '';
                    echo "<input type='text' name='mdonation_options[{$id}]' value='{$value}' class='regular-text' />";
                }
            },
            'manual-donations',
            'mdonation_settings_section'
        );
    }
}

// HTML for the settings page
function mdonation_settings_page() {
    if (!current_user_can('manage_options')) {
        return;
    }
?>
    <div class="wrap">
        <h1>Manual Donation Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('mdonation_settings_group');
            do_settings_sections('manual-donations');
            submit_button();
            ?>
        </form>
    </div>
<?php
} 