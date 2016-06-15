-- Author: Kyle Johnson
-- Date: 12/04/15
-- Description: SQL queries used to select, add, delete, update, and filter data

--queries used repeatedly, e.g. for getting name and id in a form, are only shown once for brevity

--blood_status table

SELECT blood_id, blood_status FROM blood_status;

--add to blood_status

INSERT INTO blood_status(blood_status) VALUES [status_desc];

--houses_tbl

SELECT house_id, house_name, mascot FROM houses_tbl;

--add to houses_tbl

INSERT INTO houses_tbl(house_name, mascot) VALUES ([house],[mascot]);

--subjects_tbl

SELECT subject_id, subject_desc, taught_by FROM subjects_tbl;

--get teacher_id using name, to be used in form submittal

SELECT teacher_id, CONCAT(f_name, ' ', l_name) FROM teachers_tbl;

--add subject_desc

INSERT INTO subjects_tbl(subject_desc, taught_by) VALUES ([desc_],[id]);

--teachers_tbl

SELECT teacher_id, f_name, l_name FROM teachers_tbl;

--add teacher name

INSERT INTO teachers_tbl(f_name, l_name) VALUES ([f_name],[l_name]);

--View student name, house, and blood status

SELECT students_tbl.f_name, students_tbl.l_name, houses_tbl.house_name, blood_status.blood_status
FROM students_tbl
INNER JOIN houses_tbl on houses_tbl.house_id = students_tbl.house_id
INNER JOIN blood_status on blood_status.blood_id = students_tbl.blood_id;

--get student id by name, to be used in form submittal

SELECT student_id, CONCAT(f_name, ' ', l_name) FROM students_tbl;

--insert student

INSERT INTO students_tbl(f_name, l_name, house_id, blood_id)
VALUES ([fname], [lname], [h_id], [b_id]);

--remove student

DELETE FROM students_tbl WHERE student_id=[id];

--update student house and blood_status

UPDATE students_tbl SET house_id=[h_id], blood_id=[b_id] WHERE student_id=[s_id];

--filter students by house

SELECT students_tbl.f_name, students_tbl.l_name, houses_tbl.house_name, blood_status.blood_status
FROM students_tbl
INNER JOIN houses_tbl on houses_tbl.house_id = students_tbl.house_id
INNER JOIN blood_status on blood_status.blood_id = students_tbl.blood_id
WHERE students_tbl.house_id = [id];

--view subjects, teachers, and all students taking each subject

SELECT subjects_tbl.subject_desc, students_tbl.f_name, students_tbl.l_name, 
teachers_tbl.f_name, teachers_tbl.l_name
FROM students_tbl
INNER JOIN takes_subject on takes_subject.student_id = students_tbl.student_id
INNER JOIN	subjects_tbl on subjects_tbl.subject_id = takes_subject.subject_id
INNER JOIN teachers_tbl on teachers_tbl.teacher_id = subjects_tbl.taught_by
ORDER BY subjects_tbl.subject_desc;

--list of subjects taken and teacher filtered by student

SELECT subjects_tbl.subject_desc, teachers_tbl.f_name, teachers_tbl.l_name
FROM students_tbl
INNER JOIN takes_subject on takes_subject.student_id = students_tbl.student_id
INNER JOIN	subjects_tbl on subjects_tbl.subject_id = takes_subject.subject_id
INNER JOIN  teachers_tbl on teachers_tbl.teacher_id = subjects_tbl.taught_by
WHERE students_tbl.student_id=[id];

--add student/subject to takes_subject relationship table

INSERT INTO takes_subject(student_id, subject_id)
VALUES ([s_id], [sub_id]);

--remove student/subject from relationship table

DELETE FROM takes_subject WHERE student_id=[sid] AND subject_id=[sub_id];

--update taught_by for subject

UPDATE subjects_tbl SET taught_by=[tid] WHERE subject_id=[sid];






