<?php

//global $code_dip;
$code_dip= $_GET['diplome'];

class ICS {
    var $data = "";
    var $name;
    var $start = "BEGIN:VCALENDAR\nVERSION:2.0\nMETHOD:PUBLISH\n";
    var $end = "END:VCALENDAR\n";
    function ICS($name) {
        $this->name = $name;
    }
    function add($start,$end,$name,$description,$location) {
        $this->data .= "BEGIN:VEVENT\nDTSTART:".date("Ymd\THis\Z",strtotime($start))."\nDTEND:".date("Ymd\THis\Z",strtotime($end))."\nLOCATION:".$location."\nTRANSP: OPAQUE\nSEQUENCE:0\nUID:\nDTSTAMP:".date("Ymd\THis\Z")."\nSUMMARY:".$name."\nDESCRIPTION:".$description."\nPRIORITY:1\nCLASS:PUBLIC\nBEGIN:VALARM\nTRIGGER:-PT10080M\nACTION:DISPLAY\nDESCRIPTION:Reminder\nEND:VALARM\nEND:VEVENT\n";
    }
    function save() {
        file_put_contents($this->name.".ics",$this->getData());
    }
    function show($code_dip) {
        header("Content-type:text/calendar");
        header('Content-Disposition: attachment; filename="'.$this->name.'_'.$code_dip.'.ics"');
        Header('Content-Length: '.strlen($this->getData()));
        Header('Connection: close');
        echo $this->getData();
    }
    function getData() {
        return $this->start . $this->data . $this->end;
    }
}
?>
<?php
// Get the contents of the JSON file 
$strJsonFileContents = file_get_contents('json/events_'.$code_dip.'.json');
//var_dump($strJsonFileContents); // show contents
$seances = json_decode($strJsonFileContents, true);
//print_r($seances);
$event = new ICS("EDT");
foreach($seances as $seance){
    $event->add($seance['start'], $seance['end'],$seance['title'],$seance['enseignant'],$seance['salle']);
}


$event->show($code_dip);



?>