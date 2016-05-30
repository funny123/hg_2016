<?php
/**********************************
 * Created by PhpStorm
 * User: funny
 * Date: 2015/12/23
 * Time: 10:22
 */
function tel_sub($tel='13270968527'){
    return str_replace(substr($tel,3,4),'****',$tel);
}



/**
 * 数字转字母 （类似于Excel列标）
 * @param Int $index 索引值
 * @param Int $start 字母起始值
 * @return String 返回字母
 * @author Anyon Zou <Anyon@139.com>
 * @date 2013-08-15 20:18
 */
function IntToChr($index, $start = 65) {
    $str = '';
    if (floor($index / 26) > 0) {
        $str .= IntToChr(floor($index / 26)-1);
    }
    return $str . chr($index % 26 + $start);
}

?>
 