<?php
/**
 * Plugin Name:       Disable All Updates
 * Plugin URI:        https://github.com/JahanCodeWizard/WordPress-Complete-Update-Disabler
 * Description:       Completely disables WordPress core, plugin, theme and translation updates (automatic + manual checks + notifications) when this plugin is active.
 * Version:           1.1.0
 * Requires at least: 6.0
 * Requires PHP:      8.0
 * Author:            JahanCodeWizard
 * License:           ----- Custom -----
 * Text Domain:       disable-all-updates
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


// ===== ===== (1) Disable AUTOMATIC background updates ===== =====

add_filter( 'automatic_updater_disabled', '__return_true' );

// kill auto-updates for plugins & themes (WP 5.5+)
add_filter( 'auto_update_plugin', '__return_false' );
add_filter( 'auto_update_theme',   '__return_false' );

// Extra safety for very old behaviour - SaftyNet
add_filter( 'auto_update_core',    '__return_false' );


// ===== ===== (2) Disable UPDATE CHECKS and remove notifications ===== =====
// clears the update transients completely

add_filter( 'pre_set_site_transient_update_core',    function( $value ) {
    if ( is_object( $value ) ) {
        $value->updates = [];
        $value->response = [];
        $value->no_update = [];
        $value->last_checked = time();
    }
    return $value;
}, 9999 );

add_filter( 'pre_set_site_transient_update_plugins', function( $value ) {
    if ( is_object( $value ) ) {
        $value->response = [];
        $value->no_update = [];
        $value->last_checked = time();
    }
    return $value;
}, 9999 );

add_filter( 'pre_set_site_transient_update_themes',  function( $value ) {
    if ( is_object( $value ) ) {
        $value->response = [];
        $value->no_update = [];
        $value->last_checked = time();
    }
    return $value;
}, 9999 );


// Disable translation (language pack) checks
add_filter( 'site_transient_update_core', function( $value ) {
    if ( is_object( $value ) && isset( $value->translations ) ) {
        $value->translations = [];
    }
    return $value;
}, 9999 );

?>
