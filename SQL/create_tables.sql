-- Author: Kyle Johnson
-- Date: 12/02/15
-- Description: SQL create and fill tables with data
-- Input: table contents
-- Output: tables

--create tables

CREATE TABLE students_tbl(
student_id int(11) NOT NULL AUTO_INCREMENT,
f_name varchar(255) NOT NULL,
l_name varchar(255) NOT NULL,
house_id int(11) NOT NULL,
blood_id int(11) NOT NULL,
FOREIGN KEY(house_id) REFERENCES houses_tbl(house_id),
FOREIGN KEY (blood_id) REFERENCES blood_status(blood_id),
PRIMARY KEY(student_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE teachers_tbl(
teacher_id int(11) NOT NULL AUTO_INCREMENT,
f_name varchar(255) NOT NULL,
l_name varchar(255) NOT NULL,
PRIMARY KEY(teacher_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE blood_status(
blood_id int(11) NOT NULL AUTO_INCREMENT,
blood_status varchar(255) NOT NULL,
PRIMARY KEY(blood_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE houses_tbl(
house_id int(11) NOT NULL AUTO_INCREMENT,
house_name varchar(255) NOT NULL,
mascot	varchar(255) NOT NULL,
PRIMARY KEY(house_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE subjects_tbl(
subject_id int(11) NOT NULL AUTO_INCREMENT,
subject_desc varchar(255) NOT NULL,
taught_by int(11) NOT NULL,
FOREIGN KEY(taught_by) REFERENCES teachers_tbl(teacher_id),
PRIMARY KEY(subject_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE takes_subject(
student_id int(11),
subject_id int(11),
PRIMARY KEY(student_id, subject_id),
FOREIGN KEY(student_id) REFERENCES students_tbl(student_id),
FOREIGN KEY(subject_id) REFERENCES subjects_tbl(subject_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

--add data to tables

INSERT INTO blood_status(blood_status)
values ("Pure-Blood"),
("Half-Blood"),
("Muggle-Born");

INSERT INTO houses_tbl(house_name, mascot)
values("Gryffindor", "Lion"),
("Ravenclaw", "Eagle"),
("Hufflepuff", "Badger"),
("Slytherin", "Serpent");

INSERT INTO students_tbl(f_name, l_name, house_id, blood_id)
values("Harry", "Potter", 1, 2),
("Ronald", "Weasley", 1, 1),
("Draco", "Malfoy", 4, 1),
("Hermione", "Granger", 1, 3),
("Luna", "Lovegood", 2, 1),
("Cedric", "Diggory", 3, 1);

INSERT INTO teachers_tbl(f_name,l_name)
values("Remus", "Lupin"),
("Rubeus", "Hagrid"),
("Sybill", "Trelawney"),
("Severus", "Snape");


INSERT INTO subjects_tbl(subject_desc, taught_by)
values ("Defense Against the Dark Arts", 1),
("Care of Magical Creatures", 2),
("Potions", 4),
("Divination", 3);

INSERT INTO takes_subject(student_id, subject_id)
values(1,1),
(1,2),
(1,3),
(2,1),
(2,2),
(3,1),
(3,2),
(4,1),
(4,3),
(5,1),
(5,2);




