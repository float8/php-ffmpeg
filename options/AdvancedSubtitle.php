<?php
namespace ffmpeg\options;

class AdvancedSubtitle extends Option
{
    /**
     * -fix_sub_duration
     * 修正字幕持续时间。对每个字幕根据接下来的数据包调整字幕流的时间常 数以防止相互覆盖（第一个没有完下一个就出来了）。
     * 这对很多字幕解码来说是必须的，特别是 DVB字幕，因为它在原始数据包中只记录了一个粗略的估计值，最后还以一个空的字幕帧结束。
     * 这个选项可能失败，或者出现夸张的持续时间或者合成失败，这是因为数据中有非单调递增的时 间戳。
     * 注意此选项将导致所有数据延迟输出到字幕解码器，它会增加内存消耗，并引起大量延迟。
     *
     * @return $this
     */
    public function fix_sub_duration() {
        $this->addOption("-fix_sub_duration");
        return $this;
    }

    /**
     * -canvas_size size
     * 设置字幕渲染区域的尺寸（位置）
     *
     * @param  string $size
     * @return $this
     */
    public function canvas_size($size) {
        $this->addOption("-canvas_size", $size);
        return $this;
    }


}