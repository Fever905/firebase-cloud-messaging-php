<?php

// The most simple way to send Google Firebase Cloud Messaging Push Notifications
// By Michael DeMutis / Fever905  demutis@gmail.com  https://demutis.com
// Requires PHP-Curl to be installed on your server.  Most will have it.

// Configure your notification here

$android_topic = 'SAMPLE_TOPIC';
$name = 'Notification name';
$title = 'Notification title';
$body = 'This is the body of the notification that will be sent to the phone/device.';
$android_sound = "my_sound"; //Android 7 and lower, specify sound here. For 8+ you must create a channel in your app and define sound & vibration there
$ios_sound = 'my_sound.caf';
$badge = 1;  // Badge number to display in notification area
$channel = "SAMPLE_CHANNEL";  // Android 8+ Channel needs to match channel_id you created in your android-app
$priority = 'High';
$color = '#E0002D'; // The color that the title will show up as in the notification window


$data = array(
    "to" => "/topics/" . $android_topic,
	"name" => $name, 
    "notification" => array (
        "title" => $title ,
		"priority" => $priority,
		"sound" => $android_sound,
		"android_channel_id" => $channel, 
		"notification_android_color" => $color,  
        "body" => $body
	),
	"apns" => array (
		"payload" => array (
			"aps" => array (
				"sound" => $ios_sound, 
				"badge" => $badge, 
			)
		)
	),
	"data" => array (
        "notification_foreground" => "true", /* Will display in forgreound even when app is running.  */
		"notification_ios_sound" => $ios_sound,   
		"notification_body"  => $body,
    	"notification_title" => $title,
		"notification_ios_badge" => $badge,
		"notification_android_channel_id" => $channel,
		"notification_android_color" => $color,
	
	)	
);


$url = "https://fcm.googleapis.com/fcm/send";
$ch = curl_init( $url );
$payload = str_replace("[","",str_replace("]","",json_encode(array($data))));  // Need to remove [ and ] from the json or it wont work
curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',
	'Authorization:key=ZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZ',
    'Content-Length: ' . strlen($payload))); 
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
$result = curl_exec($ch);  // Send notification
curl_close($ch);
echo "Payload:<pre>$payload</pre>"; // for debug - shows what got sent
echo "Result:<pre>$result</pre>"; // show the results of the cloud message send
