<?php

  // Replace with your database credentials
  $conn = mysqli_connect("localhost", "root", "", "test");
  if (!$conn) { 
    die("Connection failed: " . mysqli_connect_error());
  }

  // Escape special chars to prevent SQL injection
  function esc($payload) { 
    return htmlspecialchars($payload, ENT_QUOTES, 'UTF-8'); 
  }