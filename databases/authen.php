<?php 

    function login(String $email, String $password): array|bool
    {
        $conn = getConnection();
        $sql = 'select * from `user` where email = ?';
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            error_log('login prepare failed: ' . $conn->error);
            return false;
        }
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows == 0)
        {
            return false;
        }
        $row = $result->fetch_assoc();
    
        if(password_verify($password, $row['password']))
        {
            return $row;
        }else
        {
            return false;
        }
    }
    
    function logout():void
    {
        unset($_SESSION['timestamp']);
    }
    