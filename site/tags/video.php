<?php

/**
 * This KirbyText is for display videos via the HTML5 video tag.
 * Support multi source, but at the moment only one file per file type.
 *
 * Install
 * =======
 * Move this file to /site/tags/ and rename it video.php
 * 
 * @author: Thomas Fanninger <thomas@fanninger.at>
 * @version: 0.3
 */

kirbytext::$tags['video'] = array(
  'attr' => array(
    'webm',
    'ogg',
    'mp4',
    'width',
    'height',
    'poster',
    'vidclass',
    'preload',
    'controls',
    'loop',
    'muted',
    'autoplay',
    'caption',
    'caption_top',
    'class'
  ),
  'html' => function($tag) {

    $file     = $tag->file($tag->attr('ogg'));
    $url_ogg  = ($file)?$file->url():$tag->attr('ogg');
    $file     = $tag->file($tag->attr('mp4'));
    $url_mp4  = ($file)?$file->url():$tag->attr('mp4');
    $file     = $tag->file($tag->attr('webm'));
    $url_webm = ($file)?$file->url():$tag->attr('webm');

    $file     = $tag->file($tag->attr('video'));
    if($file){
      switch($file->mime()){
        case 'video/webm':
          $url_webm = $file->url();
          break;
        case 'video/mp4':
          $url_mp4 = $file->url();
          break;
        case 'video/ogg':
          $url_ogg = $file->url();
          break;
      }
    }

    $file     = $tag->file($tag->attr('poster'));
    $poster   = ($file)?$file->url():$tag->attr('poster');

    $width     = $tag->attr('width', kirby()->option('kirbytext.video.width', 'auto'));
    $height    = $tag->attr('height', kirby()->option('kirbytext.video.height', 'auto'));
    $preload   = $tag->attr('preload', 'metadata');
    $controls  = $tag->attr('controls', true);
    $loop      = $tag->attr('loop', false);
    $muted     = $tag->attr('muted', false);
    $autoplay  = $tag->attr('autoplay', false);
    $vidclass  = $tag->attr('vidclass', kirby()->option('kirbytext.video.class', 'video'));

    $caption  = $tag->attr('caption');
    $caption_top = $tag->attr('caption_top', false);
    $class = $tag->attr('class');
    
    if($width == 'auto') {
      $width = '';
    }
    if($height == 'auto'){
      $height = '';
    }
    if($preload != 'auto' && $preload != 'metadata' && $preload != 'none'){
      $preload = '';
    }

    $args = array(
      'webm'     => $url_webm,
      'mp4'      => $url_mp4,
      'ogg'      => $url_ogg,
      'width'    => $width,
      'height'   => $height,
      'class'    => $vidclass,
      'poster'   => $poster,
      'preload'  => $preload,
      'controls' => $controls,
      'loop'     => $loop,
      'muted'    => $muted,
      'autoplay' => $autoplay
    );

    $video = snippet('video', $args, true);
    
    if($caption){
      $figure = new Brick('figure');
      $figure->addClass($tag->attr('class'));
      if($caption_top)
        $figure->append('<figcaption>' . html($caption) . '</figcaption>');
      $figure->append($video);
      if(!$caption_top)
        $figure->append('<figcaption>' . html($caption) . '</figcaption>');
      return $figure;
    }else{
      return $video;
    }
  }
);