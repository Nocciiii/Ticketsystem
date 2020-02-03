-- Tabellen in Verbindung mit der Tabelle Boards
CREATE TABLE ColumnName (
  ColumnNameId NUMBER(5) PRIMARY KEY,
  Name VARCHAR2(25) NOT NULL UNIQUE
)
/

CREATE TABLE Privilege (
  PrivilegeId NUMBER(5) PRIMARY KEY,
  Privilege VARCHAR2(25) NOT NULL UNIQUE
)
/

-- Tabelle Board
CREATE TABLE Board (
  BoardId NUMBER(5) PRIMARY KEY,
  ProjectName VARCHAR2(25) NOT NULL UNIQUE,
  Privilege NUMBER(3) NOT NULL,
  ColumnOrder VARCHAR2(15) NOT NULL,

  CONSTRAINT Board_Privilege_FK FOREIGN KEY (Privilege)
	REFERENCES Privilege(PrivilegeID)
)
/

-- Zwischentabelle für die Tabelle Board
CREATE TABLE Board_ColumnName (
  Board NUMBER(5) NOT NULL,
  ColumnName NUMBER(5) NOT NULL,

  CONSTRAINT Board_ColumnName_Board_FK FOREIGN KEY (Board)
  REFERENCES Board(BoardId),
  CONSTRAINT Board_Board_ColumnName_FK FOREIGN KEY (ColumnName)
  REFERENCES ColumnName(ColumnNameId)
)
/

-- Tabellen in Verbindung mit der Tabelle User (wenn es die Tabelle noch nicht gibt)
CREATE TABLE Usertype (
  UsertypeId NUMBER(5) PRIMARY KEY,
  Usertype VARCHAR2(25) NOT NULL UNIQUE
) 
/

-- Tabelle User
CREATE TABLE "User" (
  UserId NUMBER(5) PRIMARY KEY,
  Username VARCHAR2(25) NOT NULL UNIQUE,
  Email VARCHAR2(30) NOT NULL UNIQUE, 
  Passwort VARCHAR2(50) NOT NULL,
  Usertype NUMBER(5) NOT NULL,
  
  CONSTRAINT User_Usertype_FK FOREIGN KEY (Usertype)
  REFERENCES Usertype(UsertypeId)
)
/

-- Zwischentabelle für die Tabelle Ticket
CREATE TABLE User_Privilege (
  "User" NUMBER(5) NOT NULL,
  Privilege NUMBER(5) NOT NULL,

  CONSTRAINT User_Privilege_User_FK FOREIGN KEY ("User")
  REFERENCES "User"(UserId),
  CONSTRAINT User_Privilege_Privilege_FK FOREIGN KEY (Privilege)
  REFERENCES Privilege(PrivilegeId)
)
/

-- Tabellen im Zusammenhang mit Ticket
CREATE TABLE "Priority" (
  PriorityId NUMBER(5) PRIMARY KEY,
  "Priority" VARCHAR2(25) NOT NULL UNIQUE
)
/

CREATE TABLE Status (
  StatusId NUMBER(5) PRIMARY KEY,
  Status VARCHAR2(25) NOT NULL UNIQUE
)
/

-- Tabelle Ticket
CREATE TABLE Ticket (
  TicketId NUMBER(5) PRIMARY KEY,
  TicketSummary VARCHAR2(25) NOT NULL,
  Author NUMBER(5) NOT NULL,
  "Priority" NUMBER(2) NOT NULL,
  TicketDescribtion VARCHAR2(300) NOT NULL UNIQUE,
  Assignee NUMBER(5),
  Status NUMBER(5) NOT NULL,
  Logs NUMBER(20) NOT NULL,

  CONSTRAINT Ticket_Author_FK FOREIGN KEY (Author)
  REFERENCES "User"(UserId),
  CONSTRAINT Ticket_Priority_FK FOREIGN KEY ("Priority")
  REFERENCES "Priority"(PriorityId),
  CONSTRAINT Ticket_Assignee_FK FOREIGN KEY (Assignee)
  REFERENCES "User"(UserId),
  CONSTRAINT Ticket_Status_FK FOREIGN KEY (Status)
  REFERENCES Status(StatusId)
)
/

-- Zwischentabelle zwischen User und Ticket
CREATE TABLE User_Ticket (
  "User" NUMBER(5) NOT NULL,
  Ticket NUMBER(5) NOT NULL,

  CONSTRAINT User_Ticket_User_FK FOREIGN KEY ("User")
  REFERENCES "User"(UserId),
  CONSTRAINT User_Ticket_Ticket_FK FOREIGN KEY (Ticket)
  REFERENCES Ticket(TicketId)
)
/