<?php
$host = 'localhost';
$username = 'chroma_beauty';
$password = 'aHXLanmsBzT5uSyh';
$database = 'chroma_beauty';

//connect to database
$db = new mysqli( $host, $username, $password, $database );

//check to make sure it worked
if( $db-> connect_errno > 0 ){
  die( 'Cannot connect to Database. Please try again later.' );
}

//salt for making our passwords stronger. Keep salts a secret!
define('SALT', 'ldsjflajlfkj@suajldf$$$why$you$so$salty$tho???ha7fjs()DSFSJKELFiejafji*$91113344osi7jaesa!FS(1i#a#flndfdksdfjaaakfj');

define('ROOT_URL', 'http://localhost/naomi_php/chroma_beauty/');
define('ROOT_PATH', 'C:\xampp\htdocs\naomi_php\chroma_beauty');

session_start();
