<?php
function sendMessage(){
    $content = array(
      "en" => 'hello'
      );
    
    $fields = array(
      'app_id' => "bf066476-7d73-11e5-9cff-a0369f2d9328",
      'included_segments' => array('All'),
      'send_after' => 'Fri May 02 2014 00:00:00 GMT-0700 (PDT)',
      'data' => array("foo" => "bar"),
      'contents' => $content
    );
    
    $fields = json_encode($fields);
    print("\nJSON sent:\n");
    print($fields);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
                           'Authorization: Basic YmYwNjY1MzQtN2Q3My0xMWU1LTljZmYtYTAzNjlmMmQ5MzI4'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    $response = curl_exec($ch);
    curl_close($ch);
    
    return $response;
  }
  
  $response = sendMessage();
  $return["allresponses"] = $response;
  $return = json_encode( $return);
  
  print("\n\nJSON received:\n");
  print($return);
  print("\n")
?>