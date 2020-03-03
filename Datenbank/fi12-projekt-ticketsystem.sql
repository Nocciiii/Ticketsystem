-- Bereich: Schema
-- Tabellen in Verbindung mit der Tabelle Boards
CREATE TABLE Status (
  StatusId INT(5) AUTO_INCREMENT PRIMARY KEY,
  Status VARCHAR(25) NOT NULL UNIQUE
)
;

CREATE TABLE Privilege (
  PrivilegeId INT(5) AUTO_INCREMENT PRIMARY KEY,
  Privilege VARCHAR(25) NOT NULL UNIQUE
)
;

-- Tabelle Board
CREATE TABLE Board (
  BoardId INT(5) AUTO_INCREMENT PRIMARY KEY,
  ProjectName VARCHAR(25) NOT NULL UNIQUE,
  Privilege INT(5) NOT NULL,
  ColumnOrder VARCHAR(15) NOT NULL,

  CONSTRAINT Board_Privilege_FK FOREIGN KEY (Privilege)
	REFERENCES Privilege(PrivilegeID)
)
;

-- Zwischentabelle für die Tabelle Board
CREATE TABLE Board_Status (
  Board INT(5) NOT NULL,
  Status INT(5) NOT NULL,

  CONSTRAINT Board_Status_Board_FK FOREIGN KEY (Board)
  REFERENCES Board(BoardId),
  CONSTRAINT Board_Board_Status_FK FOREIGN KEY (Status)
  REFERENCES Status(StatusId)
)
;

-- Tabellen in Verbindung mit der Tabelle User (wenn es die Tabelle noch nicht gibt)
CREATE TABLE Usertype (
  UsertypeId INT(5) AUTO_INCREMENT PRIMARY KEY,
  Usertype VARCHAR(25) NOT NULL UNIQUE
) 
;

-- Tabelle User
CREATE TABLE `User` (
  UserId INT(5) AUTO_INCREMENT PRIMARY KEY,
  Username VARCHAR(25) NOT NULL UNIQUE,
  Email VARCHAR(30) NOT NULL UNIQUE, 
  Passwort VARCHAR(50) NOT NULL,
  Usertype INT(5) NOT NULL,
  
  CONSTRAINT User_Usertype_FK FOREIGN KEY (Usertype)
  REFERENCES Usertype(UsertypeId)
)
;

-- Zwischentabelle für die Tabelle Ticket
CREATE TABLE User_Privilege (
  User INT(5) NOT NULL,
  Privilege INT(5) NOT NULL,

  CONSTRAINT User_Privilege_User_FK FOREIGN KEY (`User`)
  REFERENCES `User`(UserId),
  CONSTRAINT User_Privilege_Privilege_FK FOREIGN KEY (Privilege)
  REFERENCES Privilege(PrivilegeId)
)
;

-- Tabellen im Zusammenhang mit Ticket
CREATE TABLE `Priority` (
  PriorityId INT(5) AUTO_INCREMENT PRIMARY KEY,
  Priority VARCHAR(25) NOT NULL UNIQUE
)
;

-- Tabelle Ticket
CREATE TABLE Ticket (
  TicketId INT(5) AUTO_INCREMENT PRIMARY KEY,
  Board INT(5) NOT NULL,
  TicketSummary VARCHAR(25) NOT NULL UNIQUE,
  Author INT(5) NOT NULL,
  Priority INT(5) NOT NULL,
  TicketDescribtion VARCHAR(50) NOT NULL UNIQUE,
  Assignee INT(5),
  Status INT(5) NOT NULL,
  Logs NUMERIC(20) NOT NULL,

  CONSTRAINT Ticket_Board_FK FOREIGN KEY (Board)
  REFERENCES `Board`(BoardId),
  CONSTRAINT Ticket_Author_FK FOREIGN KEY (Author)
  REFERENCES `User`(UserId),
  CONSTRAINT Ticket_Priority_FK FOREIGN KEY (`Priority`)
  REFERENCES `Priority`(PriorityId),
  CONSTRAINT Ticket_Assignee_FK FOREIGN KEY (Assignee)
  REFERENCES `User`(UserId),
  CONSTRAINT Ticket_Status_FK FOREIGN KEY (Status)
  REFERENCES Status(StatusId)
)
;

-- Zwischentabelle zwischen User und Ticket
CREATE TABLE User_Ticket (
  User INT(5) NOT NULL,
  Ticket INT(5) NOT NULL,

  CONSTRAINT User_Ticket_User_FK FOREIGN KEY (`User`)
  REFERENCES `User`(UserId),
  CONSTRAINT User_Ticket_Ticket_FK FOREIGN KEY (Ticket)
  REFERENCES Ticket(TicketId)
)
;

-- Auto_Increment
ALTER TABLE Privilege AUTO_INCREMENT=1;
ALTER TABLE Board AUTO_INCREMENT=1;
ALTER TABLE Usertype AUTO_INCREMENT=1;
ALTER TABLE `User` AUTO_INCREMENT=1;
ALTER TABLE `Priority` AUTO_INCREMENT=1;
ALTER TABLE Status AUTO_INCREMENT=1;
ALTER TABLE Ticket AUTO_INCREMENT=1;

-- INSERT
INSERT INTO Priority
(Priority)
VALUES
(
  'Low'
);

INSERT INTO Priority
(Priority)
VALUES
(
  'Standard'
);

INSERT INTO Priority
(Priority)
VALUES
(
  'High'
);

INSERT INTO Privilege
(Privilege)
VALUES
(
  'Allgemein'
);

INSERT INTO Privilege
(Privilege)
VALUES
(
  'Developer'
);

INSERT INTO Status
(Status)
VALUES
(
  'Ready'
);

INSERT INTO Status
(Status)
VALUES
(
  'In Progress'
);

INSERT INTO Status
(Status)
VALUES
(
  'Review'
);

INSERT INTO Status
(Status)
VALUES
(
  'Done'
);

INSERT INTO Usertype
(Usertype)
VALUES
(
  'Developer'
);

INSERT INTO Usertype
(Usertype)
VALUES
(
  'Product Owner'
);

INSERT INTO Usertype
(Usertype)
VALUES
(
  'Customer'
);