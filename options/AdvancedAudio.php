<?php
namespace ffmpeg\options;

class AdvancedAudio extends Option
{

    /**
     * -atag fourcc/tag (output)
     * 强制音频标签/fourcc。这个是 -tag:a 的别名。
     *
     * @param  string $fourcc
     * @return $this
     */
    public function atag($fourcc) {
        $this->addOption("-atag", $fourcc);
        return $this;
    }

    /**
     * -absf bitstream_filter
     * 要深入了解参考 -bsf
     *
     * @param  string $bitstream_filter
     * @return $this
     */
    public function absf($bitstream_filter) {
        $this->addOption("-absf", $bitstream_filter);
        return $this;
    }

    /**
     * -guess_layout_max channels (input,per-stream)
     * 如果音频输入通道的布局不确定，则尝试猜测选 择一个能包括所有指定通道的布局。
     * 例如：通道数是2，则 ffmpeg 可以认为是2个单声道，或者1 个立体声声道而不会认为是6通道或者5.1通道模式。
     * 默认值是总是试图猜测一个包含所有通道的 布局，用0来禁用。
     *
     *
     *
     *
     * @param  string $channels
     * @return $this
     */
    public function guess_layout_max($channels) {
        $this->addOption("-aframes", $channels);
        return $this;
    }


}