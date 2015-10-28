<?php

header("Content-Type: text/html; charset=ISO-8859-1",true);

require_once "../business/LocationBus.class.php";

$lst = @LocationBus :: listByCountryId($_POST["countryId"]);

$txt = "<items>";

if ((is_array($lst)) && (count($lst) > 0)){

	foreach ($lst as $it) {
    	$label = $it->getName();
    	$id = $it->getLocationId();
    	$txt .= "<item>";
    	$txt .= "<id>$id</id>";
    	$txt .= "<label>$label</label>";
    	$txt .= "</item>";   
	}
	
}


$txt .= "</items>";
echo $txt;

?>