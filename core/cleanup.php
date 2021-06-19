<?php 

class LIFTCleanUPS {
    public $attrs = null;
    public function __construct($attrs) {
        $this->attrs = $attrs;
        if($this->attrs['removeLogo']) {
            add_action( 'wp_before_admin_bar_render', 'LIFTCleanUPS::removeLogo');
        };
        if($this->attrs['removeHelp']) {
            add_filter( 'contextual_help', 'LIFTCleanUPS::removeHelp', 999, 3 );
        };
        if($this->attrs['removeDashboardQuickPress']) {
            add_action( 'wp_dashboard_setup', 'LIFTCleanUPS::removeDashboardQuickPress' );
        };
        if($this->attrs['removeDashboardPrimary']) {
            add_action( 'wp_dashboard_setup', 'LIFTCleanUPS::removeDashboardPrimary' );
        };
        if($this->attrs['removeYoast']) {
            add_action( 'wp_dashboard_setup', 'LIFTCleanUPS::removeYoast' );
        };
        if($this->attrs['removeSiteHealth']) {
            add_action( 'wp_dashboard_setup', 'LIFTCleanUPS::removeSiteHealth' );
        };
        if($this->attrs['removeDashboardActivity']) {
            add_action( 'wp_dashboard_setup', 'LIFTCleanUPS::removeDashboardActivity' );
        };
        if($this->attrs['removeAtAGlance']) {
            add_action( 'wp_dashboard_setup', 'LIFTCleanUPS::removeAtAGlance' );
        };
        if($this->attrs['removeWelcome']) {
            add_action( 'wp_dashboard_setup', 'LIFTCleanUPS::removeWelcome' );
        };
        if($this->attrs['removeUpdate']) {
            add_action( 'wp_dashboard_setup', 'LIFTCleanUPS::removeUpdate' );
        };
        if($this->attrs['removeAdminBar']) {
            if (!is_admin()) {
                show_admin_bar(false);
                add_filter( 'show_admin_bar', '__return_false' );
            }
        };
        if($this->attrs['removeAdminText']) {
            add_filter('admin_title', 'LIFTCleanUPS::removeAdminText', 10, 2);
        };
        if($this->attrs['removeGotoLogin']) {
            add_action('login_head', 'LIFTCleanUPS::removeGotoLogin');
        };
        if($this->attrs['removeDashboardbyID']) {
            $str = preg_replace("/\s+/", "", $this->attrs['removeDashboardbyID']);
            $arr = array_unique(explode(",",$str));
            $idhide = '';
            foreach ($arr as $key => $value) {
                $idhide .= '#'.trim($value)."{display:none!important}";
                // add_action( 'wp_dashboard_setup_'.trim($value), 'LIFTCleanUPS::removeDashboardbyID', 10, 1 );
                // do_action('wp_dashboard_setup_'.trim($value), trim($value));
            }
            if (is_admin() && $arr) {
                echo '<style>';
                echo $idhide;
                echo '</style>';
            }
        };
        if($this->attrs['removeNotice']) {
            add_action('admin_head','LIFTCleanUPS::removeNotice');
        };
        if($this->attrs['removeGutenbergPanel']) {
            add_action( 'wp_dashboard_setup', 'LIFTCleanUPS::removeGutenbergPanel' );
        };
    }
    public function removeLogo() {
        global $wp_admin_bar;
        $wp_admin_bar->remove_menu( 'wp-logo' );
    }
    public function removeDashboardQuickPress() {
        remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
    }
    public function removeDashboardPrimary() {
        remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
    }
    public function removeYoast() {
        remove_meta_box( 'yoast_db_widget', 'dashboard', 'normal' );
        remove_meta_box('wpseo-dashboard-overview','dashboard', 'normal');
    }
    public function removeSiteHealth() {
        remove_meta_box( 'dashboard_site_health', 'dashboard', 'normal' );
    }
    public function removeDashboardActivity() {
        remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );
        remove_meta_box( 'rg_forms_dashboard', 'dashboard', 'normal' );
    }
    public function removeAtAGlance() {
        remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
    }
    public function removeWelcome() {
        remove_action( 'welcome_panel', 'wp_welcome_panel' );
    }
    public function removeIncoming() {
        remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
    }
    public function removePlugins() {
        remove_meta_box('dashboard_plugins', 'dashboard', 'normal');
    }
    public function removeSecondary() {
        remove_meta_box('dashboard_secondary', 'dashboard', 'normal');
    }
    public function removeDraft() {
        remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');
    }
    public function removeComment() {
        remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
    }
    public function removeUpdate() {
        global $wp_admin_bar;
        $wp_admin_bar->remove_menu( 'updates' );
        $wp_admin_bar->remove_menu( 'easy-updates-manager-admin-bar' );
        remove_action( 'admin_notices', 'update_nag' );
    }
    public function removeNotice() {
        ?><style>.notice , .update-plugins, .updated, .update_nag, .update-message.notice {display:none!important}</style><?php
    }
    public function removeGutenbergPanel() {
        remove_action( 'try_gutenberg_panel', 'wp_try_gutenberg_panel');
    }
    public function removeHelp($old_help, $screen_id, $screen) {
        $screen->remove_help_tabs();
        return $old_help;
    }
    public function liftCredits( $text ) {
        $text = 'LIFT Creations';
        return $text;
    }
    public function removeAdminText($admin_title, $title) {
        return $title.' - '.get_bloginfo('name');
    }
    public function removeGotoLogin() {
        ?><style>#login #backtoblog{display:none}</style><?php
    }
}

// CLEAN UP 
add_filter( 'admin_footer_text', 'LIFTCleanUPS::liftCredits' );
add_action( 'carbon_fields_fields_registered', '___lift_clearUpSystem' );

function ___lift_clearUpSystem() {
    $attrs = array(
        'removeDashboardbyID' => carbon_get_theme_option('___lift_remove_dashboardbyid') ? carbon_get_theme_option('___lift_remove_dashboardbyid') : null,
        'removeLogo' => carbon_get_theme_option('___lift_remove_wp_logo') ? true: false,
        'removeHelp' => carbon_get_theme_option('___lift_remove_help_menu') ? true: false,
        'removeDashboardQuickPress' => carbon_get_theme_option('___lift_remove_dashboard_quick_press') ? true: false,
        'removeDashboardPrimary' => carbon_get_theme_option('___lift_remove_dashboard_primary') ? true: false,
        'removeYoast' => carbon_get_theme_option('___lift_remove_yoast_db_widget') ? true: false,
        'removeSiteHealth' => carbon_get_theme_option('___lift_remove_dashboard_site_health') ? true: false,
        'removeDashboardActivity' => carbon_get_theme_option('___lift_remove_dashboard_activity') ? true: false,
        'removeAtAGlance' => carbon_get_theme_option('___lift_remove_dashboard_right_now') ? true: false,
        'removeWelcome' => carbon_get_theme_option('___lift_remove_welcome_panel') ? true: false,
        'removeUpdate' => carbon_get_theme_option('___lift_remove_update_nag') ? true: false,
        'removeGutenbergPanel' => carbon_get_theme_option('___lift_remove_gutenberg_panel') ? true: false,
        'removeNotice' => carbon_get_theme_option('___lift_remove_notice') ? true: false,
        'removeAdminBar' => carbon_get_theme_option('___lift_remove_admin_bar') ? true: false,
        'removeAdminText' => carbon_get_theme_option('___lift_remove_admin_text') ? true: false,
        'removeGotoLogin' => carbon_get_theme_option('___lift_remove_goto') ? true: false,

        'removeIncoming' => carbon_get_theme_option('___lift_remove_incoming_links') ? true: false,
        'removePlugins' => carbon_get_theme_option('___lift_remove_plugins') ? true: false,
        'removeSecondary' => carbon_get_theme_option('___lift_remove_secondary') ? true: false,
        'removeDraft' => carbon_get_theme_option('___lift_remove_recent_drafts') ? true: false,
        'removeComment' => carbon_get_theme_option('___lift_remove_recent_comments') ? true: false,
    );
    new LIFTCleanUPS($attrs);
}