-- Bereich: Schema
-- Tabellen in Verbindung mit der Tabelle Boards
CREATE TABLE ColumnName (
  ColumnNameId INT(5) AUTO_INCREMENT,
  Name VARCHAR(25) NOT NULL UNIQUE
)
;

CREATE TABLE Privilege (
  PrivilegeId INT(5) AUTO_INCREMENT,
  Privilege VARCHAR(25) NOT NULL UNIQUE
)
;

-- Tabelle Board
CREATE TABLE Board (
  BoardId INT(5) AUTO_INCREMENT,
  ProjectName VARCHAR(25) NOT NULL UNIQUE,
  Privilege INT(3) NOT NULL,
  ColumnOrder VARCHAR(15) NOT NULL,

  CONSTRAINT Board_Privilege_FK FOREIGN KEY (Privilege)
	REFERENCES Privilege(PrivilegeID)
)
;

-- Zwischentabelle für die Tabelle Board
CREATE TABLE Board_ColumnName (
  Board INT(5) NOT NULL,
  ColumnName INT(5) NOT NULL,

  CONSTRAINT Board_ColumnName_Board_FK FOREIGN KEY (Board)
  REFERENCES Board(BoardId),
  CONSTRAINT Board_Board_ColumnName_FK FOREIGN KEY (ColumnName)
  REFERENCES ColumnName(ColumnNameId)
)
;

-- Tabellen in Verbindung mit der Tabelle User (wenn es die Tabelle noch nicht gibt)
CREATE TABLE Usertype (
  UsertypeId INT(5) AUTO_INCREMENT,
  Usertype VARCHAR(25) NOT NULL UNIQUE
) 
;

-- Tabelle User
CREATE TABLE `User` (
  UserId INT(5) AUTO_INCREMENT,
  Username VARCHAR(25) NOT NULL UNIQUE,
  Email VARCHAR(30) NOT NULL UNIQUE, 
  Password VARCHAR(50) NOT NULL,
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
  PriorityId INT(5) AUTO_INCREMENT,
  Priority VARCHAR(25) NOT NULL UNIQUE
)
;

CREATE TABLE Status (
  StatusId INT(5) AUTO_INCREMENT,
  Status VARCHAR(25) NOT NULL UNIQUE
)
;

-- Tabelle Ticket
CREATE TABLE Ticket (
  TicketId INT(5) AUTO_INCREMENT,
  Board INT(5) NOT NULL,
  TicketSummary VARCHAR(25) NOT NULL,
  Author INT(5) NOT NULL,
  Priority INT(2) NOT NULL,
  TicketDescribtion VARCHAR(50) NOT NULL UNIQUE,
  Assignee INT(5),
  Status INT(5) NOT NULL,
  Logs INT(20) NOT NULL,

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