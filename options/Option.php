<?php


namespace ffmpeg\options;


abstract class Option
{
    private $options = [];

    /**
     * 添加选项
     * @param string $name
     * @param string $value
     * @return $this
     */
    public function addOption($name, $value = null) {
        if (!empty($name)) {
            $arr = [$name];
            if (!is_null($value)) {
                $arr[] = $value;
            }
            $this->options[] = $arr;
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
     * @return array
     */
    public function getOptions() {
        return $this->options;
    }


    /**
     * 说明符
     * @param  string $value
     * @return string
     */
    protected function spcifier($value){
        if (empty($value)) {
            return '';
        }
        if ($value[0] == ":") {
            return $value;
        }
        return ':'.$value;
    }

}