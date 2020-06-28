<?php

namespace ffmpeg\filters;


class Drawtext extends Filter
{

    protected $filter_name = "drawtext";

    /**
     * 设置是否在文本下衬一个背景颜色，1为要，0为不要，默认为0
     * @param $value
     * @return $this
     */
    public function set_box($value)
    {
        $this->addOption('box', $value);
        return $this;
    }


    /**
     * 设置背景块边缘厚度（用于在背景块边缘用 boxcolor 再围绕画一圈），默认为0
     * @param $value
     * @return $this
     */
    public function set_boxborderw($value)
    {
        $this->options["boxborderw"] = $value;
        return $this;
    }

    /**
     * 设置用于绘制文本底衬的颜色。语法详见颜色/color中的介绍。 默认为”white”.
     * @param $value
     * @return $this
     */
    public function set_boxcolor($value)
    {
        $this->options["boxcolor"] = $value;
        return $this;
    }

    /**
     * 使用 bordercolor 颜色绘制的文字边缘厚度，默认为0
     * @param $value
     * @return $this
     */
    public function set_borderw($value)
    {
        $this->options["borderw"] = $value;
        return $this;
    }

    /**
     * 绘制文本衬底的颜色。语法详见颜色/color中的介绍。 默认为”black”.
     * @param $value
     * @return $this
     */
    public function set_bordercolor($value)
    {
        $this->options["bordercolor"] = $value;
        return $this;
    }

    /**
     * 设置文本扩展模式。可以为 none , strftime (已弃用了) 或 normal (默认). 见后面 文本扩展中的详细介绍
     * @param $value
     * @return $this
     */
    public function set_expansion($value)
    {
        $this->options["expansion"] = $value;
        return $this;
    }

    /**
     * 如果为true，检查和修复文本坐标来避免剪切
     * @param $value
     * @return $this
     */
    public function set_fix_bounds($value)
    {
        $this->options["fix_bounds"] = $value;
        return $this;
    }

    /**
     * 设置行间距在像素的边界框使用框画。line_spacing的默认值是0。
     * @param $value
     * @return $this
     */
    public function set_line_spacing($value)
    {
        $this->options["line_spacing"] = $value;
        return $this;
    }

    /**
     * 设置文本颜色。语法详见颜色/color中的介绍。 默认为”black”.
     * @param $value
     * @return $this
     */
    public function set_fontcolor($value)
    {
        $this->options["fontcolor"] = $value;
        return $this;
    }

    /**
     * 用于计算获得动态 fontcolor 值的字符串表达式。默认为空，即不处理。当被设置时将把计算结 果覆盖 fontcolor 选项
     * @param $value
     * @return $this
     */
    public function set_fontcolor_expr($value)
    {
        $this->options["fontcolor_expr"] = $value;
        return $this;
    }

    /**
     * 设置选用的字体，默认为Sans.
     * @param $value
     * @return $this
     */
    public function set_font($value)
    {
        $this->options["font"] = $value;
        return $this;
    }

    /**
     * 指定字体文件。信息中包括路径。这个参数在 fontconfig 被禁用时必须设置
     * @param $value
     * @return $this
     */
    public function set_fontfile($value)
    {
        $this->options["fontfile"] = $value;
        return $this;
    }

    /**
     * 设置绘制的文本透明度，值范围为0.0-1.0。而且还可以接受x和y的变量。请参阅 fontcolor_expr
     * @param $value
     * @return $this
     */
    public function set_alpha($value)
    {
        $this->options["alpha"] = $value;
        return $this;
    }

    /**
     * 设置字体大小，默认为16 drawing text. The default value of fontsize is 16.
     * @param $value
     * @return $this
     */
    public function set_fontsize($value)
    {
        $this->options["fontsize"] = $value;
        return $this;
    }

    /**
     * 如果设置为1，则试图整理文本排列顺序（例如阿拉伯语是按从右到左排序），否则按给定的顺序 从左到右排，默认为1
     * @param $value
     * @return $this
     */
    public function set_text_shaping($value)
    {
        $this->options["text_shaping"] = $value;
        return $this;
    }


    /**
     * 这些标志用于加载字体
     * 这些标志对应于 libfreetype 支持的标志，并结合下面的值:
     * default
     * no_scale
     * no_hinting
     * render
     * no_bitmap
     * vertical_layout
     * force_autohint
     * crop_bitmap
     * pedantic
     * ignore_global_advance_width
     * no_recurse ignore_transform
     * monochrome
     * linear_design
     * no_autohint
     * 默认值为 “default”.
     * 要了解更多信息，请参考文档中 libfreetype 标志的 FT_LOAD_* 部分。
     *
     * @param $value
     * @return $this
     */
    public function set_ft_load_flags($value)
    {
        $this->options["ft_load_flags"] = $value;
        return $this;
    }

    /**
     * 阴影颜色。语法详见颜色/color中的介绍。 默认为”black”.
     * @param $value
     * @return $this
     */
    public function set_shadowcolor($value)
    {
        $this->options["shadowcolor"] = $value;
        return $this;
    }

    /**
     * 这里的x和y是字阴影对于字本体的偏移。可以是正数或者负数（决定了偏移方向），默认为0
     * @param $value
     * @return $this
     */
    public function set_shadowx($value)
    {
        $this->options["shadowx"] = $value;
        return $this;
    }

    /**
     * 这里的x和y是字阴影对于字本体的偏移。可以是正数或者负数（决定了偏移方向），默认为0
     * @param $value
     * @return $this
     */
    public function set_shadowy($value)
    {
        $this->options["shadowy"] = $value;
        return $this;
    }

    /**
     * 起始帧数，对于 n/frame_num 变量。 默认为0
     * @param $value
     * @return $this
     */
    public function set_start_number($value)
    {
        $this->options["start_number"] = $value;
        return $this;
    }

    /**
     * 用于呈现的区域数量空间大小，默认为4
     * @param $value
     * @return $this
     */
    public function set_tabsize($value)
    {
        $this->options["tabsize"] = $value;
        return $this;
    }

    /**
     * 设置初始的时间码，以”hh ss[:;.]ff”格式。
     * 它被用于有或者没有 text 参数，此 时 timecode_rate 必须被指定
     * @param $value
     * @return $this
     */
    public function set_timecode($value)
    {
        $this->options["timecode"] = $value;
        return $this;
    }

    /**
     * 设置时间码 timecode 的帧率（在 timecode 指定时）
     * @param $value
     * @return $this
     */
    public function set_timecode_rate($value)
    {
        $this->options["timecode_rate"] = $value;
        return $this;
    }

    /**
     * 设置时间码 timecode 的帧率（在 timecode 指定时）
     * @param $value
     * @return $this
     */
    public function set_rate($value)
    {
        $this->options["rate"] = $value;
        return $this;
    }

    /**
     * 设置时间码 timecode 的帧率（在 timecode 指定时）
     * @param $value
     * @return $this
     */
    public function set_r($value)
    {
        $this->options["r"] = $value;
        return $this;
    }

    /**
     * 要被绘制的文本。文本必须采用 UTF-8 编码字符。如果没有指定 textfile 则这个选项必须指 定
     * @param $value
     * @return $this
     */
    public function set_text($value)
    {
        $this->options["text"] = $value;
        return $this;
    }

    /**
     * 一个文本文件，其内容将被绘制。
     * 文本必须是一个 UTF-8 文本序列 如果没有指定 text 选项，则必须设定。
     * 如果同时设定了 text 和 textfile 将引发一个错误
     * @param $value
     * @return $this
     */
    public function set_textfile($value)
    {
        $this->options["textfile"] = $value;
        return $this;
    }

    /**
     * 如果设置为1， textfile 将在每帧前加载。一定要自动更新它，或者它可能是会被读取的或者 失败
     * @param $value
     * @return $this
     */
    public function set_reload($value)
    {
        $this->options["reload"] = $value;
        return $this;
    }

    /**
     *
     * 指定文本绘制区域的坐标偏移。是相对于图像顶/左边的值 默认均为”0”. 下面是接受的常量和函数 对于x和y是表达式时，它们接受下面的常量和函数:
     * dar ：输入显示接受的长宽比，它等于 (w / h) * sar
     * hsub
     * vsub ：水平和垂直色度分量值。例如对于”yuv422p”格式像素， hsub 为2， vsub 为1
     * line_h, lh ：文本行高
     * main_h, h, H ：输入的高
     * main_w, w, W ：输入的宽
     * max_glyph_a, ascent： 从基线到最高/上字形轮廓高点（所有内容的最高点）的最大距离。必须是一个正值，因为网格与 Y轴方向关系使然
     * max_glyph_d, descent ：从基线到最低/下字形轮廓高点（所有内容的最高点）的最大距离。必须是一个负值，因为网格与 Y轴方向关系使然
     * max_glyph_h：最大字形高度，限定了所有单个字的高度，如果设置值小于实际值，则输出可能覆盖到其他行上
     * max_glyph_w： 最大字形宽度，限定了所单个字显示的宽度，如果设置值小于实际值，则发生字重叠 n输入帧序数，从0计数
     * rand(min, max) ：返回一个min和max间的随机数
     * sar ：输入样本点的长宽比 t以秒计的时间戳。如果无效则为 NAN
     * text_h, th ：渲染文本的高
     * text_w, tw ：渲染文本的宽
     * x
     * y ：文本的x和y坐标。 所有参数都允许 x 和 y 被引用，例如 y=x/dar
     *
     * @param $value
     * @return $this
     */
    public function set_x($value)
    {
        $this->options["x"] = $value;
        return $this;
    }

    public function set_y($value)
    {
        $this->options["y"] = $value;
        return $this;
    }

    /**
     * 动画
     * @param array $style
     * mode
     * 有如下值：t、n
     * t 以秒计的时间戳。
     * n 输入帧序数，从0计数
     * 默认 t
     * start
     * 开始的时间/或者帧序数
     * end
     * 结束的时间/或者帧序数
     * x
     * start_x
     * end_x
     * y
     * start_y
     * end_y
     *
     *
     *
     * @return $this
     * @throws \Exception
     */
//    public function animation($style) {
//        if (empty($style)) {
//            return $this;
//        }
//
//        $start = isset($style['start'])? intval($style['start']) : 0;
//        $end = isset($style['end'])? $style['end'] :0 ;
//        if($start == $end) {
//            throw new \Exception("开始和结束不能相等");
//        }
//        $dval = $end-$start;
//
//        $mode = isset($style['type']) ? ($style['type'] == 't' ? 't' : 'n') : 't';
//
//        if(isset($style['x'])) {
//            $this->options["x"] = $style['x'];
//        } else {
//            $start_x = isset($style['start_x'])? $style['start_x'] : "" ;
//            $end_x = isset($style['end_x'])? $style['end_x'] : "" ;
//            $speed_x = "({$end_x}-({$start_x}))/{$dval}*({$mode}-{$start})";
//            $this->options["x"] = "if(between({$mode},{$start},{$end}), {$start_x}+{$speed_x},{$end_x})";
//        }
//
//        if (isset($style['y'])){
//            $this->options["y"] = $style['y'];
//        } else {
//            $start_y = isset($style['start_y'])? $style['start_y'] : "" ;
//            $end_y = isset($style['end_y'])? $style['end_y'] : "" ;
//            $speed_y = "({$end_y}-{$start_y})/{$dval}*({$mode}-{$start}";
//            $this->options["y"] = "if(between({$mode},{$start},{$end}), {$start_y}+{$speed_y},{$end_y}";
//        }
//        $this->options["enable"] = "between(t,{$start},{$end})";
//        $this->options["alpha"] = "if(between(t,{$start},{$end}), (t-{$start})*0.1,1)";
//        return $this;
//    }


    private $animation_map = [
        'mode'=>'mode',
        't'=>'t',
        'y'=>'y',
        'x'=>'x',
        'alpha'=>'alpha',
    ];

    public function animation_fun(callable $callback) {

        if (empty($callback)) {
            return $this;
        }
        $animation  = $callback(new Animation());

        $options = call_user_func([$animation, 'getArgs'], $this->animation_map);
        $mode = isset($options['mode']) ? ($options['mode'] == 't'? 't' : 'n')  : 't';

        $modeFun = function ($mode, $options) {
            if (!isset($options[$mode]['start']) || !isset($options[$mode]['end'])) {
                throw new \Exception("请设置'mode'参数或者start和end参数");
            }

            if ($options[$mode]['end']-$options[$mode]['start'] <= 0) {
                throw new \Exception("结束必须大于开始");
            }

            return $options[$mode];
        };


        $modeVal = $modeFun($mode, $options);

        $position = function ($mode, $opt, $start, $end, $options) {
            if(isset($options[$opt]['val'])) {
                return $options[$opt]['val'];
            }

            if (!isset($options[$opt]['start']) || !isset($options[$opt]['end'])) {
                throw new \Exception("请设置'{$opt}'参数或者start和end参数");
            }

            //执行的时长
            $len = $end - $start;

            $speed = "({$options[$opt]['end']}-({$options[$opt]['start']}))/{$len}*({$mode}-{$start})";

            return "if(between({$mode},{$start},{$end}), {$options[$opt]['start']}+{$speed},{$options[$opt]['end']})";
        };

        $alpha = function ($mode, $start, $end, $options) {
            if(isset($options['alpha']['val'])) {
                return $options['alpha']['val'];
            }

            if (!isset($options['alpha']['start']) || !isset($options['alpha']['end'])) {
                throw new \Exception("请设置'alpha'参数或者start和end参数");
            }

            //执行的时长
            $len = $end - $start;

            $speed = round(($options['alpha']['end']-$options['alpha']['start'])/$len, 1, PHP_ROUND_HALF_DOWN);

            return "if(between({$mode},{$start},{$end}), ({$mode}-$start)*{$speed},1)";
        };

        $this->addOption('x', $position($mode,'x', $modeVal['start'], $modeVal['end'], $options));
        $this->addOption('y', $position($mode,'y', $modeVal['start'], $modeVal['end'], $options));
        $this->addOption('alpha',  $alpha($mode, $modeVal['start'], $modeVal['end'], $options));
        $this->addOption('enable',  "between({$mode},{$modeVal['start']},{$modeVal['end']})");
        return $this;
    }



}