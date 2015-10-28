<?php

class SEO_URL{
        static function Filter( $str )
        {
                return str_replace( 
                                 array( ' ', ' ', '/', '~', 'á', 'é', 'í', 'ó', 'ú', 'â', 'ê', 'î', 'ô', 'û', 'à', 'è', 'ì', 'ò', 'ù', 'ã', 'õ', 'ç', 'ñ', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Â', 'Ê', 'Î', 'Ô', 'Û', 'À', 'È', 'Ì', 'Ò', 'Ù', 'Ã', 'Õ', 'Ç', 'Ñ' ) // original
                                ,array( '-', '-', '-', '_', 'a', 'e', 'i', 'o', 'u', 'a', 'e', 'i', 'o', 'u', 'a', 'e', 'i', 'o', 'u', 'a', 'o', 'c', 'n', 'A', 'E', 'I', 'O', 'U', 'A', 'E', 'I', 'O', 'U', 'A', 'E', 'I', 'O', 'U', 'A', 'O', 'C', 'N' )  // substituto
                                ,$str );
        }
        static function Strip( $str )
    {
                return self::Filter( trim( substr( $str, 0, 140 ) ) );
    }
}

?>