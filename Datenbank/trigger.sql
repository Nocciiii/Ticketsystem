-- Sequences für die Tabelle Board
CREATE SEQUENCE Board_BoardId_seq
MAXVALUE 999
START WITH 1
INCREMENT BY 1
NOCACHE
/

CREATE SEQUENCE Board_Privilege_seq
MAXVALUE 999
START WITH 1
INCREMENT BY 1
NOCACHE
/

-- Trigger für die Tabelle Board
CREATE OR REPLACE TRIGGER Board_BoardId_tr
    BEFORE INSERT ON Board
    FOR EACH ROW
    WHEN(NEW.BoardId IS NULL)
    BEGIN
        :NEW.BoardId := Board_BoardId_seq.NEXTVAL;
    END;
/

CREATE OR REPLACE TRIGGER Board_Privilege_tr
    BEFORE INSERT ON Board
    FOR EACH ROW
    WHEN(NEW.Privilege IS NULL)
    BEGIN
        :NEW.Privilege := Board_Privilege_seq.NEXTVAL;
    END;
/

-- Sequences für die Tabelle Ticket
CREATE SEQUENCE Ticket_TicketId_seq
MAXVALUE 999
START WITH 1
INCREMENT BY 1
NOCACHE
/

CREATE SEQUENCE Ticket_Author_seq
MAXVALUE 999
START WITH 1
INCREMENT BY 1
NOCACHE
/

CREATE SEQUENCE Ticket_Priority_seq
MAXVALUE 999
START WITH 1
INCREMENT BY 1
NOCACHE
/

CREATE SEQUENCE Ticket_Assignee_seq
MAXVALUE 999
START WITH 1
INCREMENT BY 1
NOCACHE
/

CREATE SEQUENCE Ticket_Status_seq
MAXVALUE 999
START WITH 1
INCREMENT BY 1
NOCACHE
/

-- Trigger für die Tabelle Ticket
CREATE OR REPLACE TRIGGER Ticket_TicketId_tr
    BEFORE INSERT ON Ticket
    FOR EACH ROW
    WHEN(NEW.TicketId IS NULL)
    BEGIN
        :NEW.TicketId := Ticket_TicketId_seq.NEXTVAL;
    END;
/

CREATE OR REPLACE TRIGGER Ticket_Author_tr
    BEFORE INSERT ON Ticket
    FOR EACH ROW
    WHEN(NEW.Author IS NULL)
    BEGIN  
        :NEW.Author := Ticket_Author_seq.NEXTVAL;
    END;
/

CREATE OR REPLACE TRIGGER Ticket_Priority_tr
    BEFORE INSERT ON Ticket
    FOR EACH ROW
    WHEN(NEW."Priority" IS NULL)
    BEGIN  
        :NEW."Priority" := Ticket_Priority_seq.NEXTVAL;
    END;
/

CREATE OR REPLACE TRIGGER Ticket_Assignee_tr
    BEFORE INSERT ON Ticket
    FOR EACH ROW
    WHEN(NEW.Assignee IS NULL)
    BEGIN  
        :NEW.Assignee := Ticket_Assignee_seq.NEXTVAL;
    END;
/

CREATE OR REPLACE TRIGGER Ticket_Status_tr
    BEFORE INSERT ON Ticket
    FOR EACH ROW
    WHEN(NEW.Status IS NULL)
    BEGIN  
        :NEW.Status := Ticket_Status_seq.NEXTVAL;
    END;
/

-- Sequences für die Tabelle User
CREATE SEQUENCE User_UserId_seq
MAXVALUE 999
START WITH 1
INCREMENT BY 1
NOCACHE
/

CREATE SEQUENCE User_Usertype_seq
MAXVALUE 999
START WITH 1
INCREMENT BY 1
NOCACHE
/

-- Trigger für die Tabelle User
CREATE OR REPLACE TRIGGER User_UserId_tr
    BEFORE INSERT ON "User"
    FOR EACH ROW
    WHEN(NEW.UserId IS NULL)
    BEGIN
        :NEW.UserId := User_UserId_seq.NEXTVAL;
    END;
/

CREATE OR REPLACE TRIGGER User_Usertype_tr
    BEFORE INSERT ON "User"
    FOR EACH ROW
    WHEN(NEW.Usertype IS NULL)
    BEGIN
        :NEW.Usertype := User_Usertype_seq.NEXTVAL;
    END;
/
