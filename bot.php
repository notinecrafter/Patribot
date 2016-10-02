<?php
include("Telegram.php");

$bot_id = "287065075:AAE5tHcWv621iOHUUvzcw6gtJSxa13SkWqM";
$telegram = new Telegram($bot_id);
$text = mb_strtolower($telegram->Text());
$chat_id = $telegram->ChatID();

//patriotten
if ($text == "/patriotten" && $telegram->messageFromGroup()) {
	$filename = "./mensies/" . $telegram->Username();
	$tijdbestand = "./tijd/" . $telegram->Username();
	
	//kijken of de gebruiker al bestaat
	if (file_exists($tijdbestand)) {
		//de tijd waarop het weer kan, 5 seconden later dus
		$nieuwetijd = file_get_contents($tijdbestand) + 5;
		if (time() >= $nieuwetijd) {
			//als de delay over is een nieuwe tijd schrijven naar bestand
			file_put_contents($tijdbestand, time()) or die();
		} else {
			//anders gewoon niks doen
			//$telegram->sendMessage(array('chat_id' => $chat_id, 'text' => "Niet zo snel.", 'reply_to_message_id' => $telegram->MessageID()));
			die();
		}
	} else {
		file_put_contents($tijdbestand, time());
	}
	
	if (file_exists($filename)) {
		$oudepunten = file_get_contents($filename);
	} else {
		$oudepunten = 0;
	}
	
	$nieuwepunten = $oudepunten + 5;
	file_put_contents($filename, $nieuwepunten) or die();
	$telegram->sendMessage(array('chat_id' => $chat_id, 'text' => "Je hebt nu " . $nieuwepunten . " patriotjes!", 'reply_to_message_id' => $telegram->MessageID()));
}

else if ($text == "/patriotten" && !$telegram->messageFromGroup()) {
	$telegram->sendMessage(array('chat_id' => $chat_id, 'text' => "Nee. Alleen in een groep.", 'reply_to_message_id' => $telegram->MessageID()));
}
