-- Insert into DOCUMENT table
INSERT INTO DOCUMENT (DOCID, TITLE, PDATE, PUBLISHERID) VALUES
(1, 'To Kill a Mockingbird', '1960-07-11', 1),
(2, '1984', '1949-06-08', 2),
(3, 'The Great Gatsby', '1925-04-10', 3),
(4, 'The Catcher in the Rye', '1951-07-16', 4),
(5, 'Brave New World', '1932-01-01', 5),
(6, 'Journal of Science - Volume 1', '2022-01-01', 11),
(7, 'Nature - Volume 100', '2021-12-31', 12),
(8, 'Journal of Medicine - Volume 50', '2021-12-30', 13),
(9, 'Journal of Engineering - Volume 25', '2021-12-29', 14),
(10, 'Journal of Art - Volume 10', '2021-12-28', 15),
(11, 'IEEE Conference Proceedings 2022', '2022-05-01', 16),
(12, 'ACM Conference Proceedings 2021', '2021-11-15', 17),
(13, 'ICML Conference Proceedings 2021', '2021-09-05', 18),
(14, 'CVPR Conference Proceedings 2020', '2020-06-14', 19),
(15, 'NeurIPS Conference Proceedings 2019', '2019-12-10', 20);

-- Insert into PUBLISHER table
INSERT INTO PUBLISHER (PUBLISHERID, PUBNAME, ADDRESS) VALUES
(1, 'HarperCollins Publishers', '195 Broadway, New York, NY 10007, United States'),
(2, 'Penguin Books Ltd', '80 Strand, London WC2R 0RL, United Kingdom'),
(3, 'Scribner', '1230 Avenue of the Americas, New York, NY 10020, United States'),
(4, 'Little, Brown and Company', '1290 Avenue of the Americas, New York, NY 10104, United States'),
(5, 'Chatto & Windus', '20 Vauxhall Bridge Rd, Westminster, London SW1V 2SA, United Kingdom'),
(6, 'Science Publishing House', '123 Main Street, Anytown, USA'),
(7, 'Nature Publishing Group', '456 Elm Street, Othertown, UK'),
(8, 'Medicine Publishers Ltd', '789 Oak Street, Another Town, USA'),
(9, 'Engineering Press', '101 Maple Avenue, Cityville, USA'),
(10, 'Artistic Books Ltd', '246 Pine Street, Artsburg, UK'),
(11, 'IEEE Press', '345 Oak Lane, Technology City, USA'),
(12, 'ACM Publications', '678 Maple Drive, Computertown, USA'),
(13, 'International Conference on Machine Learning', '901 Elm Road, AI City, USA'),
(14, 'IEEE Computer Society', '1122 Pine Street, Techville, USA'),
(15, 'Neural Information Processing Systems Foundation', '1313 Maple Street, ML City, USA');

INSERT INTO PROCEEDINGS (DOCID, CDATE, CLOCATION) VALUES
(11, '2022-04-1', '2022-05-01', "NY"),
(12, '2022-04-2', '2021-11-15', "NJ"),
(13, '2022-04-3', '2021-09-05', "FL"),
(14, '2022-04-4', '2020-06-14', "MO"),
(15, '2022-04-5', '2019-12-10', "TX");

INSERT INTO CHAIRS (PID, DOCID) VALUES
(11, 11),
(12, 12),
(13, 13),
(14, 14),
(15, 15);

CREATE TABLE USERSLIB (
    USERID INT PRIMARY KEY,
    USERREADERID INT,
    USERTYPE VARCHAR(32),
    CARDNUMBER VARCHAR(32),
    PASSWORD VARCHAR(32),
    FOREIGN KEY (USERREADERID) REFERENCES READER (RID)
);

INSERT INTO USERLIB (PID, DOCID) VALUES
(1, 1, 'reader', '1234', NULL),
(2, 2, 'reader', '2345', NULL),
(3, 3, 'reader', '3456', NULL),
(4, NULL, 'admin', NULL, '1234');