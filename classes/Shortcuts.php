<?php
namespace FlyingAnalytics;

class Shortcuts
{
  public static function init()
  {
    add_filter('plugin_action_links_flying-analytics/index.php', [
      'FlyingAnalytics\Shortcuts',
      'add_shortcuts',
    ]);
  }

  public static function add_shortcuts($links)
  {
    $settings_url = admin_url('options-general.php?page=flying_analytics');
    $plugin_shortcuts[] = "<a href='$settings_url'>Settings</a>";

    if (!defined('FLYING_PRESS_VERSION')) {
      $plugin_shortcuts[] =
        '<a href="https://flying-press.com?ref=flying_analytics" target="_blank" style="color:#3db634;">Get FlyingPress</a>';
    }

    return array_merge($links, $plugin_shortcuts);
  }
}
