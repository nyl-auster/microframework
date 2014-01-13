<?php
namespace okc\server\resources;

use okc\resource\resource;

class homepage extends resource {

  function get() {
    $out = '<style>';
    $out .= '*{padding : 0; margin : 0;}';
    $out .= 'body {color : #DDD; background-color : #111; text-align : center; padding-top : 50px; font-size : 35px;}';
    $out .= 'strong {color : orange;}';
    $out .= '</style>';
    $out .= '<html>';
    $out .= '<body>';
    $out .= 'Hello ! <br/><br/>';
    $out .= 'Please <em>copy</em> <strong>example.app</strong> directory to <strong>app</strong> to install and start coding.<br />';
    $out .= 'Then come back here and refresh this page.';
    $out .= '</body>';
    $out .= '</html>';
    return $out;
  }

}

