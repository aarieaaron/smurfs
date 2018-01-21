<?php
function humanTiming ($time)
{

    $time = time() - $time; // to get the time since that moment
    $time = ($time<1)? 1 : $time;
    $tokens = array (
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second'
    );

    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
    }

}

function dump_var($var){
  echo "<pre>";
  print_r($var);
  echo "</pre>";
}

function withStatus($content, $status){
  //Define result as an object
  $result = new stdClass();
  //add $content and $status arguments to result
  $result->content = $content;
  $result->status = $status;
  //returns the result
  return $result;
}

function get_favorite_weapon($stats){
  $array = [];
  $weapons = [
    "knife",
    "hegrenade",
    "glock",
    "deagle",
    "elite",
    "fiveseven",
    "xm1014",
    "mac10",
    "ump45",
    "p90",
    "awp",
    "ak47",
    "aug",
    "famas",
    "g3sg1",
    "m249",
    "hkp2000",
    "p250",
    "sg556",
    "scar20",
    "ssg08",
    "mp7",
    "mp9",
    "nova",
    "negev",
    "sawedoff",
    "bizon",
    "tec9",
    "mag7",
    "m4a1",
    "galilar",
    "taser",
    'molotov'
  ];

  foreach($stats as $stat){
    if(strrpos($stat->name, "total_kills_") > -1){
      $weapon = str_replace("total_kills_", '', ($stat->name));
      if(in_array($weapon, $weapons)){
        $array[$weapon] = $stat->value;
      }
    }
  }
  asort($array);
  end($array);
  $response = new stdClass();
  $response->gun = key($array);
  $response->kills = end($array);;
  return $response;
}
?>
