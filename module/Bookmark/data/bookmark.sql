create table if not exists bookmark
(
  id int(11) not null auto_increment,
  link varchar(255) not null,
  title varchar(255) not null,
  description text not null,
  primary key (id)
) engine=innodb default charset=utf8;

insert into bookmark values (1, 'http://www.google.com/ncr', 'Google', 'Google Search');
insert into bookmark values (2, 'http://www.facebook.com/', 'Facebook', 'Facebook');
insert into bookmark values (3, 'http://www.twitter.com/', 'Twitter', 'Twitter');

