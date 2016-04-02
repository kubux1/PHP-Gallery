<?php
session_start();
function get_db()
{
     $mongo = new MongoClient(
        "mongodb://localhost:27017/",
        [
            'username' => 'wai_web',
            'password' => 'w@i_w3b',
            'db' => 'wai',
        ]);
        $db = $mongo->wai;
    return $db;
   
}