<?php

/*
    Menu Structure #Menu Structure
    Default: bottom of menu structure #Default: bottom of menu structure

    2 – Dashboard
    4 – Separator
    5 – Posts
    10 – Media
    15 – Links
    20 – Pages
    25 – Comments
    59 – Separator
    60 – Appearance
    65 – Plugins
    70 – Users
    75 – Tools
    80 – Settings
    99 – Separator
 * 
 * 
 * 
    To add a menu item under posts use          add_posts_page
    To add a menu item under pages use          add_pages_page
    To add a menu item under media use          add_media_page
    To add a menu item under links use          add_links_page
    To add a menu item under comments use       add_comments_page
    To add a menu item under appearance use     add_theme_page
    To add a menu item under plugins use        add_plugin_page
    To add a menu item under users use          add_users_page
    To add a menu item under tools use          add_management_page
    To add a menu item under settings use       add_options_page


 *  */

class custom_menu_page {

    public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_menu_page' ) );
    }

    public function add_menu_page() {
        add_menu_page( 
            __( 'Custom menu page', 'textdomain' ),                    //$page_title (string) (Required) The text to be displayed in the title tags of the page when the menu is selected.
            __( 'Custom Menu Page', 'textdomain' ),                    //$menu_title (string) (Required) The text to be used for the menu.
            'manage_options',                                          //$capability (string) (Required) The capability required for this menu to be displayed to the user.
            'custom_menu_page',                                        //$menu_slug (string) (Required) The slug name to refer to this menu by. Should be unique for this menu page and only include lowercase alphanumeric, dashes, and underscores characters to be compatible with sanitize_key().
            array($this,'custom_menu_page_callback'),                  //$function (callable) (Optional) The function to be called to output the content for this page. Default value: ''
            'dashicons-tickets',                                       //$icon_url (string) (Optional) The URL to the icon to be used for this menu.
            81                                                         //$position (int) (Optional) The position in the menu order this one should appear. Default value: null
        );
        
        add_submenu_page(
            'custom_menu_page',  //parent $menu_slug
            __( 'Custom submenu page', 'textdomain' ),
            __( 'Custom Submenu Page', 'textdomain' ),
            'manage_options',
            'custom-submenu-page',
            array($this,'custom_submenu_page_callback')
        );
    }
    
    public function custom_menu_page_callback(){
        ?>
            <div class="wrap">
                <h2>Custom Menu Page</h2>
            </div>
        <?php
    }
    
    public function custom_submenu_page_callback(){
        ?>
            <div class="wrap">
                <h2>Custom Submenu Page</h2>
            </div>
        <?php
    }
}

new custom_menu_page();