<?php
//000000000060a:10:{i:0;a:4:{s:2:"id";s:2:"72";s:5:"title";s:9:"分析sql";s:7:"content";s:4147:"<p>优化sql之前,先要做一次分析sql.了解当前的sql是否已足够优化并且针对不足采取优化措施.</p><p>1. show status</p><pre class="brush:sql;toolbar:false">通过show&nbsp;status&nbsp;命令了解各种sql&nbsp;的执行频率
&nbsp;&nbsp;&nbsp;&nbsp;show&nbsp;[global|session(默认)]&nbsp;status&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;global:&nbsp;自数据库上次启动至今的统计结果.
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;session:&nbsp;当前连接的统计结果.
&nbsp;&nbsp;&nbsp;&nbsp;show&nbsp;status&nbsp;like&nbsp;&#39;com_%&#39;;&nbsp;--&nbsp;一般所关心的参数
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Com_select:&nbsp;执行select操作的次数,词义查询累加1次.
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Com_insert:&nbsp;执行insert操作次数.一次批量插入只算一次.
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Com_update:&nbsp;执行update操作次数.
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Com_delete:&nbsp;执行Delete&nbsp;操作的次数.
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Com_rollbak:&nbsp;事务回滚次数.
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Com_commit:&nbsp;事务提交次数
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;针对Innodb&nbsp;存储引擎.
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Innodb_rows_read:&nbsp;select查询返回的行数.
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Innodb_rows_inserted:&nbsp;执行Insert操作插入的行数.
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Innodb_rows_updated:&nbsp;执行Update操作更新的次数.
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Innodb_rows_deleted:&nbsp;执行Delete操作删除的次数.
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;Connections:&nbsp;试图连接Mysql服务器的次数.
&nbsp;&nbsp;&nbsp;Uptime:&nbsp;服务器工作时间.
&nbsp;&nbsp;&nbsp;Slow_queries:&nbsp;慢查询次数.&nbsp;&nbsp;show&nbsp;global&nbsp;status&nbsp;like&nbsp;&#39;Slow_queries&#39;;</pre><p>2. explain 分析</p><pre class="brush:sql;toolbar:false">eg:&nbsp;explain&nbsp;select&nbsp;*&nbsp;from&nbsp;tableName&nbsp;where&nbsp;1=1;
返回:&nbsp;id,select_type,table,type,possiable_keys,key,key_len,ref,rows,extra
select_type:&nbsp;表示select类型.常见的有
&nbsp;&nbsp;&nbsp;&nbsp;simple(简单表,即不使用表连接或者子查询),
&nbsp;&nbsp;&nbsp;&nbsp;primary(主查询,即外层的查询),
&nbsp;&nbsp;&nbsp;&nbsp;union(union中的第二个或者后面的查询语句),
&nbsp;&nbsp;&nbsp;&nbsp;subquery(子查询的第一个select)等
table:&nbsp;输出结果集的表
type:&nbsp;all&nbsp;&lt;&nbsp;index&nbsp;&lt;&nbsp;range&nbsp;&lt;&nbsp;ref&nbsp;&lt;&nbsp;eq_ref&nbsp;&lt;&nbsp;const,system&nbsp;&lt;&nbsp;null.&nbsp;性能由差到好.
&nbsp;&nbsp;&nbsp;&nbsp;all:&nbsp;全表扫描
&nbsp;&nbsp;&nbsp;&nbsp;index:&nbsp;索引全扫描,mysql遍历整个索引来查询匹配的行.
&nbsp;&nbsp;&nbsp;&nbsp;range:&nbsp;[索引]范围扫描,常见于&lt;.&gt;,&lt;=,&gt;=,between&nbsp;等.
&nbsp;&nbsp;&nbsp;&nbsp;ref:&nbsp;使用非唯一索引扫描或唯一索引的前缀扫描,返回匹配某个单独值的记录行.
&nbsp;&nbsp;&nbsp;&nbsp;eq_ref:&nbsp;类似ref,区别就在使用的索引是唯一索引.
&nbsp;&nbsp;&nbsp;&nbsp;const/system:&nbsp;单表中最多只有一个匹配行,查询起来非常迅速,所以这个匹配行的其他列的值可以被优化器在当前查询中当做常量处理.(根据主键或者唯一索引进行查询.)
&nbsp;&nbsp;&nbsp;&nbsp;null:&nbsp;mysql&nbsp;不用访问表或者索引,直接就能得到结果.
possible_keys:&nbsp;表示查询时可能使用的索引.
key:&nbsp;表示实际使用的索引.
key_len:&nbsp;使用到索引字段的长度.
rows:&nbsp;扫描行的数量.
Extra:&nbsp;执行情况的说明和描述.

可以使用&nbsp;explain&nbsp;extended&nbsp;+&nbsp;show&nbsp;warnings&nbsp;查看sql真正被执行之前优化器做了哪些sql改写.
可以使用&nbsp;explain&nbsp;partitions&nbsp;显示sql&nbsp;在哪个分区进行查找.</pre><p><br/></p>";s:7:"created";s:10:"1466061924";}i:1;a:4:{s:2:"id";s:2:"69";s:5:"title";s:12:"分区管理";s:7:"content";s:4882:"<p>Mysql 5.1提供了添加,删除,重定义,合并,拆分分区命令.这些命令都可以通过alter table 命令执行.</p><p>Range分区和List分区</p><pre class="brush:sql;toolbar:false">这两个分区命令比较类似
--&nbsp;增加
alter&nbsp;table&nbsp;tableName&nbsp;add&nbsp;partition&nbsp;(&nbsp;partition&nbsp;p0&nbsp;values&nbsp;less&nbsp;than&nbsp;(VALUE)&nbsp;);
alter&nbsp;table&nbsp;tableName&nbsp;add&nbsp;partition&nbsp;(&nbsp;partition&nbsp;p0&nbsp;values&nbsp;in&nbsp;(VALUE_LIST));&nbsp;--LIST
--&nbsp;删除
alter&nbsp;table&nbsp;tableName&nbsp;drop&nbsp;partition&nbsp;p0;
--&nbsp;拆分
alter&nbsp;table&nbsp;tableName&nbsp;reorganize&nbsp;partition&nbsp;&nbsp;p0&nbsp;into&nbsp;(
&nbsp;&nbsp;&nbsp;&nbsp;partition&nbsp;p0&nbsp;values&nbsp;less&nbsp;than&nbsp;(VALUE1),&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;partition&nbsp;p1&nbsp;values&nbsp;less&nbsp;than&nbsp;(VALUE2)
&nbsp;&nbsp;&nbsp;&nbsp;--&nbsp;partition&nbsp;p0&nbsp;values&nbsp;in&nbsp;(VALUE_LIST)&nbsp;--&nbsp;LIST
)
--&nbsp;合并
alter&nbsp;table&nbsp;tableName&nbsp;reorganize&nbsp;partition&nbsp;p0,p1&nbsp;into&nbsp;(
&nbsp;&nbsp;&nbsp;&nbsp;partition&nbsp;p0&nbsp;values&nbsp;less&nbsp;than&nbsp;(MAX_VALUE)
&nbsp;&nbsp;&nbsp;&nbsp;--&nbsp;partition&nbsp;p0&nbsp;values&nbsp;less&nbsp;than&nbsp;(VALUE_LIST)&nbsp;--LIST
)</pre><p>Range分区管理</p><pre class="brush:sql;toolbar:false">create&nbsp;table&nbsp;test1(id&nbsp;int,created&nbsp;Date)
partition&nbsp;by&nbsp;range(YEAR(created))(
&nbsp;&nbsp;&nbsp;&nbsp;partition&nbsp;p0&nbsp;values&nbsp;less&nbsp;than&nbsp;(2015),
&nbsp;&nbsp;&nbsp;&nbsp;partition&nbsp;p1&nbsp;values&nbsp;less&nbsp;than&nbsp;(2016)
)
将test1分区成2015和2016两个分区.

Range添加分区
--&nbsp;新增分区p2,p3
alter&nbsp;table&nbsp;test1&nbsp;add&nbsp;partition&nbsp;(partition&nbsp;p2&nbsp;values&nbsp;less&nbsp;than&nbsp;(2017));
alter&nbsp;table&nbsp;test1&nbsp;add&nbsp;partition&nbsp;(partition&nbsp;p3&nbsp;values&nbsp;less&nbsp;than&nbsp;(2019));
--&nbsp;查看当前test1
show&nbsp;create&nbsp;table&nbsp;test1;
--&nbsp;删除分区p0
alter&nbsp;table&nbsp;test1&nbsp;drop&nbsp;partition&nbsp;p0;
--&nbsp;合并分区p1和p2,注意必须连续的分区才能合并,并且合并的分区必须和之前的分区覆盖相同的区间.
alter&nbsp;table&nbsp;test1&nbsp;reorganize&nbsp;partition&nbsp;p1,p2&nbsp;into&nbsp;(&nbsp;partition&nbsp;p1&nbsp;values&nbsp;less&nbsp;than&nbsp;(2017))
--&nbsp;拆分分区p3,拆分为p2,p3.
alter&nbsp;table&nbsp;test1&nbsp;reorganize&nbsp;partition&nbsp;p3&nbsp;into&nbsp;(
&nbsp;&nbsp;&nbsp;&nbsp;partition&nbsp;p2&nbsp;values&nbsp;less&nbsp;than&nbsp;(2018),&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;partition&nbsp;p3&nbsp;values&nbsp;less&nbsp;than&nbsp;(2019)
)</pre><p>List分区管理<br/></p><pre class="brush:sql;toolbar:false">create&nbsp;table&nbsp;test2(id&nbsp;int,catid&nbsp;int,catname&nbsp;varchar)
partition&nbsp;by&nbsp;list&nbsp;(catid)(
&nbsp;&nbsp;&nbsp;&nbsp;partition&nbsp;p0&nbsp;values&nbsp;in&nbsp;(1,3,5),
&nbsp;&nbsp;&nbsp;&nbsp;partition&nbsp;p1&nbsp;values&nbsp;in&nbsp;(2,4,6),
&nbsp;&nbsp;&nbsp;&nbsp;partition&nbsp;p2&nbsp;values&nbsp;in(7,8,9)
);

--&nbsp;添加分区.新分区添加的值不能和之前的分区值重复,否则报错.
alter&nbsp;table&nbsp;test2&nbsp;add&nbsp;partition&nbsp;(partition&nbsp;p3&nbsp;values&nbsp;in(10,11,12));
alter&nbsp;table&nbsp;test2&nbsp;add&nbsp;partition&nbsp;(partition&nbsp;p4&nbsp;values&nbsp;in(0));
--&nbsp;删除分区p4
alter&nbsp;table&nbsp;test2&nbsp;drop&nbsp;partition&nbsp;p4;
--&nbsp;合并分区p0,p1.只能重定义相邻的分区
--&nbsp;alter&nbsp;table&nbsp;test2&nbsp;reorganize&nbsp;partition&nbsp;p0,p1&nbsp;into&nbsp;(&nbsp;partition&nbsp;p0&nbsp;values&nbsp;in&nbsp;(1,2,3,4,5,6)&nbsp;);
alter&nbsp;table&nbsp;test2&nbsp;reorganize&nbsp;partition&nbsp;p0,p1&nbsp;into&nbsp;(
&nbsp;&nbsp;&nbsp;&nbsp;partition&nbsp;p0&nbsp;values&nbsp;in&nbsp;(1,2,3),
&nbsp;&nbsp;&nbsp;&nbsp;partition&nbsp;p1&nbsp;values&nbsp;in&nbsp;(4,5,6)
);
--&nbsp;拆分分区p3
alter&nbsp;table&nbsp;test2&nbsp;reorganize&nbsp;partition&nbsp;p3&nbsp;into&nbsp;(
&nbsp;&nbsp;&nbsp;&nbsp;partition&nbsp;p4&nbsp;values&nbsp;in(10),
&nbsp;&nbsp;&nbsp;&nbsp;partition&nbsp;p5&nbsp;values&nbsp;in(11,12)
);</pre><p><br/></p><p>Hash &amp; Key 分区管理</p><pre class="brush:sql;toolbar:false">create&nbsp;table&nbsp;test3(id&nbsp;int,catid&nbsp;int)
partition&nbsp;by&nbsp;Hash&nbsp;(catid)&nbsp;partitions&nbsp;4;
--&nbsp;减少分区.将原先的4个分区,减少成4个分区.但是这个语句不能用来增加分区.
alter&nbsp;table&nbsp;coalesce&nbsp;partition&nbsp;2;
--&nbsp;alter&nbsp;table&nbsp;coalesce&nbsp;partition&nbsp;6;&nbsp;--&nbsp;error
--&nbsp;增加分区
alter&nbsp;table&nbsp;test3&nbsp;add&nbsp;partition&nbsp;partitions&nbsp;8;</pre><p><br/></p>";s:7:"created";s:10:"1465962227";}i:2;a:4:{s:2:"id";s:2:"68";s:5:"title";s:9:"子分区";s:7:"content";s:894:"<p>子分区</p><pre class="brush:sql;toolbar:false">子分区是对分区的再分区.
5.1版本以后,支持对Range&nbsp;和List&nbsp;分区后的再分区(子分区).子分区可以使用Hash&nbsp;分区和Key&nbsp;分区.
create&nbsp;table&nbsp;test(id&nbsp;int,&nbsp;created&nbsp;Data)&nbsp;
partition&nbsp;by&nbsp;range(YEAR(created))&nbsp;
subpartition&nbsp;by&nbsp;hash(TO_DAYS(created))&nbsp;partitions&nbsp;2
(
&nbsp;&nbsp;&nbsp;&nbsp;partition&nbsp;p0&nbsp;values&nbsp;less&nbsp;than&nbsp;(2015),
&nbsp;&nbsp;&nbsp;&nbsp;partition&nbsp;p1&nbsp;values&nbsp;less&nbsp;than&nbsp;(2016),
&nbsp;&nbsp;&nbsp;&nbsp;partition&nbsp;p2&nbsp;values&nbsp;less&nbsp;than&nbsp;(2017),
&nbsp;&nbsp;&nbsp;&nbsp;partition&nbsp;p3&nbsp;values&nbsp;less&nbsp;than&nbsp;(maxvalue)
);

在这里进行了8=4*2个分区.
复合分区用于保存非常大量的数据记录.</pre><p><br/></p>";s:7:"created";s:10:"1465899412";}i:3;a:4:{s:2:"id";s:2:"67";s:5:"title";s:9:"Key分区";s:7:"content";s:747:"<p>Key分区</p><pre class="brush:sql;toolbar:false">(1)&nbsp;常规Key分区
使用Key分区和Hash分区相差不大,只是Key分区使用的表达式只能是mysql提供的Hash函数.
Key分区可以使用除了blob和text类型外的所有类型.
partition&nbsp;by&nbsp;key(expr)&nbsp;partitions&nbsp;num;

(2)&nbsp;线性Key分区
partition&nbsp;by&nbsp;linear&nbsp;key(expr)&nbsp;partitions&nbsp;num;

如果不指定分区键,那么默认使用主键,如果主键不存在,那么使用唯一键,如果主键和唯一键都不存在那么返回错误.
partition&nbsp;by&nbsp;key()&nbsp;partitons&nbsp;num;

注意:&nbsp;key分区不能使用&nbsp;alter&nbsp;table&nbsp;drop&nbsp;primary&nbsp;key;来删除主键.</pre><p><br/></p>";s:7:"created";s:10:"1465892673";}i:4;a:4:{s:2:"id";s:2:"66";s:5:"title";s:10:"Hash分区";s:7:"content";s:1484:"<p>Hash分区</p><pre class="brush:sql;toolbar:false">主要作用:&nbsp;分散热点读,确保数据在预先确定个数的分区中尽可能平均分布.
(1)&nbsp;常规Hash分区
partition&nbsp;by&nbsp;hash(expr)&nbsp;partitions&nbsp;N&nbsp;;
create&nbsp;table&nbsp;emp(
&nbsp;&nbsp;&nbsp;&nbsp;id&nbsp;int&nbsp;not&nbsp;null,
&nbsp;&nbsp;&nbsp;&nbsp;ename&nbsp;varchar,
&nbsp;&nbsp;&nbsp;&nbsp;eid&nbsp;int
)partition&nbsp;by&nbsp;hash(eid)&nbsp;partitions&nbsp;4;

将表格分成了4区,p0,p1,p2,p3.&nbsp;mod(eid,4)的值就是所存储的分区.
expr表达式可以为任意的,不过在mysql进行分区处理的时候,表达式越复杂处理性能越差.

但是Hash分区会碰见另外一个问题,那就是在增加分区或者合并分区的时候.所以不适合灵活变动分区的需求.

(2)&nbsp;线性Hash分区
线性分区:&nbsp;线性分区和常规的Hash分区几乎一样,只有在定义的时候多添加&nbsp;linear.
partition&nbsp;by&nbsp;linear&nbsp;hash(expr)&nbsp;num;

优点:&nbsp;分区维护(增加,删除,合并,拆分分区)时,Mysql能够处理更加迅速.
缺点:&nbsp;各个分区之间数据分布不太平衡.

线性分区:&nbsp;分区函数是一个线性的2的幂的运算法则.
num=4;
首先,找到&gt;=num的2的幂,设置为V;
V=Power(2,Ceiling(Log(2,num)))&nbsp;=4;
其次,设置&nbsp;N=F(column_list)&nbsp;&amp;&nbsp;(V-1);N即表示所在的分区.
最后,当N&gt;=num,N=N&amp;(V-1);</pre><p><br/></p>";s:7:"created";s:10:"1465891794";}i:5;a:4:{s:2:"id";s:2:"65";s:5:"title";s:13:"Columns分区";s:7:"content";s:949:"<p>Column分区</p><pre class="brush:sql;toolbar:false">在5.5版本中新增
解决了Range分区和List分区只能使用int类型的问题,可以支持整数,日期和字符串类型.
不同于Range和List的是,Columns不能使用表达式,但是亮点是能够支持多列分区.
create&nbsp;table&nbsp;test(
&nbsp;&nbsp;&nbsp;&nbsp;a&nbsp;int,
&nbsp;&nbsp;&nbsp;&nbsp;b&nbsp;int
)engine=myisam&nbsp;default&nbsp;charset=utf8
partition&nbsp;by&nbsp;range&nbsp;columns(a,b)(
&nbsp;&nbsp;&nbsp;&nbsp;partition&nbsp;p0&nbsp;values&nbsp;less&nbsp;than&nbsp;(0,10),
&nbsp;&nbsp;&nbsp;&nbsp;partition&nbsp;p1&nbsp;values&nbsp;less&nbsp;than&nbsp;(10,10),
&nbsp;&nbsp;&nbsp;&nbsp;partition&nbsp;p2&nbsp;values&nbsp;less&nbsp;than&nbsp;(10,35),
&nbsp;&nbsp;&nbsp;&nbsp;partition&nbsp;p3&nbsp;values&nbsp;less&nbsp;than&nbsp;(maxvalue,maxvalue)
);
(1,10)&nbsp;&lt;&nbsp;(10,10)
(a&lt;10)&nbsp;or&nbsp;((a=10)and(b&lt;10))</pre><p><br/></p>";s:7:"created";s:10:"1465871156";}i:6;a:4:{s:2:"id";s:2:"64";s:5:"title";s:10:"List分区";s:7:"content";s:1442:"<p>List分区<br/></p><pre class="brush:sql;toolbar:false">List分区类似Range分区,但是不同的是无需像Range那样声明特定的顺序.
partition&nbsp;by&nbsp;List&nbsp;(expr)&nbsp;(
&nbsp;&nbsp;&nbsp;&nbsp;partition&nbsp;p0&nbsp;values&nbsp;in(value_list)
)
expr&nbsp;只能支持int型.

create&nbsp;table&nbsp;expands(
&nbsp;&nbsp;&nbsp;&nbsp;expanse_date&nbsp;Date&nbsp;not&nbsp;null,
&nbsp;&nbsp;&nbsp;&nbsp;category&nbsp;int,
&nbsp;&nbsp;&nbsp;&nbsp;amount&nbsp;decimal(10,3)
)engine=innodb&nbsp;default&nbsp;charset=utf8&nbsp;
&nbsp;partition&nbsp;by&nbsp;list(category)(
&nbsp;&nbsp;&nbsp;&nbsp;partition&nbsp;p0&nbsp;values&nbsp;in(1,3,5),
&nbsp;&nbsp;&nbsp;&nbsp;partition&nbsp;p1&nbsp;values&nbsp;in(2,4,6)
);

5.5中支持非int型
partition&nbsp;by&nbsp;list&nbsp;columns(&nbsp;expr&nbsp;)(
&nbsp;&nbsp;&nbsp;&nbsp;partition&nbsp;p0&nbsp;values&nbsp;in(&nbsp;columns_list&nbsp;)
)

create&nbsp;table&nbsp;expands(
&nbsp;&nbsp;&nbsp;&nbsp;expanse_date&nbsp;Date&nbsp;not&nbsp;null,
&nbsp;&nbsp;&nbsp;&nbsp;category&nbsp;varchar,
&nbsp;&nbsp;&nbsp;&nbsp;amount&nbsp;decimal(10,3)
)engine=innodb&nbsp;default&nbsp;charset=utf8&nbsp;
&nbsp;partition&nbsp;by&nbsp;list(category)(
&nbsp;&nbsp;&nbsp;&nbsp;partition&nbsp;p0&nbsp;values&nbsp;in(&#39;food&#39;,&#39;drink&#39;),
&nbsp;&nbsp;&nbsp;&nbsp;partition&nbsp;p1&nbsp;values&nbsp;in(&#39;fruit&#39;,&#39;anything&#39;)
);</pre><p><br/></p>";s:7:"created";s:10:"1465869516";}i:7;a:4:{s:2:"id";s:2:"62";s:5:"title";s:11:"Range分区";s:7:"content";s:2966:"<p>Range分区<br/></p><pre class="brush:sql;toolbar:false">create&nbsp;&nbsp;table&nbsp;`blog`&nbsp;(
&nbsp;&nbsp;`id`&nbsp;int(11)&nbsp;unsigned&nbsp;not&nbsp;null&nbsp;,&nbsp;--&nbsp;auto_increment,
&nbsp;&nbsp;`cat_id`&nbsp;int(11)&nbsp;unsigned&nbsp;not&nbsp;null&nbsp;default&nbsp;0,
&nbsp;&nbsp;`title`&nbsp;varchar(50)&nbsp;not&nbsp;null&nbsp;default&nbsp;&#39;&#39;,
&nbsp;&nbsp;`click`&nbsp;smallint(6)&nbsp;unsigned&nbsp;not&nbsp;null&nbsp;&nbsp;default&nbsp;0,
&nbsp;&nbsp;`created`&nbsp;Date&nbsp;not&nbsp;null&nbsp;default&nbsp;&#39;1970-01-01&#39;,
&nbsp;&nbsp;`sort`&nbsp;smallint(6)&nbsp;not&nbsp;null&nbsp;default&nbsp;0,
&nbsp;&nbsp;`status`&nbsp;tinyint(1)&nbsp;not&nbsp;null&nbsp;default&nbsp;0,
&nbsp;&nbsp;`content`&nbsp;text&nbsp;,
&nbsp;&nbsp;`update_time`&nbsp;int(11)&nbsp;not&nbsp;null&nbsp;default&nbsp;0,
&nbsp;&nbsp;--&nbsp;不能存在主键,除非以主键分区primary&nbsp;key(`id`),
&nbsp;&nbsp;key(`title`)&nbsp;,
&nbsp;&nbsp;key(`cat_id`)
)engine=myisam&nbsp;default&nbsp;charset=utf8&nbsp;--&nbsp;auto_increment=1&nbsp;
	partition&nbsp;by&nbsp;range(cat_id)&nbsp;(
&nbsp;&nbsp;&nbsp;&nbsp;partition&nbsp;p0&nbsp;values&nbsp;less&nbsp;than&nbsp;(10),
&nbsp;&nbsp;&nbsp;&nbsp;partition&nbsp;p1&nbsp;values&nbsp;less&nbsp;than&nbsp;(20),
&nbsp;&nbsp;&nbsp;&nbsp;partition&nbsp;p2&nbsp;values&nbsp;less&nbsp;than&nbsp;(30)
);

那么将分区p0,p1,p2.p0分区存储的是1-9,p1存储的是10-19,p2存储的是19-29;如果存储的cat_id&gt;30,那么报错.
需要增加:partitions&nbsp;p3&nbsp;values&nbsp;less&nbsp;than&nbsp;maxvalue;&nbsp;那么比30大的都会在p3;

也可使用日期进行分区:
partition&nbsp;by&nbsp;range&nbsp;(year(created))&nbsp;(
&nbsp;&nbsp;&nbsp;&nbsp;partition&nbsp;p0&nbsp;values&nbsp;less&nbsp;than&nbsp;(1995),
&nbsp;&nbsp;&nbsp;&nbsp;partition&nbsp;p1&nbsp;values&nbsp;less&nbsp;than&nbsp;(2000),
&nbsp;&nbsp;&nbsp;&nbsp;partition&nbsp;p2&nbsp;values&nbsp;less&nbsp;than&nbsp;maxvalue
)

在5.5版本以上,可以不在使用内置函数进行转换
partition&nbsp;by&nbsp;range&nbsp;columns&nbsp;(created)&nbsp;(
&nbsp;&nbsp;&nbsp;&nbsp;partition&nbsp;p0&nbsp;values&nbsp;less&nbsp;than&nbsp;(&#39;1995-01-01&#39;),
&nbsp;&nbsp;&nbsp;&nbsp;partition&nbsp;p1&nbsp;values&nbsp;less&nbsp;than&nbsp;(&#39;2000-01-01&#39;),
&nbsp;&nbsp;&nbsp;&nbsp;partition&nbsp;p2&nbsp;values&nbsp;less&nbsp;than&nbsp;maxvalue
)

对range分区的定义可以如上所示.</pre><p>优势<br/></p><pre class="brush:sql;toolbar:false">1.&nbsp;删除过期数据:&nbsp;alter&nbsp;table&nbsp;emp&nbsp;drop&nbsp;partition&nbsp;p0;&nbsp;删除p0中的数据.
2.&nbsp;经常运行包含分区键的查询.mysql可以确定某些分区包含有where查询的条件,因此可以不必扫描全部数据,只需要扫描对应的分区即可.
&nbsp;&nbsp;&nbsp;&nbsp;例如:&nbsp;explain&nbsp;partitions&nbsp;select&nbsp;*&nbsp;from&nbsp;blog&nbsp;where&nbsp;cat_id&nbsp;&gt;25;</pre>";s:7:"created";s:10:"1465806442";}i:8;a:4:{s:2:"id";s:2:"61";s:5:"title";s:11:"mysql分区";s:7:"content";s:3545:"<p>对于数据量较大的数据表,可以进行分区处理.</p><p>优点</p><pre class="brush:sql;toolbar:false">1.&nbsp;和单个磁盘或者文件系统分区相比,可以存储更多数据
2.&nbsp;优化查询.在where子句中包含分区条件时,可以只扫描必要的一个或者多个分区来提高查询效率;
&nbsp;&nbsp;&nbsp;&nbsp;同时在涉及sum()和count()这类聚合函数的查询时,可以容易地在每个分区上并行处理,最终只需要汇总所有分区得到的结果.
3.&nbsp;对于已经过期或者不需要保存的数据,可以通过删除与这些数据有关的分区来快速删除数据.
4.&nbsp;跨多个磁盘来分散数据查询,以获取更大的查询吞吐量.</pre><p>分区前瞻</p><pre class="brush:sql;toolbar:false">数据表的分区可以根据程序进行分区,也可以根据数据定义的时候进行分区.
--&nbsp;查看mysql&nbsp;是否支持分区
show&nbsp;variables&nbsp;like&nbsp;&#39;%partition%&#39;;
--&nbsp;查看当前mysql安装的插件
show&nbsp;plugins;

create&nbsp;table&nbsp;emp(
&nbsp;&nbsp;&nbsp;&nbsp;empid&nbsp;int,
&nbsp;&nbsp;&nbsp;&nbsp;salay&nbsp;decimal(7,2),
&nbsp;&nbsp;&nbsp;&nbsp;birth_date&nbsp;date,
&nbsp;&nbsp;&nbsp;&nbsp;key(salay)
)engine=innodb&nbsp;partition&nbsp;by&nbsp;hash(&nbsp;month(birth_date)&nbsp;)&nbsp;partitions&nbsp;6;
insert&nbsp;into&nbsp;emp&nbsp;values(1,100,&#39;2016-06-13&#39;),(2,200,&#39;2016-01-03&#39;);

将birth_date的月份%6取余,则就是所对应的分区.
select&nbsp;*&nbsp;from&nbsp;emp;&nbsp;--&nbsp;将看到没有什么不同之处.
explain&nbsp;select&nbsp;*&nbsp;from&nbsp;emp;&nbsp;可以看见查询语句总共查询的行数是6.即分区的个数
select&nbsp;partition_name&nbsp;part,partition_expression&nbsp;expr,partition_description&nbsp;descr,table_rows&nbsp;from&nbsp;information_schema.PARTITIONS&nbsp;where&nbsp;TABLE_SCHEMA=schema()&nbsp;and&nbsp;table_name=&#39;emp&#39;;
--&nbsp;可以看见在p0区和p1区各有一条数据.&nbsp;
explain&nbsp;partitions&nbsp;select&nbsp;count(*)&nbsp;from&nbsp;emp&nbsp;where&nbsp;birth_date=&#39;2016-06-13&#39;;&nbsp;--&nbsp;可以看见数据库只需要在分区p0查找即可.

注意:&nbsp;不能使用主键/唯一键之外的字段进行分区.要么没有主键唯一键.但是创建索引是不影响的.</pre><p>分区类型</p><pre class="brush:sql;toolbar:false">range分区:&nbsp;基于一个给定连续区间范围,把数据分配到不同的分区.
list分区:&nbsp;类似range分区,区别在于list分区是基于枚举出的值列表分区,range基于给定的范围.
hash分区:&nbsp;基于给定分区的个数,把数据分配到不同的分区.
key分区:&nbsp;类似hash分区.key分区唯一的可以通过除int类型外可以使用其他类型(blob,text)的分区.
Column分区:&nbsp;除了int型,还支持非int型,并且可以使用多字段分区.使Range分区和List分区支持非int型分区.
注:&nbsp;5.5以上的版本支持非整数的range和list分区.</pre><p>Mysql分区处理Null值</p><pre class="brush:sql;toolbar:false">Range分区将Null值作为最小值处理,
List分区中,如果定义Null值,则保存成功,否则会报错.
Hash分区和Key分区将Null作为0处理.</pre><p>对于每种分区的管理,将在具体的分区中介绍.</p><p></p><p>分区使用场所</p><pre class="brush:sql;toolbar:false">统计票数:&nbsp;有多少票数来自于android,多少来自于iphone.那么这种情况数据表可以根据手机类型来分区.</pre><p><br/></p>";s:7:"created";s:10:"1465802936";}i:9;a:4:{s:2:"id";s:2:"24";s:5:"title";s:7:"install";s:7:"content";s:4788:"<p><br/></p><p style="white-space: normal;">plugins<br/></p><p style="white-space: normal;">./bin/plugin install https://github.com/NLPchina/elasticsearch-sql/releases/download/2.2.0.1/elasticsearch-sql-2.2.0.1.zip&nbsp;</p><p style="white-space: normal;">sudo elasticsearch/bin/plugin install mobz/elasticsearch-head</p><p><span class="pln" style="box-sizing: border-box; margin: 0px; padding: 0px; border: 0px; font-stretch: inherit; font-size: 14.4px; line-height: 21.6px; font-family: Consolas, Menlo, &#39;DejaVu Sans Mono&#39;, &#39;Bitstream Vera Sans Mono&#39;, &#39;Lucida Console&#39;; vertical-align: baseline; white-space: pre;">cd </span><span class="pun" style="box-sizing: border-box; margin: 0px; padding: 0px; border: 0px; font-stretch: inherit; font-size: 14.4px; line-height: 21.6px; font-family: Consolas, Menlo, &#39;DejaVu Sans Mono&#39;, &#39;Bitstream Vera Sans Mono&#39;, &#39;Lucida Console&#39;; vertical-align: baseline; color: rgb(102, 102, 0); white-space: pre;">/</span><span class="pln" style="box-sizing: border-box; margin: 0px; padding: 0px; border: 0px; font-stretch: inherit; font-size: 14.4px; line-height: 21.6px; font-family: Consolas, Menlo, &#39;DejaVu Sans Mono&#39;, &#39;Bitstream Vera Sans Mono&#39;, &#39;Lucida Console&#39;; vertical-align: baseline; white-space: pre;">usr</span><span class="pun" style="box-sizing: border-box; margin: 0px; padding: 0px; border: 0px; font-stretch: inherit; font-size: 14.4px; line-height: 21.6px; font-family: Consolas, Menlo, &#39;DejaVu Sans Mono&#39;, &#39;Bitstream Vera Sans Mono&#39;, &#39;Lucida Console&#39;; vertical-align: baseline; color: rgb(102, 102, 0); white-space: pre;">/</span><span class="pln" style="box-sizing: border-box; margin: 0px; padding: 0px; border: 0px; font-stretch: inherit; font-size: 14.4px; line-height: 21.6px; font-family: Consolas, Menlo, &#39;DejaVu Sans Mono&#39;, &#39;Bitstream Vera Sans Mono&#39;, &#39;Lucida Console&#39;; vertical-align: baseline; white-space: pre;">share</span><span class="pun" style="box-sizing: border-box; margin: 0px; padding: 0px; border: 0px; font-stretch: inherit; font-size: 14.4px; line-height: 21.6px; font-family: Consolas, Menlo, &#39;DejaVu Sans Mono&#39;, &#39;Bitstream Vera Sans Mono&#39;, &#39;Lucida Console&#39;; vertical-align: baseline; color: rgb(102, 102, 0); white-space: pre;">/</span><span class="pln" style="box-sizing: border-box; margin: 0px; padding: 0px; border: 0px; font-stretch: inherit; font-size: 14.4px; line-height: 21.6px; font-family: Consolas, Menlo, &#39;DejaVu Sans Mono&#39;, &#39;Bitstream Vera Sans Mono&#39;, &#39;Lucida Console&#39;; vertical-align: baseline; white-space: pre;">elasticsearch
sudo bin</span><span class="pun" style="box-sizing: border-box; margin: 0px; padding: 0px; border: 0px; font-stretch: inherit; font-size: 14.4px; line-height: 21.6px; font-family: Consolas, Menlo, &#39;DejaVu Sans Mono&#39;, &#39;Bitstream Vera Sans Mono&#39;, &#39;Lucida Console&#39;; vertical-align: baseline; color: rgb(102, 102, 0); white-space: pre;">/</span><span class="pln" style="box-sizing: border-box; margin: 0px; padding: 0px; border: 0px; font-stretch: inherit; font-size: 14.4px; line-height: 21.6px; font-family: Consolas, Menlo, &#39;DejaVu Sans Mono&#39;, &#39;Bitstream Vera Sans Mono&#39;, &#39;Lucida Console&#39;; vertical-align: baseline; white-space: pre;">plugin install license
sudo bin</span><span class="pun" style="box-sizing: border-box; margin: 0px; padding: 0px; border: 0px; font-stretch: inherit; font-size: 14.4px; line-height: 21.6px; font-family: Consolas, Menlo, &#39;DejaVu Sans Mono&#39;, &#39;Bitstream Vera Sans Mono&#39;, &#39;Lucida Console&#39;; vertical-align: baseline; color: rgb(102, 102, 0); white-space: pre;">/</span><span class="pln" style="box-sizing: border-box; margin: 0px; padding: 0px; border: 0px; font-stretch: inherit; font-size: 14.4px; line-height: 21.6px; font-family: Consolas, Menlo, &#39;DejaVu Sans Mono&#39;, &#39;Bitstream Vera Sans Mono&#39;, &#39;Lucida Console&#39;; vertical-align: baseline; white-space: pre;">plugin install marvel</span><span class="pun" style="box-sizing: border-box; margin: 0px; padding: 0px; border: 0px; font-stretch: inherit; font-size: 14.4px; line-height: 21.6px; font-family: Consolas, Menlo, &#39;DejaVu Sans Mono&#39;, &#39;Bitstream Vera Sans Mono&#39;, &#39;Lucida Console&#39;; vertical-align: baseline; color: rgb(102, 102, 0); white-space: pre;">-</span><span class="pln" style="box-sizing: border-box; margin: 0px; padding: 0px; border: 0px; font-stretch: inherit; font-size: 14.4px; line-height: 21.6px; font-family: Consolas, Menlo, &#39;DejaVu Sans Mono&#39;, &#39;Bitstream Vera Sans Mono&#39;, &#39;Lucida Console&#39;; vertical-align: baseline; white-space: pre;">agent</span></p>";s:7:"created";s:10:"1463649922";}}
?>