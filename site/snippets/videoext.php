<?php

/**
 * Snippet example
 * 
 * @package VideoExt
 * @author Thomas Fanninger <thomas@fanninger.at>
 * @link https://github.com/fanningert/kirbycms-extension-video
 */

?>
<?php 
if ( $caption != null ):
?>
<figure<?php echo (!empty($caption_class))?' class="'.$caption_class.'"':''; ?>>
<?php 
if ( $caption_top == true ):
?>
<figcaption><?php  echo $caption; ?></figcaption>
<?php
endif;
?>
<?php
endif;
?>
<video<?php echo (!empty($width))?' width="'.$width.'"':''; ?><?php echo (!empty($height))?' height="'.$height.'"':''; ?><?php echo (!empty($preload))?' preload="'.$preload.'"':''; ?><?php echo ($controls)?' controls="controls"':''; ?><?php echo ($loop)?' loop="loop"':''; ?><?php echo ($autoplay)?' autoplay="autoplay"':''; ?><?php echo ($muted)?' muted="muted"':''; ?><?php echo (!empty($poster))?' poster="'.$poster.'"':''; ?><?php echo (!empty($class))?' class="'.$class.'"':''; ?>>
<?php foreach ($sources as $source): ?>
	<source src="<?php echo $source['src']; ?>" <?php echo ($source[type] != null)? 'type="'.$source[type].'"':''; ?> <?php echo ($source[media] != null)? 'media="'.$source[media].'"':''; ?>/>
<?php endforeach; ?>
  Your browser does not support the <code>video</code> element.
</video>
<?php 
if ( $caption != null ):
?>
<?php 
if ( $caption_top != true ):
?>
<figcaption><?php  echo $caption; ?></figcaption>
<?php
endif;
?>
</figure>
<?php
endif;
?>