<?php
namespace ffmpeg\options;

class Video extends Option
{

    /**
     * -vframes number (output)
     * 设置输出文件的帧数，是 -frames:v 的别名。
     *
     * @param int $number
     * @return $this
     */
    public function vframes($number) {
        $this->addOption("-vframes", $number);
        return $this;
    }

    /**
     * -r[:stream_specifier] fps (input/output,per-stream)
     * 设置帧率（一种Hz值，缩写或者分数 值）。
     * 在作为输入选项时，会忽略文件中存储的时间戳和时间戳而产生的假设恒定帧率 fps ，即强制 按设定帧率处理视频产生（快进/减缓效果）。
     * 这不像 -framerate 选项是用来让一些输入文件格 式如image2或者v412(兼容旧版本的FFmpeg)等，要注意这一点区别，而不要造成混淆。
     * 作为输出选项时，会复制或者丢弃输入中个别的帧以满足设定达到 fps 要求的帧率。
     *
     *
     * @param string $fps
     * @param string $stream_specifier
     * @return $this
     */
    public function r($fps, $stream_specifier = null) {
        $this->addOption("-r".$this->spcifier($stream_specifier), $fps);
        return $this;
    }

    /**
     * -s[:stream_specifier] size (input/output,per-stream)
     * 设置帧的尺寸。
     * 当作为输入选项时，是私有选项 video_size 的缩写，一些文件没有把帧尺寸进行存储，或者设 备对帧尺寸是可以设置的，例如一些采集卡或者raw视频数据。
     * 当作为输出选项是，则相当于 scale 滤镜作用在滤镜链图的最后。
     * 请使用 scale 滤镜插入到 开始或者其他地方。
     * 数据的格式是 wxh ，即 宽度值X高度值 ，例如 320x240 ，（默认同源尺寸）
     *
     * @param int $size
     * @param string $stream_specifier
     * @return $this
     */
    public function s($size, $stream_specifier = null) {
        $this->addOption("-s".$this->spcifier($stream_specifier), $size);
        return $this;
    }

    /**
     * -aspect[:stream_specifier] aspect (output,per-stream)
     * 指定视频的纵横比（长宽显示比 例）。
     * aspect 是一个浮点数字符串或者 num:den 格式字符串(其值就是num/den)，例 如”4:3”,”16:9”,”1.3333”以及”1.7777”都是常用参数值。
     * 如果还同时使用了 -vcodec copy 选项，它将只影响容器级的长宽比，而不是存储在编码中的帧 纵横比。
     *
     * @param string $aspect
     * @param string $stream_specifier
     * @return $this
     */
    public function aspect($aspect, $stream_specifier = null) {
        $this->addOption("-aspect".$this->spcifier($stream_specifier), $aspect);
        return $this;
    }

    /**
     * -vn (input/output)
     * 禁止输出视频
     *
     * @return $this
     */
    public function vn() {
        $this->addOption("-vn");
        return $this;
    }

    /**
     * -vcodec codec (output)
     * 设置视频编码器，这是 -codec:v 的一个别名。
     *
     * @param string $codec
     * @return $this
     */
    public function vcodec($codec) {
        $this->addOption("-vcodec", $codec);
        return $this;
    }

    /**
     * -pass[:stream_specifier] n (output,per-stream)
     * 选择当前编码数(1或者2)，它通常用于2次视 频编码的场景。
     * 第一次编码通常把分析统计数据记录到1个日志文件中（参考 -passlogfile 选 项），然后在第二次编码时读取分析以精确要求码率。
     * 在第一次编码时通常可以禁止音频，并且 把输出文件设置为 null ，在windows和类unix分别是:
     * ffmpeg -i foo.mov -c:v libxvid -pass 1 -an -f rawvideo -y NUL
     * ffmpeg -i foo.mov -c:v libxvid -pass 1 -an -f rawvideo -y /dev/null
     *
     * @param string $n
     * @param string $stream_specifier
     * @return $this
     */
    public function pass($n, $stream_specifier = null) {
        $this->addOption("-pass".$this->spcifier($stream_specifier), $n);
        return $this;
    }

    /**
     * -passlogfile[:stream_specifier] prefix (output,per-stream)
     * 设置2次编码模式下日志文件存储 文件前导，默认是”ffmepg2pass”，
     * 则完整的文件名就是”PREFIX-N.log”，其中的N是指定的 输出流序号（对多流输出情况）
     *
     * @param string $prefix
     * @param string $stream_specifier
     * @return $this
     */
    public function passlogfile($prefix, $stream_specifier = null) {
        $this->addOption("-passlogfile".$this->spcifier($stream_specifier), $prefix);
        return $this;
    }

    /**
     * -vf filtergraph (output)
     * 创建一个 filtergraph 的滤镜链并作用在流上。它实为 -filter:v 的 别名，详细参考 -filter 选项。
     *
     * @param string $filtergraph
     * @return $this
     */
    public function vfilter($filtergraph) {
        $this->addOption("-vf", $filtergraph);
        return $this;
    }
}