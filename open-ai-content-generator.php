<?php
/*
Plugin Name: OpenAI Content Generator
Description: Generate Post/Page content using OpenAI API.
Version: 1.0
Author: Thomas Deer
Author URI: https://thomasdeer.co.uk
*/

/**
 * OpenAI_Content_Generator class.
 *
 * This class provides an interface in the WordPress admin to set up and use the OpenAI API
 * for content generation.
 */
class OpenAI_Content_Generator {

    /**
     * Constructor.
     *
     * Initializes the OpenAI_Content_Generator object and sets up WordPress hooks.
     */
    public function __construct() {
        $this->get_required_files();

        // Add settings page to the WordPress admin menu.
        add_action('admin_menu', [$this, 'add_settings_page']);

        // Enqueue necessary scripts and styles for the plugin.
        add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);

        // Handle AJAX request for content generation.
        add_action('wp_ajax_generate_content', [$this, 'generate_content']);
    }

    /**
     * Includes required files.
     */
    public function get_required_files() {
        require_once('OpenAI_API_Handler.class.php');
    }

    /**
     * Adds a settings page for the plugin in the WordPress admin.
     */
    public function add_settings_page() {
        add_submenu_page(
            'options-general.php',           // Parent slug
            'OpenAI Settings',               // Page title
            'OpenAI Settings',               // Menu title
            'manage_options',                // Capability
            'openai-settings',               // Menu slug
            [$this, 'render_settings_page']  // Callback function
        );
    }

    /**
     * Renders the settings page for the plugin in the WordPress admin.
     */
    public function render_settings_page() {
        // Check if the form has been submitted.
        if (isset($_POST['openai_api_key_nonce']) && wp_verify_nonce($_POST['openai_api_key_nonce'], 'save_openai_api_key')) {
            // Sanitize and save the API key.
            $api_key = sanitize_text_field($_POST['openai_api_key']);
            update_option('openai_api_key', $api_key);
        }

        // Retrieve the API key from the options.
        $api_key_value = get_option('openai_api_key', '');

        // Render the form.
        echo '<div class="wrap">';
            echo '<h1>OpenAI Settings</h1>';
            echo '<form method="post" action="">';
                echo '<table class="form-table">';
                    echo '<tbody>';
                        echo '<tr>';
                            echo '<th scope="row"><label for="openai_api_key">API Key</label></th>';
                            echo '<td><input name="openai_api_key" type="text" id="openai_api_key" value="' . esc_attr($api_key_value) . '" class="regular-text"></td>';
                        echo '</tr>';
                    echo '</tbody>';
                echo '</table>';
                wp_nonce_field('save_openai_api_key', 'openai_api_key_nonce');
            echo '<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>';
            echo '</form>';
        echo '</div>';
    }

    /**
     * Enqueues necessary scripts and styles for the plugin.
     *
     * This method should be filled with the appropriate enqueue functions as needed.
     */
    public function enqueue_scripts() {
        // Enqueue necessary scripts and styles for the plugin.
    }

    /**
     * Handles AJAX request for content generation.
     *
     * This method should be filled with the logic to generate content using the OpenAI API.
     */
    public function generate_content() {
        // Handle AJAX request for content generation.
    }
}

// Initialize the OpenAI_Content_Generator class when all plugins are loaded.
if(class_exists("OpenAI_Content_Generator")) {
    function initialize_openai_content_generator() {
        new OpenAI_Content_Generator();
    }
    add_action('plugins_loaded', 'initialize_openai_content_generator');
}
