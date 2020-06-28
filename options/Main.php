<?php
namespace ffmpeg\options;

class Main extends Option
{

    /**
     * -f fmt (input/output)
     * 指定输入或者输出文件格式。常规可省略而使用依据扩展名的自动指 定，但一些选项需要强制明确设定。
     * @param string $fmt
     * @return $this
     */
    public function fmt($fmt) {
        $this->addOption("-f", $fmt);
        return $this;
    }

    /**
     * -i filename （input）
     * 指定输入文件
     * @param string $filename
     * @return $this
     */
    public function input($filename) {
        $this->addOption("-i", $filename);
        return $this;
    }

    /**
     * 是否覆盖文件
     * -y （global）
     * true 认自动覆盖输出文件，而不再询问确认。
     * -n (global)
     * false 不覆盖输出文件，如果输出文件已经存在则立即退出
     * @param bool $yes
     * @return $this
     */
    public function overwrite($yes = true) {
        $this->addOption($yes ? "-y" : "-n", null);
        return $this;
    }

    /**
     * -stream_loop number (input)
     * 设置循环次数的输入流。循环0意味着没有循环,循环1意味着无限循环。

     * @param int $number
     * @return $this
     */
    public function stream_loop($number) {
        $this->addOption('-loop', $number);
        return $this;
    }

    /**
     * -c[:stream_specifier] codec (input/output,per-stream)
     * -codec[:stream_specifier] codec (input/output,per-stream)
     * 为特定的文件选择编/解码模式，对于输出文件就是编码器，对于输入或者某个流就是解码器。选 项参数中
     * codec 是编解码器的名字，或者是 copy （仅对输出文件）则意味着流数据直接复制而不再编码。
     * 例如：
     * ffmpeg -i INPUT -map 0 -c:v libx264 -c:a copy OUTPUT
     * 是使用libx264编码所有的视频流，然后复制所有的音频流。
     *
     * 再如除了特殊设置外所有的流都由 c 匹配指定：
     * ffmpeg -i INPUT -map 0 -c copy -c 1 libx264 -c 137 libvorbis OUTPUT
     * 这将在输出文件中第2视频流按libx264编码，第138音频流按libvorbis编码，其余都直接复 制输出。
     *
     * @param string $codec
     * @param string $stream_specifier
     * @return $this
     */
    public function codec($codec, $stream_specifier = null) {
        $this->addOption("-c".$this->spcifier($stream_specifier), $codec);
        return $this;
    }

    /**
     * -t duration (input/output)
     * 限制输入/输出的时间。如果是在 -i 前面，就是限定从输入中读 取多少时间的数据；如果是用于限定输出文件，则表示写入多少时间数据后就停止。
     * duration 可以是以秒为单位的数值或者"hh ss[.xxx]"格式的时间值。 注意 -to 和 -t 是互斥的， -t 有更高优先级。
     *
     * @param string $duration
     * @return $this
     */
    public function  t($duration) {
        $this->addOption("-t", $duration);
        return $this;
    }

    /**
     * -fs limit_size (output)
     * 设置文件大小限制，以字节表示。超过限制后不会再写入字节块。输出文件的大小略大于请求的文件大小。
     *
     * @param int $limit_size
     * @return $this
     */
    public function file_size($limit_size) {
        $this->addOption("-fs", $limit_size);
        return $this;
    }

    /**
     * -to position (output)
     * 只写入 position 时间后就停止， position 可以是以秒为单位的数值或 者 "hh ss[.xxx]" 格式的时间值。
     * 注意 -to 和 -t 是互斥的， -t 有更高优先级。
     *
     * @param string $position
     * @return $this
     */
    public function  to_position($position) {
        $this->addOption("-to", $position);
        return $this;
    }



    /**
     * -ss position (input/output)
     * 从文件开始剪裁
     * 当在 -i 前，表示定位输入文件到 position 指定的位置。
     * 注意可能一些格式是不支持精 确定位的，所以 ffmpeg 可能是定位到最接近 position （在之前）的可定位点。
     * 当有转码 发生且 -accurate_seek 被设置为启用（默认），则实际定位点到 position 间的数据被解 码出来但丢弃掉。
     * 如果是复制模式或者 -noaccurate_seek 被使用，则这之间的数据会被保 留。
     * 当用于输出文件时，会解码丢弃 position 对应时间码前的输入文件数据。
     * position 可以是以秒为单位的数值或者 hh ss[.xxx] 格式的时间值
     *
     * 例子：
     * 裁剪前 10 秒：
     * ffmpeg -ss 0:0 -t 0:10 -i input.mov output.mp4
     *
     * @param string $position
     * @return $this
     */
    public function ss_position($position) {
        $this->addOption("-ss", $position);
        return $this;
    }


    /**
     * -sseof position (input)
     * 与 '-ss'选项相似，但是相对于文件结尾位置，在文件里是负值，0是结束符
     * 从文件末尾剪裁
     * 例子
     * 裁剪最后 10 秒：
     * ffmpeg -sseof -0:10 -i input.mov output.mp4
     *
     * @param string $position
     * @return $this
     */
    public function sseof($position) {
        $this->addOption("-sseof", $position);
        return $this;
    }


    /**
     * -itsoffset offset (input)
     * 设置输入文件的时间偏移。
     * offset 必须采用时间持续的方式指定， 即可以有 - 号的时间值（以秒为单位的数值或者 hh ss[.xxx] 格式的时间值）。
     * 偏移会附加 到输入文件的时间码上，意味着所指定的流会以时间码+偏移量作为最终输出时间码（定义一个正偏移意味着相应的流被延迟了 offset秒。 [-]）。
     * 视频延迟
     * @param string $offset
     * @return $this
     */
    public function itsoffset($offset) {
        $this->addOption("-itsoffset", $offset);
        return $this;
    }


    /**
     * -itsscale scale (input,per-stream)
     * 重新调节输入时间戳。刻度应该是浮点数。
     * @param float $scale
     * @return $this
     */
    public function itsscale($scale) {
        $this->addOption("-itsscale", $scale);
        return $this;
    }

    /**
     * -timestamp date (output)
     * 设置在容器中记录时间戳。 date 必须是一个时间持续描述格式，即
     * SS[.m...]]]">(YYYY-MM-DD|YYYYMMDD)[T|t| ]|(HHMMSS[.m…]]]))[Z] 格式。
     *  https://ffmpeg.org/ffmpeg-utils.html#date-syntax
     *
     * @param string $date
     * @return $this
     */
    public function timestamp($date) {
        $this->addOption("-timestamp", $date);
        return $this;
    }

    /**
     * -metadata[:metadata_specifier] key=value (output,per-metadata)
     * 指定元数据中的键值对。流或者章的 metadata_specifier 可能值是可以参考文档中 -map_metadata 部分了解。
     * 简单的覆盖 -map_metadata 可以通过一个为空的选项实现，例如：
     * ffmpeg -i in.avi -metadata title="my title" out.flv
     * 设置第1声道语言:
     * ffmpeg -i INPUT -metadata:s:a:0 language=eng OUTPUT
     * @param string $key
     * @param string $value
     * @param string $metadata_specifier
     * @return $this
     */
    public function metadata($key, $value, $metadata_specifier = null) {
        $this->addOption("-metadata".$this->spcifier($metadata_specifier), $key.'='.'"'.$value.'"');
        return $this;
    }

    /**
     * -disposition[:stream_specifier] value (output,per-stream)
     * 给一个流设置配置
     * 此选项将覆盖从输入流复制的配置。也可以通过将配置设置为0来删除它。
     *
     * 认可的配置如下：
     * default
     * dub
     * original
     * comment
     * lyrics
     * karaoke
     * forced
     * hearing_impaired
     * visual_impaired
     * clean_effects
     * attached_pic
     * captions
     * descriptions
     * dependent
     * metadata
     *
     * 例如：
     * 根据默认流制作第二个音频流
     * ffmpeg -i in.mkv -c copy -disposition:a:1 default out.mkv
     * 制作第二个字幕流默认流 和从第一个字幕流删除默认配置
     * ffmpeg -i in.mkv -c copy -disposition:s:0 0 -disposition:s:1 default out.mkv
     * 添加一个嵌入式封面/缩略图
     * ffmpeg -i in.mp4 -i IMAGE -map 0 -map 1 -c copy -c:v:1 png -disposition:v:1 attached_pic out.mp4
     * 并不是所有混合器都支持嵌入式缩略图，支持格式：jpeg、png
     * @param string $value
     * @param string $metadata_specifier
     * @return $this
     */
    public function disposition($metadata_specifier, $value) {
        $this->addOption("-disposition".$this->spcifier($metadata_specifier), $value);
        return $this;
    }

    /**
     * -program [title=title:][program_num=program_num:]st=stream[:st=stream...] (output)
     * 添加具有指定流的程序
     * 创建一个程序,指定的标题,program_num并添加指定的流(s)。
     *
     * @param string $title
     * @param int $program_num
     * @param $st array [key=>val,...]
     * @return $this
     */
    public function program($title, $program_num, $st = []) {
        $arr = ["title"=>$title, 'program_num'=>$program_num];
        $arr = array_merge($arr, $st);
        $value = '';
        foreach ($arr as $k=>$v) {
            $value .= "{$k}=$v:";
        }
        $value = trim($value, ':');
        $this->addOption("-program", $value);
        return $this;
    }


    /**
     * -target type (output)
     * 指定目标文件类型(vcd,svcd,dvd,dv,dv50)，类型还可以前缀一个 pal- , ntsc- 或者 film- 来设定更具体的标准。所有的格式选项(码率、编码、缓冲尺 寸)都会自动设置，而你仅仅只需要设置目标类型：
     * ffmpeg -i myfile.avi -taget vcd /tmp/vcd.mpg
     * 当然，你也可以指定一些额外的选项，只要你知道这些不会与标准冲突，如：
     * ffmpeg -i myfile.avi -target vcd -bf 2 /tmp/vcd.mpg
     *
     * @param string $type
     * @return $this
     */
    public function target($type) {
        $this->addOption("-target", $type);
        return $this;
    }

    /**
     * -dn (input/output)
     * 作为输入选项，当一个文件被过滤或者被自动选择或者映射一些输出时阻止所有数据流，见 -discard 选项去禁用单独的流
     * 作为输入选项，禁用数据记录即自动选择或者映射一些数据流，全手动控制，见 -map 选项
     * @return $this
     */
    public function dn() {
        $this->addOption("-dn");
        return $this;
    }


    /**
     * -dframes number (output)
     * 设定指定 number 数据帧到输出文件，这是 -frames:d 的别名。
     * @param int $number
     * @return $this
     */
    public function dframes($number) {
        $this->addOption("-dframes", $number);
        return $this;
    }


    /**
     * -frames[:stream_specifier] framecount (output,per-stream)
     * 在指定计数帧后停止写入数据。
     *
     * @param int $framecount
     * @param string $stream_specifier
     * @return $this
     */
    public function frames($framecount,  $stream_specifier = null) {
        $this->addOption("-frames".$this->spcifier($stream_specifier), $framecount);
        return $this;
    }


    /**
     * -q[:stream_specifier] q (output,per-stream)
     * -qscale[:stream_specifier] q (output,per-stream)
     * 使用固定的质量品质(VBR)。用于指定 q|qscale 编码依赖。如果 qscale 没有 跟 stream_specifier 则只适用于视频。其中值 q 取值在0.01-255,越小质量越好。
     * @param string $q
     * @param string $stream_specifier
     * @return $this
     */
    public function qscale($q,  $stream_specifier = null) {
        $this->addOption("-q".$this->spcifier($stream_specifier), $q);
        return $this;
    }

    /**
     * -filter[:stream_specifier] filtergraph (output,per-stream)
     * 创建一个由 filtergraph 指定的滤 镜，并应用于指定流。
     * filtergraph 是应用于流的滤镜链图，它必须有一个输入和输出，而且流的类型需要相同。在滤 镜链图中，从 in 标签指定出输入，从 out 标签出输出。
     * 要了解更多语法，请参考 ffmpeg－filters 手册。
     * 参考 －filter_complex 选项以了解如何建立多个输入／输出的滤镜链图。
     * @param string $filtergraph
     * @param string $stream_specifier
     * @return $this
     */
    public function filter($filtergraph,  $stream_specifier = null) {
        $this->addOption("-filter".$this->spcifier($stream_specifier), $filtergraph);
        return $this;
    }


    /**
     * -filter_script[:stream_specifier] filename (output,per-stream)
     * 这个选项类似于 -filter ，只是这里的参数是一个文件名，它的内容将被读取用于构建滤镜链图。
     * @param string $filename
     * @param string $stream_specifier
     * @return $this
     */
    public function filter_script($filename,  $stream_specifier = null) {
        $this->addOption("-filter_script".$this->spcifier($stream_specifier), $filename);
        return $this;
    }


    /**
     * -filter_threads nb_threads (global)
     * 定义了有多少线程用于处理一个过滤器管道，每个管道将产生一个线程池，多个线程可以并行处理。缺省值是可用的cpu数量。
     * @param int $nb_threads
     * @return $this
     */
    public function filter_threads($nb_threads) {
        $this->addOption("-filter_threads", $nb_threads);
        return $this;
    }


    /**
     * -pre[:stream_specifier] preset_name (output,per-stream)
     * 指定预设名字的流（单个或者多个）
     * @param string $preset_name
     * @param string $stream_specifier
     * @return $this
     */
    public function pre($preset_name, $stream_specifier =  null) {
        $this->addOption("-pre".$this->spcifier($stream_specifier), $preset_name);
        return $this;
    }


    /**
     * -stats (global)
     * 输出编码过程／统计，这是系统默认值，如果你想禁止，则需要采用 －nostats
     * @param $value
     * @return $this
     */
    public function stats() {
        $this->addOption("-stats");
        return $this;
    }


    /**
     * -progress url (global)
     * 发送友好的处理过程信息到 url 。处理过程信息是一种键值对 （key=value）序列信息，它每秒都输出，或者在一次编码结束时输出。信息中最后的一个键值 对表明了当前处理进度。
     * @param string $url
     * @return $this
     */
    public function progress($url) {
        $this->addOption("-progress", $url);
        return $this;
    }

    /**
     * -stdin
     * :允许标准输入作为交互。在默认情况下除非标准输入作为真正的输入。
     * 要禁用标准输入 交互，则你需要显式的使用 -nostdin 进行设置。
     * 禁用标准输入作为交互作用是有用的，例如 FFmpeg是后台进程组，它需要一些相同的从shell开始的调用（ ffmpeg ... </dev/null ）。
     *
     * @return $this
     */
    public function stdin() {
        $this->addOption("-stdin");
        return $this;
    }

    /**
     * -debug_ts (global)
     * 打印时间码信息，默认是禁止的。
     * 这个选项对于测试或者调试是非常有用 的特性，或者用于从一种格式切换到另外的格式（包括特性）的时间成本分析，所以不用于脚本 处理中。
     * 还可以参考 -fdebug ts 选项。
     * @return $this
     */
    public function debug_ts() {
        $this->addOption("-debug_ts");
        return $this;
    }

    /**
     * -attach filename (output)
     * 把一个文件附加到输出文件中。
     * 这里只有很少文件类型能被支持， 例如使用Matroska技术为了渲染字幕的字体文件。
     * 附件作为一种特殊的流类型，所以这个选项 会添加一个流到文件中，然后你就可以像操作其他流一样使用每种流选项。
     * 在应用本选项时，附 件流须作为最后一个流(例如根据 -map 映射流或者自动映射时需要注意)。
     * 注意对于 Matroska 你 也可以在元数据标签中进行类型设定：
     * ffmpeg -i INPUT -attach DejaVuSans.ttf -metadata:s:2 mimetype=application/x-truetype-font out.mkv
     * 这时要访问到附件流，则就是访问输出文件中的第3个流
     * @param string $filename
     * @return $this
     */
    public function attach($filename) {
        $this->addOption("-attach", $filename);
        return $this;
    }

    /**
     * -dump_attachment[:stream_specifier] filename (input,per-stream)
     * 从输入文件中解出指定的附件流到文件filename：
     * 如提取第一个附件文件名为“out.ttf”:
     * ffmpeg -dump_attachment:t:0 out.ttf -i INPUT
     * 提取所有附件文件由文件名标签:
     * ffmpeg -dump_attachment:t "" -i INPUT
     * 技术说明：附件流是作为编码扩展数据来工作的，所以其他流数据也能展开，而不仅仅是这个附件属性。
     *
     *
     * @param string $filename
     * @param string $stream_specifier
     * @return $this
     */
    public function dump_attachment($filename,  $stream_specifier = null) {
        $this->addOption("-dump_attachment".$this->spcifier($stream_specifier), $filename);
        return $this;
    }

    /**
     * -noautorotate
     * 禁止自动依据文件元数据旋转视频。
     *
     * @return $this
     */
    public function noautorotate() {
        $this->addOption("-noautorotate", );
        return $this;
    }

}