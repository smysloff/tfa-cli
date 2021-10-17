<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Generator_Fsa {
    /**
     * @param string $outputDirectory
     * @return void
     */
    static function generate($outputDirectory) {
        $helpers_ary = array('Sparse', 'Tree');
        $storage_ary = array('File', 'Mem', 'Shm');

        $tpl = new phpMorphy_Generator_Template(__DIR__ . '/Fsa/tpl');

        foreach ($helpers_ary as $helper_name) {
            $helper_class = "phpMorphy_Generator_Fsa_Helper" . ucfirst($helper_name);

            foreach ($storage_ary as $storage_name) {
                $storage_class = "phpMorphy_Generator_StorageHelper_" . ucfirst($storage_name);
                $helper = new $helper_class($tpl, new $storage_class());

                $result = $tpl->get('fsa', array('helper' => $helper));

                $file_path =
                        $outputDirectory . DIRECTORY_SEPARATOR .
                        phpMorphy_Loader::classNameToFilePath($helper->getClassName());

                @mkdir(dirname($file_path), 0744, true);
                file_put_contents($file_path, $result);
            }
        }
    }
}