<?php

namespace wpbel\classes\bootstrap;

use wpbel\classes\controllers\Wordpress_Posts_Bulk_Edit;
use wpbel\classes\controllers\WPBEL_Ajax;
use wpbel\classes\controllers\WPBEL_Post;
use wpbel\classes\repositories\Column;
use wpbel\classes\repositories\Common;
use wpbel\classes\repositories\Search;
use wpbel\classes\repositories\Setting;

class WPBEL
{
    private static $instance = null;

    public static function init()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
    }

    private function __construct()
    {
        if (!current_user_can('edit_posts')) {
            return;
        }

        $this->set_common_items();

        add_action('admin_menu', [$this, 'add_menu']);
        add_action('admin_enqueue_scripts', [$this, 'load_assets']);
        WPBEL_Ajax::register_callback();
        WPBEL_Post::register_callback();

        (new WPBEL_Custom_Queries())->init();
        (new WPBEL_Meta_Fields())->init();
    }

    private function set_common_items()
    {
        $common_repository = new Common();
        $common_items = $common_repository->get_items();
        if (!isset($common_items['active_post_type'])) {
            $common_repository->update([
                'active_post_type' => "post"
            ]);
        }
        $GLOBALS['wpbel_common'] = $common_repository->get_items();
    }

    public static function wpbel_wp_init()
    {
        // load textdomain
        load_plugin_textdomain('ithemeland-wordpress-posts-bulk-editing', false, WPBEL_LANGUAGES_DIR);
    }

    public function add_menu()
    {
        add_menu_page(esc_html__('WP Posts', WPBEL_NAME), esc_html__('WP Posts', WPBEL_NAME), 'edit_posts', 'wpbel', [new Wordpress_Posts_Bulk_Edit(), 'index'], WPBEL_IMAGES_URL . 'wpbel_icon.svg', 2);
    }

    public function load_assets($page)
    {
        if ($page == 'toplevel_page_wpbel') {
            // Styles
            wp_enqueue_style('wpbel-reset', WPBEL_CSS_URL . 'reset.css');
            wp_enqueue_style('wpbel-LineIcons', WPBEL_CSS_URL . 'LineIcons.min.css');
            wp_enqueue_style('wpbel-select2', WPBEL_CSS_URL . 'select2.min.css');
            wp_enqueue_style('wpbel-sweetalert', WPBEL_CSS_URL . 'sweetalert.css');
            wp_enqueue_style('wpbel-jquery-ui', WPBEL_CSS_URL . 'jquery-ui.min.css');
            wp_enqueue_style('wpbel-tipsy', WPBEL_CSS_URL . 'jquery.tipsy.css');
            wp_enqueue_style('wpbel-scrollbar', WPBEL_CSS_URL . 'jquery.scrollbar.css');
            wp_enqueue_style('wpbel-main', WPBEL_CSS_URL . 'style.css');
            wp_enqueue_style('wp-color-picker');

            // Scripts
            wp_enqueue_script('wpbel-functions', WPBEL_JS_URL . 'functions.js', ['jquery'], '1.0.1');
            wp_enqueue_script('wpbel-select2', WPBEL_JS_URL . 'select2.min.js', ['jquery']);
            wp_enqueue_script('wpbel-moment', WPBEL_JS_URL . 'moment-with-locales.min.js', ['jquery']);
            wp_enqueue_script('wpbel-tipsy', WPBEL_JS_URL . 'jquery.tipsy.js', ['jquery']);
            wp_enqueue_script('wpbel-scrollbar', WPBEL_JS_URL . 'jquery.scrollbar.min.js', ['jquery']);
            wp_enqueue_script('wpbel-sweetalert', WPBEL_JS_URL . 'sweetalert.min.js', ['jquery']);
            wp_enqueue_script('wpbel-main', WPBEL_JS_URL . 'main.js', ['jquery'], '6.0');
            wp_localize_script('wpbel-main', 'WPBEL_DATA', [
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('ajax-nonce'),
            ]);
            wp_enqueue_media();
            wp_enqueue_editor();
            wp_enqueue_script('jquery-ui-sortable');
            wp_enqueue_script('jquery-ui-datepicker');
            wp_enqueue_script('wp-color-picker');
        }
    }

    public static function activate()
    {
        // set plugin version
        update_option('wpbel_version', WPBEL_VERSION);

        // create tables
        self::create_tables();

        // set default settings
        (new Setting('post'))->set_default_settings();

        // set default column profile
        (new Column('post'))->set_default_columns();

        // set default filter profile
        (new Search('post'))->set_default_item();
    }

    public static function deactivate()
    {
        //
    }

    private static function create_tables()
    {
        global $wpdb;
        $history_table_name = esc_sql($wpdb->prefix . 'wpbel_history');
        $history_items_table_name = esc_sql($wpdb->prefix . 'wpbel_history_items');
        $query = '';
        $history_table = $wpdb->prepare('SHOW TABLES LIKE %s', $wpdb->esc_like($history_table_name));
        if (!$wpdb->get_var($history_table) == $history_table_name) {
            $query .= "CREATE TABLE {$history_table_name} (
                  id int(11) NOT NULL AUTO_INCREMENT,
                  user_id int(11) NOT NULL,
                  fields text NOT NULL,
                  operation_type varchar(32) NOT NULL,
                  operation_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                  reverted tinyint(1) NOT NULL DEFAULT '0',
                  sub_system varchar(64) NOT NULL,
                  PRIMARY KEY (id),
                  INDEX (user_id)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        }

        $history_items_table = $wpdb->prepare('SHOW TABLES LIKE %s', $wpdb->esc_like($history_items_table_name));
        if (!$wpdb->get_var($history_items_table) == $history_items_table_name) {
            $query .= "CREATE TABLE {$history_items_table_name} (
                      id int(11) NOT NULL AUTO_INCREMENT,
                      history_id int(11) NOT NULL,
                      historiable_id int(11) NOT NULL,
                      field varchar(255) NOT NULL,
                      prev_value longtext,
                      new_value longtext,
                      PRIMARY KEY (id),
                      INDEX (history_id),
                      INDEX (historiable_id)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

            $query .= "ALTER TABLE {$history_items_table_name} ADD CONSTRAINT wpbel_history_items_history_id_relation FOREIGN KEY (history_id) REFERENCES {$history_table_name} (id) ON DELETE CASCADE ON UPDATE CASCADE;";
        }

        if (!empty($query)) {
            require_once(ABSPATH . '/wp-admin/includes/upgrade.php');
            dbDelta($query);
        }
    }
}
