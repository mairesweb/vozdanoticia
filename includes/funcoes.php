<?php

function remover_caracter($string) {
    $string = mb_convert_case($string, MB_CASE_LOWER, 'UTF-8');
    $string = retira_acentos($string);
    $string = preg_replace("/ /", "_", $string);
    $string = str_replace("ç", "c", $string);
    $string = preg_replace("/[^a-z0-9_]/", "", $string);
    return $string;
}

function retira_acentos($str) {

    $from = "áàãâéêíóôõúüçñÁÀÃÂÉÊÍÓÔÕÚÜÇÑ";
    $to = "aaaaeeiooouucnAAAAEEIOOOUUCN";

    $keys = array();
    $values = array();
    preg_match_all('/./u', $from, $keys);
    preg_match_all('/./u', $to, $values);
    $mapping = array_combine($keys[0], $values[0]);
    return strtr($str, $mapping);
}
