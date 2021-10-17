<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Generator_Template {
    /* @var string */
    protected $template_dir;

    /**
     * @param string $dir
     */
    function __construct($dir) {
        $this->template_dir = (string)$dir;
    }

    /**
     * @param string $templateFile
     * @param array $opts
     * @return string
     */
    function get($templateFile, $opts) {
        ob_start();

        extract($opts);

        $template_path = $this->template_dir . DIRECTORY_SEPARATOR . "$templateFile.tpl.php";
        if(!file_exists($template_path)) {
            throw new phpMorphy_Exception("Template '$template_path' not found");
        }

        include($template_path);

        $content = ob_get_contents();
        if(!ob_end_clean()) {
            throw new phpMorphy_Exception("Can`t invoke ob_end_clean()");
        }

        return $content;
    }
};