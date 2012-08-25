create table voter
(srno int not null AUTO_INCREMENT primary key,
v_fname varchar(20) not null,
v_mname varchar(20) not null,
v_lname varchar(20) not null,
f_fname varchar(20) not null,
f_mname varchar(20) not null,
f_lname varchar(20) not null,
m_fname varchar(20) not null,
m_mname varchar(20) not null,
m_lname varchar(20) not null,
gender char(1) not null,
marital_status char(1) not null,
reg varchar(10) not null,
nation varchar(20) not null,
state varchar(20) not null,
city varchar(20) not null,
colony varchar(20) not null,
postal_pin varchar(20) not null,
status char(1) not null);

drop table voter;

select * from voter;
insert into voter(v_fname,v_mname,v_lname,f_fname,f_mname,f_lname,m_fname,m_mname,m_lname,gender,marital_status,reg,nation,state,city,colony,postal_pin,status)
values('d','d','d','d','d','d','d','d','d','d','d','d','d','d','d','d','d','d');

create table issuers 
(srno int not null AUTO_INCREMENT primary key,
 name varchar(20) not null,
 reg_no varchar(20) not null,
 url varchar(40) not null,
 status char(1) not null);
 
 alter table issuers add(issuer_no varchar(20) not null);
 
 update issuers
 set status = 'N' 
 where srno=15;
 
 
 Select * from issuers;
 
 insert into issuers(name,reg_no,url,status) values('Dell','N/A','www.dell.com','Y');
 
 
 create table administrator
 (username varchar(20) not null,
  password varchar(20) not null);
  
  insert into administrator values('Priyanka','Priyanka');
  
  select * from administrator;  
  
  select count(*) from administrator where username='Digvijay' and password='Digvijay';
  
  create table e_admin
  (username varchar(20) not null primary key,
   password varchar(20) not null,
   issuer_id varchar(20) not null);
   
  insert into e_admin values('Digvijay','Digvijay','90');
   
   select * from e_admin;
   
   update e_admin set issuer_id = '90' where username = 'username';
   
   
 