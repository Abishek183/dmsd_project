-- PERSON
INSERT INTO PERSON (PNAME) VALUES
('John Doe'),
('Jane Smith'),
('Alice Johnson');

-- PUBLISHER
INSERT INTO PUBLISHER (PUBNAME, ADDRESS) VALUES
('Pearson', '123 Pearson Rd, New York'),
('McGraw Hill', '456 McGraw St, Chicago'),
('Prentice Hall', '789 Prentice Ave, San Francisco');

-- DOCUMENT
INSERT INTO DOCUMENT (TITLE, PDATE, PUBLISHERID) VALUES
('Fundamentals of Database Systems', '2020-01-15', 1),
('Database Management Systems', '2020-02-20', 2),
('Modern Database Management', '2020-03-25', 3);

-- BRANCH
INSERT INTO BRANCH (LNAME, LOCATION) VALUES
('Central Library', 'Downtown'),
('West Branch', 'Westside'),
('East Branch', 'Eastside');

-- BOOK
INSERT INTO BOOK (DOCID, ISBN) VALUES
(1, '9780312542542'),
(2, '9780312542559'),
(3, '9780312542566');

-- PROCEEDINGS
INSERT INTO PROCEEDINGS (DOCID, CDATE, CLOCATION) VALUES
(1, '2021-05-10', 'New York'),
(2, '2021-06-15', 'Los Angeles'),
(3, '2021-07-20', 'Chicago');

-- JOURNAL_VOLUME
INSERT INTO JOURNAL_VOLUME (DOCID, VOLUME_NO, EDITOR) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3);

-- JOURNAL_ISSUE
INSERT INTO JOURNAL_ISSUE (DOCID, ISSUE_NO, SCOPE) VALUES
(1, 1, 'Science'),
(2, 2, 'Technology'),
(3, 3, 'Healthcare');

-- COPY
INSERT INTO COPY (DOCID, COPYNO, BID, POSITION) VALUES (1, 2, 1, '001A02');
INSERT INTO COPY (DOCID, COPYNO, BID, POSITION) VALUES (1, 3, 1, '001A03');
INSERT INTO COPY (DOCID, COPYNO, BID, POSITION) VALUES (1, 4, 1, '001A04');
INSERT INTO COPY (DOCID, COPYNO, BID, POSITION) VALUES (1, 5, 1, '001A05');
INSERT INTO COPY (DOCID, COPYNO, BID, POSITION) VALUES
(1, 1, 1, '001A01'),
(2, 1, 2, '001B02'),
(3, 1, 3, '001C03');

-- READER
INSERT INTO READER (RTYPE, RNAME, RADDRESS, PHONE_NO) VALUES
('Student', 'John Doe', '123 Elm St', '555-1234'),
('Faculty', 'Jane Smith', '456 Oak St', '555-5678'),
('Staff', 'Alice Johnson', '789 Pine St', '555-9012'),
('Senior', 'Bob Brown', '321 Maple St', '555-3456');

-- RESERVATION
INSERT INTO RESERVATION (DTIME) VALUES
('2024-04-01 10:30:00'),
('2024-04-02 11:00:00'),
('2024-04-03 09:45:00');

-- CHAIRS
INSERT INTO CHAIRS (PID, DOCID) VALUES
(1, 1),
(2, 2),
(3, 3);

-- GEDITS
INSERT INTO GEDITS (DOCID, ISSUE_NO, PID) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3);

-- AUTHORS
INSERT INTO AUTHORS (PID, DOCID) VALUES
(1, 1),
(2, 2),
(3, 3);

-- RESERVES
INSERT INTO RESERVES (RID, RESERVATION_NO, DOCID, COPYNO, BID) VALUES
(1, 1, 1, 1, 1),
(2, 2, 2, 1, 2),
(3, 3, 3, 1, 3);

-- BORROWING
INSERT INTO BORROWING (BDTIME, RDTIME, BFINE) VALUES
('2024-04-01 10:30:00', '2024-04-21 10:30:00', 0),
('2024-04-02 11:00:00', NULL, NULL),
('2024-04-03 09:45:00', '2024-04-23 09:45:00', 0);

-- BORROWS
INSERT INTO BORROWS (BOR_NO, DOCID, COPYNO, BID, RID) VALUES
(1, 1, 1, 1, 1),
(2, 2, 1, 2, 2),
(3, 3, 1, 3, 3);

INSERT INTO USERLIB (USERID, USERREADERID, USERTYPE, CARDNUMBER, PASSWORD) VALUES
(1, 1, 'reader', '1234', NULL),
(2, 2, 'reader', '2345', NULL),
(3, 3, 'reader', '3456', NULL),
(4, NULL, 'admin', NULL, '1234');