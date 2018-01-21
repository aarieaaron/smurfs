<?php
include("functions.php");
/*
This application uses the steam api

*/



//generic cURL function so I don't need to copy the code a trillion times
function call_api($call){
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $call);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  $body = '{}';
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
  curl_setopt($ch, CURLOPT_POSTFIELDS,$body);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  // Timeout in seconds
  curl_setopt($ch, CURLOPT_TIMEOUT, 30);
  $result = curl_exec($ch);

  //Cut out the useless parent elements for the object
  $response = json_decode($result);
  return $response;
  // return $result;

}

//Gets all the csgo statistics for a given profile
function get_csgo_stats($profile){
  $apiKey = "446D9274E9EAB369BE07A6C776A082D5";
  return call_api("http://api.steampowered.com/ISteamUserStats/GetUserStatsForGame/v0002/?appid=730&key={$apiKey}&steamid={$profile}")->playerstats->stats;
}
//Gets all the steam statistics for a given profile
function get_steam_stats($profile){
  $apiKey = "446D9274E9EAB369BE07A6C776A082D5";
  return call_api("http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key={$apiKey}&steamids={$profile}")->response->players[0];
}

//function that loads the users steam games library page and scans the source code
//for the object containing additional game statistics
// dump_var(get_additional_information("76561198805048631", "id"));
function get_additional_information($profile){
  $account_info = file_get_contents($profile."/games/?tab=all");

  //Get the position of the nearest unique identifier for the array
  $begin = strpos($account_info, "var rgGames");
  //Get the position of the opening array character
  $start = strpos($account_info, "[", $begin);
  //Get the position of the end of the array, add one extra so the array is properly closed
  $end =  strpos($account_info, "]", $begin) + 1;
  //Get the contents of whatever is between $start and $end
  $json = (substr($account_info, $start, ($end - $start)));
  //Go from json string to php array (ended up being an StdClass, whoops)
  $array = json_decode($json);

  //Iterate through $array and find all the information related to CSGO
  foreach($array as $item){
    if($item->appid == "730"){
      return withStatus($item, 200);
    }
  }
  //returns false if CSGO is not found in the array
  return withStatus("game not found", 404);
}
// function dump_var($var){
//   echo "<pre>";
//   var_dump($var);
// }
//
// function withStatus($content, $status){
//   //Define result as an object
//   $result = new stdClass();
//   //add $content and $status arguments to result
//   $result->content = $content;
//   $result->status = $status;
//   //returns the result
//   return $result;
// }
?>
