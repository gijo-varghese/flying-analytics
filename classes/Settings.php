<?php
namespace FlyingAnalytics;

class Settings
{
  public static function init()
  {
    add_filter('mb_settings_pages', ['FlyingAnalytics\Settings', 'add_settings_page']);
    add_filter('rwmb_meta_boxes', ['FlyingAnalytics\Settings', 'add_tabs']);
  }

  public static function add_settings_page($pages)
  {
    $pages[] = [
      'id' => 'flying_analytics',
      'menu_title' => 'Flying Analytics',
      'option_name' => 'flying_analytics',
      'parent' => 'options-general.php',
      'position' => 25,
      'style' => 'no-boxes',
      'columns' => 2,
    ];
    return $pages;
  }

  public static function add_tabs($tabs)
  {
    $tabs[] = [
      'id' => 'settings',
      'settings_pages' => 'flying_analytics',
      'columns' => 2,
      'fields' => [
        [
          'id' => 'ga_tracking_id',
          'name' => 'Google Analytics Tracking ID',
          'size' => 20,
          'desc' =>
            '<a href="https://support.google.com/analytics/thread/13109681?hl=en" target="_blank">Where to find tracking ID?</a>',
          'type' => 'text',
          'std' => get_option('flying_analytics_id') ?: '',
          'required' => true,
        ],
        [
          'id' => 'ga_js_method',
          'name' => 'JavaScript Method',
          'type' => 'radio',
          'size' => 20,
          'options' => [
            'gtagv4' => 'Google Analytics v4 (91 KB)',
            'minimal-analytics' => 'Minimal Google Analytics v4 (7 KB)',
          ],
          'std' => get_option('flying_analytics_method') ?: 'gtag.js',
          'inline' => false,
        ],
        [
          'size' => 20,
          'id' => 'disable_tracking',
          'name' => 'Disable Tracking for Admins',
          'type' => 'switch',
          'std' => 1,
        ],
        [
          'type' => 'custom_html',
          'std' => '<h4>
            Need a more faster website? Get 
            <a href="https://flying-press.com/?ref=flying_analytics" target="_blank" style="color:#4b60dc">FlyingPress</a>.
            Also check out our  
            <a href="https://profiles.wordpress.org/gijo/#content-plugins" target="_blank">free plugins</a>.
            </h4>',
        ],
      ],
    ];

    return $tabs;
  }
}