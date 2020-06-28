<?php


namespace ffmpeg\filters;


abstract class Filter
{

    /**
     * 过滤器选项
     * @var array
     */
    protected $options = [];

    /**
     * 过滤器名称
     * @var string
     */
    protected $filter_name = "";

    /**
     * 添加选项
     * @param string $name
     * @param string $value
     * @return $this
     */
    public function addOption($name, $value = null) {
        if (!empty($name)) {
            $this->options[$name] = $value;
        }
        return $this;
    }

    /**
     * 添加选项
     * @param array $options
     * @return $this
     */
    public function addOptions($options = []) {
        if (!empty($options)) {
            $this->options = array_merge($this->options, $options);
        }
        return $this;
    }

    /**
     * @desc 输出
     * @return string
     */
    public function out(){
        $options = "";
        foreach ($this->options as $key=>$val) {
            $options .= "{$key}='{$val}':";
        }
        $options = trim($options, ':');
        $out = $this->filter_name."=".$options;
        return $out;
    }

}