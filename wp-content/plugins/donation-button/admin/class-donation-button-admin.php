<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Donation_Button
 * @subpackage Donation_Button/admin
 * @author     mbj-webdevelopment <mbjwebdevelopment@gmail.com>
 */
class Donation_Button_Admin {

    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->load_dependencies();
        $this->enqueue_styles();
        $this->enqueue_scripts();
        $this->define_constants();
    }

    private function load_dependencies() {
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/class-donation-button-admin-display.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/class-donation-button-general-setting.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/class-donation-button-html-output.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/class-donation-button-admin-widget.php';        
    }
    
    private function define_constants() {
        if (!defined('DBP_FOR_WORDPRESS_LOG_DIR')) {
            define('DBP_FOR_WORDPRESS_LOG_DIR', ABSPATH . 'donation-button-logs/');
        }
    }

    public function enqueue_styles() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Paypal_Invoice_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Paypal_Invoice_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/donation-button-admin.css', array(), $this->version, 'all');
        wp_enqueue_style($this->plugin_name . 'jquery-ui-datepicker', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Paypal_Invoice_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Paypal_Invoice_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/donation-button-admin.js', array('jquery', 'wp-color-picker'), $this->version, false);
        if (wp_script_is($this->plugin_name)) {
            wp_localize_script($this->plugin_name, 'donation_button_twilio_test_sms_button_params', apply_filters('donation_button_twilio_test_sms_button_params', array(
                'ajax_url' => admin_url('admin-ajax.php'),
            )));
        }
        wp_enqueue_script('jquery-ui-datepicker');
        wp_enqueue_style('wp-color-picker');
    }

    public function paypal_donation_button_woocommerce_standard_parameters($paypal_args) {
        if (isset($paypal_args['BUTTONSOURCE'])) {
            $paypal_args['BUTTONSOURCE'] = 'mbjtechnolabs_SP';
        } else {
            $paypal_args['bn'] = 'mbjtechnolabs_SP';
        }
        return $paypal_args;
    }

    public function donation_goal_custom_post_create() {

        $labels = array(
            'name' => _x('Goals', 'post type general name', 'donation-button'),
            'singular_name' => _x('Goal', 'post type singular name', 'donation-button'),
            'menu_name' => _x('Goal', 'admin menu', 'donation-button'),
            'name_admin_bar' => _x('Goals', 'add new on admin bar', 'donation-button'),
            'add_new' => _x('Add New Goal', 'Goal', 'donation-button'),
            'add_new_item' => __('Add New Goal', 'donation-button'),
            'new_item' => __('New Goal', 'donation-button'),
            'edit_item' => __('Edit Goal', 'donation-button'),
            'view_item' => __('View Goal', 'donation-button'),
            'all_items' => __('All Goals', 'donation-button'),
            'search_items' => __('Search Goals', 'donation-button'),
            'parent_item_colon' => __('Parent Goals:', 'donation-button'),
            'not_found' => __('No Goals found.', 'donation-button'),
            'not_found_in_trash' => __('No Goals found in Trash.', 'donation-button')
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'Invoice', 'with_front' => true),
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => null,
            'supports' => array('title')
        );
        register_post_type('donationgoal', $args);
    }

    public function add_donation_goal_in_meta_boxes_detail() {

        add_meta_box('donationgoal-id', __('Goal Details'), array(__CLASS__, 'donation_goal_detail_manager_metabox'), 'donationgoal', 'normal', 'high');
    }

    public function donation_goal_detail_manager_metabox() {

        $get_donation_button_post_meta = get_post_meta(get_the_ID(), 'donation_button_detail');
        $get_donation_button_post_meta_array = $get_donation_button_post_meta[0];        
        $start_date = date("Y-m-d", strtotime($get_donation_button_post_meta_array['donation_button_start_date']));
        $end_date = date("Y-m-d", strtotime($get_donation_button_post_meta_array['donation_button_end_date']));
        $donation_button_complete_target = '0';
		
        global $wpdb;
        $meta_key = 'mc_gross';
        $donation_button_result_array = $wpdb->get_var($wpdb->prepare("
		SELECT sum(meta_value) 
		FROM $wpdb->postmeta,$wpdb->posts 
		WHERE meta_key = %s
                AND $wpdb->posts.ID = $wpdb->postmeta.post_id 
                AND $wpdb->postmeta.meta_key = 'mc_gross'            
                AND $wpdb->posts.post_status = 'publish' 
                AND $wpdb->posts.post_type = 'donation_list'
                AND (date($wpdb->posts.post_date) BETWEEN %s AND %s)
            ", $meta_key, $start_date, $end_date));
         
        if( isset( $donation_button_result_array ) && !empty( $donation_button_result_array ) ) {
             
             $donation_button_target_amount = $get_donation_button_post_meta_array['donation_button_target_amount'];
             $donation_complete_amount = round( $donation_button_result_array );
            
             $donation_button_complete_target = round(( 100 * $donation_complete_amount ) / $donation_button_target_amount);
             if ($donation_button_complete_target > 100) {
                $donation_button_complete_target = 100;
            }
         }
        
        ?>        
        <div class='wrap donation_button_div_table'>            
            <table class="widefat" cellspacing="0" >
                <thead>
                    <tr>
                        <th colspan="2"><?php _e('Goal Detail', 'donation-button'); ?></th>
                    </tr>
                </thead>
                <tbody>                    
                    <tr>
                        <th><?php _e('Donation Goal Detail', 'donation-button'); ?></th>
                        <td>
                            <textarea name="donation_button_goal_detail" class="donation_button_goal_detail"><?php echo (isset($get_donation_button_post_meta_array['donation_button_goal_detail'])) ? $get_donation_button_post_meta_array['donation_button_goal_detail'] : ''; ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th><?php _e('Donation Target Amount', 'donation-button'); ?></th>
                        <td>
                            <input type="text" id="donation_button_target_amount" class="donation_button_target_amount" name="donation_button_target_amount" value="<?php echo (isset($get_donation_button_post_meta_array['donation_button_target_amount'])) ? $get_donation_button_post_meta_array['donation_button_target_amount'] : ''; ?>">
                        </td>                        
                    </tr>
                    <tr>
                        <th><?php _e('Start Date', 'donation-button'); ?></th>
                        <td>
                            <input type="text" id="donation_button_start_date" class="donation_button_date" name="donation_button_start_date" value="<?php echo (isset($get_donation_button_post_meta_array['donation_button_start_date'])) ? $get_donation_button_post_meta_array['donation_button_start_date'] : ''; ?>" readonly>
                        </td>                        
                    </tr>
                    <tr>
                        <th><?php _e('End Date', 'donation-button'); ?></th>
                        <td>                            
                            <input type="text" id="donation_button_end_date" class="donation_button_date" name="donation_button_end_date" value="<?php echo (isset($get_donation_button_post_meta_array['donation_button_end_date'])) ? $get_donation_button_post_meta_array['donation_button_end_date'] : ''; ?>" readonly/>
                        </td>
                    </tr>
                    <tr>
                        <th><?php _e('Change Progress Background Color', 'donation-button'); ?></th>
                        <td>                            
                            <input type="text" id="donation_button_progress_background" class="donation_button_progress_background donation_background_color_change" name="donation_button_progress_background" value="<?php echo (isset($get_donation_button_post_meta_array['donation_button_progress_background'])) ? $get_donation_button_post_meta_array['donation_button_progress_background'] : '#eaeaea'; ?>"/>
                            <img class="donation_button_pbg_reload_color" src="<?php echo plugin_dir_url(__FILE__) . 'images/reload.png'; ?>" alt="<?php _e('Change The Progress Backgroud', 'donation-button'); ?>">

                        </td>                         
                    </tr>
                    <tr>
                        <th><?php _e('Change Percentage Background Color', 'donation-button'); ?></th>
                        <td>                            
                            <input type="text" id="donation_button_bar_percentage_background" class="donation_button_bar_percentage_background donation_background_color_change" name="donation_button_bar_percentage_background" value="<?php echo (isset($get_donation_button_post_meta_array['donation_button_bar_percentage_background'])) ? $get_donation_button_post_meta_array['donation_button_bar_percentage_background'] : '#BEC7D3'; ?>"/>
                            <img class="donation_button_bpg_reload_color" src="<?php echo plugin_dir_url(__FILE__) . 'images/reload.png'; ?>" alt="<?php _e('Change The Percentage Background', 'donation-button'); ?>">
                        </td>                         
                    </tr>
                    <tr>
                        <th><?php _e('Change Bar Color', 'donation-button'); ?></th>
                        <td>                            
                            <input type="text" id="donation_button_bar_background" class="donation_button_bar_background donation_background_color_change" name="donation_button_bar_background" value="<?php echo (isset($get_donation_button_post_meta_array['donation_button_bar_background'])) ? $get_donation_button_post_meta_array['donation_button_bar_background'] : '#666666'; ?>"/>
                            <img class="donation_button_bb_reload_color" src="<?php echo plugin_dir_url(__FILE__) . 'images/reload.png'; ?>" alt="<?php _e('Change The Progress Bar Background', 'donation-button'); ?>">
                        </td>                         
                    </tr>
                    <tr>
                        <th><?php _e('Change Percentage Font Color', 'donation-button'); ?></th>
                        <td>                            
                            <input type="text" id="donation_button_bar_and_font" class="donation_button_bar_and_font donation_background_color_change" name="donation_button_bar_and_font" value="<?php echo (isset($get_donation_button_post_meta_array['donation_button_bar_and_font'])) ? $get_donation_button_post_meta_array['donation_button_bar_and_font'] : '#000000'; ?>"/>
                            <img class="donation_button_bf_reload_color" src="<?php echo plugin_dir_url(__FILE__) . 'images/reload.png'; ?>" alt="<?php _e('Change The Progress Bar And Font Color', 'donation-button'); ?>">
                        </td>                         
                    </tr>                    
                    <tr>
                        <th><?php _e('Font Color Goal Preview', 'donation-button'); ?></th>
                        <td>                            
                            <input type="text" id="donation_button_preview_table_color" class="donation_button_preview_table_color donation_background_color_change" name="donation_button_preview_table_color" value="<?php echo (isset($get_donation_button_post_meta_array['donation_button_preview_table_color'])) ? $get_donation_button_post_meta_array['donation_button_preview_table_color'] : '#000000'; ?>"/>
                            <img class="donation_button_pt_color" src="<?php echo plugin_dir_url(__FILE__) . 'images/reload.png'; ?>" alt="<?php _e('Change The Progress Bar table Background', 'donation-button'); ?>">
                        </td>                         
                    </tr>
                </tbody>
            </table><br />
            <table class="widefat donation_button_table_hide_show" cellspacing="0" >
                <thead>
                    <tr>
                        <th colspan="2"><?php _e('Hide/Show', 'donation-button'); ?></th>
                    </tr>
                </thead>
                <tbody class="donation_button_table_tbody_hide_show">                   
                    <tr>
                        <th><?php _e('Donation Goal Detail', 'donation-button'); ?></th>
                        <td>                       
                            <?php                             
                                    $chk_donation_goal_detail_checked = '';
                                    $chk_donation_target_amount_checked = '';
                                    $chk_donation_goal_start_date_checked = '';
                                    $chk_donation_goal_end_date_checked = '';
                                    $chk_donation_goal_display_paypal_donation_button_checked = '';
                                    
                                    if(isset($get_donation_button_post_meta_array['chk_donation_goal'])){
                                        foreach ($get_donation_button_post_meta_array['chk_donation_goal'] as $value) {
                                            if ( $value == 'chk_donation_goal_detail' ){
                                                $chk_donation_goal_detail_checked = 'checked';
                                            } elseif ( $value == 'chk_donation_target_amount' ) {
                                                $chk_donation_target_amount_checked = 'checked';
                                            } elseif ( $value == 'chk_donation_goal_start_date' ) {
                                                $chk_donation_goal_start_date_checked = 'checked';
                                            } elseif ( $value == 'chk_donation_goal_end_date' ) {
                                                $chk_donation_goal_end_date_checked = 'checked';
                                            } elseif ( $value == 'chk_donation_goal_display_paypal_donation_button' ) {
                                                $chk_donation_goal_display_paypal_donation_button_checked = 'checked';
                                            }
                                        }
                                    }
                            ?>
                            <input type="checkbox" id="chk_donation_goal_detail_click" name="chk_donation_goal[]" value="chk_donation_goal_detail" <?php echo $chk_donation_goal_detail_checked; ?>/>                 
                        </td>
                    </tr>
                    <tr>
                        <th><?php _e('Donation Target Amount', 'donation-button'); ?></th>
                        <td>
                            <input type="checkbox" id="chk_donation_target_amount_click" name="chk_donation_goal[]" value="chk_donation_target_amount" <?php echo $chk_donation_target_amount_checked; ?>/>
                        </td>
                    </tr>
                    <tr>
                        <th><?php _e('Start Date', 'donation-button'); ?></th>
                        <td>
                            <input type="checkbox" id="chk_donation_goal_start_date_click" name="chk_donation_goal[]" value="chk_donation_goal_start_date" <?php echo $chk_donation_goal_start_date_checked; ?>/>
                        </td>
                    </tr>
                    <tr>
                        <th><?php _e('End Date', 'donation-button'); ?></th>
                        <td>
                            <input type="checkbox" id="chk_donation_goal_end_date_click" name="chk_donation_goal[]" value="chk_donation_goal_end_date" <?php echo $chk_donation_goal_end_date_checked; ?>/>
                        </td>
                    </tr>
                    <tr>
                        <th><?php _e('Display Paypal Donation Button', 'donation-button'); ?></th>
                        <td>
                            <input type="checkbox" id="chk_donation_goal_display_paypal_donation_button_click" name="chk_donation_goal[]" value="chk_donation_goal_display_paypal_donation_button" <?php echo $chk_donation_goal_display_paypal_donation_button_checked; ?>/>
                        </td>
                    </tr>
                </tbody>
            </table><br />
            <table class="widefat donation_button_table_backgroud_color" cellspacing="0" >
                <thead>
                    <tr>
                        <th colspan="2"><?php _e('Goal Preview', 'donation-button'); ?></th>
                    </tr>
                </thead>
                <tbody class="donation_button_table_tbody_backgroud_color">                    
                    <tr id="label_donation_goal_detail_tr">
                        <th><?php _e('Donation Goal Detail', 'donation-button'); ?></th>
                        <td>
                            <label class="label_donation_goal_detail lbl" ><?php echo (isset($get_donation_button_post_meta_array['donation_button_goal_detail'])) ? $get_donation_button_post_meta_array['donation_button_goal_detail'] : ''; ?></label>                        
                        </td>
                    </tr>
                    <tr id="label_donation_goal_target_amount_lbl_tr">
                        <th><?php _e('Donation Target Amount', 'donation-button'); ?></th>
                        <td>
                            <label class="label_donation_goal_target_amount_lbl" ><?php echo (isset($get_donation_button_post_meta_array['donation_button_target_amount'])) ? $get_donation_button_post_meta_array['donation_button_target_amount'] : ''; ?></label>                        
                        </td>
                    </tr>
                    <tr id="label_donation_goal_start_date_tr">
                        <th><?php _e('Start Date', 'donation-button'); ?></th>
                        <td>
                            <label class="label_donation_goal_start_date lbl" ><?php echo (isset($get_donation_button_post_meta_array['donation_button_start_date'])) ? $get_donation_button_post_meta_array['donation_button_start_date'] : ''; ?></label>                        
                        </td>
                    </tr>
                    <tr id="label_donation_goal_end_date_tr">
                        <th><?php _e('End Date', 'donation-button'); ?></th>
                        <td>                            
                            <label class="label_donation_goal_end_date lbl" ><?php echo (isset($get_donation_button_post_meta_array['donation_button_end_date'])) ? $get_donation_button_post_meta_array['donation_button_end_date'] : ''; ?></label>                        
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div id="donation_button_container">  
                                <div class="donation-button-bar-main-container donation-button-background-color">
                                    <div class="wrap">
                                        <div class="donation-button-bar-percentage" data-percentage="<?php echo $donation_button_complete_target; ?>"></div>
                                        <div class="donation-button-bar-container">
                                            <div class="donation-button-bar"></div>
                                        </div>
                                    </div>
                                </div>   
                            </div>
                        </td>
                    </tr>
                    <tr id="label_donation_goal_display_paypal_donation_button_tr">                        
                        <td>                            
                            <label class="label_donation_goal_display_paypal_donation_button lbl" ><?php echo do_shortcode( '[paypal_donation_button]' ); ?> </label>                        
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    <?php
    }

    public function save_post_donation_details($postID, $post, $update) {

        $slug = 'donationgoal';
        if ($slug != $post->post_type) {
            return;
        }
        $donation_button_array_merge = array();
        $donation_button_array_merge_final = array();
        $get_post_request_data_donation_button = $_REQUEST;

        if (isset($get_post_request_data_donation_button['donation_button_goal_detail']) && !empty($get_post_request_data_donation_button['donation_button_goal_detail'])) {
            $donation_button_array_field = array(                
                'donation_button_goal_detail' => (isset($get_post_request_data_donation_button['donation_button_goal_detail'])) ? $get_post_request_data_donation_button['donation_button_goal_detail'] : '',
                'donation_button_target_amount' => (isset($get_post_request_data_donation_button['donation_button_target_amount'])) ? $get_post_request_data_donation_button['donation_button_target_amount'] : '',
                'donation_button_start_date' => (isset($get_post_request_data_donation_button['donation_button_start_date'])) ? $get_post_request_data_donation_button['donation_button_start_date'] : '',
                'donation_button_end_date' => (isset($get_post_request_data_donation_button['donation_button_end_date'])) ? $get_post_request_data_donation_button['donation_button_end_date'] : '',
                'donation_button_progress_background' => (isset($get_post_request_data_donation_button['donation_button_progress_background'])) ? $get_post_request_data_donation_button['donation_button_progress_background'] : '',
                'donation_button_bar_percentage_background' => (isset($get_post_request_data_donation_button['donation_button_bar_percentage_background'])) ? $get_post_request_data_donation_button['donation_button_bar_percentage_background'] : '',
                'donation_button_bar_background' => (isset($get_post_request_data_donation_button['donation_button_bar_background'])) ? $get_post_request_data_donation_button['donation_button_bar_background'] : '',
                'donation_button_bar_and_font' => (isset($get_post_request_data_donation_button['donation_button_bar_and_font'])) ? $get_post_request_data_donation_button['donation_button_bar_and_font'] : '',
                'donation_button_preview_table_color' => (isset($get_post_request_data_donation_button['donation_button_preview_table_color'])) ? $get_post_request_data_donation_button['donation_button_preview_table_color'] : '',
                'chk_donation_goal' => (isset($get_post_request_data_donation_button['chk_donation_goal'])) ? $get_post_request_data_donation_button['chk_donation_goal'] : '',
            );
            $donation_button_array_merge = array_merge($donation_button_array_merge, $donation_button_array_field);
        }

        foreach ($get_post_request_data_donation_button as $key => $value) {
            if (array_key_exists($key, $donation_button_array_merge)) {
                $donation_button_array_merge_final[$key] = $value;
            }
        }
        update_post_meta($postID, 'donation_button_detail', $donation_button_array_merge_final);
    }
    
    public function set_custom_edit_donation_goal_columns($columns) {

        unset($columns['date']);
        $columns['donation_button_short_code'] = __('Short Code', 'paypal-invoicing');        
        $columns['date'] = __('Date', 'paypal-invoicing');
        return $columns;
    }
          
    public function custom_donationgoal_columns($column, $post_id) {       
       
            switch ($column) {

                case 'donation_button_short_code' : 
                      echo "[donation_goal id='".$post_id."']";             
                    break;
                default :
                    break;
            }      
    }
    
    public function bs_donation_goal_table_sorting($columns) {
        $columns['donation_button_short_code'] = 'donation_button_short_code';       
        return $columns;
    }
}