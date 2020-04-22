<?php
/*
 * @package TorchlightPlugin
 */

if(!defined('WP_UNINSTALL_PLUGIN')){
    die();
}

$affinities = get_posts(['post_type' => 'affinity', 'numberposts' => -1]);

foreach ($affinities as $affinity) {
    wp_delete_post($affinity->ID, true);
}

global $wpdb;
$wpdb->query("DELETE FROM wp_posts WHERE post_type = 'affinity'");
$wpdb->query( "DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)");
$wpdb->query( "DELETE FROM wp_term_relationships WHERE object_id NOT IN (SELECT id FROM wp_posts)" );