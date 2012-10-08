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

create table issuers 
(srno int not null AUTO_INCREMENT primary key,
 name varchar(20) not null,
 reg_no varchar(20) not null,
 url varchar(40) not null,
 status char(1) not null);
 
alter table issuers add(issuer_no varchar(20) not null);
 
 create table administrator
 (username varchar(20) not null,
  password varchar(20) not null);
    
 create table e_admin
 (username varchar(20) not null primary key,
   password varchar(20) not null,
   issuer_id varchar(20) not null);
   
 
 create table constituency 
 (srno int not null AUTO_INCREMENT primary key,
  name varchar(50) not null,
  issuer_id varchar(50) not null);

create table voter_issuer
(sr_no int not null auto_increment primary key,
voter_srno int,
foreign key(voter_srno) references voter(srno),
const_id int,
foreign key(const_id) references constituency(srno),
voter_id varchar(50),
issuer_id varchar(50));

create table elections
(sr_no int not null auto_increment primary key,
 election_name varchar(50),
 election_purpose varchar(200),
 start_date varchar(30),
 end_date varchar(30));
 
 create table elections_voterissuer
 (sr_no int not null auto_increment primary key,
  election_id int,
  foreign key(election_id) references elections(sr_no),
  const_id int,
  foreign key(const_id) references voter_issuer(const_id),
  issuer_id varchar(50));
  
create table voter_login
(sr_no int not null auto_increment primary key,
 voter_id varchar(50),
 username varchar(50),
 password varchar(50));
 
create table candidates
(srno int not null auto_increment primary key,
 election_id int,
 foreign key(election_id) references elections(sr_no),
 const_id int,
 foreign key(const_id) references constituency(srno),
 voter_id varchar(50));
 
create table registered_vote
(voter_id varchar(50),
 candidate_voter_id varchar(50),
 election_id int,
 foreign key(election_id) references elections(srno))