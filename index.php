<?php
include("api.php");

$accounts = [
  "76561198160768434",
  "76561198257798315",
  "76561198031543918",
  "76561198805048631",
  "76561198274451633",
  "76561198273639624"
];
?>
<div class='wrapper'>
  <div class="header">
    <h1>Counter Strike: Global Offensive</h1>
    <h3>account list</h3>
  </div>
<?php
foreach($accounts as $user){
  $userDetails = get_steam_stats($user);
  $csgoDetails = get_csgo_stats($user);
  $miscGameDetails = get_additional_information($userDetails->profileurl);
  $favoriteWeapon = get_favorite_weapon($csgoDetails);
  ?>
  <div class='userContainer'>
    <div class='userImage'>
      <img class="profilePicture" src="<?=$userDetails->avatarfull?>">
    </div>
    <div class="userRest">
      <div class='userTop'>
          <span>
            <?=$userDetails->personaname?>
            |
            <a href='<?=$userDetails->profileurl?>'>
              <?=$userDetails->profileurl?>
            </a>
          </span>
      </div>
      <div class='userBottom'>
        <span>Last Played: <?php echo date('l d-n-Y', $miscGameDetails->content->last_played)?> (<?=humanTiming($miscGameDetails->content->last_played)." ago"?>)</span><br>
        <span>Playtime: <?php echo ($miscGameDetails->content->hours_forever)?> Hours</span><br>
        <span>Favorite weapon: <?=$favoriteWeapon->gun?> kills: <?=$favoriteWeapon->kills?></span>
      </div>
    </div>
  </div>
  <?php
  // echo "<pre>";
  // var_dump($userDetails);
  // dump_var($csgoDetails);
}
echo "</div>";

?>
<style>
.header{
  width: 100%;
  height: 100px;
  background-color: black;
  color: white;
}
body{
  padding: 0px;
  margin: 0px;
}
.wrapper{
  max-width: 1280px;
  margin: auto;
  height: 100%;
  background-color: blue;
}
.userContainer{
  border-bottom: 2px solid red;
  width: 100%;
  height: 110px;
  background-color: #ddd;
}
.userImage{
  float: left;
  margin-top: 5px;
  margin-left: 5px;
  width: 110px;
}
.userTop, .userMiddle{
  width: 100%;
  float: left;
}
.userRest{
  width: calc(100% - 120px);
  float: left;
}
.userTop{
  /*padding-left: 25px;*/
  margin-top: 5px;
  height: 25px;
  font-size: 1.2em;
  border-bottom: 1px solid grey;
}
.userBottom{
  height: 200px;
}
.userContainer{
  float: left;
}
.profilePicture{
  width: auto;
  height: 100px;
}
</style>
