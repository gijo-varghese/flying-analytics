<?php
namespace FlyingAnalytics;

class JavaScript
{
  public static function init()
  {
    add_action('wp_print_footer_scripts', ['FlyingAnalytics\JavaScript', 'inject_js']);
  }

  public static function inject_js()
  {
    $ga_tracking_id =
      rwmb_meta('ga_tracking_id', ['object_type' => 'setting'], 'flying_analytics') ?:
      get_option('flying_analytics_id');

    $ga_js_method =
      rwmb_meta('ga_js_method', ['object_type' => 'setting'], 'flying_analytics') ?:
      get_option('flying_analytics_method');

    $disable_tracking = rwmb_meta(
      'disable_tracking',
      ['object_type' => 'setting'],
      'flying_analytics'
    );

    if ($disable_tracking && current_user_can('edit_posts')) {
      return;
    }

    if ($ga_js_method == 'gtagv4') {
      $local_js = plugins_url('flying-analytics/assets/gtagv4.js');
      echo "<script>window.GA_ID='{$ga_tracking_id}'</script>";
      echo "<script src='{$local_js}' defer></script>";
      echo "<script>window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', '{$ga_tracking_id}');</script>";
    } else {
      $local_js = plugins_url('flying-analytics/assets/minimal-ga4.js');
      echo "<script>window.minimalAnalytics={trackingId:'$ga_tracking_id',autoTrack:true}</script>";
      echo "<script src='{$local_js}' defer></script>";
    }
  }
}