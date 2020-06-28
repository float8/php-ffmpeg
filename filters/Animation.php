<?php


namespace ffmpeg\filters;


class Animation
{
    private  $args = [];

    private $opt = "";

    public function option($val){
        $this->opt = $val;
        return $this;
    }

    private function val($val) {
        if(!is_null($val)) {
            $this->args[$this->opt]['val'] = $val;
        }
        return $this;
    }

    public function start($val) {
        $this->args[$this->opt]['start'] = $val;
        return $this;
    }

    public function end($val) {
        $this->args[$this->opt]['end'] = $val;
        return $this;
    }

    public function x($val = null) {
        $this->option('x');
        $this->val($val);
        return $this;
    }

    public function n() {
        $this->option('n');
        return $this;
    }

    public function t() {
        $this->option('t');
        return $this;
    }

    public function y($val = null) {
        $this->option('y');
        $this->val($val);
        return $this;
    }

    public function alpha($val = null) {
        $this->option('alpha');
        $this->val($val);
        return $this;
    }

    public function mode($val) {
        $this->option('mode');
        $this->val($val);
        return $this;
    }

    public function getArgs($map) {
        $_args = [];
        foreach ($this->args as $k=>$v){
            $_args[$map[$k]] = $v;
        }
        return $_args;
    }

}