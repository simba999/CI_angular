<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of csvreader
 *
 * @author chiragc
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Csvreader {

    var $fields;/** columns names retrieved after parsing */
    var $separator = ',';/** separator used to explode each line */
    var $enclosure = '"';/** enclosure used to decorate each field */
    var $max_row_size = 4096;/** maximum row size to be used for decoding */

    function parse_file($p_Filepath) {
        $file = fopen($p_Filepath, 'r');
        $this->fields = fgetcsv($file, $this->max_row_size);
        $keys_values = explode(',', $this->fields[0]);

        $content = array();
        $keys = $this->escape_string($keys_values);

        $i = 1;
        while (($row = fgetcsv($file, $this->max_row_size)) != false) {
            if ($row != null) { // skip empty lines
                $values = explode(',', $row[0]);
                if (count($keys) == count($values)) {
                    $arr = array();
                    $new_values = array();
                    $new_values = $this->escape_string($values);
                    for ($j = 0; $j < count($keys); $j++) {
                        if ($keys[$j] != "") {
                            $arr[$keys[$j]] = $new_values[$j];
                        }
                    }
                    $content[$i] = $arr;
                    $i++;
                }
            }
        }
        fclose($file);
        return $content;
    }

    function escape_string($data) {
        $result = array();
        foreach ($data as $row) {
            $result[] = str_replace('"', '', $row);
        }
        return $result;
    }

    function parseFile($p_Filepath) {
        $output = array();
        /*var_dump(file($p_Filepath));
        die;*/
        $csvfilerowdatainarray = file($p_Filepath);
        foreach ($csvfilerowdatainarray as $row){
            $output[] = str_getcsv($row,$this->getFileDelimiter($p_Filepath));
        }
        return $output;
    }

    function getFileDelimiter($file, $checkLines = 2) {
        $file = new SplFileObject($file);
        $delimiters = array(
            ',',
            '\t',
            ';',
            '|',
            ':'
        );
        $results = array();
        $i = 0;
        while ($file->valid() && $i <= $checkLines) {
            $line = $file->fgets();
            foreach ($delimiters as $delimiter) {
                $regExp = '/[' . $delimiter . ']/';
                $fields = preg_split($regExp, $line);
                if (count($fields) > 1) {
                    if (!empty($results[$delimiter])) {
                        $results[$delimiter] ++;
                    } else {
                        $results[$delimiter] = 1;
                    }
                }
            }
            $i++;
        }
        $results = array_keys($results, max($results));
        return $results[0];
    }

    function parseFile_old($p_Filepath) {
        return
                array_map('str_getcsv', file($p_Filepath));
    }

}

?>
