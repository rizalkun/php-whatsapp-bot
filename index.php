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
        }
    }
?>