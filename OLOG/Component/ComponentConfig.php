<?php


namespace OLOG\Component;


class ComponentConfig
{
    protected $generate_css;
    protected $generate_js;

    public function __construct($generate_css = false, $generate_js = false)
    {
        $this->setGenerateCss($generate_css);
        $this->setGenerateJs($generate_js);
    }

    /**
     * @return boolean
     */
    public function generateCss()
    {
        return $this->generate_css;
    }

    /**
     * @param boolean $generate_css
     */
    public function setGenerateCss($generate_css)
    {
        $this->generate_css = $generate_css;
    }

    /**
     * @return boolean
     */
    public function generateJs()
    {
        return $this->generate_js;
    }

    /**
     * @param boolean $generate_js
     */
    public function setGenerateJs($generate_js)
    {
        $this->generate_js = $generate_js;
    }
}