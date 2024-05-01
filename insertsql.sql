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

-- Insert into COPY (matching each document to multiple copies if needed)
INSERT INTO COPY (DOCID, COPYNO, BID, POSITION) VALUES
(1, 1, 1, '001A01'), (1, 1, 2, '001B01'), (1, 1, 3, '001C01'),
(1, 2, 1, '001A02'), (1, 2, 2, '001B02'), (1, 2, 3, '001C02'),
(1, 3, 1, '001A03'), (1, 3, 2, '001B03'), (1, 3, 3, '001C03'),
(1, 4, 1, '001A04'), (1, 4, 2, '001B04'), (1, 4, 3, '001C04'),
(1, 5, 1, '001A05'), (1, 5, 2, '001B05'), (1, 5, 3, '001C05'),
(2, 1, 1, '002A01'), (2, 1, 2, '002B01'), (2, 1, 3, '002C01'),
(2, 2, 1, '002A02'), (2, 2, 2, '002B02'), (2, 2, 3, '002C02'),
(2, 3, 1, '002A03'), (2, 3, 2, '002B03'), (2, 3, 3, '002C03'),
(2, 4, 1, '002A04'), (2, 4, 2, '002B04'), (2, 4, 3, '002C04'),
(2, 5, 1, '002A05'), (2, 5, 2, '002B05'), (2, 5, 3, '002C05'),
(3, 1, 1, '003A01'), (3, 1, 2, '003B01'), (3, 1, 3, '003C01'),
(3, 2, 1, '003A02'), (3, 2, 2, '003B02'), (3, 2, 3, '003C02'),
(3, 3, 1, '003A03'), (3, 3, 2, '003B03'), (3, 3, 3, '003C03'),
(3, 4, 1, '003A04'), (3, 4, 2, '003B04'), (3, 4, 3, '003C04'),
(3, 5, 1, '003A05'), (3, 5, 2, '003B05'), (3, 5, 3, '003C05'),
(4, 1, 1, '004A01'), (4, 1, 2, '004B01'), (4, 1, 3, '004C01'),
(4, 2, 1, '004A02'), (4, 2, 2, '004B02'), (4, 2, 3, '004C02'),
(4, 3, 1, '004A03'), (4, 3, 2, '004B03'), (4, 3, 3, '004C03'),
(4, 4, 1, '004A04'), (4, 4, 2, '004B04'), (4, 4, 3, '004C04'),
(4, 5, 1, '004A05'), (4, 5, 2, '004B05'), (4, 5, 3, '004C05'),
(5, 1, 1, '005A01'), (5, 1, 2, '005B01'), (5, 1, 3, '005C01'),
(5, 2, 1, '005A02'), (5, 2, 2, '005B02'), (5, 2, 3, '005C02'),
(5, 3, 1, '005A03'), (5, 3, 2, '005B03'), (5, 3, 3, '005C03'),
(5, 4, 1, '005A04'), (5, 4, 2, '005B04'), (5, 4, 3, '005C04'),
(5, 5, 1, '005A05'), (5, 5, 2, '005B05'), (5, 5, 3, '005C05'),
(6, 1, 1, '006A01'), (6, 1, 2, '006B01'), (6, 1, 3, '006C01'),
(6, 2, 1, '006A02'), (6, 2, 2, '006B02'), (6, 2, 3, '006C02'),
(6, 3, 1, '006A03'), (6, 3, 2, '006B03'), (6, 3, 3, '006C03'),
(6, 4, 1, '006A04'), (6, 4, 2, '006B04'), (6, 4, 3, '006C04'),
(6, 5, 1, '006A05'), (6, 5, 2, '006B05'), (6, 5, 3, '006C05'),
(7, 1, 1, '007A01'), (7, 1, 2, '007B01'), (7, 1, 3, '007C01'),
(7, 2, 1, '007A02'), (7, 2, 2, '007B02'), (7, 2, 3, '007C02'),
(7, 3, 1, '007A03'), (7, 3, 2, '007B03'), (7, 3, 3, '007C03'),
(7, 4, 1, '007A04'), (7, 4, 2, '007B04'), (7, 4, 3, '007C04'),
(7, 5, 1, '007A05'), (7, 5, 2, '007B05'), (7, 5, 3, '007C05'),
(8, 1, 1, '008A01'), (8, 1, 2, '008B01'), (8, 1, 3, '008C01'),
(8, 2, 1, '008A02'), (8, 2, 2, '008B02'), (8, 2, 3, '008C02'),
(8, 3, 1, '008A03'), (8, 3, 2, '008B03'), (8, 3, 3, '008C03'),
(8, 4, 1, '008A04'), (8, 4, 2, '008B04'), (8, 4, 3, '008C04'),
(8, 5, 1, '008A05'), (8, 5, 2, '008B05'), (8, 5, 3, '008C05'),
(9, 1, 1, '009A01'), (9, 1, 2, '009B01'), (9, 1, 3, '009C01'),
(9, 2, 1, '009A02'), (9, 2, 2, '009B02'), (9, 2, 3, '009C02'),
(9, 3, 1, '009A03'), (9, 3, 2, '009B03'), (9, 3, 3, '009C03'),
(9, 4, 1, '009A04'), (9, 4, 2, '009B04'), (9, 4, 3, '009C04'),
(9, 5, 1, '009A05'), (9, 5, 2, '009B05'), (9, 5, 3, '009C05');


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
('2024-05-06 11:00:00', '2024-05-26 11:00:00', 0),
('2024-05-07 09:00:00', NULL, NULL),  -- Book not yet returned
('2024-05-08 10:00:00', NULL, NULL),
('2024-05-09 11:00:00', NULL, NULL),
('2024-06-01 09:30:00', '2024-06-21 09:30:00', 0),
('2024-06-02 10:30:00', NULL, NULL),  -- Not yet returned
('2024-06-03 11:30:00', '2024-06-23 11:30:00', 0),
('2024-06-04 09:00:00', '2024-06-24 09:00:00', 0),
('2024-05-07 09:00:00', NULL, NULL),  -- Book not yet returned
('2024-05-08 10:00:00', NULL, NULL),
('2024-05-09 11:00:00', NULL, NULL),
('2024-06-01 09:30:00', '2024-06-21 09:30:00', 0),
('2024-05-07 09:00:00', NULL, NULL),  -- Book not yet returned
('2024-05-08 10:00:00', NULL, NULL),
('2024-05-09 11:00:00', NULL, NULL),
('2024-06-01 09:30:00', '2024-06-21 09:30:00', 0),
('2024-05-07 09:00:00', NULL, NULL),  -- Book not yet returned
('2024-05-08 10:00:00', NULL, NULL),
('2024-05-09 11:00:00', NULL, NULL),
('2024-06-01 09:30:00', '2024-06-21 09:30:00', 0),
('2024-06-05 10:00:00', NULL, NULL),  -- Not yet returned
('2024-06-06 11:00:00', '2024-06-26 11:00:00', 0),
('2024-06-06 11:00:00', '2024-06-26 11:00:00', 0),
('2024-06-06 11:00:00', '2024-06-26 11:00:00', 0);


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
(9, 9, 1, 3, 3),
(10, 1, 1, 1, 4),  -- Borrowed by another reader after return
(11, 2, 1, 2, 5),
(12, 3, 1, 3, 6),
(13, 1, 2, 1, 6), -- Borrowing second copy
(14, 2, 2, 2, 5),
(15, 3, 2, 3, 4),
(16, 4, 1, 1, 3),
(17, 5, 1, 2, 2),
(18, 6, 1, 3, 1),
(19, 7, 2, 1, 6), -- Borrowing second copy
(20, 8, 2, 2, 5),
(21, 9, 2, 3, 4),
(22, 1, 2, 1, 4), -- Borrowing second copy again after return
(23, 2, 2, 2, 1),
(24, 3, 2, 3, 2),
(25, 4, 2, 1, 5),
(26, 5, 2, 2, 6),
(27, 6, 2, 3, 1),
(28, 7, 2, 1, 2), -- Borrowing second copy again
(29, 8, 2, 2, 3),
(30, 9, 2, 3, 4),
(31, 1, 4, 1, 1),
(32, 1, 4, 2, 1);

-- Insert into USERLIB
INSERT INTO USERSLIB (USERID, USERREADERID, USERTYPE, CARDNUMBER, PASSWORD) VALUES
(1, 1, 'reader', '1234', NULL),
(2, 2, 'reader', '2345', NULL),
(3, 3, 'reader', '3456', NULL),
(4, NULL, 'admin', NULL, '1234');
