<?php
namespace ffmpeg\options;

class Audio extends Option
{


    /**
     * -aframes number (output)
     * 设置 number 音频帧输出，是 -frames:a 的别名
     *
     * @param  string $number
     * @return $this
     */
    public function aframes($number) {
        $this->addOption("-aframes", $number);
        return $this;
    }

    /**
     * -ar[:stream_specifier] freq (input/output,per-stream)
     * 设置音频采样率。默认是输出同于输入。
     * 对于输入进行设置，仅仅通道是真实的设备或者raw数据分离出并映射的通道才有效。
     * 对于输出 则可以强制设置音频量化的采用率。
     *
     * @param string $freq
     * @param string $stream_specifier
     * @return $this
     */
    public function pix_fmt($freq, $stream_specifier = null) {
        $this->addOption("-ar".$this->spcifier($stream_specifier), $freq);
        return $this;
    }

    /**
     * -aq q (output)
     * 设置音频品质(编码指定为VBR)，它是 -q:a 的别名。
     *
     * @param  string $q
     * @return $this
     */
    public function aq($q) {
        $this->addOption("-aq", $q);
        return $this;
    }

    /**
     * -ac[:stream_specifier] channels (input/output,per-stream)
     * 设置音频通道数。
     * 默认输出会有输入 相同的音频通道。
     * 对于输入进行设置，仅仅通道是真实的设备或者raw数据分离出并映射的通道 才有效。
     *
     * @param string $channels
     * @param string $stream_specifier
     * @return $this
     */
    public function ac($channels, $stream_specifier = null) {
        $this->addOption("-ac".$this->spcifier($stream_specifier), $channels);
        return $this;
    }

    /**
     * -an (input/output)
     * 禁止输出音频
     *
     * @return $this
     */
    public function an() {
        $this->addOption("-an");
        return $this;
    }

    /**
     * -acodec codec (input/output)
     * 设置音频解码/编码的编/解码器，是 -codec:a 的别名
     *
     * @param  string $codec
     * @return $this
     */
    public function acodec($codec) {
        $this->addOption("-acodec", $codec);
        return $this;
    }


    /**
     * -sample_fmt[:stream_specifier] sample_fmt (output,per-stream)
     * 设置音频样例格式。使用 -sample_fmts 可以获取所有支持的样例格式。
     *
     * @param string $sample_fmt
     * @param string $stream_specifier
     * @return $this
     */
    public function sample_fmt($sample_fmt, $stream_specifier = null) {
        $this->addOption("-sample_fmt".$this->spcifier($stream_specifier), $sample_fmt);
        return $this;
    }

    /**
     * -af filtergraph (output)
     * 对音频使用 filtergraph 滤镜效果，其是 -filter:a 的别名，参考 - filter 选项。
     *
     * @param  string $filtergraph
     * @return $this
     */
    public function af($filtergraph) {
        $this->addOption("-af", $filtergraph);
        return $this;
    }




}