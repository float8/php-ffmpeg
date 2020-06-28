<?php
namespace ffmpeg\options;

class AdvancedVideo extends Option
{


    /**
     * -pix_fmt[:stream_specifier] format (input/output,per-stream)
     * 设置像素格式。
     * 使用 - pix_fmts 可以显示所有支持的像素格式。
     * 如果设置的像素格式不能被选中（启用），则ffmpeg会 输出一个警告和并选择这个编码最好（兼容）的像素格式。
     * 如果 pix_fmt 前面前导了一个 + 字 符，ffmepg会在要求的像素格式不被支持时退出，这也意味着滤镜中的自动转换也会被禁止。
     * 如 果 pix_fmt 是单独的 + ，则ffmpeg选择和输入（或者滤镜通道）一样的像素格式作为输出，这 时自动转换也会被禁止。
     *
     * @param string $format
     * @param string $stream_specifier
     * @return $this
     */
    public function pix_fmt($format, $stream_specifier = null) {
        $this->addOption("-pix_fmt".$this->spcifier($stream_specifier), $format);
        return $this;
    }

    /**
     * -sws_flags flags (input/output)
     * 选择 SwScaler 放缩标志量。
     *
     * @param  string $flags
     * @return $this
     */
    public function sws_flags($flags) {
        $this->addOption("-sws_flags", $flags);
        return $this;
    }

    /**
     * -rc_override[:stream_specifier] override (output,per-stream)
     * 在特定时间范围内的间隔覆盖 率， override 的格式是”int\int\int”。
     * 其中前两个数字是开始帧和结束帧，最后一个数字如 果为正则是量化模式，如果为负则是品质因素。
     *
     * @param string $override
     * @param string $stream_specifier
     * @return $this
     */
    public function rc_override($override, $stream_specifier = null) {
        $this->addOption("-rc_override".$this->spcifier($stream_specifier), $override);
        return $this;
    }

    /**
     * -ilme
     * 支持交错编码（仅MPEG-2和MPEG-4）。
     * 如果你的输入是交错的，而且你想保持交错格 式，又想减少质量损失，则选此项。
     * 另一种方法是采用 -deinterlace 对输入流进行分离，但会引 入更多的质量损失。
     *
     * @return $this
     */
    public function ilme() {
        $this->addOption("-ilme");
        return $this;
    }

    /**
     * -psnr
     * 计算压缩帧的 PSNR
     *
     * @return $this
     */
    public function psnr() {
        $this->addOption("-psnr");
        return $this;
    }

    /**
     * -vstats
     * 复制视频编码统计分析到日志文件 vstats_HHMMSS.log
     *
     * @return $this
     */
    public function vstats() {
        $this->addOption("-vstats");
        return $this;
    }

    /**
     * -vstats_file file
     * 复制视频编码统计分析到 file 所指的日志文件中。
     *
     * @param  string file
     * @return $this
     */
    public function vstats_file($file) {
        $this->addOption("-vstats_file", $file);
        return $this;
    }


    /**
     * -vstats_version file
     * 指定要使用哪个版本的vstats格式。默认是2。
     * version = 1 :
     * frame= %5d q= %2.1f PSNR= %6.2f f_size= %6d s_size= %8.0fkB time= %0.3f br= %7.1fkbits/s avg_br= %7.1fkbits/s
     * version > 1:
     * out= %2d st= %2d frame= %5d q= %2.1f PSNR= %6.2f f_size= %6d s_size= %8.0fkB time= %0.3f br= %7.1fkbits/s avg_br= %7.1fkbits/s
     *
     * @param  string file
     * @return $this
     */
    public function vstats_version($file) {
        $this->addOption("-vstats_version", $file);
        return $this;
    }

    /**
     * -top[:stream_specifier] n (output,per-stream)
     * 指明视频帧数据描述的起点。 顶部=1/底部=0/自动 =-1 （以往CRT电视扫描线模式）
     *
     * @param string $n
     * @param string $stream_specifier
     * @return $this
     */
    public function top($n, $stream_specifier = null) {
        $this->addOption("-top".$this->spcifier($stream_specifier), $n);
        return $this;
    }


    /**
     * -dc precision
     * Intra_dc_precision值。
     *
     * @param  string $precision
     * @return $this
     */
    public function dc($precision) {
        $this->addOption("-dc", $precision);
        return $this;
    }


    /**
     * -vtag fourcc/tag (output)
     * 是 -tag:v 的别名
     * 强制指定视频标签/fourCC （FourCC全称 Four-Character Codes，
     * 代表四字符代码 (four character code), 它是一个32位的标 示符，
     * 其实就是typedef unsigned int FOURCC;是一种独立标示视频数据流格式的四字符代 码。）
     *
     * @param  string $fourcc
     * @return $this
     */
    public function vtag($fourcc) {
        $this->addOption("-vtag", $fourcc);
        return $this;
    }

    /**
     * -qphist (global)
     * 显示 QP 直方图。
     *
     * @return $this
     */
    public function qphist() {
        $this->addOption("-qphist");
        return $this;
    }

    /**
     * -vbsf bitstream_filter
     * 参考 -bsf 以进一步了解。
     *
     * @param  string $bitstream_filter
     * @return $this
     */
    public function vbsf($bitstream_filter) {
        $this->addOption("-vbsf", $bitstream_filter);
        return $this;
    }


    /**
     * -force_key_frames[:stream_specifier] time[,time...] (output,per-stream)
     * ffmpeg将根据编码器的时间基数将指定的时间取整到最接近的输出时间戳，并在第一个帧强制设置一个关键帧，该帧的时间戳等于或大于计算的时间戳。
     * 注意，如果编码器的时间基数太粗，那么关键帧可能会被强制在时间戳低于指定时间的帧上。
     * 默认编码器的时间基是输出帧率的倒数，但可以通过-enc_time_base进行其他设置。
     *
     * 如果其中一个时间是“chapters[delta]”，则将其扩展为文件中所有章节开始的时间，通过增量进行移动，以秒表示时间。
     * 此选项有助于确保在章节标记处或输出文件中的任何其他指定位置出现查找点。
     *
     * 例如，在5分钟插入关键帧，在每章开始前0.1秒插入关键帧:
     * -force_key_frames 0:05:00,chapters-0.1
     *
     * @param string $stream_specifier*
     * @param array $time
     * @return $this
     */
    public function force_key_frames_time($stream_specifier, ...$time) {
        $this->addOption("-force_key_frames".$this->spcifier($stream_specifier), implode(" ", $time));
        return $this;
    }

    /**
     * -force_key_frames[:stream_specifier] expr:expr (output,per-stream)
     * 强制时间戳位置帧为关键 帧，更确切说是从第一帧起每设置时间都是关键帧（即强制关键帧率）。
     * 如果参数值是以 expr: 前导的，则字符串 expr 为一个表达式用于计算关键帧间隔数。关键帧 间隔值必须是一个非零数值。
     * 如果一个时间值是” chapters [delta]”则表示文件中从 delta 章开始的所有章节点计算以 秒为单位的时间，并把该时间所指帧强制为关键帧。
     * 这个选项常用于确保输出文件中所有章标记 点或者其他点所指帧都是关键帧（这样可以方便定位）。
     * 例如下面的选项代码就可以使“第5分钟 以及章节chapters-0.1开始的所有标记点都成为关键帧”：
     * 其中表达式 expr 接受如下的内容：
     * n ：当前帧序数，从0开始计数
     * n_forced ：强制关键帧数
     * prev_forced_n ：之前强制关键帧数，如果之前还没有强制关键帧，则其值为 NAN
     * prev_forced_t ：之前强制关键帧时间，如果之前还没有强制关键帧则为 NAN
     * t ：当前处理到的帧对应时间。
     *
     * 例如要强制每5秒一个关键帧：
     * -force_key_frames expr:if(isnan(prev_forced_t),gte(t,13),gte(t,prev_forced_t+5))
     * 从13秒后每5秒一个关键帧：
     * -force_key_frames expr:gte(t,n_forced*5)
     *
     * 注意设置太多强制关键帧会损害编码器前瞻算法效率，采用固定 GOP 选项或采用一些近似 设置可能更高效。
     *
     * @param string $stream_specifier
     * @param string $expr
     * @return $this
     */
    public function force_key_frames_expr($stream_specifier, $expr) {
        $this->addOption("-force_key_frames".$this->spcifier($stream_specifier), "expr:{$expr}");
        return $this;
    }

    /**
     * -force_key_frames[:stream_specifier] source (output,per-stream)
     * ffmpeg将迫使一个关键帧,如果当前帧编码是标记为一个关键帧的源。
     *
     * @param string $stream_specifier
     * @param string $source
     * @return $this
     */
    public function force_key_frames_source($stream_specifier, $source) {
        $this->addOption("-force_key_frames".$this->spcifier($stream_specifier), $source);
        return $this;
    }

    /**
     * -copyinkf[:stream_specifier] (output,per-stream)
     * 流复制时同时复制非关键帧。
     *
     * @param string $stream_specifier
     * @return $this
     */
    public function copyinkf($stream_specifier) {
        $this->addOption("-copyinkf".$this->spcifier($stream_specifier));
        return $this;
    }

    /**
     * -init_hw_device type[=name][:device[,key=value...]]
     * 初始化一个新的硬件设备类型的类型称为名称、使用给定的设备参数。如果没有指定名称,它将获得一个默认的名称形式“type%d”。
     *
     *
     * 设备和以下参数的含义取决于设备类型:
     *
     * cuda
     *  设备为CUDA设备的编号。
     *
     * dxva2
     *  设备是Direct3D 9显示适配器的编号
     *
     * vaapi
     *  设备是X11显示名称或DRM渲染节点。如果没有指定,它将尝试打开默认的X11显示($DISPLAY),然后第一个DRM渲染节点(/dev/dri/renderD128)。
     *
     * vdpau
     *  设备是一个X11显示名称。如果没有指定,它将尝试打开默认的X11显示($DISPLAY)
     *
     * qsv
     *  设备选择一个值“MFX_IMPL_ *”。允许的值是:
     *  auto
     *  sw
     *  hw
     *  auto_any
     *  hw_any
     *  hw2
     *  hw3
     *  hw4
     *  如果未指定，则使用' auto_any '。(注意，通过创建适合于平台的子设备(' dxva2 '或' vaapi ')，然后从中派生出QSV设备，可能更容易实现QSV所需的结果。)
     *
     * opencl
     * 设备选择平台和设备为platform_index.device_index。
     * 设备的设置也可以过滤使用键值只找到设备匹配特定平台或设备的字符串。
     * 字符串使用过滤器:
     *  platform_profile
     *  platform_version
     *  platform_name
     *  platform_vendor
     *  platform_extensions
     *  device_name
     *  device_vendor
     *  driver_version
     *  device_version
     *  device_profile
     *  device_extensions
     *  device_type
     *  指数和过滤器必须一起独特的选择一个设备。
     *  例子
     *  在第一平台选择第二个设备。
     *  -init_hw_device opencl:0.1
     *  选择一个名称的设备包含字符串Foo9000
     *  -init_hw_device opencl:,device_name=Foo9000
     *   选择第二个平台支持GPU设备cl_khr_fp16扩展。
     *  -init_hw_device opencl:1,device_type=gpu,device_extensions=cl_khr_fp16
     *
     * vulkan
     * 如果设备是一个整数,它选择指数的设备与系统相关的设备列表。如果设备是任何其他字符串,它选择第一设备的名称包含字符串的子字符串。
     * 以下选项是公认的:
     *  debug
     *  如果设置为1,如果安装启用验证层。
     *  linear_images
     *  如果设置为1,图像分配hwcontext将线性和本地可用图表示的。
     *  instance_extensions
     *  加上分隔列表扩展,使额外的实例。
     *  device_extensions
     *  加上分隔列表启用额外的设备扩展。
     *  例子：
     *  选择系统上的第二个设备。
     *  -init_hw_device vulkan:1
     *  选择第一个包含字符串RADV设备使用名称。
     * -init_hw_device vulkan:RADV
     *  选择第一个设备,启用Wayland 和 XCB实例扩展
     * -init_hw_device vulkan:0,instance_extensions=VK_KHR_wayland_surface+VK_KHR_xcb_surface
     *
     * @param string $type
     * @param string $name
     * @param string $device
     * @param array $device_options [key=>val,...]
     * @return $this
     */
    public function init_hw_device($type, $name, $device, ...$device_options) {
        $options = "";
        if (!empty($name)) {
            $options = $type;
        }
        if (!empty($name)) {
            $options .= "={$name}";
        }
        if (!empty($device)) {
            $options .= ":{$device}";
        }
        if (!empty($device_options)) {
            foreach ($device_options as $option) {
                foreach ($option as $key=>$val) {
                    $options .= ",{$key}={$val}";
                }
            }
        }

        $this->addOption("-init_hw_device", $options);
        return $this;
    }

    /**
     * -init_hw_device type[=name]@source
     * 初始化一个新的硬件设备类型的类型称为名称、
     * 从现有设备的名字来源推导它。
     *
     * @param string $type
     * @param string $name
     * @param string $source
     * @return $this
     */
    public function init_hw_device_source($type, $name, $source) {
        $options = "";
        if (!empty($name)) {
            $options = $type;
        }
        if (!empty($name)) {
            $options .= "={$name}";
        }
        if (!empty($device)) {
            $options .= "@{$source}";
        }
        $this->addOption("-init_hw_device", $options);
        return $this;
    }

    /**
     * -init_hw_device list
     * 列出所有支持的硬件设备类型在这个构建的ffmpeg。
     *
     * @param string $list
     * @return $this
     */
    public function init_hw_device_list($list) {
        $options = "";
        if (!empty($list)) {
            $options = $list;
        }
        $this->addOption("-init_hw_device", $options);
        return $this;
    }

    /**
     * -filter_hw_device name
     * 通过硬件设备称为名称所有过滤器在过滤图。
     * 这可以用于设置设备上传以hwupload过滤器,或设备映射到hwmap过滤器。
     * 其他过滤器也可以利用这个参数时需要一个硬件设备。
     * 注意,这通常是唯一的要求当输入不是已经在硬件帧
     * 过滤器将获得他们需要的设备，从上下文他们收到的帧作为输入。
     * 这是一个全局性的设置,所以所有过滤器将收到相同的设备。
     *
     * @param  string file
     * @return $this
     */
    public function filter_hw_device($name) {
        $this->addOption("-filter_hw_device", $name);
        return $this;
    }

    /**
     * -hwaccels
     * 列出所有支持硬件加速方法ffmpeg的构建。
     *
     * -hwaccel[:stream_specifier] hwaccel (input,per-stream)
     * 使用硬件加速解码匹配的流。允许 的 hwaccel 值为：
     * none ：没有硬件加速（默认值）
     * auto ：自动选择硬件加速
     * vda ：使用Apple的VDA硬件加速
     * vdpau ：使用VDPAU（Video Decode and Presentation API for Unix，类unix 下的技术标准）硬件加速
     * dxva2 ：使用DXVA2 (DirectX Video Acceleration，windows下的技术标准) 硬 件加速。
     * 这个选项可能并不能起效果（它依赖于硬件设备支持和选择的解码器支持）
     * 注意：很多加速方法（设备）现在并不比现代CPU快了，而且额外的 ffmpeg 需要拷贝解码 的帧（从GPU内存到系统内存）完成后续处理（例如写入文件），从而造成进一步的性能损 失。
     * 所以当前这个选项更多的用于测试。
     *
     * @param string $hwaccel
     * @param string $stream_specifier
     * @return $this
     */
    public function hwaccel($hwaccel = null, $stream_specifier = null) {
        $this->addOption("-hwaccel".$this->spcifier($stream_specifier), $hwaccel);
        return $this;
    }


    /**
     * -hwaccel_device[:stream_specifier] hwaccel_device (input,per-stream)
     * 选择一个设备使用硬件加速。这个选项必须同时指定了 -hwaccel 才可能生效。
     * 它既可以指现有的设备创建-init_hw_device的名字
     * 也可以创建一个新的设备犹如-init_hw_device的 type:hwaccel_device 在之前被立即访问 。
     * vdpau ：对应于 VDPAU ，在 X11 （类Unix）显示/屏幕 上的，如果这个选项值没有选中， 则必须在 DISPLAY 环境变量中有设置。
     * dxva2 ：对应于 DXVA2 ，这个是显示硬件（卡）的设备号，如果没有指明，则采用默认设备 （对于多个卡时）。
     *
     * @param string $hwaccel_device
     * @param string $stream_specifier
     * @return $this
     */
    public function hwaccel_device($hwaccel_device, $stream_specifier = null) {
        $this->addOption("-hwaccel_device".$this->spcifier($stream_specifier), $hwaccel_device);
        return $this;
    }
}