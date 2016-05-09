create  table `think_blog` (
  `id` int(11) unsigned not null  auto_increment,
  `cat_id` int(11) unsigned not null default 0,
  `title` varchar(50) not null default '',
  `click` smallint(6) unsigned not null  default 0,
  `created` int(11) not null default 0,
  `sort` smallint(6) not null default 0,
  `status` tinyint(1) not null default 0,
  `content` text ,
<<<<<<< HEAD
=======
  `update_time` int(11) not null default 0,
>>>>>>> gh-pages
  primary key(`id`),
  key(`title`) ,
  key(`cat_id`)
)engine=myisam default charset=utf8 auto_increment=1;

create table `think_cate_blog`(
   `cat_id` int(11) unsigned not null default 0,
  `blog_id` int(11) unsigned not null default 0,
  key `cat_id`(`cat_id`),
  key `blog_id`(`blog_id`)  
)engine=myisam default charset=utf8;

create table `think_category`(
  `id` int(11) unsigned not null auto_increment,
  `title` varchar(50) not null default '',
  `sort` smallint(6) not null default 0,
  `pid`  int(11) not null default 0,
  `level` smallint(2) not null default 0,
  `multi` tinyint(1) not null default 0,
  `status` tinyint(1) not null default 0,
  primary key(`id`),
  key(`title`)
)engine=myisam default charset=utf8 auto_increment=1;

-- alter table `think_category` add multi   tinyint(1) not null default 0;
-- alter table `think_category` add status   tinyint(1) not null default 0;

create table `think_attr`(
  `id` int(11) unsigned not null auto_increment,
  `title` varchar(30) not null default '',
  `color` varchar(10) not null default '',
<<<<<<< HEAD
=======
  `sort` tinyint(1) not null default 0,
>>>>>>> gh-pages
  primary key(`id`)
)engine=myisam default charset=utf8 auto_increment=1;

create table `think_blog_attr`(
  `blog_id` int(11) not null default 0,
  `attr_id` int(11) not null default 0,
    KEY `group_id` (`blog_id`),
    KEY `attr_id` (`attr_id`)
)engine=myisam default charset=utf8;
-- alter table `think_blog_attr` delete index user_id;

create table `think_user`(
  `id` int(11) not null  auto_increment,
  `username` varchar(20) not null default '',
  `password` varchar(100) not null default '',
  `login_ip` varchar(20) not null default '',
  `login_time` int(11) not null default 0,
  `lock` tinyint(1) not null default 0,
  primary key(`id`),
  key(`username`)
)engine=myisam default charset=utf8 auto_increment=1;

create table `think_navigation`(
  `id` int(11) not null  auto_increment,
  `en_name` varchar(20) not null default '',
  `zn_name` varchar(20) not null default '',
  `leavel` tinyint(1) not null default 0,
  `pid` int(11) unsigned not null default 0,
  `url` varchar(100) not null default '',
  `color` varchar(20) not null default '',
<<<<<<< HEAD
=======
  `sort` int(6) not null default 0,
>>>>>>> gh-pages
  primary key(`id`)
)engine=myisam default charset=utf8 auto_increment=1;

create table `think_blog_comment`(
  `id` int(11)  unsigned auto_increment primary key ,
  `blog_id` int(11) unsigned not null default 0,
  `username` varchar(20) not null default '',
  `content`  varchar(500) not null default '',
  `pid` int(11) unsigned not null default 0,
  `status` tinyint(1) not null default 0,
  `created` int(11) not null default 0,
<<<<<<< HEAD
=======
  `top_num` int(6) not null default 0,
  `base_num` int(6) not null default 0,
>>>>>>> gh-pages
  `extra` varchar(200) not null default '',
  key(`blog_id`)
)engine=myisam default charset=utf8 auto_increment=1;

create table `think_commenter`(
  `id` int(11) unsigned auto_increment primary key,
  `username` varchar(20) not null default '',
  `password` varchar(100) not null default '',
  `login_time` int(11) not null default 0,
  `login_ip` varchar(20) not null default '',
  `lock` tinyint(1) not null default 0,
  key(`username`) 
  )engine=myisam default charset=utf8 auto_increment=1;

create table `think_comment_count`(
  `comment_id` int(11) unsigned not null default 0,
  `comment` tinyint(1) not null default 0 comment'0 null ,1 perfect , 2 good ,3 just so so',
  `count` int(11) not null default 0,
  key(`comment_id`)
)engine=myisam default charset=utf8 ;
