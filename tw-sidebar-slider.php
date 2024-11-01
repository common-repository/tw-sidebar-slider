<?php
/*
  Plugin Name: TW Sidebar Slider
  Plugin URI: http://www.socialfbwidgets.com
  Description: Thanks for installing TW Sidebar Slider
  Version: 1.0
  Author: Social FB Widgets
  Author URI: http://www.socialfbwidgets.com
 */

class Bs_twitter_Sidebar {

    public $options;

    public function __construct() {

        $this->options = get_option('bs_twitter_options');
        $this->bs_twitter_setting_register();


    }
  
    public static function bs_twitter_sidebar_slider_menu() {
        add_menu_page(__('Twitter Sidebar', 'bs-twitter-sidebar'), __('TW Sidebar Slider', 'bs-twitter-sidebar'), 'manage_options', __FILE__, array('Bs_twitter_Sidebar', 'bs_show_setting_page'), 'dashicons-twitter', '80');
    }

    public static function bs_show_setting_page() {
        ?>
        <div class="wrap">
        <?php screen_icon(); ?>
            <h2>Twitter Sidebar Slider Configuration</h2>
            <form method="post" action="options.php" enctype="multipart/form-data">

                <?php settings_fields('bs_twitter_options'); ?>
        <?php do_settings_sections(__FILE__); ?>
                <p class="submit">
                    <input name="submit" type="submit" class="button-primary" value="Save Changes"/>
                </p>
            </form>
        </div>
        <?php
    }

    public function bs_twitter_setting_register() {
        register_setting('bs_twitter_options', 'bs_twitter_options', array($this, 'bs_twitter_sidebar_validate'));
        add_settings_section('bs_twitter_sidebar_slider', 'Settings', array($this, 'bs_twitter_sidebar_slider_cb'), __FILE__);
        add_settings_field('title', 'Title', array($this, 'bs_twitter_title'), __FILE__, 'bs_twitter_sidebar_slider');
        add_settings_field('widget_id', 'Widget ID', array($this, 'bs_twitter_name_settings'), __FILE__, 'bs_twitter_sidebar_slider');
        add_settings_field('twitter_username', 'Twitter Name', array($this, 'bs_twitter_url'), __FILE__, 'bs_twitter_sidebar_slider');
        add_settings_field('icon', 'Margin Top', array($this, 'bs_twitter_margin'), __FILE__, 'bs_twitter_sidebar_slider');
        add_settings_field('position', 'Alignment Position', array($this, 'bs_twitter_possition'), __FILE__, 'bs_twitter_sidebar_slider');
        add_settings_field('link_color', 'Link Color', array($this, 'bs_link_color'), __FILE__, 'bs_twitter_sidebar_slider');
        add_settings_field('border_color', 'Border Color', array($this, 'bs_border_color'), __FILE__, 'bs_twitter_sidebar_slider');
        add_settings_field('language', 'Language', array($this, 'bs_twitter_language_settings'), __FILE__, 'bs_twitter_sidebar_slider');
    }

    public function bs_twitter_sidebar_validate($plugin_options) {
        return($plugin_options);
    }

    public function bs_twitter_sidebar_slider_cb() {

    }
    
	public function bs_twitter_title() {
        if (empty($this->options['title']))
            $this->options['title'] = "Twitter Feeds";
        echo "<input name='bs_twitter_options[title]' type='text' value='{$this->options['title']}' />";
    }
    public function bs_twitter_url() {
        if (empty($this->options['twitter_username']))
            $this->options['twitter_username'] = "https://twitter.com/BarackObama";
        echo "<input name='bs_twitter_options[twitter_username]' type='text' value='{$this->options['twitter_username']}' />";
    }
	public function bs_twitter_name_settings() {
        if (empty($this->options['widget_id']))
            $this->options['widget_id'] = "470475991895138304";
        echo "<input name='bs_twitter_options[widget_id]' type='text' value='{$this->options['widget_id']}' />";
    }
	
    public function bs_twitter_margin() {
        (!empty($this->options['icon']))?$icon=$this->options['icon']:$icon=150;  
        echo "<input name='bs_twitter_options[icon]' type='text' value='$icon' />";
    }

  public function bs_border_color() {
        (!empty($this->options['border_color']))?$border_color=$this->options['border_color']:$border_color="#fff";
        echo "<input type='text' name='bs_twitter_options[border_color]' value='$border_color' class='my-color-field'} />";
    }



    public function bs_link_color() {
        (!empty($this->options['link_color']))?$color=$this->options['link_color']:$color="#fff";          ;
        echo "<input type='text' name='bs_twitter_options[link_color]' value='$color' class='my-color-field'} />";
    }
    public function bs_twitter_possition() {
        (!empty($this->options['position']))?$position=$this->options['position']:$position="right"; 
        $items = array('right', 'left');
        echo "<select name='bs_twitter_options[position]'>";
        foreach ($items as $item) {
            $selected = ($position === $item) ? 'selected = "selected"' : '';
            echo "<option value='$item' $selected>$item</option>";
        }
        echo "</select>";
    }

    public function bs_twitter_cover_settings() {
        if (empty($this->options['cover']))
            $this->options['cover'] = "true";
        $items = array('true', 'false');
        echo "<select name='bs_twitter_options[cover]'>";
        foreach ($items as $cover) {
            $selected = ($this->options['cover'] === $cover) ? 'selected = "selected"' : '';
            echo "<option value='$cover' $selected>$cover</option>";
        }
        echo "</select>";
    }

    public function bs_twitter_post_settings() {
        if (empty($this->options['post']))
            $this->options['post'] = "false";
        $items = array('false', 'true');
        echo "<select name='bs_twitter_options[post]'>";
        foreach ($items as $post) {
            $selected = ($this->options['post'] === $post) ? 'selected = "selected"' : '';
            echo "<option value='$post' $selected>$post</option>";
        }
        echo "</select>";
    }

    public function bs_twitter_language_settings() {
        if (empty($this->options['language']))
            $this->options['language'] = "en_US";
        $items = array('en_US', 'en_GB', 'af_ZA', 'bn_IN', 'es_ES', 'it_IT', 'ar_AR', 'tt_RU');
        echo "<select name='bs_twitter_options[language]'>";
        foreach ($items as $language) {
            $selected = ($this->options['language'] === $language) ? 'selected = "selected"' : '';
            echo "<option value='$language' $selected>$language</option>";
        }
        echo "</select>";
    }


}

add_action('admin_menu', 'bs_twitter_options_menu');

function bs_twitter_options_menu() {
    Bs_twitter_Sidebar::bs_twitter_sidebar_slider_menu();
}

add_action('admin_init', 'bs_twitter_object');

function bs_twitter_object() {
    new Bs_twitter_Sidebar();
}

add_action('wp_footer', 'bs_twitter_sidebar_footer');

function bs_twitter_sidebar_footer() {

    $o = get_option('bs_twitter_options');
    extract($o);
    $responsive_twitter ='';
    $responsive_twitter .= '<a class="twitter-timeline" 
                                href="https://twitter.com/"'.$twitter_username.'" 
                                data-widget-id="'.$widget_id.'" 
                                data-height="600" 
                                data-width="" 
                                data-theme="light"
                                data-link-color="'.$link_color.'"
                                data-border-color="'.$border_color.'">
                                Tweets by @BarackObama
                            </a>
            </div>';
    $imgURL = plugins_url('tw-sidebar-slider/assets/css/twitter-left.png');
    $imgURLR = plugins_url('tw-sidebar-slider/assets/css/twitter-right.png');
    ?>
    <style type="text/css">
        .cd-main-content-twitter .cd-btn-twitter {
			width: 48px;
            height: 150px;

            position:fixed;

            top:<?php echo $icon; ?>px;
    <?php if ($position == 'right') { ?>

                background:url(<?php echo $imgURLR; ?>);

                background-repeat: no-repeat;

                right: 0px;
    <?php } else { ?>

                background:url(<?php echo $imgURL; ?>);
                background-repeat: no-repeat;
                left: 0px;
    <?php } ?>

        }

        .cd-panel-content-twitter {
            min-width: 195px !important;
            background: #fff;

        }




    </style>


    </style>

<?php //foreach ($bs_sidebar_pages as $bs_sidebar_page ):?>
    <main class="cd-main-content-twitter">

        <a href="#0" class="cd-btn-twitter"></a>

    </main>

    <?php if ($position == 'right') { ?>
        <div class="cd-panel-twitter from-right-twitter ">
    <?php } else { ?>
            <div class="cd-panel-twitter from-left-twitter ">
    <?php } ?>

            <header class="cd-panel-header-twitter">

                <h3 style="text-align:center"><?php echo $title; ?></h3>
                <a href="#0" class="cd-panel-close-twitter">Close</a>

            </header>

            <div class="cd-panel-container-twitter" style="width:25%">

                <div class="cd-panel-content-twitter">
                    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

        <?php echo $responsive_twitter; ?>
      
        <?php echo $bs_sidebar_page;?>
         
         <?php //endforeach;?>

                </div> <!-- cd-panel-content -->

            </div> <!-- cd-panel-container -->

        </div> <!-- cd-panel -->



    <?php
}

add_action('wp_enqueue_scripts', 'bs_twitter_sidebar_css_register');

function bs_twitter_sidebar_css_register() {
    wp_enqueue_style('bs_twitter_sidebar_css', plugins_url('assets/css/style.css', __FILE__));
}

add_action('wp_enqueue_scripts', 'bs_twitter_sidebar_script_register');

function bs_twitter_sidebar_script_register() {

    wp_enqueue_script('bs_twitter_sidebar_js', plugins_url('assets/js/main.js', __FILE__), array('jquery'));
    
}

add_action( 'admin_enqueue_scripts', 'mw_enqueue_color_picker' );
function mw_enqueue_color_picker() {
    // first check that $hook_suffix is appropriate for your admin page
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'my-script-handle', plugins_url('assets/js/color.js', __FILE__ ), array( 'wp-color-picker' ), '', true );
}
