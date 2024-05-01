DROP TABLE IF EXISTS PERSON;
CREATE TABLE IF NOT EXISTS PERSON (
    PID INT AUTO_INCREMENT,
    PNAME VARCHAR(32),
    PRIMARY KEY (PID)
);

DROP TABLE IF EXISTS CHAIRS;
CREATE TABLE IF NOT EXISTS CHAIRS (
    PID INT,
    DOCID INT,
    PRIMARY KEY (PID, DOCID)
);

DROP TABLE IF EXISTS GEDITS;
CREATE TABLE IF NOT EXISTS GEDITS (
    DOCID INT,
    ISSUE_NO INT,
    PID INT,
    PRIMARY KEY (DOCID, ISSUE_NO, PID)
);

DROP TABLE IF EXISTS AUTHORS;
CREATE TABLE IF NOT EXISTS AUTHORS (
    PID INT,
    DOCID INT,
    PRIMARY KEY (PID, DOCID)
);

DROP TABLE IF EXISTS BOOK;
CREATE TABLE IF NOT EXISTS BOOK (
    DOCID INT,
    ISBN VARCHAR(64),
    PRIMARY KEY (DOCID)
);

DROP TABLE IF EXISTS JOURNAL_ISSUE;
CREATE TABLE IF NOT EXISTS JOURNAL_ISSUE (
    DOCID INT,
    ISSUE_NO INT,
    SCOPE VARCHAR(2048),
    PRIMARY KEY (DOCID, ISSUE_NO)
);

DROP TABLE IF EXISTS PROCEEDINGS;
CREATE TABLE IF NOT EXISTS PROCEEDINGS (
    DOCID INT,
    CDATE DATE,
    CLOCATION VARCHAR(64),
    -- Not needed as per library db spec - CEDITOR [],
    PRIMARY KEY (DOCID)
);

DROP TABLE IF EXISTS JOURNAL_VOLUME;
CREATE TABLE IF NOT EXISTS JOURNAL_VOLUME (
    DOCID INT,
    VOLUME_NO INT,
    EDITOR INT,
    PRIMARY KEY (DOCID)
);

DROP TABLE IF EXISTS DOCUMENT;
CREATE TABLE IF NOT EXISTS DOCUMENT (
    DOCID INT AUTO_INCREMENT,
    TITLE VARCHAR(64),
    PDATE DATE,
    PUBLISHERID INT,
    PRIMARY KEY (DOCID)
);

DROP TABLE IF EXISTS PUBLISHER;
CREATE TABLE IF NOT EXISTS PUBLISHER (
    PUBLISHERID INT AUTO_INCREMENT,
    PUBNAME VARCHAR(32),
    ADDRESS VARCHAR(64),
    PRIMARY KEY (PUBLISHERID)
);

DROP TABLE IF EXISTS COPY;
CREATE TABLE IF NOT EXISTS COPY (
    DOCID INT,
    COPYNO INT,
    BID INT,
    POSITION CHAR(6),
    PRIMARY KEY (DOCID, COPYNO, BID)
);

DROP TABLE IF EXISTS BRANCH;
CREATE TABLE IF NOT EXISTS BRANCH (
    BID INT AUTO_INCREMENT,
    LNAME VARCHAR(32),
    LOCATION VARCHAR(32),
    PRIMARY KEY (BID)
);

DROP TABLE IF EXISTS BORROWING;
CREATE TABLE IF NOT EXISTS BORROWING (
    BOR_NO INT AUTO_INCREMENT,
    BDTIME DATETIME,
    RDTIME DATETIME,
    BFINE FLOAT,
    PRIMARY KEY (BOR_NO)
);

DROP TABLE IF EXISTS RESERVES;
CREATE TABLE IF NOT EXISTS RESERVES (
    RID INT,
    RESERVATION_NO INT,
    DOCID INT,
    COPYNO INT,
    BID INT,
    PRIMARY KEY (RESERVATION_NO, DOCID, COPYNO, BID)
);

DROP TABLE IF EXISTS RESERVATION;
CREATE TABLE IF NOT EXISTS RESERVATION (
    RES_NO INT AUTO_INCREMENT,
    DTIME DATETIME DEFAULT NULL,
    PRIMARY KEY (RES_NO)
);

DROP TABLE IF EXISTS BORROWS;
CREATE TABLE IF NOT EXISTS BORROWS (
    BOR_NO INT,
    DOCID INT,
    COPYNO INT,
    BID INT,
    RID INT,
    PRIMARY KEY (BOR_NO, DOCID, COPYNO, BID)
);

DROP TABLE IF EXISTS READER;
CREATE TABLE IF NOT EXISTS READER (
    RID INT AUTO_INCREMENT,
    RTYPE VARCHAR(32),
    RNAME VARCHAR(32),
    RADDRESS VARCHAR(32),
    PHONE_NO VARCHAR(32),
    PRIMARY KEY (RID)
);

-- CHAIRS table fk constraints
ALTER TABLE CHAIRS
ADD CONSTRAINT
FOREIGN KEY (PID)
REFERENCES PERSON(PID) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE CHAIRS
ADD CONSTRAINT
FOREIGN KEY (DOCID)
REFERENCES PROCEEDINGS(DOCID) ON DELETE CASCADE ON UPDATE CASCADE;

-- GEDITS table FK constraints
ALTER TABLE GEDITS
ADD CONSTRAINT
FOREIGN KEY (PID)
REFERENCES PERSON(PID) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE GEDITS
ADD CONSTRAINT
FOREIGN KEY (DOCID, ISSUE_NO)
REFERENCES JOURNAL_ISSUE(DOCID, ISSUE_NO) ON DELETE CASCADE ON UPDATE CASCADE;

-- AUTHORS table FK constraints
ALTER TABLE AUTHORS
ADD CONSTRAINT
FOREIGN KEY (PID)
REFERENCES PERSON(PID) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE AUTHORS
ADD CONSTRAINT
FOREIGN KEY (DOCID)
REFERENCES BOOK(DOCID) ON DELETE CASCADE ON UPDATE CASCADE;

-- JOURNAL_ISSUE
ALTER TABLE JOURNAL_ISSUE
ADD CONSTRAINT
FOREIGN KEY (DOCID)
REFERENCES JOURNAL_VOLUME(DOCID) ON DELETE CASCADE ON UPDATE CASCADE;

-- BOOK
ALTER TABLE BOOK
ADD CONSTRAINT
FOREIGN KEY (DOCID)
REFERENCES DOCUMENT(DOCID) ON DELETE CASCADE ON UPDATE CASCADE;

-- PROCEEDINGS
ALTER TABLE PROCEEDINGS
ADD CONSTRAINT
FOREIGN KEY (DOCID)
REFERENCES DOCUMENT(DOCID) ON DELETE CASCADE ON UPDATE CASCADE;

-- JOURNAL_VOLUME
ALTER TABLE JOURNAL_VOLUME
ADD CONSTRAINT
FOREIGN KEY (EDITOR)
REFERENCES PERSON(PID) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE JOURNAL_VOLUME
ADD CONSTRAINT
FOREIGN KEY (DOCID)
REFERENCES DOCUMENT(DOCID) ON DELETE CASCADE ON UPDATE CASCADE;

-- DOCUMENT
ALTER TABLE DOCUMENT
ADD CONSTRAINT
FOREIGN KEY (PUBLISHERID)
REFERENCES PUBLISHER(PUBLISHERID) ON DELETE SET NULL ON UPDATE CASCADE;

-- COPY
ALTER TABLE COPY
ADD CONSTRAINT
FOREIGN KEY (DOCID)
REFERENCES DOCUMENT(DOCID) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE COPY
ADD CONSTRAINT
FOREIGN KEY (BID)
REFERENCES BRANCH(BID) ON DELETE CASCADE ON UPDATE CASCADE;

-- RESERVES
ALTER TABLE RESERVES
ADD CONSTRAINT
FOREIGN KEY (DOCID, COPYNO, BID)
REFERENCES COPY(DOCID, COPYNO, BID) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE RESERVES
ADD CONSTRAINT
FOREIGN KEY (RID)
REFERENCES READER(RID) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE RESERVES
ADD CONSTRAINT
FOREIGN KEY (RESERVATION_NO)
REFERENCES RESERVATION(RES_NO) ON DELETE CASCADE ON UPDATE CASCADE;

-- BORROWS
ALTER TABLE BORROWS
ADD CONSTRAINT
FOREIGN KEY (DOCID, COPYNO, BID)
REFERENCES COPY(DOCID, COPYNO, BID) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE BORROWS
ADD CONSTRAINT
FOREIGN KEY (BOR_NO)
REFERENCES BORROWING(BOR_NO) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE BORROWS
ADD CONSTRAINT
FOREIGN KEY (RID)
REFERENCES READER(RID) ON DELETE CASCADE ON UPDATE CASCADE;

-- Creation of simple users table for authentication

CREATE TABLE USERSLIB (
    USERID INT PRIMARY KEY,
    USERREADERID INT,
    USERTYPE VARCHAR(32),
    CARDNUMBER VARCHAR(32),
    PASSWORD VARCHAR(32),
    FOREIGN KEY (USERREADERID) REFERENCES READER (RID)
);
