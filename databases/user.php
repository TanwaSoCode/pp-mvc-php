<?php

function ensureEmailUniqueIndex(): void
{
    $conn = getConnection();
    $res = $conn->query("SHOW INDEX FROM `user` WHERE Key_name='uq_user_email'");
    if ($res && $res->num_rows === 0) {
        @$conn->query("ALTER TABLE `user` ADD UNIQUE INDEX uq_user_email (email)");
    }
}

function emailExists(string $email): bool
{
    $conn = getConnection();
    $sql = 'SELECT 1 FROM `user` WHERE email = ? LIMIT 1';
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log('emailExists prepare failed: ' . $conn->error);
        return false;
    }
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result && $result->num_rows > 0;
}

// function getUser(): mysqli_result|bool
// {
//     $conn = getConnection();
//     $sql = 'select * from user';
//     $result = $conn->query($sql);
//     return $result;
// }

function membership(String $username, String $fname, String $lname, String $date, String $gender, String $email, String $password, int $age): bool
{
    $conn = getConnection();

    ensureEmailUniqueIndex();

    if (emailExists($email)) {
        return false;
    }

    $sql = 'INSERT INTO `user` (username, password, fname, lname, email, gender, birthday, age) VALUES(?,?,?,?,?,?,?,?)';
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log('membership prepare failed: ' . $conn->error);
        return false;
    }
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt->bind_param('sssssssi', $username, $hash, $fname, $lname, $email, $gender, $date, $age);
    $stmt->execute();

    if ($stmt->errno === 1062) {
        return false;
    }

    return $stmt->affected_rows > 0;
}

// function getUserbyId(int $id): mysqli_result|bool
// {
//     $conn = getConnection();
//     $sql = 'select * from user where userID = ?';
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("i", $id);
//     $stmt->execute();
//     $result = $stmt->get_result();
//     if ($stmt->affected_rows > 0) {
//         return  $result;
//     } else {
//         return false;
//     }
// }

class UserRegister
{
    private $conn;
    private $table_name = "`user`";

    public $name;
    public $email;
    public $password;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }

    // public function validatePassword()
    // {
    //     if ($this->password != $this->password) {
    //         return false;
    //     }
    //     return true;
    // }
}
