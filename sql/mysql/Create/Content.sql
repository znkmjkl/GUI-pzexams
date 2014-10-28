-- Skrypt wstawia do bazy danych przykładowe dane
-- Hasła to kopytko
INSERT INTO Users (Email, Password, Activated, FirstName , Surname, Visibility , Rights , Gender , RegistrationDate) VALUES ('test@uj.edu.pl','2c6cdb45ce39d669f4e059c46216380785164d2f',True,'Mariusz','Testowicz', 'private', 'examiner','male' , '2014-03-28');
INSERT INTO Users (Email, Password, Activated, FirstName , Surname, Visibility , Rights , Gender , RegistrationDate) VALUES ('antek.egzaminator@uj.edu.pl','2c6cdb45ce39d669f4e059c46216380785164d2f',True,'Antek','Egzaminator', 'private', 'examiner','male' , '2014-03-28');
INSERT INTO Users (Email, Password, Activated, FirstName , Surname, Visibility , Rights , Gender , RegistrationDate) VALUES ('alicja.egzaminator@uj.edu.pl','2c6cdb45ce39d669f4e059c46216380785164d2f',True,'Alicja','Egzaminator', 'private', 'examiner','female' , '2014-03-28');
INSERT INTO Users (Email, Password, Activated, FirstName , Surname, Visibility , Rights , Gender , RegistrationDate) VALUES ('admin@uj.edu.pl', '2c6cdb45ce39d669f4e059c46216380785164d2f', 1, 'Admin', 'Nerd', 'private', 'administrator', 'male', '2014-03-28');
INSERT INTO Users (Email, Password, Activated, FirstName , Surname, Visibility , Rights , Gender , RegistrationDate) VALUES ('owner@uj.edu.pl', '2c6cdb45ce39d669f4e059c46216380785164d2f', 1, 'Owner', 'Nerd', 'private', 'owner', 'male', '2014-03-28');

INSERT INTO Exams (UserID, Name, Duration, Activated, EmailsPosted) VALUES ('1', 'Metody Numeryczne I - Egzamin I termin', '0:30:00', True, False);
INSERT INTO Exams (UserID, Name, Duration, Activated, EmailsPosted) VALUES ('1', 'Metody Numeryczne I - Egzamin II termin', '0:15:00', False, False);
INSERT INTO Exams (UserID, Name, Duration, Activated, EmailsPosted) VALUES ('1', 'Język C++ - Egzamin I termin', '00:15:00', True, False);
INSERT INTO Exams (UserID, Name, Duration, Activated, EmailsPosted) VALUES ('1', 'Język C++ - Egzamin II termin', '00:20:00', False, False);
INSERT INTO Exams (UserID, Name, Duration, Activated, EmailsPosted) VALUES ('1', 'Język C - Egzamin I termin', '0:05:00', True, False);
INSERT INTO Exams (UserID, Name, Duration, Activated, EmailsPosted) VALUES ('1', 'Język C - Egzamin II termin', '0:10:00', False, False);
INSERT INTO Exams (UserID, Name, Duration, Activated, EmailsPosted) VALUES ('1', 'Areonautyka - Egzamin I termin', '0:10:00', True, False);
INSERT INTO Exams (UserID, Name, Duration, Activated, EmailsPosted) VALUES ('1', 'Buddologia - Egzamin I termin', '0:20:00', False, False);
INSERT INTO Exams (UserID, Name, Duration, Activated, EmailsPosted) VALUES ('1', 'Programowanie mikrokontrolerów - Egzamin sesja poprawkowa', '0:30:00', False, False);
INSERT INTO Exams (UserID, Name, Duration, Activated, EmailsPosted) VALUES ('2', 'Przedmiot nie do zdania - Egzamin I termin', '1:00:00', False, False);
INSERT INTO Exams (UserID, Name, Duration, Activated, EmailsPosted) VALUES ('1', 'Stary egzamin - Egzamin I termin', '0:30:00', True, False);

INSERT INTO ExamUnits (ExamID, Day, TimeFrom, TimeTo, State) VALUES('1', '2014-04-16', '08:00:00', '08:30:00', 'unlocked');
INSERT INTO ExamUnits (ExamID, Day, TimeFrom, TimeTo, State) VALUES('1', '2014-06-16', '08:30:00', '09:00:00', 'unlocked');
INSERT INTO ExamUnits (ExamID, Day, TimeFrom, TimeTo, State) VALUES('1', '2014-06-16', '09:00:00', '09:30:00', 'unlocked');
INSERT INTO ExamUnits (ExamID, Day, TimeFrom, TimeTo, State) VALUES('1', '2014-06-16', '09:30:00', '10:00:00', 'unlocked');
INSERT INTO ExamUnits (ExamID, Day, TimeFrom, TimeTo, State) VALUES('2', '2014-09-01', '08:00:00', '08:30:00', 'unlocked');
INSERT INTO ExamUnits (ExamID, Day, TimeFrom, TimeTo, State) VALUES('3', '2014-06-17', '08:00:00', '08:15:00', 'locked');
INSERT INTO ExamUnits (ExamID, Day, TimeFrom, TimeTo, State) VALUES('3', '2014-06-17', '08:15:00', '08:30:00', 'unlocked');
INSERT INTO ExamUnits (ExamID, Day, TimeFrom, TimeTo, State) VALUES('3', '2014-06-18', '10:00:00', '10:15:00', 'unlocked');
INSERT INTO ExamUnits (ExamID, Day, TimeFrom, TimeTo, State) VALUES('3', '2014-06-18', '10:15:00', '10:30:00', 'unlocked');
INSERT INTO ExamUnits (ExamID, Day, TimeFrom, TimeTo, State) VALUES('7', '2015-06-18', '08:00:00', '08:10:00', 'locked');
INSERT INTO ExamUnits (ExamID, Day, TimeFrom, TimeTo, State) VALUES('7', '2015-06-18', '08:20:00', '08:30:00', 'locked');
INSERT INTO ExamUnits (ExamID, Day, TimeFrom, TimeTo, State) VALUES('8', '2015-06-18', '08:00:00', '08:20:00', 'unlocked');
INSERT INTO ExamUnits (ExamID, Day, TimeFrom, TimeTo, State) VALUES('9', '2014-06-19', '09:00:00', '09:30:00', 'unlocked');
INSERT INTO ExamUnits (ExamID, Day, TimeFrom, TimeTo, State) VALUES('9', '2014-06-20', '09:00:00', '09:30:00', 'unlocked');
INSERT INTO ExamUnits (ExamID, Day, TimeFrom, TimeTo, State) VALUES('10', '2013-06-23', '09:00:00', '10:00:00', 'unlocked');
INSERT INTO ExamUnits (ExamID, Day, TimeFrom, TimeTo, State) VALUES('11', '2013-02-20', '09:00:00', '10:00:00', 'locked');

INSERT INTO Students (Email, Code, FirstName, Surname) VALUES ('a@uj.edu.pl', '123', 'Adam', 'Test');
INSERT INTO Students (Email, Code, FirstName, Surname) VALUES ('b@uj.edu.pl', 'abc', 'Ewa', 'Testowa');
INSERT INTO Students (Email, Code, FirstName, Surname) VALUES ('c@uj.edu.pl', 'qwerty', 'Zbigniew', 'Pachel');
INSERT INTO Students (Email, Code, FirstName, Surname) VALUES ('d@uj.edu.pl', '1qaz', 'A', 'E');
INSERT INTO Students (Email, Code, FirstName, Surname) VALUES ('e@uj.edu.pl', '2wsx', 'B', 'F');
INSERT INTO Students (Email, Code, FirstName, Surname) VALUES ('f@uj.edu.pl', '3edc', 'C', 'G');
INSERT INTO Students (Email, Code, FirstName, Surname) VALUES ('g@uj.edu.pl', '4rfv', 'D', 'H');

INSERT INTO Records (StudentID, ExamID, MessageSent) VALUES (1, 1, True);
INSERT INTO Records (StudentID, ExamID, MessageSent) VALUES (1, 2, True);
INSERT INTO Records (StudentID, ExamID, MessageSent) VALUES (1, 3, True);
INSERT INTO Records (StudentID, ExamID, MessageSent) VALUES (1, 4, True);
INSERT INTO Records (StudentID, ExamID, MessageSent) VALUES (1, 7, True);
INSERT INTO Records (StudentID, ExamID, MessageSent) VALUES (1, 11, True);
INSERT INTO Records (StudentID, ExamID, MessageSent) VALUES (2, 1, True);
INSERT INTO Records (StudentID, ExamID, ExamUnitID, MessageSent) VALUES (2, 3, 6, True);
INSERT INTO Records (StudentID, ExamID, MessageSent) VALUES (2, 11, True);
INSERT INTO Records (StudentID, ExamID, ExamUnitID, MessageSent) VALUES (2, 7, 10, True);
INSERT INTO Records (StudentID, ExamID, ExamUnitID, MessageSent) VALUES (3, 7, 11, True);
INSERT INTO Records (StudentID, ExamID, ExamUnitID, MessageSent) VALUES (4, 11, 16, True);
