<?php

class User extends dbh
{

 Private $firstname;
 Private $lastname;
 Private $email;
 private $streetname;
 private $housenumber;
 private $postalcode;
 private $city;
 Private $password;

    public function __construct ($firstname, $lastname, $email,  $streetname, $housenumber, $postalcode, $city, $password) {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->streetname = $streetname;
        $this->housenumber = $housenumber;
        $this->postalcode = $postalcode;
        $this->city = $city;
        $this->password = $password;
    }

    protected function userExists() {
        $stmt = $this->connection()->prepare('SELECT user_email FROM users WHERE user_email= ?;');

        if(!$stmt->execute(array($this->email))) {
        $stmt = null;
        header("location: register.php?error=stmtUserExistsFailed");
        exit();
        }
        else {
            $userExists = false;

            if(!$stmt->rowCount() > 0) {
                $userExists = true;
            }

            return $userExists;
        }

    }


    public function createUser()
    {
            $userExists = $this->userExists();
        if ($userExists == 1) {
            $stmt = $this->connection()->prepare('INSERT INTO users (user_firstname, user_lastname, user_email, user_password) VALUES (?, ?, ?, ?);');
            $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);

            if (!$stmt->execute(array($this->firstname, $this->lastname, $this->email, $hashedPassword))) {
                $stmt = null;
                header("location: register.php?error=stmtCreateUserFailed");
                exit();
            }

            $stmt = null;

            $stmt2 = $this->connection()->prepare('SELECT user_id FROM users WHERE user_email = ?;');
            if (!$stmt2->execute(array($this->email))) {
                $stmt2 = null;
                header("location: register.php?error=stmt2CreateUserFailed");
                exit();
            }

            $userId = $stmt2->fetch(PDO::FETCH_ASSOC);
            

            $stmt3 = $this->connection()->prepare('INSERT INTO users_addresses (address_streetname, address_housenumber, address_postalcode, address_city, user_id) VALUES (?, ?, ?, ?, ?);');
           
            if (!$stmt3->execute(array($this->streetname, $this->housenumber, $this->postalcode, $this->city, $userId['user_id']))) {
                $stmt = null;
                header("location: register.php?error=stmt3CreateUserFailed");
                exit();
            }

            $stmt3= null;

            header("location: register.php?error=none");

        }
    }

    public function loginUser() {
        $userExists=  $this->userExists();

        if ($userExists == 0) {
            $stmt = $this->connection()->prepare('SELECT user_password FROM users WHERE user_email= ?;');


            if (!$stmt->execute(array($this->email))) {
                $stmt = null;
                header("location: login.php?error=loginUserStmt1Failed");
                exit();
            }

            $hashedPassword = $stmt->fetch(PDO::FETCH_ASSOC);
            $checkPassword = password_verify($this->password, $hashedPassword["user_password"]);

            if (!$checkPassword == false) {

                $stmtId = $this->connection()->prepare('SELECT user_id FROM users WHERE user_email= ?;');

                if (!$stmtId->execute(array($this->email))) {
                    $stmtId = null;
                    header("location: index.php?error=loginUserStmt2Failed");
                    exit();
                }

                if ($stmtId->rowCount() == 0) {

                    $stmt = null;
                    header("location: login.php?error=userNotFound");
                    exit();
                }

                $userId = $stmtId->fetch(PDO::FETCH_ASSOC);

                $stmtUser = $this->connection()->prepare('SELECT * FROM users INNER JOIN users_addresses ON users.user_id = users_addresses.user_id WHERE users.user_id= ?;');

                if (!$stmtUser->execute(array($userId['user_id']))) {
                    $stmtUser = null;
                    header("location: index.php?error=loginUserStmt3Failed");
                    exit();
                }

                $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

                session_start();
                $_SESSION["userId"] = $user["user_id"];
                $_SESSION["userEmail"] = $user["user_email"];
                $_SESSION["userFirstname"] = $user["user_firstname"];
                $_SESSION["userLastname"] = $user["user_lastname"];
                $_SESSION["userRole"] = $user["user_role"];
                $_SESSION["userStreetName"] = $user["address_streetname"];
                $_SESSION["userHouseNumber"] = $user["address_housenumber"];
                $_SESSION["userPostalCode"] = $user["address_postalcode"];
                $_SESSION["userCity"] = $user["address_city"];
                $_SESSION["userPassword"] = $user["user_password"];
    

            $stmt = null;
            }
            else {
                $stmt = null;
                header("location: login.php?error=wrongLoginCredentials");
                exit();
            }
        }
        else {
            header("location: login.php?error=userNotFound");
            exit();
        }
    }

    public function logoutUser() {
        session_start();
        unset($_SESSION['userId']);
    }

    public function insertResetCode($resetCode) {
        $userExists=  $this->userExists();

        if ($userExists == 0) {
            $stmt = $this->connection()->prepare('UPDATE users SET resetcode = ? WHERE email = ?;');

            $hashedResetCode = password_hash($resetCode, PASSWORD_DEFAULT);
            if (!$stmt->execute(array($hashedResetCode, $this->email))) {
                $stmt = null;
                header("location:forgottenPassword.php?error=stmtGenerateResetCodeFailed");
                exit();
            }

            $stmt = null;
        }
    }

    public function getUserFirstname() {
        $userExists=  $this->userExists();

        if ($userExists == 0) {
            $stmt = $this->connection()->prepare('SELECT * FROM users WHERE email = ?;');

            if (!$stmt->execute(array($this->email))) {
                $stmt = null;
                header("location:forgottenPassword.php?error=stmtGenerateResetCodeFailed");
                exit();
            }

            $getFirstname = $stmt->fetchAll();

            $stmt = null;
            return $getFirstname[0]["firstname"];
        }
    }

    public function updatePasswordViaResetCode($resetCode) {
        $userExists=  $this->userExists();

        if ($userExists == 0) {
            $stmt = $this->connection()->prepare('SELECT * FROM users WHERE email = ?;');

            if (!$stmt->execute(array($this->email))) {
                $stmt = null;
                header("location:forgottenPassword.php?error=stmtVerifyResetCodeFailed");
                exit();
            }

            $hashedCode = $stmt->fetchAll();
            $checkCode = password_verify($resetCode, $hashedCode['0']['resetcode']);

            if(!$checkCode == false) {

                $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
                $stmt = $this->connection()->prepare('UPDATE users SET password = ? WHERE email = ?;');

                if(!$stmt->execute(array($hashedPassword, $this->email))) {
                    $stmt = null;
                    header("location: resetPassword?error=stmtResetPasswordFailed");
                    exit();
                }
                else {

                $stmt2 = $this->connection()->prepare('UPDATE users SET resetcode = NULL WHERE email = ?;');

                if (!$stmt2->execute(array($this->email))) {
                    $stmt = null;
                    header("location:forgottenPassword.php?error=stmt2ResetPasswordFailed");
                    exit();
                }
            }

                $stmt = null;

            }
            else {
                header("location:resetPassword.php?email=$this->email&error=InvalidCode");
                exit();
            }
        }

    }

    public function updateProfilePicture($imageName) {

        $stmt = $this->connection()->prepare('UPDATE users SET profilepicture = ? WHERE email = ?;');

        if (!$stmt->execute(array($imageName, $this->email))) {
            $stmt = null;
            header("location:profile.php?error=stmtUpdateProfilePictureFailed");
            exit();
        }

        $_SESSION['userProfilePicture'] = $imageName;
    }

    public function updateBiography($biography) {
        $stmt  ="UPDATE users SET biography = ? WHERE email = ?";
        $result = $this->connection()->prepare($stmt);

        if (!$result->execute(array($biography, $this->email))) {
            $result = null;
            header("location:profile.php?error=stmtUpdateBiographyFailed");
            exit();
        }
        $_SESSION['userBiography'] = $biography;
    }

}