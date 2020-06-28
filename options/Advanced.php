<?php
namespace ffmpeg\options;

class Advanced extends Option
{

    /**
     * -map [-]input_file_id[:stream_specifier][?][,sync_file_id[:stream_specifier]] | [linklabel] (output)
     * 设定一个或者多个输入流作为输出流的源。
     *
     * 每个输入流是以 input_file_id 序数标记 的输入文件和 input_stream_id 标记的流序号共同作用指明，它们都以0起始计数。
     * 如果设置 了 sync_file_id:stream_specifier ，则把这个输入流作为同步信号参考。
     *
     * 命令行中的第一个 -map 选项指定了输出文件中第一个流的映射规则（编号为0的流，0号流）， 第二个则指定1号流的，以此类推。
     *
     * 如果在流限定符前面有一个 - 标记则表明创建一个“负”映射，这意味着禁止该流输出，及排除 该流。
     *
     * 一种替代的形式是在复合滤镜中利用 [linklabel] 来进行映射（参看 -filter_complex 选项）。 其中的 linklabel 必须是输出滤镜链图中已命名的标签。
     *
     * 例子：映射第一个输入文件的所有流到输出文件：
     * ffmpeg -i INPUT -map 0 output
     *
     * 又如，如果在输入文件中有两路音频流，则这些流的标签就是”0:0”和”0:1”，你可以使用 -map 来选择某个输出，例如：
     * ffmpeg -i INPUT -map 0:1 out.wav
     *
     * 这将只把输入文件中流标签为”0:1”的音频流单独输出到out.wav中。 再如，从文件a.mov中选择序号为2的流（流标签0:2）
     * ，以及从b.mov中选择序号为6的流(流标 签1:6)，然后共同复制输出到out.mov需要如下写:
     * ffmpeg -i a.mov -i b.mov -c copy -map 0:2 -map 1:6 out.mov
     *
     * 选择所有的视频和第三个音频流则是:
     * ffmpeg -i INPUT -map 0:v -map 0:a:2 OUTPUT
     *
     * 选择所有的流除了第二音频流外的流进行输出是：
     * ffmpeg -i INPUT -map 0 -map -0:a:1 OUTPUT
     *
     * 选择输出英语音频流:
     * ffmpeg -i INPUT -map 0:v -map 0:a? OUTPUT
     *
     * 选择输出英语音频流:
     * ffmpeg -i INPUT -map 0:m:language:eng OUTPUT
     *
     * 注意应用了该选项将自动禁用默认的映射。
     *
     * @param string $input_file_id [-]input_file_id
     * @param string $stream_specifier [:stream_specifier][?]
     * @param array $sync_file_id [sync_file_id,stream_specifier]   [,sync_file_id[:stream_specifier]]
     *
     * @return $this
     */
    public function map($input_file_id, $stream_specifier= null, $sync_file_id = [] ) {
        $option = "";
        if (!empty($input_file_id)){
            $option = $input_file_id;
        }
        if (!empty($stream_specifier)){
            $option .= $this->spcifier($stream_specifier);
        }
        if (!empty($sync_file_id)){
            $option .= "{$sync_file_id[0]}".(isset($sync_file_id[1])?$this->spcifier($sync_file_id[1]):"");
        }
        $this->addOption("-map", $option);
        return $this;
    }

    /**
     * -ignore_unknown
     * 如果流的类型未知则忽略，而不进行复制。
     *
     * @return $this
     */
    public function ignore_unknown() {
        $this->addOption("-ignore_unknown");
        return $this;
    }

    /**
     * -copy_unknown
     * 复制类型未知的流。
     *
     * @return $this
     */
    public function copy_unknown() {
        $this->addOption("-copy_unknown");
        return $this;
    }

    /**
     * -map_channel [input_file_id.stream_specifier.channel_id|-1][?][:output_file_id.stream_specifier]
     * 从输入文件中指定映射一个通道的音频到输出文件指定流。
     * 如 果 output_file_id.stream_specifier 没有设置，则音频通道将映射到输出文件的所有音频流中。
     * 使用 -1 插入到 input_file_id.stream_specifier.chnnel_id 会映射一个静音通道
     *
     * 例如 INPUT 是一个立体声音频文件，你可以分别选择两个音频通道(下面实际上对于输入是交换 了2个音频通道顺序进行输出)：
     *
     * @param  string $option
     * @return $this
     */
    public function map_channel($option) {
        $this->addOption("-map_channel", $option);
        return $this;
    }

    /**
     * -map_metadata[:metadata_spec_out] infile[:metadata_spec_in] (output,per-metadata)
     * 在下一个输 出文件中从 infile 读取输出元数据信息。
     * 注意这里的文件索引也是以0开始计数的，而不是文 件名。
     * 参数 metadata_spec_in/out 指定的元数据将被复制，一个元数据描述可以有如下的信息 块:
     * g :全局元数据，这些元数据将作用于整个文件
     * s[:stream_spec] :每个流的元数据，
     * steam_spec 的介绍在 流指定 章节。如果是描述输入 流，则第一个被匹配的流相关内容被复制，如果是输出元数据指定，则所有匹配的流相关信 息被复制到该处。
     * c:chapter_index :每个章节的元数据，
     * chapter_index 也是以0开始的章节索引。
     * p:program_index ：每个节目元数据，
     * program_index 是以0开始的节目索引 如果元数据指定被省略，则默认是全局的。
     *
     * 默认全局元数据会从第一个输入文件每个流每个章节依次复制（流/章节），这种默认映射会 因为显式创建了任意的映射而失效。一个负的文件索引就可以禁用默认的自动复制。
     * 例如从输入文件的第一个流复制一些元数据作为输出的全局元数据
     * ffmpeg -i in.ogg -map_metadata 0:s:0 out.mp3
     * 与上相反的操作，例如复制全局元数据给所有的音频流
     * ffmpeg -i in.mkv -map_metadata:s:a 0:g out.mkv
     * 注意这里简单的 0 在这里能正常工作是因为全局元数据是默认访问的。
     *
     * @param $metadata_spec_out
     * @param $infile
     * @param $metadata_spec_in
     * @return $this
     */
    public function map_metadata($metadata_spec_out, $infile, $metadata_spec_in) {
        $option = "";
        if (!empty($infile)){
            $option = $infile;
        }

        if (!empty($metadata_spec_in)){
            $option .= $this->spcifier($metadata_spec_in);
        }
        $this->addOption("-map_metadata".$this->spcifier($metadata_spec_out), $option);
        return $this;
    }

    /**
     * -map_chapters input_file_index (output)
     * 从输入文件中复制由 input_file_index 指定的章节的内 容到输出。如果没有匹配的章节，则复制第一个输入文件至少一章内容（第一章）。使用负数索 引则禁用所有的复制。
     *
     * @param  string $input_file_index
     * @return $this
     */
    public function map_chapters($input_file_index) {
        $this->addOption("-map_chapters", $input_file_index);
        return $this;
    }


    /**
     * -benchmark (global)
     * 在编码结束后显示基准信息。则包括CPU使用时间和最大内存消耗，最大 内存消耗是不一定在所有的系统中被支持，它通常以显示为0表示不支持。
     *
     * @return $this
     */
    public function benchmark() {
        $this->addOption("-benchmark");
        return $this;
    }

    /**
     * -benchmark_all (global)
     * 在编码过程中持续显示基准信息，则包括CPU使用时间（音频/视频 的 编/解码）
     *
     * @return $this
     */
    public function benchmark_all() {
        $this->addOption("-benchmark_all");
        return $this;
    }

    /**
     * -timelimit duration (global)
     * ffmpeg在编码处理了 duration 秒后退出。
     *
     * @return $this
     */
    public function timelimit() {
        $this->addOption("-timelimit");
        return $this;
    }

    /**
     * -dump (global)
     * 复制每个输入包到标准输出设备
     *
     * @return $this
     */
    public function dump() {
        $this->addOption("-dump");
        return $this;
    }

    /**
     * -hex (global)
     * 复制包时也复制荷载信息
     *
     * @return $this
     */
    public function hex() {
        $this->addOption("-hex");
        return $this;
    }

    /**
     * -re (input)
     *
     * 以指定帧率读取输入。
     * 通常用于模拟一个硬件设备，例如在直播输入流（这时是 读取一个文件）。
     * 不应该在实际设备或者在直播输入中使用（因为这将导致数据包的丢弃）。
     * 默 认 ffmpeg 会尽量以最高可能的帧率读取。
     * 这个选项可以降低从输入读取的帧率，这常用于实时输 出（例如直播流）。
     *
     * @return $this
     */
    public function re() {
        $this->addOption("-re");
        return $this;
    }

    /**
     * -vsync parameter
     * 视频同步方式。为了兼容旧，常被设置为一个数字值。也可以接受字符串来 作为描述参数值，其中可能的值是:
     * 0,passthrough :每个帧都通过时间戳来同步（从解复用到混合）。
     * 1，cfr ：帧将复制或者降速以精准达到所要求的恒定帧速率。
     * 2，vfr ：个别帧通过他们的时间戳或者降速以防止2帧具有相同的时间戳
     * drop ：直接丢弃所有的时间戳，而是在混合器中基于设定的帧率产生新的时间戳。
     * -1，auto ：根据混合器功能在1或者2中选择，这是默认值。
     *
     * 注意时间戳可以通过混合器进一步修改。例如 avoid_negative_ts 被设置时。
     * 利用 -map 你可以选择一个流的时间戳作为凭据，它可以对任何视频或者音频 不改变或者 重新同步持续流到这个凭据。
     *
     * @param  string $parameter
     * @return $this
     */
    public function vsync($parameter) {
        $this->addOption("-vsync", $parameter);
        return $this;
    }

    /**
     * -frame_drop_threshold parameter
     *
     * 丢帧的阀值，它指定后面多少帧内可能有丢帧。在帧率计数时 1.0是1帧，默认值是1.1。
     * 一个可能的用例是避免在混杂的时间戳或者需要增加精准时间戳的情 况下确立丢帧率。
     *
     * @param  string $parameter
     * @return $this
     */
    public function frame_drop_threshold($parameter) {
        $this->addOption("-frame_drop_threshold", $parameter);
        return $this;
    }



    /**
     * -async samples_per_second
     * 音频同步方式。”拉伸/压缩”音频以匹配时间戳。参数是每秒最大 可能的音频改变样本。
     * -async 1 是一种特殊情况指只有开始时校正，后续不再校正。
     * 注意时间戳还可以进一步被混合器修改。
     * 例如 avoid_negative_ts 选项被指定时 已不推荐这个选项，而是用 aresample 音频滤波器代替。
     *
     *
     * @param  string $samples_per_second
     * @return $this
     */
    public function async($samples_per_second) {
        $this->addOption("-async", $samples_per_second);
        return $this;
    }


    /**
     * -copyts
     * 不处理输入的时间戳，保持它们而不是尝试审核。特别是不会消除启动时间偏移值。
     * 注意根据 vsync 同步选项或者特定的混合器处理流程（例如格式选项 avoid_negative_ts 被设 置）输出时间戳会忽略匹配输入时间戳（即使这个选项被设置）
     *
     *
     *
     * @return $this
     */
    public function copyts() {
        $this->addOption("-copyts");
        return $this;
    }


    /**
     * -start_at_zero
     * 当使用 -copyts ,位移输入时间戳作为开始时间0.
     * 这意味着使用该选项，同时 又设置了 -ss ，例如 -ss 50 则输出中会从50秒开始加入输入文件时间戳。
     *
     * @return $this
     */
    public function start_at_zero() {
        $this->addOption("-start_at_zero");
        return $this;
    }

    /**
     * -copytb mode
     * 指定当流复制时如何设置编码时间基准。 mode 参数是一个整数值，可以有如下可能：
     * 1 表示使用分离器时间基准，从分离器中复制时间戳到编码中。复制可变帧率视频流时需要 避免非单调递增的时间戳。
     * 0 表示使用解码器时间基准，使用解码器中获取的时间戳作为输出编码基准。
     * -1 尝试自动选择，只要能产生一个正常的输出，这是默认值。
     *
     * @param  string $mode
     * @return $this
     */
    public function copytb($mode) {
        $this->addOption("-copytb", $mode);
        return $this;
    }



    /**
     * -enc_time_base[:stream_specifier] timebase (output,per-stream)
     * 默认值是0。
     *
     * 设置编码器时基。时基是一个浮点数,可以假设以下值之一:
     * 0 : 根据媒体类型指定一个默认值。视频 - 使用 1/framerate, 音频-使用 -1/samplerate。
     * -1 : 用输入流时基。如果一个输入流不可用,将使用默认的时基。
     * >0 : 使用提供的数字扫描基线。这个领域可以提供两个整数之比(例如一24,1:48000)或作为一个浮点数(如0.04166、2.0833 e-5)
     * 这个领域可以提供两个整数之比(例如一24,1:48000)或作为一个浮点数(如0.04166、2.0833 e-5)
     *
     * @param  string $stream_specifier
     * @param  string $timebase
     * @return $this
     */
    public function enc_time_base($stream_specifier, $timebase) {
        $this->addOption("-enc_time_base".$this->spcifier($stream_specifier), $timebase);
        return $this;
    }




    /**
     * -bitexact (input/output)
     *  启动 bitexact 模式的(de)muxer 和 (de/en)coder
     *
     * @return $this
     */
    public function bitexact() {
        $this->addOption("-bitexact");
        return $this;
    }




    /**
     * -shortest (output)
     * 完成编码时最短输入端。
     *
     *
     *
     * @return $this
     */
    public function shortest() {
        $this->addOption("-shortest");
        return $this;
    }




    /**
     * -dts_delta_threshold
     * 时间不连续增量阀值。
     *
     * @return $this
     */
    public function dts_delta_threshold() {
        $this->addOption("-dts_delta_threshold");
        return $this;
    }



    /**
     * -dts_error_threshold seconds
     * 设置初始的 解复用-解码延迟，参数是秒数值。
     *
     *
     * @param  int $seconds
     * @return $this
     */
    public function dts_error_threshold($seconds) {
        $this->addOption("-dts_error_threshold", $seconds);
        return $this;
    }

    /**
     * -muxpreload seconds (output)
     * 设置初始的 解复用-解码延迟，参数是秒数值。
     *
     *
     * @param  string $seconds
     * @return $this
     */
    public function muxpreload($seconds) {
        $this->addOption("-muxpreload", $seconds);
        return $this;
    }

    /**
     * -streamid output-stream-index:new-value (output)
     * 强制把输出文件中序号为 output-stream-id 的 流命名为 new-value 的值。
     * 这对应于这样的场景：在存在了多输出文件时需要把一个流分配给不同的值。
     * 例如设置0号 流为33号流，1号流为36号流到一个mpegts格式输出文件中（这相当于对流建立链接/别名）：
     * ffmpeg -i infile -streamid 0:33 -streamid 1:36 out.ts
     *
     * @param  string $input_file_index
     * @return $this
     */
    public function streamid($output_stream_index, $new_value) {
        $option = "";
        if (!empty($output_stream_index)) {
            $option = "{$output_stream_index}:{$new_value}";
        }
        $this->addOption("-streamid", $option);
        return $this;
    }

    /**
     * -bsf[:stream_specifier] bitstream_filters (output,per-stream)
     * 为每个匹配流设置bit流滤 镜。
     * bitstream_filters 是一个逗号分隔的bit流滤镜列表。可以使用 -bsfs 来获得当前可用的 bit流滤镜。
     * ffmpeg -i h264.mp4 -c:v copy -bsf:v h264_mp4toannexb -an out.h264
     * ffmpeg -i file.mov -an -vn -bsf:s mov2textsub -c:s copy -f rawvideo sub.txt
     *
     * @param  string $input_file_index
     * @return $this
     */
    public function bsf($bitstream_filters, $stream_specifier = null) {
        $this->addOption("-bsf".$this->spcifier($stream_specifier), $bitstream_filters);
        return $this;
    }

    /**
     * -tag[:stream_specifier] codec_tag (input/output,per-stream)
     * 为匹配的流设置 tag/fourcc。
     *
     * @return $this
     */
    public function tag($codec_tag, $stream_specifier = null) {
        $this->addOption("-tag".$this->spcifier($stream_specifier), $codec_tag);
        return $this;
    }


    /**
     * -timecode hh:mm:ssSEPff
     * :指定时间码，这里 SEP 如果是 : 则不减少时间码，如果是 ; 或 者 . 则可减少。
     *
     * @param string $timecode
     * @return $this
     */
    public function timecode($timecode) {
        $this->addOption("-timecode", $timecode);
        return $this;
    }



    /**
     * -filter_complex filtergraph (global)
     * 定义一个复合滤镜，可以有任意数量的输入/输出。
     * 最 简单的滤镜链图至少有一个输入和一个输出，且需要相同类型。
     * 参考 -filter 以获取更多信息 （更有价值）。
     * filtergraph 用来指定一个滤镜链图。关于 滤镜链图的语法 可以参考 ffmpeg- filters 相关章节。
     *
     *其中输入链标签必须对应于一个输入流。
     * filtergraph的具体描述可以使 用 file_index:stream_specifier 语法（事实上这同于 -map ）。
     * 如果 stream_specifier 匹配到 了一个多输出流，则第一个被使用。滤镜链图中一个未命名输入将匹配链接到的输入中第一个未 使用且类型匹配的流。
     *
     * 使用 -map 来把输出链接到指定位置上。未标记的输出会添加到第一个输出文件。
     * 注意这个选项参数在用于 -lavfi 源时不是普通的输入文件。
     * ffmpeg -i video.mkv -i image.png -filter_complex '[0:v][1:v]overlay[out]' -map '[out]' out.mkv
     * 这里 [0:v] 是第一个输入文件的第一个视频流，它作为滤镜的第一个（主要的）输入，同样， 第二个输入文件的第一个视频流作为滤镜的第二个输入。
     *
     * 假如每个输入文件只有一个视频流，则我们可以省略流选择标签，所以上面的内容在这时等价于:
     * ffmpeg -i video.mkv -i image.png -filter_complex 'overlay[out]' -map '[out]' out.mkv
     *
     * 此外，在滤镜是单输出时我们还可以进一步省略输出标签，它会自动添加到输出文件，所以进一 步简写为:
     * ffmpeg -i video.mkv -i image.png -filter_complex 'overlay' out.mkv
     *
     * 利用 lavfi 生成5秒的 红 color （色块）:
     * ffmpeg -filter_complex 'color=c=red' -t 5 out.mkv
     *
     * @param  string $filtergraph
     * @return $this
     */
    public function filter_complex($filtergraph) {
        $this->addOption("-filter_complex", $filtergraph);
        return $this;
    }


    public function filter_complex_fun(callable ...$callbacks ){
        $filter = "";
        foreach ($callbacks as $callback) {
            $filter .= $callback().",";
        }
        print_r($filter);
        $filter = trim($filter, ',');
        $this->filter_complex($filter);
        return $this;
    }


    /**
     * -filter_complex_threads nb_threads (global)
     * 定义一个复合滤镜，至少有一个输入和/或输出，等效于 - filter_complex
     *
     * @param  string $nb_threads
     * @return $this
     */
    public function filter_complex_threads($nb_threads) {
        $this->addOption("-filter_complex_threads", $nb_threads);
        return $this;
    }


    /**
     * -lavfi filtergraph (global)
     * 定义一个复合滤镜，至少有一个输入和/或输出，等效于 - filter_complex
     *
     * @param  string $filtergraph
     * @return $this
     */
    public function lavfi($filtergraph) {
        $this->addOption("-lavfi", $filtergraph);
        return $this;
    }


    /**
     * -filter_complex_script filename (global)
     * 这个选项类似于 -filter_complex ，唯一不同就是它 的参数是文件名，会从这个文件中读取复合滤镜的定义。
     *
     * @param  string $filename
     * @return $this
     */
    public function filter_complex_script($filename) {
        $this->addOption("-filter_complex_script", $filename);
        return $this;
    }


    /**
     * -accurate_seek (input)
     * 这个选项会启用/禁止输入文件的精确定位（配合 -ss )，它默认是启 用的，即可以精确定位。
     * 需要时可以使用 -noaccurate_seek 来禁用，例如在复制一些流而转码另 一些的场景下。
     *
     * @return $this
     */
    public function accurate_seek() {
        $this->addOption("-accurate_seek");
        return $this;
    }


    /**
     * -seek_timestamp (input)
     * 这个选项配合 -ss 参数可以在输入文件上启用或者禁止利用时间戳的 定位。
     * 默认是禁止的，如果启用，则认为 -ss 选项参数是正式的时间戳，而不是由文件开始计算 出来的偏移。
     * 这一般用于具有不是从0开始时间戳的文件，例如一些传输流（直播下）。
     *
     * @return $this
     */
    public function seek_timestamp() {
        $this->addOption("-seek_timestamp");
        return $this;
    }


    /**
     * -thread_queue_size size (input)
     * 这个选项设置可以从文件或者设备读取的最大排队数据包数 量。对于低延迟高速率的直播流，如果不能及时读取，则出现丢包，所以提高这个值可以避免出 现大量丢包现象。
     *
     * @param  string $size
     * @return $this
     */
    public function thread_queue_size($size) {
        $this->addOption("-thread_queue_size", $size);
        return $this;
    }

    /**
     * -sdp_file file (global)
     * 输出 sdp 信息到文件 file 。它会在至少一个输出不是 rtp 流时同时 输出 sdp 信息。
     *
     * @param  string $file
     * @return $this
     */
    public function sdp_file($file) {
        $this->addOption("-sdp_file", $file);
        return $this;
    }

    /**
     * -discard (input)
     * 允许丢弃特定的流或者分离出的流上的部分帧，但不是所有的分离器都支持 这个特性。
     * none ：不丢帧
     * default ：丢弃无效帧
     * noref ：丢弃所有非参考帧
     * bidir ：丢弃所有双向帧
     * nokey ：丢弃所有非关键帧
     * all ：丢弃所有帧
     *
     * @param  string $mode
     * @return $this
     */
    public function discard($mode) {
        $this->addOption("-discard", $mode);
        return $this;
    }

    /**
     * -abort_on flags (global)
     * 停止和终止在各种条件。以下标志:
     * empty_output
     * 没有数据包被传递给muxer，输出为空。
     * empty_output_stream
     * 在某些输出流中，没有数据包被传递给muxer。
     *
     * @param  string $flags
     * @return $this
     */
    public function abort_on($flags) {
        $this->addOption("-abort_on", $flags);
        return $this;
    }

    /**
     * -xerror (global)
     * 在出错时停止并退出
     *
     * @return $this
     */
    public function xerror() {
        $this->addOption("-xerror");
        return $this;
    }

    /**
     * -max_muxing_queue_size packets (output,per-stream)
     *
     * 当音频和/或视频转码流,ffmpeg不会开始编写到输出,直到有一个数据包对于每一次这样的流。
     * 在等待这种情况发生,对于其他的数据包流缓冲。
     * 这个选项设置这个缓冲区的大小,在数据包匹配的输出流。
     *
     * 这个选项的默认值应该足够高对于大多数使用,所以只有触摸这个选项如果你确信你需要它。
     *
     * 作为一个特殊的例外，你可以把一个位图字幕（bitmap subtitle）流作为输入，它将转换作为同 于文件最大尺寸的视频（如果没有视频则是720x576分辨率）。
     * 注意这仅仅是一个特殊的例外的临时 解决方案，如果在 libavfilter 中字幕处理方案成熟后这样的处理方案将被移除。
     *
     * 例如需要为一个储存在DVB-T上的MPEG-TS格式硬编码字幕，而且字幕延迟1秒：
     * ffmpeg -i input.ts -filter_complex '[#0x2ef] setpts=PTS+1/TB [sub] ; [#0x2d0] [sub] overlay' -sn -map '#0x2dc' output.mkv
     *
     * (0x2d0, 0x2dc 以及 0x2ef 是MPEG-TS 的PIDs，分别指向视频、音频和字幕流，一般作为 MPEG-TS中的0:0,0:3和0：7是实际流标签)
     * @return $this
     */
    public function max_muxing_queue_size($packets) {
        $this->addOption("-max_muxing_queue_size", $packets);
        return $this;
    }
}