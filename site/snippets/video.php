<?php

/**
 *
 * Install
 * =======
 * Move this file to /site/snippets/ and rename it video.php
 * 
 * @author: Thomas Fanninger <thomas@fanninger.at>
 * @version: 0.3
 */

?>

<video<?php echo (!empty($width))?' width="'.$width.'"':''; ?><?php echo (!empty($height))?' height="'.$height.'"':''; ?><?php echo (!empty($preload))?' preload="'.$preload.'"':''; ?><?php echo ($controls)?' controls="constrols"':''; ?><?php echo ($loop)?' loop="loop"':''; ?><?php echo ($autoplay)?' autoplay="autoplay"':''; ?><?php echo ($muted)?' muted="muted"':''; ?><?php echo (!empty($poster))?' poster="'.$poster.'"':''; ?><?php echo (!empty($class))?' class="'.$class.'"':''; ?>>
  <?php if(!empty($webm)) { ?>
  <source src="<?php echo $webm; ?>" type="video/webm"/>
  <?php } ?>
  <?php if(!empty($mp4)){ ?>
  <source src="<?php echo $mp4; ?>" type="video/mp4"/>
  <?php } ?>
  <?php if(!empty($ogg)){ ?>
  <source src="<?php echo $ogg; ?>" type="video/ogg"/>
  <?php } ?>
  Your browser does not support the <code>video</code> element.
</video>