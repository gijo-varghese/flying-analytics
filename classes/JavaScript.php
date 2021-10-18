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

    if ($disable_tracking && current_user_can('contributor')) {
      return;
    }

    if ($ga_js_method == 'gtagv4') {
      $local_js = plugins_url('flying-analytics/assets/gtagv4.js');
      echo "<script>window.GA_ID='{$ga_tracking_id}'</script>";
      echo "<script src='{$local_js}' defer></script>";
      echo "<script>window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', '{$ga_tracking_id}');</script>";
    } elseif ($ga_js_method == 'gtag.js') {
      $local_js = plugins_url('flying-analytics/assets/gtag.js');
      $local_analytics_js = plugins_url('flying-analytics/assets/analytics.js');

      echo "<script>window.GA_ID='{$ga_tracking_id}';window.GA_URL='{$local_analytics_js}';</script>";
      echo "<script src='{$local_js}' defer></script>";
      echo "<script>window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', '{$ga_tracking_id}');</script>";
    } elseif ($ga_js_method == 'analytics.js') {
      $local_js = plugins_url('flying-analytics//assets/analytics.js');
      echo "<script>(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','{$local_js}','ga');ga('create','{$ga_tracking_id}','auto');ga('send','pageview');</script>";
    } elseif ($ga_js_method == 'minimal-analytics') {
      $local_js = plugins_url('flying-analytics/assets/minimal-analytics.js');
      echo "<script>window.GA_ID='{$ga_tracking_id}';</script>";
      echo "<script src='{$local_js}' defer></script>";
    } elseif ($ga_js_method == 'minimal-analytics-inlined') {
      echo '<script>(function(a,b,c){var d=a.history,e=document,f=navigator||{},g=localStorage,h=encodeURIComponent,i=d.pushState,k=function(){return Math.random().toString(36)},l=function(){return g.cid||(g.cid=k()),g.cid},m=function(r){var s=[];for(var t in r)r.hasOwnProperty(t)&&void 0!==r[t]&&s.push(h(t)+"="+h(r[t]));return s.join("&")},n=function(r,s,t,u,v,w,x){var z="https://www.google-analytics.com/collect",A=m({v:"1",ds:"web",aip:c.anonymizeIp?1:void 0,tid:b,cid:l(),t:r||"pageview",sd:c.colorDepth&&screen.colorDepth?screen.colorDepth+"-bits":void 0,dr:e.referrer||void 0,dt:e.title,dl:e.location.origin+e.location.pathname+e.location.search,ul:c.language?(f.language||"").toLowerCase():void 0,de:c.characterSet?e.characterSet:void 0,sr:c.screenSize?(a.screen||{}).width+"x"+(a.screen||{}).height:void 0,vp:c.screenSize&&a.visualViewport?(a.visualViewport||{}).width+"x"+(a.visualViewport||{}).height:void 0,ec:s||void 0,ea:t||void 0,el:u||void 0,ev:v||void 0,exd:w||void 0,exf:"undefined"!=typeof x&&!1==!!x?0:void 0});if(f.sendBeacon)f.sendBeacon(z,A);else{var y=new XMLHttpRequest;y.open("POST",z,!0),y.send(A)}};d.pushState=function(r){return"function"==typeof d.onpushstate&&d.onpushstate({state:r}),setTimeout(n,c.delay||10),i.apply(d,arguments)},n(),a.ma={trackEvent:function o(r,s,t,u){return n("event",r,s,t,u)},trackException:function q(r,s){return n("exception",null,null,null,null,r,s)}}})(window,"' .
        $ga_tracking_id .
        '",{anonymizeIp:!0,colorDepth:!0,characterSet:!0,screenSize:!0,language:!0})</script>';
    }
  }
}
