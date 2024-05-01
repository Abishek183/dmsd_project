-- Insert into PERSON
INSERT INTO PERSON (PNAME) VALUES
('John Doe'),
('Jane Smith'),
('Alice Johnson'),
('Emma Watson'),
('Robert Downey'),
('Chris Evans');

-- Insert into PUBLISHER
INSERT INTO PUBLISHER (PUBNAME, ADDRESS) VALUES
('Pearson', '123 Pearson Rd, New York'),
('McGraw Hill', '456 McGraw St, Chicago'),
('Prentice Hall', '789 Prentice Ave, San Francisco'),
('Random House', '10 Random St, Boston'),
('Simon & Schuster', '123 Simon Rd, Philadelphia'),
('Hachette Book Group', '321 Hachette Blvd, Miami');

-- Insert into DOCUMENT
INSERT INTO DOCUMENT (TITLE, PDATE, PUBLISHERID) VALUES
('Fundamentals of Database Systems', '2020-01-15', 1),
('Database Management Systems', '2020-02-20', 2),
('Modern Database Management', '2020-03-25', 3),
('Advanced Programming', '2021-05-10', 4),
('The Art of Computer Programming', '2021-06-20', 5),
('Algorithms + Data Structures = Programs', '2021-07-15', 6),
('Learning Python', '2021-08-15', 1),
('Mastering MySQL', '2021-09-20', 2),
('Cloud Computing Basics', '2021-10-25', 3);

-- Insert into BRANCH
INSERT INTO BRANCH (LNAME, LOCATION) VALUES
('Central Library', 'Downtown'),
('West Branch', 'Westside'),
('East Branch', 'Eastside');

-- Insert into BOOK
INSERT INTO BOOK (DOCID, ISBN) VALUES
(1, '9780312542542'),
(2, '9780312542559'),
(3, '9780312542566'),
(4, '978-0641723445'),
(5, '978-0321573513'),
(6, '978-0471117094'),
(7, '978-1492051366'),
(8, '978-1492040377'),
(9, '978-1491954469');

-- Insert into PROCEEDINGS
INSERT INTO PROCEEDINGS (DOCID, CDATE, CLOCATION) VALUES
(1, '2021-05-10', 'New York'),
(2, '2021-06-15', 'Los Angeles'),
(3, '2021-07-20', 'Chicago'),
(4, '2022-03-15', 'Boston'),
(5, '2022-04-16', 'San Diego'),
(6, '2022-05-17', 'Seattle');

-- Insert into JOURNAL_VOLUME
INSERT INTO JOURNAL_VOLUME (DOCID, VOLUME_NO, EDITOR) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4),
(5, 5, 5),
(6, 6, 6);

-- Insert into JOURNAL_ISSUE
INSERT INTO JOURNAL_ISSUE (DOCID, ISSUE_NO, SCOPE) VALUES
(1, 1, 'Science'),
(2, 2, 'Technology'),
(3, 3, 'Healthcare'),
(4, 4, 'Mathematics'),
(5, 5, 'Engineering'),
(6, 6, 'Physics');

-- Insert into COPY
INSERT INTO COPY (DOCID, COPYNO, BID, POSITION) VALUES
(1, 1, 1, '001A01'),
(2, 1, 2, '001B02'),
(3, 1, 3, '001C03'),
(4, 1, 1, '002A01'),
(5, 1, 2, '002B01'),
(6, 1, 3, '002C01'),
(7, 1, 1, '003A01'),
(8, 1, 2, '003B01'),
(9, 1, 3, '003C01');


-- Insert into READER
INSERT INTO READER (RTYPE, RNAME, RADDRESS, PHONE_NO) VALUES
('Student', 'John Doe', '123 Elm St', '555-1234'),
('Faculty', 'Jane Smith', '456 Oak St', '555-5678'),
('Staff', 'Alice Johnson', '789 Pine St', '555-9012'),
('Senior', 'Bob Brown', '321 Maple St', '555-3456'),
('Guest', 'Natalie Portman', '456 Vine St', '555-6789'),
('Student', 'Scarlett Johansson', '789 Maple St', '555-9876');

-- Insert into RESERVATION
INSERT INTO RESERVATION (DTIME) VALUES
('2024-04-01 10:30:00'),
('2024-04-02 11:00:00'),
('2024-04-03 09:45:00'),
('2024-05-01 09:00:00'),
('2024-05-02 10:00:00'),
('2024-05-03 11:00:00'),
('2024-06-01 10:00:00'),
('2024-06-02 11:00:00'),
('2024-06-03 12:00:00');

-- Insert into BORROWING
INSERT INTO BORROWING (BDTIME, RDTIME, BFINE) VALUES
('2024-04-01 10:30:00', '2024-04-21 10:30:00', 0),
('2024-04-02 11:00:00', NULL, NULL),
('2024-04-03 09:45:00', '2024-04-23 09:45:00', 0),
('2024-05-01 09:30:00', '2024-05-21 09:30:00', 0),
('2024-05-02 10:30:00', NULL, NULL),
('2024-05-03 11:30:00', '2024-05-23 11:30:00', 0),
('2024-05-04 09:00:00', '2024-05-24 09:00:00', 0),
('2024-05-05 10:00:00', NULL, NULL),
('2024-05-06 11:00:00', '2024-05-26 11:00:00', 0);

-- Insert into BORROWS
INSERT INTO BORROWS (BOR_NO, DOCID, COPYNO, BID, RID) VALUES
(1, 1, 1, 1, 1),
(2, 2, 1, 2, 2),
(3, 3, 1, 3, 3),
(4, 4, 1, 1, 4),
(5, 5, 1, 2, 5),
(6, 6, 1, 3, 6),
(7, 7, 1, 1, 1),
(8, 8, 1, 2, 2),
(9, 9, 1, 3, 3);

-- Insert into USERLIB
INSERT INTO USERLIB (USERID, USERREADERID, USERTYPE, CARDNUMBER, PASSWORD) VALUES
(1, 1, 'reader', '1234', NULL),
(2, 2, 'reader', '2345', NULL),
(3, 3, 'reader', '3456', NULL),
(4, NULL, 'admin', NULL, '1234');
