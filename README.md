# php0217-group4
加油，我们是最胖的~~~~

#企业会员管理系统
数据库名为member

控制器命名统一为表名+Controller.class.php

form表单name值与表中字段名保持一致


#所需要用到的建表
会员表:
create table users(
	user_id smallint unsigned primary key auto_increment,
	username varchar(50) not null default '' comment '用户名',
	password varchar(32) not null default '' comment '密码',
	realname varchar(30) not null default '' comment '姓名',
	sex varchar(5) not null default '' comment '性别',
	telephone varchar(20) not null default '' comment '电话号码',
	remark text comment '备注',
	money decimal(9,2) not null default 0 comment '余额',
	is_vip tinyint not null default 0 comment '1为vip,0则不是',
	photo varchar(100) not null default '' comment '头像',
	add_time int not null default 0 comment '会员加入时间',
	vip_level smallint comment 'vip会员等级',
	score int not null default 0 comment '会员积分'
)default charset utf8;

员工表:
create table members(
	member_id smallint unsigned primary key auto_increment,
	username varchar(50) not null default '' comment '用户名',
	password varchar(32) not null default '' comment '密码',
	realname varchar(30) not null default '' comment '姓名',
	sex varchar(5) not null default '' comment '性别',
	telephone varchar(20) not null default '' comment '电话号码',
	group_id smallint not null comment '所属组id',
	last_login int not null default 0 comment '最后登录时间',
	is_admin tinyint not null default 0 comment '1为管理员,0不是',
	photo varchar(100) not null default '' comment '头像'
)default charset utf8;

活动表:
create table article(
	article_id smallint unsigned primary key auto_increment,
	title varchar(50) not null default '' comment '活动标题',
	content text not null comment '活动内容',
	start int not null default 0 comment '开始日期',
	end int not null default 0 comment '结束日期',
	time int not null default 0 comment '发布时间'
)default charset utf8;

group组:
create table `group`(
	group_id smallint unsigned primary key auto_increment,
	name varchar(20) not null default '' comment '组名称'
)default charset utf8;

histories消费记录:
create table histories(
	history_id smallint unsigned primary key auto_increment,
	user_id smallint not null comment '会员id',
	member_id smallint not null comment '服务员工id',
	type tinyint comment '1为充值,0为消费',
	amount decimal(9,2) default 0 comment '金额',
	content varchar(100) not null default '' comment '消费内容',
	time int not null default 0 comment '消费时间',
	remainder decimal(9,2) not null default 0 comment '余额'
)default charset utf8;

order预约:
create table `order`(
	order_id smallint unsigned primary key auto_increment,
	phone varchar(20) not null default '' comment '电话号码',
	realname varchar(30) not null default '' comment '姓名',
	barber varchar(20) not null default '' comment '预约美发师',
	content text comment '备注',
	date int not null comment '预约日期',
	status tinyint not null default 0 comment '预约状态(1:成功/-1:失败/0:未处理)',
	reply varchar(100) not null default '' comment '回复信息'
)default charset utf8;

plans套餐:
create table plans(
	plan_id smallint unsigned primary key auto_increment,
	name varchar(20) not null default '' comment '套餐名称',
	des text comment '套餐描述',
	money decimal(9,2) comment '套餐金额',
	status tinyint not null default 0 comment '状态(0:下线/1:上线)'
)default charset utf8;

codes代金券:
create table codes(
	code_id smallint unsigned primary key auto_increment,
	code varchar(50) not null comment '代码',
	user_id smallint not null comment '所属会员id',
	money decimal(9,2) not null comment '代金券金额',
	status tinyint not null default 0 comment '状态(未使用:0/已使用:1)'
)default charset utf8;