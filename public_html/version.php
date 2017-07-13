<?php
//
// MultiQC Version Check
//

// First - print the latest version.
// This file is automatically generated by the latest tag in the git repository when a new commit is pushed
$version = file_get_contents("/home/multiqc/version.txt");
preg_replace('/[^\d\.]/', '', $version);
print($version);

// Log version of tool that's asking
if(isset($_GET['v'])){
    $remote_version_pieces = explode(" ", $_GET['v']);
    $remote_version = $remote_version_pieces[0];
    $remote_version = str_replace('.dev0', '.dev', $remote_version);
    $dev = substr($remote_version, -3) == 'dev' ? 'dev' : '';
    $remote_version = preg_replace('/[^\d\.]/', '', $remote_version).$dev;

    if ($remote_version == '') $remote_version = '< 0.5';

    // Connect to the database
    $dbconfig = parse_ini_file("../config.ini");
    $db = new mysqli('localhost', $dbconfig['user'], $dbconfig['password'], $dbconfig['db']);
    if($db->connect_errno == 0){

        // Insert new record with querying version
        $stmt = $db->prepare("INSERT INTO version_check (version, ip, addr) VALUES (?, ?, ?)");
        $stmt->bind_param('sss',$remote_version, $_SERVER['REMOTE_ADDR'], gethostbyaddr($_SERVER['REMOTE_ADDR']));
        $stmt->execute();
        $db->close();

    }
}

