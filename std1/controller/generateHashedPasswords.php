<?php

$users = [
    ['admin@gmail.com', '12345', 'Admin'],
    ['t1@gmail.com', '12345', 'Teacher'],
    ['t2@gmail.com', '12345', 'Teacher'],
    ['t3@gmail.com', '12345', 'Teacher'],
    ['t4@gmail.com', '12345', 'Teacher'],
    ['t5@gmail.com', '12345', 'Teacher'],
    ['t6@gmail.com', '12345', 'Teacher'],
    ['std1@gmail.com', '12345', 'Student'],
    ['dad1@gmail.com', '12345', 'Parents'],
    ['std2@gmail.com', '12345', 'Student'],
    ['dad2@gmail.com', '12345', 'Parents'],
    ['std3@gmail.com', '12345', 'Student'],
    ['dad3@gmail.com', '12345', 'Parents'],
    ['std4@gmail.com', '12345', 'Student'],
    ['std4@gmail.com', '12345', 'Student'],
    ['std4@gmail.com', '12345', 'Student'],
    ['std4@gmail.com', '12345', 'Student'],
    ['std4@gmail.com', '12345', 'Student'],
    ['dad4@gmail.com', '12345', 'Parents'],
    ['dad123@gmail.com', '12345', 'Parents'],
    ['lkforex2015111@gmail.com', '12345', 'Student']
];

echo "USE std_db;\n";

foreach ($users as $user) {
    $email = $user[0];
    $password = $user[1];
    $type = $user[2];

    // Generate a random salt
    $salt = bin2hex(openssl_random_pseudo_bytes(16));

    // Hash the password using bcrypt with the generated salt
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['salt' => $salt]);

    // Output the SQL INSERT statement
    echo "INSERT INTO `user` (`email`, `password`, `salt`, `type`) VALUES ('$email', '$hashedPassword', '$salt', '$type');\n";
}

?>