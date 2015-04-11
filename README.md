# Kirby Extension - VideoExt

*Version:* 1.1

This plugin adds a new `video` and `videoext` Kirbytext tag which enables you to embed your video clips easily and HTML5 compatible.

**Attention:** In this version I changed the used custom config variable for a better usage with other extension and kirby. Also the default kirbytext tag is now `videoext` but you can reactivate the `video` tag support via config variables.

**Info:** When you don't use the snipped, you get a wrong HTML code. This is a existend bug of kirby in version 2.0.6. In the current develop version is this bug corrected. https://github.com/getkirby/kirby/issues/226

## KirbyText options

| Option | Optional | Description |
| ------ | -------- | ----------- |
| `webm` | X | Name of a page file or absolute URL of a external file |
| `ogg` | X | Name of a page file or absolute URL of a external file |
| `mp4` | X | Name of a page file or absolute URL of a external file |
| `width` | X | see config variable `kirby.extension.videoext.width`|
| `height` | X | see config variable `kirby.extension.videoext.height` |
| `poster` | X | Name of a page file or absolute URL of a external file |
| `class` | X | see config variable `kirby.extension.videoext.vidclass` |
| `preload` | X | see config variable `kirby.extension.videoext.preload` |
| `controls` | X | see config variable `kirby.extension.videoext.controls` |
| `loop` | X | see config variable `kirby.extension.videoext.loop` |
| `muted` | X | see config variable `kirby.extension.videoext.muted` |
| `autoplay` | X | see config variable `kirby.extension.videoext.autoplay` |
| `caption` | X | see config variable `kirby.extension.videoext.caption` |
| `caption_top` | X | see config variable `kirby.extension.videoext.caption_top` |
| `caption_class` | X | see config variable `kirby.extension.videoext.caption_class` |
| `snippet_name` | X | see config variable `kirby.extension.videoext.snippet_name` |

## Config variables

| Kirby option | Default | Values | Description |
| ------------ | ------- | ------ | ----------- |
| `kirby.extension.videoext.snippet_name` | null | null/{string} | Set the name of the snippet (example `videoext`), or false. With the false false, the script generate via Brick class the HTML code. |
| `kirby.extension.videoext.width` | null | null/{number} | Sets the width of the video player. When `null` is select, the script read the `kirbytext.video.width` value, or set it to `auto`. |
| `kirby.extension.videoext.height` | null | null/{number} | Sets the height of the video player. When `null` is select, the script read the `kirbytext.video.height` value, or set it to `auto`. |
| `kirby.extension.videoext.class` | `video` | false/{string} | Define a class string for the video element. When `false` is select, the script read the `kirbytext.video.class` value. |
| `kirby.extension.videoext.preload` | false | false/none/metadata/auto | The preload attribute specifies if and how the author thinks that the video should be loaded when the page loads. |
| `kirby.extension.videoext.controls` | true | true/false | Specifies that video controls should be displayed (such as a play/pause button etc). |
| `kirby.extension.videoext.loop` | false | true/false | Specifies that the video will start over again, every time it is finished. |
| `kirby.extension.videoext.muted` | false | true/false | Specifies that the audio output of the video should be muted. |
| `kirby.extension.videoext.autoplay` | false | true/false | Specifies that the video will start playing as soon as it is ready. |
| `kirby.extension.videoext.caption` | null | null/{string} | Create a figure with a caption element over the video tag. |
| `kirby.extension.videoext.caption_top` | false | true/false | Place the caption at the top of the video player. |
| `kirby.extension.videoext.caption_class` | `video` | {string} | Class string for the figure element. |
| `kirby.extension.videoext.video_tag` | false | true/false | Overwrite the default `video` kirbytext tag |


## Hint to convert a video file into different file formats

Thanks goes to https://github.com/derhuerst for this script.

```bash
#!/bin/bash
 
# This script takes any (high resolution) video file as input and converts it to WebM (VP8 & Vorbis) and MP4 (H264 & AAC) for HTML5 <video>. For each format, it creates a high quality (`-hq`) and a low quality (`-lq`) version.
# ffmpeg has to be installed, see http://docs.sublimevideo.net/encode-videos-for-the-web for more instructions.
# Usage: videoToWeb.sh <inputfile>
 
# This is heavily inspired by
# - https://github.com/kornl/video-conversion/blob/master/convert_video_for_html_5.sh
# - https://github.com/mickro/video2html5/blob/master/video2html5.sh
# - http://diveintohtml5.info/video.html#webm-cli
 
 
file=`basename $1`
file="${file%.*}"
 
# low quality MP4
ffmpeg -i $1 -acodec libfaac -vcodec libx264 -vb 2000k -vf scale=iw/2:ih/2 -f mp4 $file.lq.mp4
# high quality MP4
ffmpeg -i $1 -acodec libfaac -vcodec libx264 -vb 8000k -f mp4 $file.hq.mp4
 
# low quality WebM
ffmpeg -i $1 -acodec libvorbis -vcodec libvpx -vb 2000k -vf scale=iw/2:ih/2 -f webm $file.lq.webm
# high quality WebM
ffmpeg -i $1 -acodec libvorbis -vcodec libvpx -vb 8000k -f webm $file.hq.webm

# low quality OGV
ffmpeg -i $1 -acodec libvorbis -vcodec libtheora -vb 2000k -vf scale=iw/2:ih/2 -f ogv $file.lq.ogv
# high quality OGV
ffmpeg -i $1 -acodec libvorbis -vcodec libtheora -vb 8000k -f ogv $file.hq.ogv
```

## Examples

### with files of the page

```
(videoext: mp4: big_buck_bunny.mp4 ogg: big_buck_bunny.ogv webm: big_buck_bunny.webm)
```

### with external urls

```
(videoext: mp4: http://www.quirksmode.org/html5/videos/big_buck_bunny.mp4 webm: http://www.quirksmode.org/html5/videos/big_buck_bunny.webm ogg: http://www.quirksmode.org/html5/videos/big_buck_bunny.ogv)
```

### Deactivate the default video tag

Insert the config line `c::set('kirby.extension.videoext.video_tag', true);` into to the `config.php`. At this momenten the `video` tag will also supported, with the same parameters like the `videoext` tag.

## Changelog

## v1.1

* Change the default value of `kirby.extension.videoext.video_tag` from `false` to `true`.

## v1.0

* Changed the used the default kirbytext tag from `video` to `videoext`. It's is possible to reactivate the `video` tag support.
* Changed the name of theis extension from "Video" to "VideoExt". "VideoExt" stands for "Video Extended".
* Changed the used custom config variable for a better usage with other extension and kirby.
* Moved the used code into a custom class for better reusage in themes and other extension.
* Some Options and there values are changed.

## v0.3

* Initial release