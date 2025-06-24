<?php
/**
 * Plugin Name: Manual Donations form for GCF
 * Description: Adds a manual donation page with offline payment instructions and confirmation form.
 * Version: 1.2
 * Author: Rollins
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

add_shortcode('manual_donation_form', 'mdonation_render_form');

function mdonation_render_form() {
    if (isset($_GET['donation_confirmed']) && $_GET['donation_confirmed'] === '1') {
        ob_start();
?>
        <style>
            .md-container {
                max-width: 700px;
                margin: 40px auto;
                padding: 30px;
                background-color: #ffffff;
                border-radius: 8px;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
            }

            .md-success-message {
                padding: 40px;
                text-align: center;
                background-color: #f0fff4;
                border: 1px solid #27ae60;
                border-radius: 8px;
            }

            .md-success-message h2 {
                color: #27ae60;
                margin-bottom: 15px;
            }
        </style>
        <div class="md-container">
            <div class="md-success-message">
                <h2>Thank You!</h2>
                <p>Your donation confirmation has been received. We will get in touch with you shortly to acknowledge your support.</p>
            </div>
        </div>
<?php
        return ob_get_clean();
    }

    ob_start();
?>
    <style>
        .md-container {
            max-width: 700px;
            margin: 40px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
            line-height: 1.6;
            color: #333;
        }

        .md-container h2,
        .md-container h3 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 20px;
        }

        .md-container h3 {
            text-align: left;
            margin-top: 30px;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 10px;
        }

        .md-container p {
            margin-bottom: 15px;
        }

        .md-container ul {
            list-style: none;
            padding-left: 0;
        }

        .md-container ul li {
            padding: 5px 0;
        }

        .md-container hr {
            border: none;
            border-top: 1px solid #eee;
            margin: 30px 0;
        }

        .md-container .md-form-group {
            margin-bottom: 20px;
        }

        .md-container label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
        }

        .md-container input[type="text"],
        .md-container input[type="email"],
        .md-container input[type="number"],
        .md-container select,
        .md-container textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 16px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .md-container input:focus,
        .md-container select:focus,
        .md-container textarea:focus {
            outline: none;
            border-color: #4a90e2;
            box-shadow: 0 0 0 2px rgba(74, 144, 226, 0.2);
        }

        .md-container .md-submit-btn {
            display: block;
            width: 100%;
            padding: 15px;
            background-color: #27ae60;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .md-container .md-submit-btn:hover {
            background-color: #229954;
        }

        .md-container .md-info-text {
            font-style: italic;
            text-align: center;
            color: #777;
        }
    </style>
    <div class="md-container">
        <h2 style="text-align: center; color: #2c3e50;">Donate to Hearts United Foundation</h2>
        <p style="text-align: center; font-size: 18px;">Support our mission to uplift lives. You can donate using the options below.</p>

        <hr>

        <h3>📱 Mobile Money</h3>
        <ul>
            <li><strong>MTN:</strong> 0770 XXX XXX</li>
            <li><strong>Airtel:</strong> 0750 XXX XXX</li>
            <li><strong>Recipient Name:</strong> Hearts United Foundation</li>
        </ul>

        <h3>🏦 Bank Transfer</h3>
        <ul>
            <li><strong>Bank Name:</strong> XYZ Bank Uganda</li>
            <li><strong>Account Name:</strong> Hearts United Foundation</li>
            <li><strong>Account Number:</strong> 123456789</li>
            <li><strong>SWIFT Code:</strong> XYZBUGKA</li>
        </ul>

        <p class="md-info-text"><em>After sending your donation, please fill the confirmation form below so we can verify and acknowledge your support.</em></p>

        <hr>

        <form method="post">
            <?php wp_nonce_field('manual_donation_nonce', 'manual_donation_nonce_field'); ?>
            <div class="md-form-group">
                <label for="md_name">Full Name:</label>
                <input type="text" id="md_name" name="md_name" required>
            </div>
            <div class="md-form-group">
                <label for="md_email">Email:</label>
                <input type="email" id="md_email" name="md_email" required>
            </div>
            <div class="md-form-group">
                <label for="md_phone">Phone:</label>
                <input type="text" id="md_phone" name="md_phone" required>
            </div>
            <div class="md-form-group">
                <label for="md_amount">Amount (UGX):</label>
                <input type="number" id="md_amount" name="md_amount" required>
            </div>
            <div class="md-form-group">
                <label for="md_method">Payment Method:</label>
                <select id="md_method" name="md_method" required>
                    <option value="">--Select--</option>
                    <option value="MTN">MTN</option>
                    <option value="Airtel">Airtel</option>
                    <option value="Bank Transfer">Bank Transfer</option>
                </select>
            </div>
            <div class="md-form-group">
                <label for="md_ref">Transaction Reference:</label>
                <input type="text" id="md_ref" name="md_ref" required>
            </div>
            <div class="md-form-group">
                <label for="md_msg">Message (Optional):</label>
                <textarea id="md_msg" name="md_msg" rows="4"></textarea>
            </div>
            <button type="submit" name="submit_manual_donation" class="md-submit-btn">Submit Confirmation</button>
        </form>
    </div>
<?php
    return ob_get_clean();
}

add_action('template_redirect', function () {
    if (isset($_POST['submit_manual_donation']) && isset($_POST['manual_donation_nonce_field']) && wp_verify_nonce($_POST['manual_donation_nonce_field'], 'manual_donation_nonce')) {

        $name    = sanitize_text_field($_POST['md_name']);
        $email   = sanitize_email($_POST['md_email']);
        $phone   = sanitize_text_field($_POST['md_phone']);
        $amount  = number_format(floatval($_POST['md_amount']));
        $method  = sanitize_text_field($_POST['md_method']);
        $ref     = sanitize_text_field($_POST['md_ref']);
        $message = sanitize_textarea_field($_POST['md_msg']);

        $body = "
New Manual Donation Received:

Name: {$name}
Email: {$email}
Phone: {$phone}
Amount: UGX {$amount}
Method: {$method}
Reference: {$ref}
Message: {$message}
";

        $subject = 'New Manual Donation from ' . $name;
        wp_mail(get_option('admin_email'), $subject, $body);

        $current_page_url = strtok($_SERVER['REQUEST_URI'], '?');
        $redirect_url = add_query_arg('donation_confirmed', '1', $current_page_url);

        wp_redirect($redirect_url);
        exit;
    }
});

// Register Manual Donation Widget
class Manual_Donation_Widget extends WP_Widget
{

    public function __construct()
    {
        parent::__construct(
            'manual_donation_widget',
            __('Manual Donation Form', 'manual-donation'),
            ['description' => __('Displays the manual donation form with instructions.', 'manual-donation')]
        );
    }

    public function widget($args, $instance)
    {
        echo $args['before_widget'];
        echo do_shortcode('[manual_donation_form]');
        echo $args['after_widget'];
    }

    public function form($instance)
    {
        echo '<p>No settings for this widget.</p>';
    }

    public function update($new_instance, $old_instance)
    {
        return $old_instance;
    }
}

// Register the widget
add_action('widgets_init', function () {
    register_widget('Manual_Donation_Widget');
});
