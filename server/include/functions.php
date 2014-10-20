<?php
/*
 * Вспомогательные функции
 */


function dle_strrpos($str, $needle, $charset ) {

	if ( strtolower($charset) == "utf-8") return iconv_strrpos($str, $needle, "utf-8");
	else return strrpos($str, $needle);

}



?>