<?php
    $base_url = 'https://api.zuwinda.com/v1/message/send-whatsapp';
    $secret_key = 'your zuwinda secret key webhook';
    $zuwinda_token = 'your zuwinda token';
    $post_data = file_get_contents('php://input');
    $json = json_decode($post_data);
    $signature = hash_hmac('sha256', json_encode($json->data), $secret_key);
    $headers = getallheaders();
    if ($headers['X-Zuwinda-Signature'] == $signature) {
        $data = $json->data;
        // log response from webhook
        error_log(json_encode($data));
        // filter by event message received 
        if ($data->event == "WHATSAPP_MESSAGE_RECEIVED") {
            // your action
            if ($data->content == "!halo") {
                $ch = curl_init( $base_url );
                $payload = json_encode( array( "instances_id" => $data->instances_id, "to" => $data->from, "content" => "Halo zuwinda 🥳" ) );
                curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
                curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'x-access-key:' . $zuwinda_token));
                curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
                $result = curl_exec($ch);
                curl_close($ch);
            }
            if ($data->content == "!button1") {
                $buttons = array(
                    (object)[
                        "buttonId" => "id1", "buttonText" => (object)["displayText" => "button 1", "type" => 1]
                    ]
                );
                $button_message = [
                    "text" => "hello zuwinda 🥳",
                    "footer" => "zuwinda button",
                    "buttons" => $buttons,
                    "headerType" => 1
                ];
                $ch = curl_init( $base_url );
                $payload = json_encode( array( "instances_id" => $data->instances_id, "to" => $data->from, "content" => $button_message ) );
                curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
                curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'x-access-key:' . $zuwinda_token));
                curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
                $result = curl_exec($ch);
                curl_close($ch);
            }
            if ($data->content == "!button2") {
                $buttons = array(
                    (object)[
                        "index" => 1, "urlButton" => (object)["displayText" => "zuwinda", "url" => "https://zuwinda.com"]
                    ],
                    (object)[
                        "index" => 2, "callButton" => (object)["displayText" => "call me", "url" => "+6285156172902"]
                    ]
                );
                $button_message = [
                    "text" => "hello zuwinda 🥳",
                    "footer" => "zuwinda button 2",
                    "templateButtons" => $buttons,
                ];
                $ch = curl_init( $base_url );
                $payload = json_encode( array( "instances_id" => $data->instances_id, "to" => $data->from, "content" => $button_message ) );
                curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
                curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'x-access-key:' . $zuwinda_token));
                curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
                $result = curl_exec($ch);
                curl_close($ch);
            }
            if ($data->content == "!button3") {
                $buttons = array(
                    (object)[
                        "title" => "Check Status", "rows" => array((object)["title" => "Healthy", "rowId" => "option1"], (object)["title" => "Love", "rowId" => "option2", "description" => "This is example description"])
                    ],
                );
                $button_message = [
                    "text" => "hello zuwinda 🥳",
                    "footer" => "zuwinda button 3",
                    "title" => "Title Example",
                    "buttonText" => "Required, text on the button to view the list",
                    "sections" => $buttons,
                ];
                $ch = curl_init( $base_url );
                $payload = json_encode( array( "instances_id" => $data->instances_id, "to" => $data->from, "content" => $button_message ) );
                curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
                curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'x-access-key:' . $zuwinda_token));
                curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
                $result = curl_exec($ch);
                curl_close($ch);
            }
        }
    }
?>