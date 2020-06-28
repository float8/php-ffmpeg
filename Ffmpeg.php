<?php

namespace ffmpeg;

use ffmpeg\options\Advanced;
use ffmpeg\options\Audio;
use ffmpeg\options\Main;
use ffmpeg\options\Subtitle;
use ffmpeg\options\Video;
use ffmpeg\options\AdvancedVideo;

class Ffmpeg
{

    private $bin = "ffmpeg";

    private $options = [];

    private function callback($obj, callable $callback) {
        $callback($obj);
        $this->options = array_merge($this->options,
            call_user_func([$obj, 'getOptions']));
    }

    public function video(callable $callback)  {
        $this->callback(new Video(), $callback);
        return $this;
    }

    public function advancedVideo(callable $callback)  {
        $this->callback(new AdvancedVideo(), $callback);
        return $this;
    }

    public function audio(callable $callback) {
        $this->callback(new Audio(), $callback);
        return $this;
    }

    public function subtitle(callable $callback) {
        $this->callback(new Subtitle(), $callback);
        return $this;
    }

    public function main(callable $callback) {
        $this->callback(new Main(), $callback);
        return $this;
    }

    public function advanced(callable $callback) {
        $this->callback(new Advanced(), $callback);
        return $this;
    }

    private function options_tostring() {
        $str = "";
        foreach ($this->options as $option) {
            $str .= " ".$option[0].(isset($option[1]) ? ' "'.$option[1].'"': "");
        }
        return $str." ";
    }

    public function out($file = "") {
        $output = "";
        $cmd = $this->bin.$this->options_tostring().$file;
        exec($cmd, $output);
        print_r($cmd);
    }


}