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
	if (file_exists($tijdbestand)) {
		$oudetijd = file_get_contents($tijdbestand);
		$nieuwetijd = $oudetijd + 5;
		if (time() >= $nieuwetijd) {
			file_put_contents($tijdbestand, time()) or die();
		} else {
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