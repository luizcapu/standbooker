<?php

/**
 *	(llbra) - www.llbra.tk - llbra@bol.com.br
 *	GNU General Public License (GPL) 
 */
 
/* $Id: ValidateEmail.class.php,v 0.0.01 2004/08/08 12:31:40 llbra Exp $ */

/**
 *	Validate Email Class v 0.0.01
 *	
 *	Class for Email Validation. Has a simples regexp in case of trouble with
 *	the others. Has a 2nd regexp for validating emails with subdomains. And
 *	has a email size limit option.
 *	Just read the script for more details. It´s all described and commented.
 *
 *	Tests are on the bottom. Call checkEmail() to check one email
 */

class ValidateEmail {

    /**
	 * either to allow or not emails like "user@ww2.server.org" or
     * "user@srv1.server.org.xx"
     * 
     * emails like "user@server.org.xx should match without this set 'false'
     * and also the "email@server.info" that some doesn´t match
     *
     * normally, this set to 'false' should do for most email on the net
     * and works to for the "email@mike.zzn.com" because zzn is 3 chars
     *
     * $allowSubdomain has more chance to match invalid emails. So you
     * can make an experience and see if it´s really necessary to set it to
     * 'true'. You can record some of the failure ones and check them, make a
     * list of the ones who returned false or even moderate manualy this ones.
     */
	var $allowSubdomain =  false;
	// this one is set on constructor and allows for all
	var $allowSubdomainForAll = false; 
	
    // default regexp for the email matching
    var $defaultEr = "[a-z]+([\._\-]?[a-z0-9]+)*@([a-z0-9])+(-?[a-z0-9]+)*(\.([a-z0-9]){2,4}){1}(\.([a-z0-9]){2})?";
                    
    var $lengthLimit = 0; // limit size for the email. 0 for no limit
    
    var $res = false; // the result of the email match	
	
	// a simple er for matching valid emails. see the uses above:
	var $simpleEr = "[^@]+@[^.]+(\.[^.]+)+";	
	// allow simple ER mode, that has a simple ER that allow many wrong 
	// emails to pass but also doesn´t block any kind of real email, so
	// nobody will complain of real emails being block. It´s a choice you
	// make. Useful for systems that send a check email with a 
	// verification code.
	var $useSimpleEr = false;
	// this one is set on constructor and allows for all
	var $useSimpleErForAll = false;
    
	/**	*constructor*
	 *	void *constructor* ValidateEmail( boolean $allowSd,
	 *									  boolean $useSimpleEr )
	 *
	 *	@param bool $allowSd Either to allow or not subdomains on emails
	 *	@param bool $useSimpleEr Either to use or not a simple regexp
	 *	@desc Used to set the class parameters
	 *	@author llbra
	 */
    function ValidateEmail ($allowSd=false, $useSimpleEr=false){
        
		$this->allowSubdomainForAll = ($allowSd) ? true : false;
			
		$this->useSimpleErForAll = ($useSimpleEr) ? true : false;

    }
    
	/**
	 *	bool checkEmail( string $email, bool $allowSd, bool $useSimpleEr )
	 *
	 *	@param string $email Email that is going to be checked
	 *	@param bool $allowSd Either to allow or not subdomains on email
	 *	@param bool $useSimpleEr Either to use or not a simple regexp
	 *	@desc Used to check if a email is valid or not
	 *	@author llbra
	 */
    function checkEmail ($email, $allowSd=false, $useSimpleEr=false){
    	
		$this->allowSubdomain = ($allowSd || $this->allowSubdomainForAll)
							  ? true : false;
			
		$this->useSimpleEr = ($useSimpleEr || $this->useSimpleErForAll) 
						   ? true : false;
			
		if(!$this->useSimpleEr)
        	return $this->matchEmail ($email);
		else
			return preg_match ("'$this->simpleEr'is",$email,$matches);
    	
    }
    
	/**
	 *	bool matchEmail( string $email )
	 *
	 *	@param string $email Email that is going to be checked
	 *	@desc Does the checking job. Can be used instead of checkEmail()
	 *	@author llbra
	 */
	function matchEmail ($email){

        if (!$this->allowSubdomain){
            
            $er = $this->defaultEr;
            
        }else{
            
            /**
             *  checking fot @ and returning everyting after it
             *  we will use it to check for "." occurences
             */
            if ( !($em = strstr ($email, "@")) )
                return false;
            
            /**
             *  if $em is empty we return false and we match the "." (dots)
             */
            if ( !empty ($em) )
                preg_match_all ("'\.'is", $em, $matches);
            else
                return false;
                
            /**
             *  if less than 2 "." we use the defaultEr cause its the same
             *  of having no subdomain
             */   
            if ( count ($matches[0]) > 1 ){
            
                $er = "([a-z])+([a-z0-9])+([\._-]?[a-z0-9])*"
                        ."@"
                        ."(([a-z0-9])+(-?[a-z0-9]+)*){1}"
                        ."((\.[a-z0-9])+(-?[a-z0-9]+)*)*"
                        ."(\.([a-z0-9]){2,4}){1,2}";
            }else
            
            	$er = $this->defaultEr;
            
        }
        
        $this->res = preg_match ("'^$er$'is", $email, $matches);
              
        if ($this->lengthLimit)
            $this->res = $this->res && ($matches[0]<=$this->lengthLimit);
        
        return $this->res; 

    }


}

// Above you can find some examples of use

/** //ONE USE:

$email = "email@yahoo.com.br";

$v = new ValidateEmail ();
$valid = $v->checkEmail($email);

if (!$valid)
    echo "Invalid email: $email";
    
*/	
/** //MAIN TEST

$v = new ValidateEmail ();

$valid["llbra@yahoo.com"]       = $v->checkEmail("llbra@yahoo.com");
$valid["llbra@yahoo"]           = $v->checkEmail("llbra@yahoo");
$valid[".llbra@yahoo.com"]      = $v->checkEmail(".llbra@yahoo.com");
$valid["llbra@yahoo.com.br"]    = $v->checkEmail("llbra@yahoo.com.br");
$valid["llbra@yahoo.com.br.br"] = $v->checkEmail("llbra@yahoo.com.br.br");
$valid["llbra@yahoo.c"] 		= $v->checkEmail("llbra@yahoo.c");
$valid["llbra@uol.com.br.br"] 	= $v->checkEmail("llbra@uol.com.br.br");
$valid["-llbra@uol.com.br"] 	= $v->checkEmail("-llbra@uol.com.br");
$valid["l-lbra@uol.com.br"] 	= $v->checkEmail("l-lbra@uol.com.br");
$valid["ll_bra@uol.com.br"] 	= $v->checkEmail("ll_bra@uol.com.br");
$valid["ll.bra@uol.com.br"] 	= $v->checkEmail("ll.bra@uol.com.br");
$valid["llbra@u-o-l.com.br"] 	= $v->checkEmail("llbra@u-o-l.com.br");
$valid["9llbra@uol.com.br"]   	= $v->checkEmail("9llbra@uol.com.br");
$valid["llbra9@uol.com.br"]   	= $v->checkEmail("llbra9@uol.com.br");
$valid["llbra@2xr.com.br"]   	= $v->checkEmail("llbra@2xr.com.br");
$valid["ll---bra@2x-r.com.br"]  = $v->checkEmail("ll---bra@2x-r.com.br");
$valid["ll---bra@2x--r.com.br"] = $v->checkEmail("ll---bra@2x--r.com.br");

$valid["llbra@br.yahoo.com"]    = $v->checkEmail("llbra@br.yahoo.com");
$valid["bra@mx1.yahoo.com.br"]  = $v->checkEmail("bra@mx1.yahoo.com.br");

$valid["llbra@br.yahoo.com,true"]    = $v->checkEmail("llbra@br.yahoo.com",true);
$valid["bra@mx1.yahoo.com.br,true"]  = $v->checkEmail("bra@mx1.yahoo.com.br",true);

echo "<pre>";
var_dump($valid);
echo "</pre>";

*/

?>
