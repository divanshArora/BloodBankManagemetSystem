DROP DATABASE BloodBank;
CREATE DATABASE BloodBank;
USE BloodBank;
/*Create tables*/

CREATE TABLE medicalReport(

report_id INT(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
blood_grp VARCHAR(4) NOT NULL
);

CREATE TABLE Location(
code INT NOT NULL PRIMARY KEY,
address VARCHAR(50) NOT NULL 
);


CREATE TABLE Donor (
donor_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
donor_name VARCHAR(30) NOT NULL,
report_id INT(6) NOT NULL, 
appointment_date TIMESTAMP,
location_code INT NOT NULL,
FOREIGN KEY (report_id) REFERENCES 	medicalReport(report_id),
FOREIGN KEY (location_code) REFERENCES Location(code)
);

CREATE TABLE Bank(
bank_id INT(6) UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
bank_name VARCHAR(40),
location_code INT NOT NULL, 

FOREIGN KEY (location_code) REFERENCES Location(code)
);


CREATE TABLE Hospital(

hospital_id INT(6) UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
bank_id INT(6) UNSIGNED ,
hospital_address VARCHAR(50),
FOREIGN KEY (bank_id) REFERENCES Bank(bank_id)
);


CREATE TABLE Doctor(

doctor_id INT(6) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
hospital_id INT(6) UNSIGNED NOT NULL ,
rating INT UNSIGNED,
age INT NOT NULL,
qualification INT NOT NULL,
doctor_name VARCHAR(30) NOT NULL,
doctor_address VARCHAR(50) NOT NULL,
doctor_phone_number VARCHAR(50) NOT NULL,
FOREIGN	KEY (hospital_id) REFERENCES Hospital(hospital_id)
);



CREATE TABLE Blood(

blood_id INT(6) UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
doctor_id INT(6) UNSIGNED  NOT NULL,
donor_id INT(6) UNSIGNED  NOT NULL,
blood_grp VARCHAR(4) NOT NULL,
quantity FLOAT(9,3) NOT NULL ,
bank_id INT(6) UNSIGNED  NOT NULL,
FOREIGN KEY (doctor_id) REFERENCES Doctor(doctor_id),
FOREIGN KEY (bank_id) REFERENCES Bank(bank_id),
FOREIGN KEY (donor_id) REFERENCES Donor(donor_id)

);
/* NOTE:: LOCATION NOT CREATED */

CREATE TABLE Patient(

patient_id INT(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
rank INT NOT NULL,
patient_name VARCHAR(30) NOT NULL,
date_needed DATE NOT NULL,
blood_grp_needed VARCHAR(4) NOT NULL,
blood_quant_needed FLOAT(9,3) NOT NULL
);

/* NOTE:: Report id can be added to patient*/

CREATE TABLE Needs(
blood_id INT(6) UNSIGNED NOT NULL,
patient_id INT(6) NOT NULL,
PRIMARY KEY ( patient_id, blood_id)
);

CREATE TABLE Transport (
bank_id1 INT(6) UNSIGNED  NOT NULL,
bank_id2 INT(6) UNSIGNED  NOT NULL,
PRIMARY KEY(bank_id1,bank_id2)
);

INSERT INTO medicalReport(blood_grp) VALUES('A');
INSERT INTO Location(code, address) VALUES(1,'Delhi1');
INSERT INTO Donor(donor_name, report_id, appointment_date, location_code) VALUES('testdonor1',1,'2017-10-10 10:10:10' , 1);
INSERT INTO medicalReport(blood_grp) VALUES('B');
INSERT INTO Location(code, address) VALUES(2,'Delhi2');
INSERT INTO Donor(donor_name, report_id, appointment_date, location_code) VALUES('testdonor2',2,'2017-01-02 10:10:10' , 2);
INSERT INTO medicalReport(blood_grp) VALUES('C');
INSERT INTO Location(code, address) VALUES(3,'Delhi3');
INSERT INTO Donor(donor_name, report_id, appointment_date, location_code) VALUES('testdonor3',3,'2017-10-20 10:10:10' , 3);


-- Add Bank

INSERT INTO Bank(location_code, bank_name) VALUES (1,"Bank1");
INSERT INTO Bank(location_code,bank_name) VALUES (1,"Bank4");
INSERT INTO Bank(location_code,bank_name) VALUES (2,"Bank2");
INSERT INTO Bank(location_code,bank_name) VALUES (3,"Bank3");

-- Add patients

INSERT INTO Patient(rank, patient_name, date_needed, blood_grp_needed, blood_quant_needed) VALUES (1,"pat1",CURDATE(),"A",5.5);
INSERT INTO Patient(rank, patient_name, date_needed, blood_grp_needed, blood_quant_needed) VALUES (2,"pat2","2017-10-01","B",9.5);
INSERT INTO Patient(rank, patient_name, date_needed, blood_grp_needed, blood_quant_needed) VALUES (3,"pat3","2017-05-01","C",30.5);
INSERT INTO Patient(rank, patient_name, date_needed, blood_grp_needed, blood_quant_needed) VALUES (4,"pat4","2017-06-05","A",19.5);


-- Add Hospitals

INSERT INTO Hospital(bank_id,hospital_address) VALUES( 1,  "HDelhi1");
INSERT INTO Hospital(bank_id,hospital_address) VALUES( 2,  "HDelhi2");



-- Add doctors

INSERT INTO Doctor(hospital_id ,rating ,age ,qualification ,doctor_name,doctor_address,doctor_phone_number ) VALUES(1,3,34,9,"Doctor1","Ad1","123456789");
INSERT INTO Doctor(hospital_id ,rating ,age ,qualification ,doctor_name,doctor_address,doctor_phone_number ) VALUES(2,1,26,4,"Doctor2","Ad2","123456711");
INSERT INTO Doctor(hospital_id ,rating ,age ,qualification ,doctor_name,doctor_address,doctor_phone_number ) VALUES(2,4,50,10,"Doctor3","Ad3","323456789");
INSERT INTO Doctor(hospital_id ,rating ,age ,qualification ,doctor_name,doctor_address,doctor_phone_number ) VALUES(1,2,55,1,"Doctorx","Ad4","123456789");
INSERT INTO Doctor(hospital_id ,rating ,age ,qualification ,doctor_name,doctor_address,doctor_phone_number ) VALUES(2,3,90,3,"Doctory","Ad5","123456711");
INSERT INTO Doctor(hospital_id ,rating ,age ,qualification ,doctor_name,doctor_address,doctor_phone_number ) VALUES(2,4,111,8,"Doctorz","Ad6","323456789");

-- Add blood vials
INSERT INTO Blood(doctor_id,donor_id,blood_grp,quantity,bank_id) VALUES(1,1,"A",2.3,1);
INSERT INTO Blood(doctor_id,donor_id,blood_grp,quantity,bank_id) VALUES(1,1,"A",4.5,2);
INSERT INTO Blood(doctor_id,donor_id,blood_grp,quantity,bank_id) VALUES(2,2,"B",1,1);
INSERT INTO Blood(doctor_id,donor_id,blood_grp,quantity,bank_id) VALUES(3,1,"A",10,3);
INSERT INTO Blood(doctor_id,donor_id,blood_grp,quantity,bank_id) VALUES(3,3,"C",2.3,1);

INSERT INTO Transport(bank_id1, bank_id2) VALUES(1,2);
INSERT INTO Transport(bank_id1, bank_id2) VALUES(1,3);
INSERT INTO Transport(bank_id1, bank_id2) VALUES(2,1);
INSERT INTO Transport(bank_id1, bank_id2) VALUES(3,1);


