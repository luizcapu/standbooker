<?php

class SEO_URL{
        static function Filter( $str )
        {
                return str_replace( 
                                 array( ' ', ' ', '/', '~', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�' ) // original
                                ,array( '-', '-', '-', '_', 'a', 'e', 'i', 'o', 'u', 'a', 'e', 'i', 'o', 'u', 'a', 'e', 'i', 'o', 'u', 'a', 'o', 'c', 'n', 'A', 'E', 'I', 'O', 'U', 'A', 'E', 'I', 'O', 'U', 'A', 'E', 'I', 'O', 'U', 'A', 'O', 'C', 'N' )  // substituto
                                ,$str );
        }
        static function Strip( $str )
    {
                return self::Filter( trim( substr( $str, 0, 140 ) ) );
    }
}

?>