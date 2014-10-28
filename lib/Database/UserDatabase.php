<?php
    
    include_once("User.php");
    include_once("DatabaseConnector.php");
    
    final class UserDatabase
    {
        /*
         * Metoda sprawdza czy użytkownik o zadanym e-mailu istnieje w bazie danych.
         */
        static public function checkEmail($basicUserU)
        {
			$basicUserEmail = mysqli_real_escape_string(DatabaseConnector::getConnection(), $basicUserU->getEmail());
			
            $sql = "Select * from Users WHERE Email = '".$basicUserEmail."'";
            // echo $sql;
    
            $result = DatabaseConnector::getConnection()->query($sql);
            if ($result->num_rows == 1)
                return true;
            return false;
        }
    
        /*
         * Metoda sprawdza czy przypisane hasło do klasy $user jest poprawne.
         */
        static public function checkPassword($basicUser)
        {
			$basicUserEmail = mysqli_real_escape_string(DatabaseConnector::getConnection(), $basicUser->getEmail());
			$basicUserPassword = mysqli_real_escape_string(DatabaseConnector::getConnection(), $basicUser->getPassword());
			
            $sql = "Select * from Users WHERE Email = '" . $basicUserEmail . "' && Password = '" . $basicUserPassword . "'";
            $result = DatabaseConnector::getConnection()->query($sql);
            if ($result->num_rows == 1)
            {
                $result = DatabaseConnector::getConnection()->query($sql);
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                $basicUser->setID($row['ID']);                
                $basicUser->setFirstName($row['FirstName']);
                $basicUser->setSurname($row['Surname']);       
				$basicUser->setRight($row['Rights']);                

                return true;
            }
            return false;		
        }
    
        static public function checkActivated($basicUserU)
        {
			$basicUserEmail = mysqli_real_escape_string(DatabaseConnector::getConnection(), $basicUserU->getEmail());
			
            $sql = "Select * from Users WHERE Email = '" . $basicUserEmail . "' && Activated = TRUE";
            $result = DatabaseConnector::getConnection()->query($sql);
            if ($result->num_rows == 1)
                return true;
            return false;
        }
    
        static public function addUser($userU)
        {
			$userEmail = mysqli_real_escape_string(DatabaseConnector::getConnection(), $userU->getEmail());
			$userPassword = mysqli_real_escape_string(DatabaseConnector::getConnection(), $userU->getPassword());
			$userActivated = mysqli_real_escape_string(DatabaseConnector::getConnection(), $userU->getActivated());
			$userActivationCode = mysqli_real_escape_string(DatabaseConnector::getConnection(), $userU->getActivationCode());
			$userFirstName = mysqli_real_escape_string(DatabaseConnector::getConnection(), $userU->getFirstName());
			$userSurname = mysqli_real_escape_string(DatabaseConnector::getConnection(), $userU->getSurname());
			$userGender = mysqli_real_escape_string(DatabaseConnector::getConnection(), $userU->getGender());
			
			date_default_timezone_set('Europe/Warsaw');
			
            $values = "('"	. $userEmail    . "', '"
                            . sha1($userPassword) . "', '"
                            . ($userActivated        ? "TRUE" : "FALSE") . "', '"
                            . $userActivationCode . "', "
                            . (is_null($userFirstName)    ? "NULL" : "'" . $userFirstName    . "'")  . ", " 
                            . (is_null($userSurname) ? "NULL" : "'" . $userSurname . "'")  . ", 'private', 'examiner'," 
                            . (is_null($userGender)  ? "NULL" : "'" . $userGender  . "'" ) . " , '"
                            . date("Y/m/d") . "')";  
    
            $sql =  "INSERT INTO Users (Email, Password, Activated, ActivationCode, FirstName , Surname, Visibility , Rights , Gender , RegistrationDate) " 
                 .	"VALUES $values";
    
            // echo($sql);
    
            return DatabaseConnector::getConnection()->query($sql) ? true : false;
        }
		
		static public function getAllUsers()
        {
            $sql = "SELECT * FROM Users";
            $result = DatabaseConnector::getConnection()->query($sql);
            if (!$result) {
                return null;
            }

			$i = 0;
			while ($row = $result->fetch_array(MYSQLI_NUM)) {
				$resultUser = new User(); 
				$resultUser->setID($row[0]);
				$resultUser->setEmail($row[1]);
				$resultUser->setActivated($row[3]);
				$resultUser->setPassword($row[2]);
				$resultUser->setFirstName($row[5]);
				$resultUser->setSurname($row[6]);
				$resultUser->setGender($row[9]);
				$resultUser->setRight($row[8]);
				$users[$i] = $resultUser; 
				$i++;
			}
			return $users;
        } 
    
        static public function getUser($idU)
        {
			$id = mysqli_real_escape_string(DatabaseConnector::getConnection(), $idU);
			
            $sql = "SELECT * FROM Users WHERE ID = " . $id ;
            $result = DatabaseConnector::getConnection()->query($sql);
            if (!$result) {
                return null;
            }
            $row = $result->fetch_array(MYSQLI_ASSOC);
    
            $resultUser = new User(); 
            $resultUser->setID($row['ID']);
            $resultUser->setEmail($row['Email']);
            $resultUser->setActivated($row['Activated']);
            $resultUser->setPassword($row['Password']);
            $resultUser->setFirstName($row['FirstName']);
            $resultUser->setSurname($row['Surname']);
            $resultUser->setGender($row['Gender']);
			$resultUser->setRight($row['Rights']);
    
            return $resultUser;
        }
    
        /*
         * Aktualizacja imienia usera
         */
         static public function updateUserFirstName($userU, $firstNameU)
         { 
			$userID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $userU->getID());
			$firstName = mysqli_real_escape_string(DatabaseConnector::getConnection(), $firstNameU);
			
             $sql = "UPDATE Users SET 
             FirstName  = '" . $firstName . "' 
             WHERE ID = '" . $userID . "'";
    
             return DatabaseConnector::getConnection()->query($sql) ? true : false;
         } 
    
         /*
         * Aktualizacja hasla usera
         */
         static public function updateUserPassword($userU, $passwordU)
         { 
			$userID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $userU->getID());
			$password = mysqli_real_escape_string(DatabaseConnector::getConnection(), $passwordU);
			
             $sql = "UPDATE Users SET 
             Password  = '" . $password . "' 
             WHERE ID = '" . $userID . "'";
    
             return DatabaseConnector::getConnection()->query($sql) ? true : false;
         }

         static public function updateUserPassword2($userU, $passwordU)
         { 
            $email = mysqli_real_escape_string(DatabaseConnector::getConnection(), $userU->getEmail());
            $password = mysqli_real_escape_string(DatabaseConnector::getConnection(), $passwordU);
            $password = sha1($password);
             $sql = "UPDATE Users SET 
             Password  = '" . $password . "' 
             WHERE Email = '" . $email . "'";
    
             return DatabaseConnector::getConnection()->query($sql) ? true : false;
         } 
    
         /*
         * Aktualizacja nicku usera
         */
         static public function updateUserSurname($userU, $surnameU)
         { 
			$userID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $userU->getID());
			$surname = mysqli_real_escape_string(DatabaseConnector::getConnection(), $surnameU);
			
             $sql = "UPDATE Users SET 
             Surname  = '" . $surname . "' 
             WHERE ID = '" . $userID . "'";
    
             return DatabaseConnector::getConnection()->query($sql) ? true : false;
         } 
    
         /*
         * Aktualizacja plci usera
         */
         static public function updateUserGender($userU, $genderU)
         { 
			$userID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $userU->getID());
			$gender = mysqli_real_escape_string(DatabaseConnector::getConnection(), $genderU);
			
             $sql = "UPDATE Users SET 
             Gender  = '" . $gender . "'
             WHERE ID = '" . $userID . "'";
    
             return DatabaseConnector::getConnection()->query($sql) ? true : false;
         }

		 /*
         * Aktualizacja praw usera
         */
		 static public function updateUserRights($userU, $rightsU)
         { 
			$userID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $userU->getID());
			$rights = mysqli_real_escape_string(DatabaseConnector::getConnection(), $rightsU);
			
             $sql = "UPDATE Users SET 
             Rights  = '" . $rights . "'
             WHERE ID = '" . $userID . "'";
    
             return DatabaseConnector::getConnection()->query($sql) ? true : false;
         }
    
        static public function activate($email, $code)
        {
            $email = mysqli_real_escape_string(DatabaseConnector::getConnection(), $email);
            $code = mysqli_real_escape_string(DatabaseConnector::getConnection(), $code);
    
            $user = new User();
            $user->setEmail($email);
    
            $sql =  "SELECT ID From Users WHERE email = '$email' AND ActivationCode = '$code' AND Activated = 0";
    
            if (DatabaseConnector::getConnection()->query($sql)->num_rows == 1)
            {
                $sql =  "UPDATE Users SET Activated = 1 WHERE Email = '$email'";
    
                return DatabaseConnector::getConnection()->query($sql) ? true : false;
            }
            else
            {
                return false;
            }
        }
		
		static public function adminCountUsers()
        {    
            $sql =  "SELECT Count(ID) From Users";
			$result = DatabaseConnector::getConnection()->query($sql);
            $userCount=0;

			if($result!=null){
				$row = $result->fetch_array(MYSQLI_NUM);
				$userCount=$row[0];
			}
			
			
			return $userCount;
        }
    
		static public function deleteUser($userIDU)
		{
			$userID = mysqli_real_escape_string(DatabaseConnector::getConnection(), $userIDU);
			
			$sql = "Select * from Users WHERE ID = '" . $userID . "'";
			$result = DatabaseConnector::getConnection()->query($sql);
			if ($result->num_rows == 0) { 
				return false;
			}
			
			$sql = "Delete from Users WHERE ID  = '" . $userID . "'";
			return DatabaseConnector::getConnection()->query($sql) ? true : false;
		}
	
        // Nie pozwalamy na utworzenie obiektu - Jeżeli zrozumiałeś design to nigdy nie zmienisz tego konstruktora na publiczny ;)
        private function __construct() { }
    }
?>
