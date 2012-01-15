<?php
/*
For your account you need to create a MD5 version of your password to insert in the database or update a password already. Edit the password variable to get the MD5! One Linux systems and OS X you can most likely get the md5 in the terminal.

If you upload this, make sure to delete it right away. Not really recommended to use this but for some people it's simple.
*/
$password = 'sexybabe';

echo md5($password); 
?>