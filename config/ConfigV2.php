<?php
try {
    $GLOBALS['dbPath'] = 'db/persistentconndb.sqlite';

    $db = new SQLite3($GLOBALS['dbPath'], $flags = SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE, $encryptionKey = "");

    if (!$db)
    {
        echo $db->lastErrorMsg();
    } else
    {
        //Opened database successfully
    }

    //Set up passwords for hashing
    $passwords = [0 => 'Password1', 1 => 'Password2', 2 => 'Password3', 3 => 'Password4', 4 => 'Password5',
         5 => 'Password6', 6 => 'Password7', 7 => 'Password8', 8 => 'Password9', 9 => 'Password10'
    ];

    //Create variables for hashed passwords
    $count = 0; //tracks array index
    $HashedPasswords = [];

    //Hash all the passwords as 80 byte hash using ripemd256
    foreach($passwords as $pass)
    {
        $HashedPasswords[$count] = hash('ripemd256', $pass);
        $count++;
    }

    $sql = <<<EOF
      
CREATE TABLE User
      	(
	UserID	    	INT	    PRIMARY KEY     NOT NULL	UNIQUE,
	Email		    TEXT 	NOT NULL	UNIQUE,
	AccType    	    INT     NOT NULL,
	Password    	TEXT    NOT NULL,      		
	FName          	TEXT    NOT NULL,
	LName           TEXT    NOT NULL,
	DOB		        TEXT	NOT NULL,
    Year		    INT,
	Rank		    TEXT,
	SQuestion	    TEXT	NOT NULL,
	SAnswer		    TEXT	NOT NULL,
	FOREIGN KEY (AccType) REFERENCES Role (RoleID) ON
    		DELETE SET NULL ON UPDATE CASCADE
	);

CREATE TABLE Section
    (
	CRN		        INT 	PRIMARY KEY     NOT NULL	UNIQUE,
	Instructor	    TEXT,
	Course		    TEXT	NOT NULL,
	Semester    	TEXT    NOT NULL,
	SectionLetter	TEXT	NOT NULL,
	StartTime	    TEXT	NOT NULL,
	EndTime		    TEXT	NOT NULL,
	Year		    TEXT	NOT NULL,
    Location    	TEXT	NOT NULL,
	FOREIGN KEY (Course) REFERENCES Course (Code) ON
    		DELETE SET NULL ON UPDATE CASCADE,	    		
	FOREIGN KEY (Instructor) REFERENCES User (UserID) ON
    		DELETE SET NULL ON UPDATE CASCADE
	);
    
CREATE TABLE Enrollment
    	(
	CRN		    INT     NOT NULL,
	StudentID	TEXT    NOT NULL,	
	PRIMARY KEY(CRN,StudentID), 	
	FOREIGN KEY (StudentID) REFERENCES User (UserID) ON
    		DELETE SET NULL ON UPDATE CASCADE,
	FOREIGN KEY (CRN) REFERENCES Section (CRN) ON
    		DELETE SET NULL ON UPDATE CASCADE
	);
	
CREATE TABLE Grade
      	(
	CRN		    INT     NOT NULL,
	StudentID	INT     NOT NULL,
    Grade		TEXT	NOT NULL,
	PRIMARY KEY(CRN,StudentID),  		
	FOREIGN KEY (StudentID) REFERENCES User (UserID) ON
    		DELETE SET NULL ON UPDATE CASCADE,
	FOREIGN KEY (CRN) REFERENCES Section (CRN) ON
    		DELETE SET NULL ON UPDATE CASCADE
	);

CREATE TABLE Course
      	(
	Code		TEXT	PRIMARY KEY 	NOT NULL	UNIQUE,
	CourseName	TEXT	NOT NULL
	);

CREATE TABLE Role
      	(
	RoleID		INT	    PRIMARY KEY 	NOT NULL	UNIQUE,
	Role		TEXT	NOT NULL
	);


BEGIN TRANSACTION;
/*--------------User Values-----------------*/
/*---------Emails must be lowercase---------*/
/*--------UserID must be sequential---------*/
	INSERT INTO User (UserID, Email, AccType, Password, FName, LName, DOB, Year, Rank, SQuestion, SAnswer)
      	VALUES ('1', 'admin@email.com', '1', '$HashedPasswords[0]', 'John', 'Doe', '2001-05-10', NULL, NULL, 'Favorite Relative?', 'Bobsmyuncle');

	INSERT INTO User (UserID, Email, AccType, Password, FName, LName, DOB, Year, Rank, SQuestion, SAnswer)
      	VALUES ('2', 'scienceguy@email.com', '2', '$HashedPasswords[1]', 'Bill', 'Nye', '1955-11-27', NULL, 'Associate', 'Favorite Relative?', 'Charity Nye');
	
	INSERT INTO User (UserID, Email, AccType, Password, FName, LName, DOB, Year, Rank, SQuestion, SAnswer)
      	VALUES ('3', 'student@email.com', '3', '$HashedPasswords[2]', 'Pepe', 'Frog', '2002-06-12', '3', NULL, 'Favorite Relative?', 'JoeyBatey');

	INSERT INTO User (UserID, Email, AccType, Password, FName, LName, DOB, Year, Rank, SQuestion, SAnswer)
      	VALUES ('4', 'student2@email.com', '3', '$HashedPasswords[3]', 'Pepe', 'Le Pew', '2002-06-12', '3', NULL, 'Favorite Relative?', 'PituLePew');

INSERT INTO User (UserID, Email, AccType, Password, FName, LName, DOB, Year, Rank, SQuestion, SAnswer)
      	VALUES ('5', 'student3@email.com', '3', '$HashedPasswords[4]', 'John', 'Le Pew', '1997-08-11', '3', NULL, 'Favorite Relative?', 'Mom');

INSERT INTO User (UserID, Email, AccType, Password, FName, LName, DOB, Year, Rank, SQuestion, SAnswer)
      	VALUES ('6', 'student4@email.com', '3', '$HashedPasswords[5]', 'John', 'Smith', '1997-08-12', '3', NULL, 'Favorite Relative?', 'Dad');

INSERT INTO User (UserID, Email, AccType, Password, FName, LName, DOB, Year, Rank, SQuestion, SAnswer)
      	VALUES ('7', 'student5@email.com', '3', '$HashedPasswords[6]', 'John', 'Wright', '1997-08-11', '3', NULL, 'Favorite Relative?', 'Brother');

INSERT INTO User (UserID, Email, AccType, Password, FName, LName, DOB, Year, Rank, SQuestion, SAnswer)
      	VALUES ('8', 'student6@email.com', '3', '$HashedPasswords[7]', 'Link', 'Le Pew', '1998-08-11', '3', NULL, 'Favorite Relative?', 'seastar');

INSERT INTO User (UserID, Email, AccType, Password, FName, LName, DOB, Year, Rank, SQuestion, SAnswer)
      	VALUES ('9', 'student7@email.com', '3', '$HashedPasswords[8]', 'Smith', 'Smitherson', '1987-08-13', '3', NULL, 'Favorite Relative?', 'Mom');

	INSERT INTO User (UserID, Email, AccType, Password, FName, LName, DOB, Year, Rank, SQuestion, SAnswer)
      	VALUES ('10', 'cyberperson@email.com', '2', '$HashedPasswords[9]', 'Cherryll', 'Young', '1855-05-15', NULL, 'Associate', 'Favorite Relative?', 'Bobby');

/*--------------Course Values-----------------*/
    INSERT INTO Course (Code, CourseName)
    VALUES ('CYBR 2200', 'Intro to CyberSecurity');

    INSERT INTO Course (Code, CourseName)
    VALUES ('CYBR 2480', 'Intermediate CyberSecurity');

    INSERT INTO Course (Code, CourseName)
    VALUES ('CYBR 3501', 'Intermediate CyberSecurity II');


/*--------------Section Values-----------------*/
	INSERT INTO Section (CRN, Instructor, Course,  Semester, SectionLetter, StartTime, EndTime, Year, Location)
      	VALUES ('123', '2', 'CYBR 2200' , 'Fall', 'A', '08:30:00', '09:45:00', '2030','Building A');

	INSERT INTO Section (CRN, Instructor, Course,  Semester, SectionLetter, StartTime, EndTime, Year, Location)
      	VALUES ('456', '10', 'CYBR 2480', 'Spring', 'A','13:30:00', '14:45:00', '2030', 'Building A');

	INSERT INTO Section (CRN, Instructor, Course,  Semester, SectionLetter, StartTime, EndTime, Year, Location)
      	VALUES ('1233', '2', 'CYBR 2480', 'Spring', 'B','15:30:00', '16:45:00', '2030', 'Building 51');

	INSERT INTO Section (CRN, Instructor, Course,  Semester, SectionLetter, StartTime, EndTime, Year, Location)
      	VALUES ('1113', '10', 'CYBR 2480', 'Spring', 'C','12:30:00', '13:45:00', '2030', 'Building C');

	INSERT INTO Section (CRN, Instructor, Course,  Semester, SectionLetter, StartTime, EndTime, Year, Location)
      	VALUES ('1343', '2', 'CYBR 2200' , 'Fall', 'A', '08:31:00', '09:46:00', '2030','Building X');

	INSERT INTO Section (CRN, Instructor, Course,  Semester, SectionLetter, StartTime, EndTime, Year, Location)
      	VALUES ('1453', '10', 'CYBR 3501', 'Spring', 'B','15:30:00', '16:45:00', '2030', 'Building 51');

	INSERT INTO Section (CRN, Instructor, Course,  Semester, SectionLetter, StartTime, EndTime, Year, Location)
      	VALUES ('113', '10', 'CYBR 3501', 'Spring', 'C','12:30:00', '13:45:00', '2030', 'Building C');


	INSERT INTO Section (CRN, Instructor, Course,  Semester, SectionLetter, StartTime, EndTime, Year, Location)
      	VALUES ('5000', '2', 'CYBR 3501' , 'Fall', 'A', '08:31:00', '09:46:00', '2030','Building X');

/*--------------CourseEnroll Values-----------------*/
	INSERT INTO Enrollment (CRN, StudentID)
      	VALUES ('123', '4');


/*--------------Grade Values-----------------*/
	INSERT INTO Grade (CRN, StudentID, Grade)
      	VALUES ('123', '3', 'C');

	INSERT INTO Grade (CRN, StudentID, Grade)
      	VALUES ('456', '4', 'F');
      	
/*--------------Role Values-----------------*/
	INSERT INTO Role (RoleID, Role)
      	VALUES ('1', 'Admin');
      	
    INSERT INTO Role (RoleID, Role)
      	VALUES ('2', 'Faculty');
      	
    INSERT INTO Role (RoleID, Role)
      	VALUES ('3', 'Student');
      	
      	END TRANSACTION;
EOF;


    $ret = $db->exec($sql);
    if (!$ret)
    {
        echo $db->lastErrorMsg();
    } else
    {
        //Tables created successfully.
    }
}
catch(Exception $e)
{
    echo 'Caught exception: ',  $e->getMessage(), "<br>";
    var_dump($e->getTraceAsString());
    echo 'in '.'http://'. $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']."<br>";

    $allVars = get_defined_vars();
    debug_zval_dump($allVars);
}
?>