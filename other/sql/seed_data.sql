insert into people (first_name, surname, priority, waiting_since, created_at, updated_at)
  values ('Test', 'Person1', 1, '2012-05-02', now(), now());
insert into people (first_name, surname, priority, waiting_since, created_at, updated_at)
  values ('Test', 'Person2', 2, '2012-06-02', now(), now());
insert into people (first_name, surname, priority, waiting_since, created_at, updated_at)
  values ('Martin', 'Cook', 1, '2012-06-09', now(), now());
insert into people (first_name, surname, priority, waiting_since, created_at, updated_at)
  values ('Bob', 'Jones', 4, '2011-11-11', now(), now());
insert into people (first_name, surname, priority, waiting_since, created_at, updated_at)
  values ('Fred', 'Anderson', 3, '2012-01-02', now(), now());

insert into "appointmenttypes"(name, created_at, updated_at) values ('Pre-op', now(), now());
insert into "appointmenttypes"(name, created_at, updated_at) values ('Operation', now(), now());
insert into "appointmenttypes"(name, created_at, updated_at) values ('Post-op', now(), now());