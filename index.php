<?php
error_reporting(0);
$tok = "Enter Your Bot Token!!";
$owner_id = "Enter Your User Id!";
function botaction($method, $data){
	global $tok;
	global $dadel;
	global $dueto;
    $url = "https://api.telegram.org/bot$tok/$method";
    $curld = curl_init();
    curl_setopt($curld, CURLOPT_POST, true);
    curl_setopt($curld, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curld, CURLOPT_URL, $url);
    curl_setopt($curld, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($curld);
    curl_close($curld);
    $dadel = json_decode($output,true);
    $dueto = $dadel['description'];
    return json_decode($output,true);
}
//These Are The Needed Variables!! 😬


😬
$update = file_get_contents('php://input');
$update = json_decode($update, true);

$bot_username = json_decode(file_get_contents("https://api.telegram.org/bot$tok/getMe"),true);
$bot_username = $bot_username['result']['username'];
$mid = $update['message']['message_id'];
$cid = $update['message']['chat']['id'];
$uid = $update['message']['chat']['id'];
$cname = $update['message']['chat']['username'];
$fid = $update['message']['from']['id'];
$fname = $update['message']['from']['first_name'];
$lname = $update['message']['from']['last_name'];
$uname = $update['message']['from']['username'];
$typ = $update['message']['chat']['type'];
$texts = $update['message']['text'];
$text = strtolower($update['message']['text']);
$fullname = ''.$fname.' '.$lname.'';

##################NEW MEMBER DATA ################
$new_member = $update['message']['new_chat_member'];
$gname = $update['message']['chat']['title'];
$nid = $update['message']['new_chat_member']['id'];
$nfname = $update['message']['new_chat_member']['first_name'];
$nlname = $update['message']['new_chat_member']['last_name'];
$nuname = $update['message']['new_chat_member']['username'];
$nfullname = ''.$nfname.' '.$nlname.'';
#################################################
$lfname = $update['message']['left_chat_member']['first_name'];
$llname = $update['message']['left_chat_member']['last_name'];
$luname = $update['message']['left_chat_member']['username'];
$reply_message = $update['message']['reply_to_message'];
$reply_message_id = $update['message']['reply_to_message']['message_id'];
$reply_message_user_id = $update['message']['reply_to_message']['from']['id'];
$reply_message_text = $update['message']['reply_to_message']['text'];
$reply_message_user_fname = $update['message']['reply_to_message']['from']['first_name'];
$reply_message_user_lname = $update['message']['reply_to_message']['from']['last_name'];
$reply_message_user_uname = $update['message']['reply_to_message']['from']['username'];
#######################################################################################
###########################CALL BACK DATA##############################################
$callback = $update['callback_query'];
$callback_id = $update['callback_query']['id'];
$callback_from_id = $update['callback_query']['from']['id'];
$callback_from_uname = $update['callback_query']['from']['username'];
$callback_from_fname = $update['callback_query']['from']['first_name'];
$callback_from_lname = $update['callback_query']['from']['last_name'];
$callback_user_data = $update['callback_query']['data'];
$callback_message_id = $update['callback_query']['message']['id'];
$cbid = $update['callback_query']['message']['chat']['id'];
$cbmid = $update['callback_query']['message']['message_id'];
$thug_chat_id = '';
$chat_id = (string)$cid;
$photo = $update['message']['photo'];
$sticker_pack_name = "photo_2_sticker_ng_by_$bot_username";
$photo_id = $update['message']['photo']['0']['file_id'];

function checkStickerPack($nname,$usid,$token,$bname){
  $sedlyf = json_decode(file_get_contents("https://api.telegram.org/bot$token/getStickerSet?name=$nname"),true);
  $yes = $sedlyf['result']['name'];
  if ($yes) {
  }
  else {
    botaction("createNewStickerSet",['user_id'=>$usid,'name'=>$nname,'title'=>"Created By @$bname",'png_sticker'=>"CAACAgUAAxkBAAMJYAbwZdOqo7_U2vCYkTT__MoYRngAAkcAA9D-xy9gxRg6hvpCZx4E","emojis"=>"😎"]);
  }
}
function resizeimg(){
	$filename = 'Sticker.jpg';
	$width = 512;
	$height = 512;
	list($width_orig, $height_orig) = getimagesize($filename);
	$ratio_orig = $width_orig/$height_orig;
	if ($width/$height > $ratio_orig) {
	    $width = $height*$ratio_orig;
	} else {
	    $height = $width/$ratio_orig;
	}
	$image_p = imagecreatetruecolor($width, $height);
	$image = imagecreatefromjpeg($filename);
	imagecopyresampled($image_p, $image, 0, 0, 0, 0,$width, $height, $width_orig, $height_orig);
	imagejpeg($image_p, "Sticker.jpg", 100);
	file_put_contents("Sticker.png",file_get_contents("Sticker.jpg"));
}

if ($typ == 'private') {

  if ($photo) {
		botaction("sendChatAction",['chat_id'=>$cid,'action'=>'typing']);
		checkStickerPack($sticker_pack_name,$owner_id,$tok,$bot_username);
    $sticker_img = botaction("getFile",['file_id'=>$photo_id]);
    $sticker_path = $sticker_img['result']['file_path'];
    $sed = "https://api.telegram.org/file/bot$tok/$sticker_path";
    file_put_contents("Sticker.jpg",file_get_contents($sed));
		resizeimg();
    $filepath = realpath('Sticker.png');
    botaction("addStickerToSet",['user_id'=>$owner_id,'png_sticker'=>new CurlFile($filepath),'name'=>$sticker_pack_name,'emojis'=>'😁']);
		$sticker_post = botaction("getStickerSet",['name'=>$sticker_pack_name]);
		$sticker_post = $sticker_post['result']['stickers']['1']['file_id'];
		botaction("sendSticker",['chat_id'=>$cid,'sticker'=>$sticker_post]);
		botaction("deleteStickerFromSet",['sticker'=>$sticker_post]);

  }
  else {
    botaction("sendMessage",['chat_id'=>$cid,'text'=>"Hey, $fname. \n<code>I am Photo2Sticker Robot. I Help You To Convert Any Photo To A Sticker File!!</code>\n\n<b>Bot Made By : @NoobsGang</b>",'parse_mode'=>'HTML','reply_to_message_id'=>$mid]);
  }

}
else{

}
