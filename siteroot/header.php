<?php
  error_reporting( E_ALL & ~E_NOTICE );
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>ChromaBeauty About Us</title>
    <!-- TODO: ADD RESET -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="alternate" type="application/rss+xml" href="rss.php">
    <meta name=viewport content="width=device-width, initial-scale=1">
  </head>
  <body>
    <header>
      <h1><span id="chroma">Chroma</span><span id="beauty">Beauty</span></h1>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="#">Products</a></li>
        <li><a href="about.php">About Us</a></li>
        <li><a href="#">Contact Us</a></li>
      </ul>
      <form action="search.php" method="get">
        <label for="keywords">Search:</label>
        <input type="search" name="keywords" id="keywords" />
        <input type="submit" value="Find" />
      </form>
    </header>
