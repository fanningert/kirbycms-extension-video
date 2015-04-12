<?php

/**
 * This KirbyText is for display videos via the HTML5 video tag.
 * Support multi source, but at the moment only one file per file type.
 *
 * Install
 * =======
 * Move this file to /site/tags/ and rename it video.php
 * 
 * @package VideoExt
 * @author Thomas Fanninger <thomas@fanninger.at>
 * @link https://github.com/fanningert/kirbycms-extension-video
 */

kirbytext::$tags['videoext'] = array(
		'attr' => array(
				'webm',
				'ogg',
				'mp4',
				'width',
				'height',
				'poster',
				'class',
				'preload',
				'controls',
				'loop',
				'muted',
				'autoplay',
				'caption',
				'caption_top',
				'caption_class',
				'snippet_name'
		),
		'html' => function($tag) {
			return \at\fanninger\kirby\extension\videoext\VideoExt::executeTag( $tag );
		}
);

if ( kirby()->option('kirby.extension.videoext.video_tag') == true ) {
	kirbytext::$tags['video'] = array(
		'attr' => array(
				'webm',
				'ogg',
				'mp4',
				'width',
				'height',
				'poster',
				'class',
				'preload',
				'controls',
				'loop',
				'muted',
				'autoplay',
				'caption',
				'caption_top',
				'caption_class',
				'snippet_name'
		),
		'html' => function($tag) {
			return \at\fanninger\kirby\extension\videoext\VideoExt::executeTag( $tag );
		}
	);
}