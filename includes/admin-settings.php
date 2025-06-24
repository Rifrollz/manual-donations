<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Add the admin menu page
add_action('admin_menu', 'mdonation_add_admin_menu');
function mdonation_add_admin_menu() {
    add_menu_page(
        'Manual Donations Settings',
        'Manual Donations',
        'manage_options',
        'manual-donations',
        'mdonation_settings_page_html',
        'dashicons-money-alt',
        30
    );
}

// Register settings, sections, and fields
add_action('admin_init', 'mdonation_settings_init');
function mdonation_settings_init() {
    // Register a setting group
    register_setting('mdonation_settings', 'mdonation_options');

    // Add settings section for Mobile Money
    add_settings_section(
        'mdonation_section_mobile_money',
        'Mobile Money Details',
        null,
        'manual-donations'
    );

    add_settings_field('md_mtn', 'MTN Number', 'mdonation_textfield_render', 'manual-donations', 'mdonation_section_mobile_money', ['name' => 'md_mtn', 'placeholder' => 'e.g., 0770 XXX XXX']);
    add_settings_field('md_airtel', 'Airtel Number', 'mdonation_textfield_render', 'manual-donations', 'mdonation_section_mobile_money', ['name' => 'md_airtel', 'placeholder' => 'e.g., 0750 XXX XXX']);
    add_settings_field('md_recipient', 'Recipient Name', 'mdonation_textfield_render', 'manual-donations', 'mdonation_section_mobile_money', ['name' => 'md_recipient']);

    // Add settings section for Bank Transfer
    add_settings_section(
        'mdonation_section_bank',
        'Bank Transfer Details',
        null,
        'manual-donations'
    );

    add_settings_field('md_bank_name', 'Bank Name', 'mdonation_textfield_render', 'manual-donations', 'mdonation_section_bank', ['name' => 'md_bank_name']);
    add_settings_field('md_account_name', 'Account Name', 'mdonation_textfield_render', 'manual-donations', 'mdonation_section_bank', ['name' => 'md_account_name']);
    add_settings_field('md_account_number', 'Account Number', 'mdonation_textfield_render', 'manual-donations', 'mdonation_section_bank', ['name' => 'md_account_number']);
    add_settings_field('md_swift_code', 'SWIFT Code', 'mdonation_textfield_render', 'manual-donations', 'mdonation_section_bank', ['name' => 'md_swift_code']);

    // Add settings section for additional information
    add_settings_section(
        'mdonation_section_additional_info',
        'Additional Information',
        null,
        'manual-donations'
    );

    add_settings_field('md_additional_info', 'Additional Info', 'mdonation_textarea_render', 'manual-donations', 'mdonation_section_additional_info', ['name' => 'md_additional_info', 'rows' => 5, 'placeholder' => 'Enter any additional information or instructions here.']);
}

// Render functions for the fields
function mdonation_textfield_render($args) {
    $options = get_option('mdonation_options');
    $name = esc_attr($args['name']);
    $value = isset($options[$name]) ? esc_attr($options[$name]) : '';
    $placeholder = isset($args['placeholder']) ? esc_attr($args['placeholder']) : '';
    echo "<input type='text' name='mdonation_options[{$name}]' value='{$value}' class='regular-text' placeholder='{$placeholder}'>";
}

function mdonation_textarea_render($args) {
    $options = get_option('mdonation_options');
    $name = esc_attr($args['name']);
    $value = isset($options[$name]) ? esc_textarea($options[$name]) : '';
    $rows = isset($args['rows']) ? esc_attr($args['rows']) : '5';
    $placeholder = isset($args['placeholder']) ? esc_attr($args['placeholder']) : '';
    echo "<textarea name='mdonation_options[{$name}]' rows='{$rows}' class='large-text' placeholder='{$placeholder}'>{$value}</textarea>";
}


// HTML for the settings page
function mdonation_settings_page_html() {
    if (!current_user_can('manage_options')) {
        return;
    }
?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields('mdonation_settings');
            do_settings_sections('manual-donations');
            submit_button('Save Settings');
            ?>
        </form>
    </div>
<?php
} 