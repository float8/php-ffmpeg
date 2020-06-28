<?php
namespace ffmpeg\options;

class Subtitle extends Option
{
    /**
     * -scodec codec (input/output)
     * 设置字幕解码器，是 -codec:s 的别名。
     *
     * @param  string $codec
     * @return $this
     */
    public function atag($codec) {
        $this->addOption("-scodec", $codec);
        return $this;
    }

    /**
     * -sn (input/output)

     * 禁止输出字幕
     *
     * @param  string $sn
     * @return $this
     */
    public function sn($sn) {
        $this->addOption("-sn", $sn);
        return $this;
    }

    /**
     * -sbsf bitstream_filter
     * 深入了解请参考 -bsf
     *
     * @param  string $bitstream_filter
     * @return $this
     */
    public function sbsf($bitstream_filter) {
        $this->addOption("-sbsf", $bitstream_filter);
        return $this;
    }

}