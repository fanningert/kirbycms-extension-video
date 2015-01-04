# KirbyText Extension - Video

*Version:* 0.3

Display a video via the HTML5 video tag.

**IMPORTANT:** In the current version of Kirby (2.0.5) is a bug. So every file with a extension that has a number and a upper case letter can not be found. Here the [issue](https://github.com/getkirby/kirby/issues/158) on GitHub.

## Options

* *webm*: Name of a page file or absolute URL of a external file
* *ogg*: Name of a page file or absolute URL of a external file
* *mp4*: Name of a page file or absolute URL of a external file
* *width*: (optional, Default: "kirbytext.video.width" or auto) Sets the height of the video player
* *height*: (optional, Default: "kirbytext.video.height" or auto) Sets the width of the video player
* *poster*: (optional) Name of a page file or absolute URL of a external file
* *vidclass*: (optional, Default: "kirbytext.video.class" or "video") Define a class string for the video element
* *preload*: (optional, Values: none/metadata/auto) The preload attribute specifies if and how the author thinks that the video should be loaded when the page loads. 
* *controls*: (optional, Values: true/false, Default: true) Specifies that video controls should be displayed (such as a play/pause button etc).
* *loop*: (optional, Values: true/false, Default: false) Specifies that the video will start over again, every time it is finished
* *muted*: (optional, Values: true/false, Default: false) Specifies that the audio output of the video should be muted
* *autoplay*: (optional, Values: true/false, Default: false) Specifies that the video will start playing as soon as it is ready.
* *caption*: (optional) Create a figure with a caption element over the video tag
* *caption_top*: (optional, Values: true/false, Default: false) Place the caption at the top of the video player
* *class*: (optional) Class string for the figure element

## Examples

### with files of the page

```
(video: mp4: big_buck_bunny.mp4 ogg: big_buck_bunny.ogv webm: big_buck_bunny.webm)
```

### with external urls

```
(video: mp4: http://www.quirksmode.org/html5/videos/big_buck_bunny.mp4 webm: http://www.quirksmode.org/html5/videos/big_buck_bunny.webm ogg: http://www.quirksmode.org/html5/videos/big_buck_bunny.ogv)
```