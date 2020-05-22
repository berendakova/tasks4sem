<?php


namespace App\Controller;


class Tmpl
{
    public function render($file, $vars = array())
    {
        if (file_exists('templates/' . $file . '.tmpl')) {
            ob_start();
            extract($vars);

            require 'templates/' . $file . '.tmpl';
            return ob_get_clean();
        } else {
            die('<br>Шаблон не найден!<br>');
        }
    }

    public function readerFile($file)
    {
        global $currentFile;
        if (isset($file)) {
            $tmpl = fopen($file, 'r');
            if ($tmpl) {
                while (!feof($tmpl)) {
                    $currentFile .= fgets($tmpl, 100);
                }
                fclose($tmpl);
            } else {
                die('<br>Шаблон не найден!<br>');
            }
        }

    }

    public function set($tag, $target)
    {
        global $a_cur_file;
        $a_cur_file = str_replace($tag, $target, $a_cur_file);
    }

    public function get()
    {
        global $a_cur_file;
        return $a_cur_file;
    }


}