insert into people (first_name, surname, hospital_number, grade, date_booked, created_at, updated_at)
  values ('Test', 'Person1', '1234', 1, '2012-05-02', now(), now());
insert into people (first_name, surname, hospital_number, grade, date_booked, created_at, updated_at)
  values ('Test', 'Person2', '5412', 2, '2012-06-02', now(), now());
insert into people (first_name, surname, hospital_number, grade, date_booked, created_at, updated_at)
  values ('Martin', 'Cook', '67567', 1, '2012-06-09', now(), now());
insert into people (first_name, surname, hospital_number, grade, date_booked, created_at, updated_at)
  values ('Bob', 'Jones', '14354', 4, '2011-11-11', now(), now());
insert into people (first_name, surname, hospital_number, grade, date_booked, created_at, updated_at)
  values ('Fred', 'Anderson', '12341', 3, '2012-01-02', now(), now());

insert into "appointmenttypes"(name, created_at, updated_at) values ('Pre-op', now(), now());
insert into "appointmenttypes"(name, created_at, updated_at) values ('Post-op', now(), now());


insert into "surgerytypes"(name, "group", created_at, updated_at) values ('P+I', 1, now(), now());
insert into "surgerytypes"(name, "group", created_at, updated_at) values ('E+I', 1, now(), now());
insert into "surgerytypes"(name, "group", created_at, updated_at) values ('Secondary IOL', 1, now(), now());
insert into "surgerytypes"(name, "group", created_at, updated_at) values ('Other Intra-ocular Procedures', NULL, now(), now());
insert into "surgerytypes"(name, "group", created_at, updated_at) values ('Strab', NULL, now(), now());
insert into "surgerytypes"(name, "group", created_at, updated_at) values ('Trab', NULL, now(), now());
insert into "surgerytypes"(name, "group", created_at, updated_at) values ('Conj Mass Excision', 2, now(), now());
insert into "surgerytypes"(name, "group", created_at, updated_at) values ('Other Extra-Ocular Procedures', 2, now(), now());



