<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Generator_GramTab {
    /**
     * @param string $outputHeaderFile
     * @param string $outputCppFile
     * @return void
     */
    static function generateCpp($outputHeaderFile, $outputCppFile) {
        $tpl = new phpMorphy_Generator_Template(__DIR__ . '/GramTab/tpl/cpp');
        $helpers = phpMorphy_Dict_GramTab_ConstStorage_Factory::getAllHelpers();

        $declaration = $tpl->get('declaration', array('helpers' => $helpers));
        $definition = $tpl->get('definition', array('helpers' => $helpers, 'header_file' => $outputHeaderFile));

        file_put_contents($outputHeaderFile, $declaration);
        file_put_contents($outputCppFile, $definition);
    }

    /**
     * @param string $outputFile
     * @return void
     */
    static function generatePhp($outputFile) {
        $tpl = new phpMorphy_Generator_Template(__DIR__ . '/GramTab/tpl/php');
        $consts = phpMorphy_Dict_GramTab_ConstStorage_Factory::getAllHelpers();
        $helper = new phpMorphy_Generator_GramTab_HelperPhp();

        $content = $tpl->get(
            'gramtab',
            array(
                 'helper' => $helper,
                 'all_constants' => $consts
            )
        );

        @mkdir(dirname($outputFile), 0744, true);
        file_put_contents($outputFile, $content);
    }
}