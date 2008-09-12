drop table if exists Authors;

drop table if exists BookTypes;

drop table if exists Books;

drop table if exists LendLogs;

drop table if exists Locations;

drop table if exists Pubs;

drop table if exists Sorts;

drop table if exists Users;

drop table if exists keywords;

drop table if exists members;

/*==============================================================*/
/* Table: Authors                                               */
/*==============================================================*/
create table Authors
(
   authorid             int not null auto_increment,
   authorname           varchar(50) not null,
   primary key (authorid)
);

/*==============================================================*/
/* Table: BookTypes                                             */
/*==============================================================*/
create table BookTypes
(
   typeID               int not null auto_increment,
   typeName             varchar(50) not null,
   primary key (typeID)
);

/*==============================================================*/
/* Table: Books                                                 */
/*==============================================================*/
create table Books
(
   bookid               int not null auto_increment,
   booklabel            varchar(50) not null,
   bookname             varchar(50) not null,
   bookcontent          text,
   bookkeywords         varchar(500),
   bookauthors          varchar(200),
   bookstar             int not null default 1 comment '1-5ÐÇ',
   bookisbn             varchar(20),
   bookmoney            float,
   bookaddtime          datetime not null,
   bookbuytime          datetime,
   bookstatus           int not null default 1 comment '0¹Ø±Õ 1ÆÕÍ¨  2½è³ö 3¶ªÊ§',
   typeID               int not null,
   authorid             int,
   pubid                int not null,
   sortid               int not null,
   locationid           int not null,
   memberid             int,
   primary key (bookid)
);

/*==============================================================*/
/* Table: LendLogs                                              */
/*==============================================================*/
create table LendLogs
(
   LendLogId            int not null auto_increment,
   Boo_bookid           int,
   BookID               int not null,
   MemberID             int not null,
   status               int not null comment '1½è 2»¹',
   primary key (LendLogId)
);

/*==============================================================*/
/* Table: Locations                                             */
/*==============================================================*/
create table Locations
(
   locationid           int not null auto_increment,
   locationname         varchar(50) not null,
   primary key (locationid)
);

/*==============================================================*/
/* Table: Pubs                                                  */
/*==============================================================*/
create table Pubs
(
   pubid                int not null auto_increment,
   pubname              varchar(50) not null,
   primary key (pubid)
);

/*==============================================================*/
/* Table: Sorts                                                 */
/*==============================================================*/
create table Sorts
(
   sortid               int not null auto_increment,
   sortname             varchar(20) not null,
   sortdesc             varchar(500),
   primary key (sortid)
);

/*==============================================================*/
/* Table: Users                                                 */
/*==============================================================*/
create table Users
(
   userid               int not null auto_increment,
   username             varchar(50) not null,
   password             varchar(50) not null,
   realname             varchar(30) not null,
   primary key (userid)
);

/*==============================================================*/
/* Table: keywords                                              */
/*==============================================================*/
create table keywords
(
   keywordid            int not null auto_increment,
   keywordname          varchar(50) not null,
   primary key (keywordid)
);

/*==============================================================*/
/* Table: members                                               */
/*==============================================================*/
create table members
(
   memberid             int not null auto_increment,
   membername           varchar(50) not null,
   membertel            varchar(100),
   memberemail          varchar(300) not null,
   primary key (memberid)
);

alter table Books add constraint FK_Reference_1 foreign key (typeID)
      references BookTypes (typeID) on delete restrict on update restrict;

alter table Books add constraint FK_Reference_3 foreign key (authorid)
      references Authors (authorid) on delete restrict on update restrict;

alter table Books add constraint FK_Reference_4 foreign key (locationid)
      references Locations (locationid) on delete restrict on update restrict;

alter table Books add constraint FK_Reference_5 foreign key (pubid)
      references Pubs (pubid) on delete restrict on update restrict;

alter table Books add constraint FK_Reference_6 foreign key (sortid)
      references Sorts (sortid) on delete restrict on update restrict;

alter table Books add constraint FK_Reference_8 foreign key (memberid)
      references members (memberid) on delete restrict on update restrict;

alter table LendLogs add constraint FK_Reference_2 foreign key (Boo_bookid)
      references Books (bookid) on delete restrict on update restrict;

alter table LendLogs add constraint FK_Reference_7 foreign key (MemberID)
      references members (memberid) on delete restrict on update restrict;
