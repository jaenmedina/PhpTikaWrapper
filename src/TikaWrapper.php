<?php

use Symfony\Component\Process\Process;

class TikaWrapper {

    /**
     * @var Symfony\Component\Process\Process
     */
    protected $serverProcess;

    /**
     * @param string $option
     * @param string $fileName
     * @return string
     * @throws RuntimeException
     */
    private static function run($option, $fileName){
        $file = new SplFileInfo($fileName);
        $shellCommand = 'java -jar tika-app-1.8.jar ' . $option . ' "' . $file->getRealPath() . '"';

        $process = new Process($shellCommand);
        $process->setWorkingDirectory(VENDOR_PATH);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new RuntimeException($process->getErrorOutput());
        }

        return $process->getOutput();
    }

    /**
     * @param int $portNumber
     * @return string
     */
    public function startServer($portNumber){
        $shellCommand = 'java -jar tika-app-1.8.jar --server ' . $portNumber ;
        $this->serverProcess = new Process($shellCommand);
        $this->serverProcess->setWorkingDirectory(VENDOR_PATH);
        $this->serverProcess->start();
    }

    public function stopServer(){
        $this->serverProcess->stop();
    }

    public function __destruct(){
        $this->stopServer();
    }

    /**
     * @param string $fileName
     * @return int
     */
    public static function getWordCount($fileName){
        return str_word_count(self::getText($fileName));
    }

    /**
     * Options
     */

    /**
     * @param $filename
     * @return string
     */
    public static function getXHTML($filename){
        return self::run("--xml", $filename);
    }

    /**
     * @param $filename
     * @return string
     */
    public static function getHTML($filename){
        return self::run("--html", $filename);
    }

    /**
     * @param string $filename
     * @return string
     */
    public static function getText($filename) {
        return self::run("--text", $filename);
    }

    /**
     * @param $filename
     * @return string
     */
    public static function getTextMain($filename){
        return self::run("--text-main", $filename);
    }

    /**
     * @param $filename
     * @return string
     */
    public static function getMetadata($filename){
        return self::run("--metadata", $filename);
    }

    /**
     * @param $filename
     * @return string
     */
    public static function getJson($filename){
        return self::run("--json", $filename);
    }

    /**
     * @param $filename
     * @return string
     */
    public static function getXmp($filename){
        return self::run("--xmp", $filename);
    }

    /**
     * @param $filename
     * @return string
     */
    public static function getLanguage($filename){
        return self::run("--language", $filename);
    }

    /**
     * @param $filename
     * @return string
     */
    public static function getDocumentType($filename){
        return self::run("--detect", $filename);
    }

}