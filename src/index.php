<?php

// this is the parameter we expect to use
$safeParameter = '../license.txt';
// an attacker is able to supply content in us using this parameter
$unsafeParameter = "../license.txt; cat /etc/passwd > passwd.html";

echo "----- list the files in the directory below us and ignore license.txt" . PHP_EOL;
$ignore = "license.txt";
system(escapeshellcmd("ls --ignore=" . escapeshellarg($ignore) . ' ../'));

echo "----- show that using both escapeshellcmd and escapeshellarg allows us to include extra arguments" . PHP_EOL;
$ignore = "license.txt' -la ";
$singleEncoded = "ls --ignore=" . escapeshellarg($ignore) . ' ../';
$doubleEncoded = escapeshellcmd("ls --ignore=" . escapeshellarg($ignore) . ' ../');
// output is in the format with "-la" applied
system($doubleEncoded);

echo "----- unsafe execution (causes the passwd file to be accessible on http://localhost:8000/passwd.html)" . PHP_EOL;
$directoryListing = '';
exec('ls ' . $unsafeParameter, $directoryListing );

echo "----- safe execution (generates an error saying \"ls: cannot access 'license.txt; cat /etc/passwd > passwd.html': No such file or directory\")" . PHP_EOL;
$directoryListing = '';
exec('ls ' . escapeshellarg($unsafeParameter), $directoryListing );

echo "----- unsafe execution (causes the passwd file to be accessible on http://localhost:8000/passwd.html)" . PHP_EOL;
$command = "ls $unsafeParameter";
system($command);

echo "----- semi-safe execution (Generates multiple errors but still allows ls to be called with multiple parameters)" . PHP_EOL;
system(escapeshellcmd($command));