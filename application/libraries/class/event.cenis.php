<?php
/*
* plugin calendar de google
* Desarrollador: Henry oy
* Correo: henry.oy@ticc.com.mx
* version: 1.0.0
* Fecha: 20/01/2016 
*/

class Event {
	
	private $Email;
	private $Summary;
	private $Location;
	private $Description;
	private $Creator;
	private $Organizer;
	private $Start;
	private $End;
	private $Recurrence;
	private $Attendees;
	private $ColorId;
	private $Reminders;
	private $Visibility;
	private $Transparency;
	private $originalStartTime;
	private $Attachment;
	private $SupportsAttachments;
	
	public function setEmail($email)
	{
		$this->Email = $email;
	}
	public function getEmail()
	{
		return $this->Email;
	}
	public function setSummary($summary)
	{
		$this->Summary = $summary;
	}
	public function getSummary()
	{
		return $this->Summary;
	}
	public function setLocation($location)
	{
		$this->Location = $location;
	}
	public function getLocation()
	{
		return $this->Location;
	}
	public function setDescription($description)
	{
		$this->Description = $description;
	}
	public function getDescription()
	{
		return $this->Description;
	}
	public function setCreator($creator)
	{
		$this->Creator = $creator;
	}
	public function getCreator()
	{
		return $this->Creator;
	}
	public function setOrganizer($organizer)
	{
		$this->Organizer = $organizer;
	}
	public function getOrganizer()
	{
		return $this->Organizer;
	}
	public function setStart($start){
		$this->Start = $start;
	}
	public function getStart(){
		return $this->Start;
	}
	public function setEnd($end){
		$this->End = $end;
	}
	public function getEnd(){
		return $this->End;
	}
	public function setRecurrence($recurrence = array('RRULE:FREQ=DAILY;COUNT=2')){
		$this->Recurrence = $recurrence;
	}
	public function getRecurrence(){
		return $this->Recurrence;
	}
	public function setAttendees($attendees){
		$this->Attendees = $attendees;
	}
	public function getAttendees(){
		return $this->Attendees;
	}
	
	public function setColorId($colorId){
		$this->ColorId = $colorId;
	}
	public function getColorId(){
		return $this->ColorId;
	}
	
	public function getReminders(){
		return $this->Reminders;
	}
	
	public function setReminders( $Reminders ){
		$this->Reminders = $Reminders;
	}
	
	public function getVisibility(){
		return $this->Visibility;
	}
	
	public function setVisibility( $Visibility ){
		$this->Visibility = $Visibility;
	}
	public function getTransparency(){
		return $this->Transparency;
	}
	public function setTransparency( $trans ){
		$this->Transparency = $trans;
	}
	public function setOriginalStartTime($org){
		$this->originalStartTime = $org;
	}
	public function GetOriginalStartTime(){
		return $this->originalStartTime;
	}
	public function setAttachment($Attachment){
		 $this->Attachment = $Attachment;
	}
	public function getAttachment(){
		return $this->Attachment;
	}
	
	public function getSupportsAttachments(){
		return $this->SupportsAttachments;
	}
	
	public function setSupportsAttachments($SupportsAttachments){
		$this->SupportsAttachments = $SupportsAttachments;
	}
	
	public function ReturnArray(){
		$evento = array();
		$reminder = array();
		try{

			$evento = array(
					'summary' => $this->getSummary(),
					'location' => $this->getLocation(),
					'description' => $this->getDescription(),
					'creator' => $this->getCreator(),
					'organizer' => $this->getOrganizer(),					
					'start' => $this->getStart(),
					'end' => $this->getEnd(),
					'supportsAttachments' => $this->getSupportsAttachments(),
					'recurrence' => $this->getRecurrence(),
					'attendees' => $this->getAttendees(),
					'visibility' => $this->getVisibility(),
					'guestsCanInviteOthers' => false,
					'transparency' => $this->getTransparency(),
					'attachments' => $this->getAttachment(),
					'reminders' => array(
									'useDefault' => FALSE,
											'overrides' => array(
												array('method' => 'email', 'minutes' => 24 * 60),
												array('method' => 'popup', 'minutes' => 10),
											),
								),
					"originalStartTime" => $this->originalStartTime
					);
			
			if(!empty($this->getColorId())){	
				array_push($evento,array('colorId' => $this->getColorId()));		
			}			
			
		}catch(EXception $e){
			echo 'Excepci&oacute;n capturada: ',  $e->getMessage(), "\n";
		}
		return $evento;
	}
}
?>