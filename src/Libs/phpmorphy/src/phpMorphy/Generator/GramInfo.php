<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Generator_GramInfo {
    /**
     * @param string $outputDirectory
     * @return void
     */
    static function generate($outputDirectory) {
        $storage_ary = array('File', 'Mem', 'Shm');

        $tpl = new phpMorphy_Generator_Template(__DIR__ . '/GramInfo/tpl');
        $helper_class = "phpMorphy_Generator_TemplateHelper_Fsa";

        foreach($storage_ary as $storage_name) {
            $storage_class = "phpMorphy_Generator_StorageHelper_" . ucfirst($storage_name);
            $helper = new phpMorphy_Generator_GramInfo_Helper($tpl, new $storage_class());

            $result = $tpl->get('graminfo', array('helper' => $helper));

            $file_path =
                    $outputDirectory . DIRECTORY_SEPARATOR .
                    phpMorphy_Loader::classNameToFilePath($helper->getClassName());

            @mkdir(dirname($file_path), 0744, true);
            file_put_contents($file_path, $result);
        }
    }
}