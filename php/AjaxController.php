<?php

class ProjektRequest {

    private $empfaenger = 'info@just-refresh.de'; // <-- Email Anpassen

	/**
	* constructor
	*/
	public function __construct() {}

	/**
	* execute
	*/
	public function execute(){

		$jsonObject = null;
        $response  = null;
        $error  = null;

		if (isset($_POST['jsonObject'])){
			// JSON-String parsen damit auf das Objekt zugegriffen werden kann
			$jsonObject = json_decode($_POST['jsonObject']);
		}

		switch ($jsonObject->action) {

            //sendProjektRequest
            case 'sendProjektRequest':
                if( !$jsonObject->datenschutz ){
                    $error[] = 'datenschutz';
                }
                if(strlen($jsonObject->name) < 1){
                    $error[] = 'emptyName';
                }
                if(!filter_var($jsonObject->email, FILTER_VALIDATE_EMAIL)){
                    $error[] = 'emptyEmail';
                }
                //keineFehler gefunden
                if(!isset($error)){
                    $header  = "MIME-Version: 1.0\r\n";
                    $header .= "Content-type: text/html; charset=utf-8\r\n";
                    $betreff = 'Projektanfrage';
                    $bodyEmail = "Name: <b>" .htmlspecialchars($jsonObject->name, ENT_QUOTES). "</b><br>Email: <b>"
                    .htmlspecialchars($jsonObject->email, ENT_QUOTES) ."</b><br>Telefon: <b>"
                    .htmlspecialchars($jsonObject->telefon, ENT_QUOTES)."</b><br>Textarea: <b>"
                    .htmlspecialchars($jsonObject->textarea, ENT_QUOTES) ."</b><br>";

                    for($i = 0; $i < sizeof($jsonObject->FragenList); $i++){
                        $bodyEmail .= "<br>".$jsonObject->FragenList[$i].": <b>".$jsonObject->AntwortenList[$i]."</b>";
                    }

                    mail($this->empfaenger, $betreff, $bodyEmail, $header);
                    $content = file_get_contents("../html_templates/Template.html");
                    //RueckgabeArray fuellen mit der Methode und dem Content
                    $response = array(
                        "method" => 'sendProjektRequest_true',
                        "content" => $content
                    );
                }
                else{
                    //RueckgabeArray fuellen mit der Methode und dem Fehler Array
                    $response = array(
                        "method" => 'sendProjektRequest_false',
                        "error" => $error
                    );
                }
            break;//end sendProjektRequest


			//sendContactmail
            case 'sendContactmail':
                if( !$jsonObject->datenschutz ){
                    $error[] = 'datenschutz';
                }
                if(strlen($jsonObject->name) < 1){
                    $error[] = 'emptyName';
                }
                if(!filter_var($jsonObject->email, FILTER_VALIDATE_EMAIL)){
                    $error[] = 'emptyEmail';
                }
                if(strlen($jsonObject->textarea) < 1){
                    $error[] = 'emptyTextarea';
                }
                //keineFehler gefunden
                if(!isset($error)){
                    $header  = "MIME-Version: 1.0\r\n";
                    $header .= "Content-type: text/html; charset=utf-8\r\n";
                    $betreff = 'Kontaktmail';
                    $bodyEmail = "Name: <b>".htmlspecialchars($jsonObject->name, ENT_QUOTES) ."</b><br>Email: <b>"
                    .htmlspecialchars($jsonObject->email, ENT_QUOTES) ."</b><br>Telefon: <b>"
                    .htmlspecialchars($jsonObject->telefon, ENT_QUOTES)."</b><br>Textarea: <b>"
                    .htmlspecialchars($jsonObject->textarea, ENT_QUOTES) ."</b><br>";

                    mail($this->empfaenger, $betreff, $bodyEmail, $header);
                    $content = file_get_contents("../html_templates/Template.html");
                    //RueckgabeArray fuellen mit der Methode und dem Content
                    $response = array(
                        "method" => 'sendContactmail_true',
                        "content" => $content
                    );
                }
                else{
                    $response = array(
                        "method" => 'sendContactmail_false',
                        "error" => $error
                    );
                }
            break;//end sendContactmail


		} //end switchcase

		$response = json_encode($response);

		return $response;
	} // end function execute


}// end class AjaxController

$Controller = new ProjektRequest();
echo $Controller->execute();

?>
