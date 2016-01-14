<?php
define('FLAG', 'DCTF{try harder}');
define('P2','Password147186970!');
define('P3', 2000000);  

$arg  = 'D';
$init = ( ( $arg == 'D' ) ? 'w' :
             ( $arg == '-' ) ? 't' :
             ( $arg == 'C' ) ? 'f' :
             ( $arg == 'T' ) ? 'm' :
             ( $arg == 'F' ) ? 'a' :
             'n' );

if(isset($_GET[6]) && !is_array($_GET[6]) && strlen($_GET[6]) === 7 && '13337' == $_GET[6] &&
   isset($_GET[7]) && !is_array($_GET[7]) && strlen($_GET[7]) === 1 && '2.0' == $_GET[7] &&
   isset($_GET[8]) && !is_array($_GET[8]) &&
   isset($_GET[9]) && !is_array($_GET[9]) && strlen($_GET[9]) === 10 &&
   isset($_GET[10]) && !is_array($_GET[10]) && strlen($_GET[10]) === 10 &&
   $_GET[9] + $_GET[10] === 10) {
	if(isset($_GET[1]) && strcmp($_GET[1], P1) == 0) {
		if(isset($_GET[2]) && !is_array($_GET[2]) && sha1(intval($_GET[2])) == md5(P2)) {
			if(isset($_GET[3]) && !is_array($_GET[3]) && strlen($_GET[3]) === 6 &&
			   isset($_GET[4]) && !is_array($_GET[4]) && strlen($_GET[4]) === 3 &&
			   $_GET[3] == $_GET[4] && $_GET[3] == P3 && $_GET[4] == P3) {

					if(isset($_GET[5]) && !is_array($_GET[5]) && strlen($_GET[5]) === 2 && 31337 > $_GET[5]) {
						  
						$hash = md5(str_repeat($init, 3) . base64_decode($_GET[8]). str_repeat($init,3));
						
						if($hash == "0"){
							$uh = unserialize($_GET[11]);
							die($uh);
						}
					}	
				}
		}
	} 
}

class Flag
{     
    public function __toString()
    {
        return 'Flag: '.FLAG;
    }
}

die('Try harder.');