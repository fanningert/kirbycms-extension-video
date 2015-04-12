<?php

namespace at\fanninger\kirby\extension\videoext;

/**
 *
 * @package VideoExt
 * @author Thomas Fanninger <thomas@fanninger.at>
 * @link https://github.com/fanningert/kirbycms-extension-video
 */
class VideoExt {
	
	/**
	 * **************************************************************************
	 */
	const SNIPPET_NAME = 'snippet_name';
	const VIDEO_WIDTH = 'width';
	const VIDEO_HEIGHT = 'height';
	const VIDEO_CLASS = 'class';
	const OPTION_PRELOAD = 'preload';
	const OPTION_CONTROLS = 'controls';
	const OPTION_LOOP = 'loop';
	const OPTION_MUTED = 'muted';
	const OPTION_AUTOPLAY = 'autoplay';
	const CAPTION = 'caption';
	const CAPTION_TOP = 'caption_top';
	const CAPTION_CLASS = 'caption_class';
	const SOURCES = 'sources';
	const POSTER = 'poster';
	
	/**
	 * **************************************************************************
	 */
	protected $page = null;
	protected $options = array (
			VideoExt::SNIPPET_NAME => null,
			VideoExt::VIDEO_WIDTH => null,
			VideoExt::VIDEO_HEIGHT => null,
			VideoExt::VIDEO_CLASS => 'video',
			VideoExt::OPTION_PRELOAD => false,
			VideoExt::OPTION_CONTROLS => true,
			VideoExt::OPTION_LOOP => false,
			VideoExt::OPTION_MUTED => false,
			VideoExt::OPTION_AUTOPLAY => false,
			VideoExt::CAPTION => null,
			VideoExt::CAPTION_TOP => false,
			VideoExt::CAPTION_CLASS => 'video',
			VideoExt::POSTER => null,
			VideoExt::SOURCES => array () 
	);
	
	/**
	 *
	 * @param \Page $page        	
	 */
	public function __construct(\Page $page) {
		$this->page = $page;
		
		// if ($this->page instanceof \Page) {
		// throw new VideoExtException ( VideoExtException::missing_page_object );
		// }
		
		$this->setOption ( VideoExt::SNIPPET_NAME, kirby ()->option ( 'kirby.extension.videoext.snippet_name', null ) );
		$this->setOption ( VideoExt::VIDEO_WIDTH, kirby ()->option ( 'kirby.extension.videoext.width', null ) );
		$this->setOption ( VideoExt::VIDEO_HEIGHT, kirby ()->option ( 'kirby.extension.videoext.height', null ) );
		$this->setOption ( VideoExt::VIDEO_CLASS, kirby ()->option ( 'kirby.extension.videoext.class', 'video' ) );
		$this->setOption ( VideoExt::OPTION_PRELOAD, kirby ()->option ( 'kirby.extension.videoext.preload', false ) );
		$this->setOption ( VideoExt::OPTION_CONTROLS, kirby ()->option ( 'kirby.extension.videoext.controls', true ) );
		$this->setOption ( VideoExt::OPTION_LOOP, kirby ()->option ( 'kirby.extension.videoext.loop', false ) );
		$this->setOption ( VideoExt::OPTION_MUTED, kirby ()->option ( 'kirby.extension.videoext.muted', false ) );
		$this->setOption ( VideoExt::OPTION_AUTOPLAY, kirby ()->option ( 'kirby.extension.videoext.autoplay', false ) );
		$this->setOption ( VideoExt::CAPTION, kirby ()->option ( 'kirby.extension.videoext.caption', null ) );
		$this->setOption ( VideoExt::CAPTION_TOP, kirby ()->option ( 'kirby.extension.videoext.caption_top', false ) );
		$this->setOption ( VideoExt::CAPTION_CLASS, kirby ()->option ( 'kirby.extension.videoext.caption_class', 'video' ) );
	}
	public function setOption($opt_name, $opt_value) {
		if (array_key_exists ( $opt_name, $this->options ))
			$this->options[$opt_name] = $opt_value;
		
		return $this;
	}
	public function getOption($opt_name) {
		if (array_key_exists ( $opt_name, $this->options )) {
			return $this->options [$opt_name];
		} else {
			throw new VideoExtException ( VideoExtException::unknown_option );
		}
	}
	
	/**
	 * Add a new Source
	 *
	 * @param string $video        	
	 * @param string $type        	
	 * @param string $media        	
	 * @return VideoExt
	 */
	public function addSource($video, $type = null, $media = null) {
		$this->options [VideoExt::SOURCES] [] = array (
				'src' => $video,
				'type' => $type,
				'media' => $media 
		);
		return $this;
	}
	
	/**
	 * Check if the caption should print at the top.
	 *
	 * @return boolean
	 */
	public function isCaptionTop() {
		return $this->getOption ( VideoExt::CAPTION_TOP );
	}
	
	/**
	 * Generate the HTML-Code of the video tag.
	 *
	 * @return string
	 */
	public function toHtml() {
		// Check if snippet set and snippet exist
		if ($this->getOption ( VideoExt::SNIPPET_NAME ) != null && file_exists ( $kirby->roots->snippets () . '/' . $this->getOption ( VideoExt::SNIPPET_NAME ) . '.php' )) {
			$snippet = ( string ) $this->getOption ( VideoExt::SNIPPET_NAME );
			return ( string ) snippet ( $snippet, $options, true );
		} else {
			// Create over BRICK
			$video = new \Brick ( 'video' );

			// Add options
			if($this->getOption(VideoExt::VIDEO_WIDTH) != null)
				$video->attr('width', $this->getOption(VideoExt::VIDEO_WIDTH));
			if ($this->getOption(VideoExt::VIDEO_HEIGHT) != null)
				$video->attr('width', $this->getOption(VideoExt::VIDEO_HEIGHT));
			if ($this->getOption(VideoExt::VIDEO_CLASS) != null)
				$video->addClass($this->getOption(VideoExt::VIDEO_CLASS));
			if ($this->getOption(VideoExt::OPTION_PRELOAD) != false)
				$video->attr('preload', $this->getOption(VideoExt::OPTION_PRELOAD));
			if ($this->getOption(VideoExt::OPTION_CONTROLS) == true)
				$video->attr('controls', 'controls');
			if ($this->getOption(VideoExt::OPTION_LOOP) == true)
				$video->attr('loop', 'loop');
			if ($this->getOption(VideoExt::OPTION_MUTED) == true)
				$video->attr('muted', 'muted');
			
			//Add Sources
			foreach ( $this->options [VideoExt::SOURCES] as $source ) {
				$video_source = new \Brick ( 'source' );
				$video_source->attr ( 'src', $source ['src'] );
				if ($source ['type'] != null)
					$video_source->attr ( 'type', $source ['type'] );
				if ($source ['media'] != null)
					$video_source->attr ( 'media', $source ['media'] );
				$video->append($video_source);
			}
			
			//Add optional caption
			$figure_caption = '';
			if ($this->getOption ( VideoExt::CAPTION ) != null) {
				$caption = ( string ) $this->convert ( $this->getOption ( VideoExt::CAPTION ) );
				$figure_caption = new \Brick ( 'figcaption', $caption );
			}
			
			if ($this->getOption ( VideoExt::CAPTION ) != null) {
				$figure = new \Brick ( 'figure' );
				if ($this->getOption ( VideoExt::CAPTION_CLASS ) != null)
					$figure->addClass ( $this->getOption ( VideoExt::CAPTION_CLASS ) );
				if ($this->isCaptionTop () && ! empty ( $figure_caption ))
					$figure->append ( $figure_caption );
				$figure->append ( $video );
				if (! $this->isCaptionTop () && ! empty ( $figure_caption ))
					$figure->append ( $figure_caption );
				
				return ( string ) $figure->toString ();
			} else {
				return ( string ) $video->toString ();
			}
		}
	}
	
	/**
	 * Overwrite of the super method
	 */
	public function __toString() {
		$this->toHtml ();
	}
	
	/**
	 * Replace not allowed character in the text with replacements.
	 *
	 * @param string $text        	
	 * @return string
	 */
	protected function convert($text) {
		return ( string ) htmlentities ( $text );
	}
	
	/**
	 * This static method is executed by kirbytag method.
	 *
	 * @param unknown $tag        	
	 * @return string Generated HTML-Code for the HTML5-Video-KirbyTag
	 */
	public static function executeTag($tag) {
		try {
			$videoext = new VideoExt ( $tag->page () );

			foreach(\kirbytext::$tags['videoext']['attr'] as $name) {
				if( !empty($value = $tag->attr($name)) )
					$videoext->setOption ( $name, $value );
			}
			
			// Sources
			$file = $tag->file ( $tag->attr ( 'ogg' ) );
			$url_ogg = ($file) ? $file->url () : $tag->attr ( 'ogg' );
			$file = $tag->file ( $tag->attr ( 'mp4' ) );
			$url_mp4 = ($file) ? $file->url () : $tag->attr ( 'mp4' );
			$file = $tag->file ( $tag->attr ( 'webm' ) );
			$url_webm = ($file) ? $file->url () : $tag->attr ( 'webm' );
			
			if ( !empty($url_ogg) )
				$videoext->addSource ( $url_ogg, 'video/ogg' );
			if ( !empty($url_mp4) )
				$videoext->addSource ( $url_mp4, 'video/mp4' );
			if ( !empty($url_webm) )
				$videoext->addSource ( $url_webm, 'video/webm' );
			
			return $videoext->toHtml ();
		} catch ( VideoExtException $e ) {
			echo 'Exception: ', $e->getMessage (), "\n";
		}
	}
}

/**
 *
 * @package VideoExt
 * @author Thomas Fanninger <thomas@fanninger.at>
 * @link https://github.com/fanningert/kirbycms-extension-video
 */
class VideoExtException extends \Exception {
	const unknown_option = 1;
	const missing_page_object = 2;
	public function __construct($code, $message = null, $previous = null) {
		$this->code = $code;
		
		if ($message == null)
			$message = $this->generateMessageForCode ();
		
		parent::__construct ( $message, $code, $previous );
	}
	public function __toString() {
	}
	private function generateMessageForCode() {
		switch ($this->code) {
			case 2 :
				return 'Missing page object';
			case 1 :
				return 'Unknown option';
			default :
				return 'Unknown error';
		}
	}
	public function toHtml() {
	}
}