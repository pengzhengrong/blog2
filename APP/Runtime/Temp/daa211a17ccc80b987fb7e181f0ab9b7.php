<?php
//000000000000a:13:{i:0;a:4:{s:2:"id";s:2:"71";s:5:"title";s:12:"异常处理";s:7:"content";s:572:"<p>问题描述</p><pre class="brush:php;toolbar:false">在自定义的Smarty框架中,每次出现异常的时候并不会报错,而是直接性的500.因此为了解决此问题,需要Think.
自定义Exception:
function&nbsp;myException($exception)&nbsp;{
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;echo&nbsp;&quot;&lt;b&gt;Exception:&lt;/b&gt;&nbsp;&quot;&nbsp;,&nbsp;$exception-&gt;getMessage();
	P($exception);
}
set_exception_handler(&#39;myException&#39;);

一切没有被捕获的异常,将会由自定义异常函数捕获.</pre><p><br/></p>";s:7:"created";s:10:"1465979064";}i:1;a:4:{s:2:"id";s:2:"60";s:5:"title";s:18:"博客分页缓存";s:7:"content";s:1317:"<p>分页缓存,会根据业务的不同而设计有所不同.博客的话,不会出现写的频率太快,特别像我这种个人博客.因此,要解决分泌液缓存的话可以从很多地方入手.</p><p>分页缓存的话,必须解决的问题有删除,插入和修改.发生这种操作的时候对应的缓存应该如何处理.还需要参考缓存的实时性,如果对实时性要求较高,那么</p><p>又需要如何处理?</p><p><br/></p><p>1. 对于相对文章较少的博客,可以采取当页缓存,对博客的增删改,可以操作缓存的更新.</p><p>&nbsp; &nbsp; 查看博客--缓存--db<br/></p><p>&nbsp;&nbsp;&nbsp;&nbsp;修改博客--db更新--刷新当页缓存--查看博客<br/></p><p>&nbsp;&nbsp;&nbsp;&nbsp;删除博客--db更新--刷新当页缓存--废弃当前页后面的页码缓存--查看博客<br/></p><p>&nbsp;&nbsp;&nbsp;&nbsp;增加博客--db更新--刷新尾页缓存--查看博客<br/></p><p>&nbsp;&nbsp;&nbsp;&nbsp;如果采用这种模式,那么将会在删除的时候出现大量缓存失效的问题.而且局限于按时间顺序排序.<br/></p><p><br/></p><p>缓存分为主动缓存和被动缓存,主动缓存由程序逻辑去更新缓存.被动缓存则是用户触发的缓存.</p><p>&nbsp;http://kb.cnblogs.com/page/511212/ &nbsp;</p><p><br/></p><p><br/></p>";s:7:"created";s:10:"1465795520";}i:2;a:4:{s:2:"id";s:2:"40";s:5:"title";s:8:"TP过程";s:7:"content";s:10642:"<p>1, 打开SHOW_PAGE_TRACE=true,然后可以看就流程是这样的</p><pre class="brush:php;toolbar:false">[&nbsp;app_init&nbsp;]&nbsp;--START--
Run&nbsp;Behavior\BuildLiteBehavior&nbsp;[&nbsp;RunTime:0.000029s&nbsp;]
[&nbsp;app_init&nbsp;]&nbsp;--END--&nbsp;[&nbsp;RunTime:0.000192s&nbsp;]
[&nbsp;app_begin&nbsp;]&nbsp;--START--
Run&nbsp;Behavior\ReadHtmlCacheBehavior&nbsp;[&nbsp;RunTime:0.000099s&nbsp;]
[&nbsp;app_begin&nbsp;]&nbsp;--END--&nbsp;[&nbsp;RunTime:0.000189s&nbsp;]
[&nbsp;view_parse&nbsp;]&nbsp;--START--
[&nbsp;template_filter&nbsp;]&nbsp;--START--
Run&nbsp;Behavior\ContentReplaceBehavior&nbsp;[&nbsp;RunTime:0.000030s&nbsp;]
[&nbsp;template_filter&nbsp;]&nbsp;--END--&nbsp;[&nbsp;RunTime:0.000063s&nbsp;]
Run&nbsp;Behavior\ParseTemplateBehavior&nbsp;[&nbsp;RunTime:0.004351s&nbsp;]
[&nbsp;view_parse&nbsp;]&nbsp;--END--&nbsp;[&nbsp;RunTime:0.004390s&nbsp;]
[&nbsp;view_filter&nbsp;]&nbsp;--START--
Run&nbsp;Behavior\WriteHtmlCacheBehavior&nbsp;[&nbsp;RunTime:0.000055s&nbsp;]
[&nbsp;view_filter&nbsp;]&nbsp;--END--&nbsp;[&nbsp;RunTime:0.000077s&nbsp;]
[&nbsp;app_end&nbsp;]&nbsp;--START--</pre><p>2. 代码流程概览</p><pre class="brush:php;toolbar:false">index.php&nbsp;//&nbsp;唯一路口
&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;引入ThinkPHP入口文件
&nbsp;&nbsp;&nbsp;&nbsp;require&nbsp;&#39;./ThinkPHP/ThinkPHP.php&#39;;
ThinkPHP.php
&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;加载核心Think类
&nbsp;&nbsp;&nbsp;&nbsp;require&nbsp;CORE_PATH.&#39;Think&#39;.EXT;
&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;应用初始化&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;Think\Think::start();
Think.class.php
&nbsp;&nbsp;&nbsp;&nbsp;start方法
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;注册AUTOLOAD方法
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;设定错误和异常处理
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;初始化文件存储方式
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;File存储模式
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;如果不是调试模式,那么加载~runtime.php,否则加载Think/Mode/common.php,并且删除~runtime.php&nbsp;(目前,调试模式)
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;读取应用模式
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;common.php
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;配置文件(convention.php和Common/config.php)
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;别名定义(别名一些主要的类库,Think目录下的Log.class.php,Db.class.php,Model.class.php,Template.class.php等)
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;函数和类文件(Think目录下的函数文件和公共函数文件,以及控制器类,视图类,Hook类,分发器类,路由类,行为类等)
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;行为扩展定义(就是流程输出的过程,类似app_init,app_begin等)
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;加载核心文件
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;加载common.php中定义的core指定的文件
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;如果不是调试模式,那么$content&nbsp;.=&nbsp;compile($file);&nbsp;//$file表示core指定文件,这应该就是编译文件的开始
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;因为core中包括公用的函数,因此接下来就能使用公用函数了.
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;加载应用模式配置文件
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;加载配置文件,Think目录下的和Common目录下的.
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;读取当前应用模式对应的配置文件
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;加载一些额外定义的配置文件
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;加载模式别名定义
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;加载common.php中alias指定的文件
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;加载应用别名定义文件
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;加载额外的定义的类文件
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;加载模式行为定义
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;加载common.php中定义的行为文件
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;加载应用行为定义
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;加载额外的行为定义文件
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;加载框架底层语言包
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;加载语言包
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;如果不是调试模式,那么将一些内容写入~runtime.php
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;否则,加载系统默认的debug.php
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;读取当前应用状态对应的配置文件
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;加载一些额外的自定义配置文件
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;设置系统时区
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;检查应用目录结构&nbsp;如果不存在则自动创建
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;记录加载文件时间</pre><p>3. 在第二步之后,主要需要研究的方法则是App::run()</p><pre class="brush:php;toolbar:false">通过第二步的过程,已经基本将需要的配置文件和公共函数和主要的类加载完毕.那么准备工作已经完成,接下来就是如何完成所有行为的正确走向
App::init();
&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;加载动态应用公共文件和配置
&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;日志目录转换为绝对路径&nbsp;默认情况下存储到公共模块下面
&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;定义当前请求的系统常量
&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;URL调度&nbsp;&nbsp;--完成URL解析、路由和调度
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dispatcher::dispatch();
&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;URL调度结束标签
&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;TMPL_EXCEPTION_FILE&nbsp;改为绝对地址
App::exec();
&nbsp;&nbsp;&nbsp;&nbsp;主要是用来执行控制器的操作.到这里,那么就执行了控制器的操作方法了.因此MC完整的流程结束.</pre><p>4. 视图过程</p><pre class="brush:php;toolbar:false">控制器都会继承Controller类,然后调用$this-&gt;view-&gt;display方法.$this-&gt;view&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=&nbsp;Think::instance(&#39;Think\View&#39;);
那么来看看Think\View类的display方法
function&nbsp;display()
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;视图开始标签
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;解析并获取模板内容
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$content&nbsp;=&nbsp;$this-&gt;fetch($templateFile,$content,$prefix);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;输出模板内容
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this-&gt;render($content,$charset,$contentType);
&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;视图结束标签
function&nbsp;fetch()
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hook::listen(&#39;view_parse&#39;,$params);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$result&nbsp;=&nbsp;&nbsp;&nbsp;self::exec($name,&nbsp;$tag,$params);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$addon&nbsp;&nbsp;&nbsp;=&nbsp;new&nbsp;$name();&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$name=$tags[&#39;view_parse&#39;];&nbsp;也就是common.php中行为定义的一个类:
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;view_parse&#39;&nbsp;&nbsp;&nbsp;&nbsp;=&gt;&nbsp;&nbsp;array(&nbsp;&#39;Behavior\ParseTemplateBehavior&#39;,&nbsp;//&nbsp;模板解析&nbsp;支持PHP、内置模板引擎和第三方模板引擎
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;因此,执行ParseTemplateBehavior这个类的run方法.那么视图的缓存文件也就写入完毕.
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;return&nbsp;$addon-&gt;$tag($params);</pre><p>5. 关于第三步的一些类的细节</p><pre class="brush:php;toolbar:false">(1)&nbsp;URL调度:Dispatcher::dispatch();</pre><p>6. 关于一些问题的回答</p><pre class="brush:php;toolbar:false">(1)&nbsp;在调试模式中,模板文件是如何生成的?怎么生成的?
&nbsp;&nbsp;&nbsp;&nbsp;当网站搭建完成之后,点击某一个链接会生成这个页面的缓存文件.文件存在的目录在Runtime/Cache/Home/****.php
&nbsp;&nbsp;&nbsp;&nbsp;那么问题就在于这个页面的文件是如何生成的呢?
&nbsp;&nbsp;&nbsp;&nbsp;在第四步当中,大概的介绍了页面的生成,但是其中的一些细节并未深入讨论.比如,在生成的页面当中,是如何获取控制器传输的值呢?有待讨论.
(2)&nbsp;在生成的缓存页面当中,使如何获取控制器传输的值呢?
&nbsp;&nbsp;&nbsp;&nbsp;如果不用display加载,用include加载,那么就可以获取控制器的值了.
&nbsp;&nbsp;&nbsp;&nbsp;而display的方式和include类似,因为最后是在控制器下面输出了缓存页面,那么理所当然的控制器的值就可以获取了.
(3)&nbsp;怎么扩展自定义Widget?扩展的Widget如何生效?
(4)&nbsp;怎么扩展自定义标签?扩展的标签如何生效?</pre><p>7. 流程必要元素</p><pre class="brush:php;toolbar:false">在分析TP之前,我们可能想要了解TP加载的一些必要的元素.
(1)&nbsp;配置文件
(2)&nbsp;公共函数
(3)&nbsp;主要类库
(4)&nbsp;模板引擎
(5)&nbsp;模板编译
(6)&nbsp;异常处理</pre>";s:7:"created";s:10:"1465376907";}i:3;a:4:{s:2:"id";s:2:"39";s:5:"title";s:22:"基于Smarty框架-DIY";s:7:"content";s:2318:"<p>介绍: 用过Tp之后, 对TP 有了一些深深的感触.刚好在学习Smarty,那么就利用这个机会自己搭建一个基于Smarty的框架.Ps:利用namespace;</p><p>1. 项目架构思路:<br/></p><pre class="brush:php;toolbar:false">目录:
|++Project(项目名称)
&nbsp;&nbsp;&nbsp;&nbsp;|++Home(模块名称)
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|++Common(公共函数和配置)
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|++Controller(控制器)
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|++View(Smarty框架指定视图)
&nbsp;&nbsp;&nbsp;&nbsp;|++Think(主要类库)
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|++Core(主要函数)
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|++Common(公共配置和函数)
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|--function.php(公共函数)
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|--config.php(公共配置)
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|--Db.class.php(数据库类)
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|--Controller.class.php(控制器基类)
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|--Route.class.php(路由类)
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|--Think.class.php(项目入口类)
&nbsp;&nbsp;&nbsp;&nbsp;|++Runtime(Smarty框架指定路径)
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|++Cache(Smarty框架指定页面缓存路径)
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|++Config(Smarty框架指定配置路径)
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|++Temp(Smarty框架指定模板编译路径)
&nbsp;&nbsp;&nbsp;&nbsp;|++Smarty(Smarty类库)
&nbsp;&nbsp;&nbsp;&nbsp;|--index.php(项目唯一入口)</pre><p>2. Smarty 的页面编译和缓存是一个重要的模块,但是Smarty的函数和自定义函数也是Smarty的一个重要元素.那么如何自定义函数?</p><pre class="brush:php;toolbar:false">http://blog.csdn.net/huli870715/article/details/6526268
在这个自定义框架中,也集成这个功能.但是在TP中是以{:U(params)}&nbsp;的方式调用自定义函数.那么如何更改Smarty的这一行为呢?

Smarty&nbsp;拼接字符串:&nbsp;&nbsp;|cat:&nbsp;&nbsp;相当于.</pre><p><br/></p>";s:7:"created";s:10:"1465267310";}i:4;a:4:{s:2:"id";s:2:"27";s:5:"title";s:7:"M方法";s:7:"content";s:35:"<p>M方法 同步成功? 哈哈</p>";s:7:"created";s:10:"1463998534";}i:5;a:4:{s:2:"id";s:2:"21";s:5:"title";s:12:"面试问题";s:7:"content";s:3511:"<p style="white-space: normal;">1. 弱(mei)类(guan)型(xi)<br/></p><pre class="brush:php;toolbar:false">&nbsp;$str1&nbsp;=&nbsp;&#39;yahoo&#39;;&nbsp;
&nbsp;$str2&nbsp;=&nbsp;&#39;yah&#39;;
&nbsp;strpos(&nbsp;$str1,$str2&nbsp;)&nbsp;==&nbsp;?&nbsp;;&nbsp;//&nbsp;0&nbsp;如果不包含,那么返回false;&nbsp;
//这个实际和弱类型没有关系.&nbsp;在php中,如果没有达到预期结果,基本都是返回false;</pre><p style="white-space: normal;">2. $x++ 和 ++$x<br/></p><pre class="brush:php;toolbar:false">$x&nbsp;=&nbsp;5;
echo&nbsp;$x+++$x++&nbsp;;&nbsp;//11&nbsp;#$x=7
echo&nbsp;&#39;&lt;br&gt;&#39;;
echo&nbsp;$x;&nbsp;&nbsp;//7
echo&nbsp;$x---$x--;&nbsp;&nbsp;//$x=1
echo&nbsp;$x;&nbsp;&nbsp;//#x=5</pre><p style="white-space: normal;">$x++ 无非就是先用后加 , ++$x 是先加后用,所以$x+++$x++ 无非就是 ($x++)(5+) + ($x++)(6+) == 11; 这个时候的$x=7;<br/>那么改变一下 $x=5; ++$x+(++$x) = ?; (++$x)(6) + (++$x)(7) = 13;</p><p style="white-space: normal;">3. 变量的引用<br/></p><pre class="brush:php;toolbar:false">$a&nbsp;=&nbsp;&#39;1&#39;;
$b&nbsp;=&nbsp;&amp;$a&nbsp;;
$b&nbsp;=&nbsp;&quot;2$b&quot;;</pre><p style="white-space: normal;">$a = &#39;1&#39;; 字符串1, &amp;$a 无非就是$b 的指针直接指向了$a 的内存地址,此时如果$b改变,那么$a实际也会发生改变;$b = &#39;1&#39;; $b=&quot;2$b&quot;=&quot;21&quot;; 所以$a=&#39;21&#39;;$b=&#39;21&#39;;<br/>如果是$b=$a; 那么就是$b 引用了$a 的值,但是$b的改变不会影响$a;<br/></p><p style="white-space: normal;">4. == 和 === 的区别(ke yi zhu yi xia)<br/></p><pre class="brush:php;toolbar:false">var_dump(&nbsp;0123&nbsp;==&nbsp;123&nbsp;);
var_dump(&nbsp;&#39;0123&#39;&nbsp;==&nbsp;123&nbsp;);
var_dump(&nbsp;&#39;0123&#39;&nbsp;===&nbsp;123&nbsp;);</pre><p style="white-space: normal;">很容易理解成为: true , false , false; 实际却是 false , true ,false;&nbsp;<br/>0123 php 理解成为8进制 , &#39;0123&#39; 会转换为数字123 , 而=== 必须是类型和值都必须相等.<br/>而这个问题很好的说明了一点,注意php 的弱类型 和 谨慎使用== 和 === ;</p><p style="white-space: normal;">5. array_merge( array, array , ... )<br/></p><pre class="brush:php;toolbar:false">$arr1&nbsp;=&nbsp;array();
$arr1[&#39;var1&#39;]&nbsp;=&nbsp;array(1,2);
$arr1[&#39;var2&#39;]&nbsp;=&nbsp;3;
$arr1[&#39;var3&#39;]&nbsp;=&nbsp;array(4,5);
$arr2&nbsp;=&nbsp;array();
$arr2&nbsp;=&nbsp;array_merge(&nbsp;$arr2&nbsp;,&nbsp;$arr1[&#39;var1&#39;]&nbsp;);
var_dump($arr2);
$arr2&nbsp;=&nbsp;array_merge(&nbsp;$arr2&nbsp;,&nbsp;$arr1[&#39;var2&#39;]&nbsp;);
var_dump($arr2);
$arr2&nbsp;=&nbsp;array_merge(&nbsp;$arr2&nbsp;,&nbsp;$arr1[&#39;var3&#39;]&nbsp;);
var_dump($arr2);</pre><p style="white-space: normal;">返回 array(1,2),null,null; 这个无非就是告诫array_merge 的用法,这个函数的参数只能是数组;<br/>6. 运算符的优先级<br/></p><pre class="brush:php;toolbar:false">$x&nbsp;=&nbsp;true&nbsp;and&nbsp;false;
var_dump($x);</pre><p style="white-space: normal;">答案: true; 因为 = 的优先级 &gt; and;<br/></p><p style="white-space: normal;">7. $text 的值 和 strlen( $text );</p><pre class="brush:php;toolbar:false">$text&nbsp;=&nbsp;&#39;pzr&#39;;
$text[8]=&#39;zy&#39;;
//$text&nbsp;=&nbsp;&#39;pzr(5空格)z&#39;;&nbsp;str_len($text)=9;</pre><p style="white-space: normal;"><br/></p><p style="white-space: normal;"><br/></p><p style="white-space: normal;"><br/></p><p><br/></p>";s:7:"created";s:10:"1462505256";}i:6;a:4:{s:2:"id";s:2:"20";s:5:"title";s:9:"多线程";s:7:"content";s:5762:"<pre class="brush:php;toolbar:false">&lt;?php&nbsp;
class&nbsp;vote&nbsp;extends&nbsp;Thread&nbsp;{
&nbsp;&nbsp;&nbsp;&nbsp;public&nbsp;$res&nbsp;&nbsp;&nbsp;&nbsp;=&nbsp;&#39;&#39;;
&nbsp;&nbsp;&nbsp;&nbsp;public&nbsp;$url&nbsp;&nbsp;&nbsp;&nbsp;=&nbsp;array();
&nbsp;&nbsp;&nbsp;&nbsp;public&nbsp;$name&nbsp;&nbsp;&nbsp;=&nbsp;&#39;&#39;;
&nbsp;&nbsp;&nbsp;&nbsp;public&nbsp;$runing&nbsp;=&nbsp;false;
&nbsp;&nbsp;&nbsp;&nbsp;public&nbsp;$lc&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=&nbsp;false;
&nbsp;&nbsp;&nbsp;&nbsp;public&nbsp;function&nbsp;__construct($name)&nbsp;{
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this-&gt;res&nbsp;&nbsp;&nbsp;&nbsp;=&nbsp;&#39;暂无,第一次运行.&#39;;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this-&gt;param&nbsp;&nbsp;&nbsp;&nbsp;=&nbsp;0;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this-&gt;lurl&nbsp;&nbsp;&nbsp;=&nbsp;0;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this-&gt;name&nbsp;&nbsp;&nbsp;=&nbsp;$name;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this-&gt;runing&nbsp;=&nbsp;true;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this-&gt;lc&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=&nbsp;false;
&nbsp;&nbsp;&nbsp;&nbsp;}
&nbsp;&nbsp;&nbsp;&nbsp;public&nbsp;function&nbsp;run()&nbsp;{
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;while&nbsp;($this-&gt;runing)&nbsp;{
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;if&nbsp;($this-&gt;param&nbsp;!=&nbsp;0)&nbsp;{
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$nt&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=&nbsp;rand(1,&nbsp;10);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;echo&nbsp;&quot;线程[{$this-&gt;name}]收到任务参数::{$this-&gt;param},需要{$nt}秒处理数据.\n&quot;;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this-&gt;res&nbsp;&nbsp;&nbsp;=&nbsp;rand(100,&nbsp;999);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;sleep($nt);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this-&gt;lurl&nbsp;=&nbsp;$this-&gt;param;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this-&gt;param&nbsp;&nbsp;&nbsp;=&nbsp;&#39;&#39;;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}&nbsp;else&nbsp;{
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;echo&nbsp;&quot;线程[{$this-&gt;name}]等待任务..\n&quot;;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;sleep(1);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}
&nbsp;&nbsp;&nbsp;&nbsp;}
}
//这里创建线程池.
$pool[]&nbsp;=&nbsp;new&nbsp;vote(&#39;a&#39;);
$pool[]&nbsp;=&nbsp;new&nbsp;vote(&#39;b&#39;);
$pool[]&nbsp;=&nbsp;new&nbsp;vote(&#39;c&#39;);
//启动所有线程,使其处于工作状态
foreach&nbsp;($pool&nbsp;as&nbsp;$w)&nbsp;{
&nbsp;&nbsp;&nbsp;&nbsp;$w-&gt;start();
}
//派发任务给线程
for&nbsp;($i&nbsp;=&nbsp;1;&nbsp;$i&nbsp;&lt;&nbsp;10;&nbsp;$i++)&nbsp;{
&nbsp;&nbsp;&nbsp;&nbsp;$worker_content&nbsp;=&nbsp;rand(10,&nbsp;99);
&nbsp;&nbsp;&nbsp;&nbsp;while&nbsp;(true)&nbsp;{
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;foreach&nbsp;($pool&nbsp;as&nbsp;$worker)&nbsp;{
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//参数为空则说明线程空闲
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;if&nbsp;($worker-&gt;param==&#39;&#39;)&nbsp;{
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$worker-&gt;param&nbsp;=&nbsp;$worker_content;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;echo&nbsp;&quot;[{$worker-&gt;name}]线程空闲,放入参数{$worker_content},上次参数[{$worker-&gt;lurl}]结果[{$worker-&gt;res}].\n&quot;;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;break&nbsp;2;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;sleep(1);
&nbsp;&nbsp;&nbsp;&nbsp;}
}
echo&nbsp;&quot;所有线程派发完毕,等待执行完成.\n&quot;;
//等待所有线程运行结束
while&nbsp;(count($pool))&nbsp;{
&nbsp;&nbsp;&nbsp;&nbsp;//遍历检查线程组运行结束
&nbsp;&nbsp;&nbsp;&nbsp;foreach&nbsp;($pool&nbsp;as&nbsp;$key&nbsp;=&gt;&nbsp;$threads)&nbsp;{
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;if&nbsp;($worker-&gt;param==&#39;&#39;)&nbsp;{
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;echo&nbsp;&quot;[{$threads-&gt;name}]线程空闲,上次参数[{$threads-&gt;lurl}]结果[{$threads-&gt;res}].\n&quot;;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;echo&nbsp;&quot;[{$threads-&gt;name}]线程运行完成,退出.\n&quot;;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//设置结束标志
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$threads-&gt;runing&nbsp;=&nbsp;false;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;unset($pool[$key]);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}
&nbsp;&nbsp;&nbsp;&nbsp;}
&nbsp;&nbsp;&nbsp;&nbsp;echo&nbsp;&quot;等待中...\n&quot;;
&nbsp;&nbsp;&nbsp;&nbsp;sleep(1);
}
echo&nbsp;&quot;所有线程执行完毕.\n&quot;;</pre><p><br/></p>";s:7:"created";s:10:"1462354386";}i:7;a:4:{s:2:"id";s:2:"19";s:5:"title";s:24:"关联模型的上下文";s:7:"content";s:2855:"<p>调用关联模型的方法: <br/>function D($name=&#39;&#39;,$layer=&#39;&#39;) <br/>$name 资源地址 , $layer 模型层名称 .<br/>D(&#39;UserRelation&#39;); &nbsp;<br/><br/></p><pre class="brush:php;toolbar:false">/**
&nbsp;*&nbsp;实例化模型类&nbsp;格式&nbsp;[资源://][模块/]模型
&nbsp;*&nbsp;@param&nbsp;string&nbsp;$name&nbsp;资源地址
&nbsp;*&nbsp;@param&nbsp;string&nbsp;$layer&nbsp;模型层名称
&nbsp;*&nbsp;@return&nbsp;Think\Model
&nbsp;*/
function&nbsp;D($name=&#39;&#39;,$layer=&#39;&#39;)&nbsp;{
&nbsp;&nbsp;&nbsp;&nbsp;if(empty($name))&nbsp;return&nbsp;new&nbsp;Think\Model;
&nbsp;&nbsp;&nbsp;&nbsp;static&nbsp;$_model&nbsp;&nbsp;=&nbsp;&nbsp;&nbsp;array();
&nbsp;&nbsp;&nbsp;&nbsp;$layer&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;&nbsp;$layer?&nbsp;:&nbsp;C(&#39;DEFAULT_M_LAYER&#39;);&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;//$layer&nbsp;=&nbsp;Model
&nbsp;&nbsp;&nbsp;&nbsp;//$name&nbsp;=&nbsp;UserRelation
&nbsp;&nbsp;&nbsp;&nbsp;if(isset($_model[$name.$layer]))
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;return&nbsp;$_model[$name.$layer];
&nbsp;&nbsp;&nbsp;&nbsp;$class&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;&nbsp;parse_res_name($name,$layer);
&nbsp;&nbsp;&nbsp;&nbsp;if(class_exists($class))&nbsp;{
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$model&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;&nbsp;new&nbsp;$class(basename($name));
&nbsp;&nbsp;&nbsp;&nbsp;}elseif(false&nbsp;===&nbsp;strpos($name,&#39;/&#39;)){
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;自动加载公共模块下面的模型
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;if(!C(&#39;APP_USE_NAMESPACE&#39;)){
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;import(&#39;Common/&#39;.$layer.&#39;/&#39;.$class);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}else{
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$class&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;&nbsp;&#39;\\Common\\&#39;.$layer.&#39;\\&#39;.$name.$layer;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$model&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;&nbsp;class_exists($class)?&nbsp;new&nbsp;$class($name)&nbsp;:&nbsp;new&nbsp;Think\Model($name);
&nbsp;&nbsp;&nbsp;&nbsp;}else&nbsp;{
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Think\Log::record(&#39;D方法实例化没找到模型类&#39;.$class,Think\Log::NOTICE);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$model&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;&nbsp;new&nbsp;Think\Model(basename($name));
&nbsp;&nbsp;&nbsp;&nbsp;}
&nbsp;&nbsp;&nbsp;&nbsp;$_model[$name.$layer]&nbsp;&nbsp;=&nbsp;&nbsp;$model;
&nbsp;&nbsp;&nbsp;&nbsp;return&nbsp;$model;
}</pre><p><br/></p>";s:7:"created";s:10:"1462330372";}i:8;a:4:{s:2:"id";s:2:"18";s:5:"title";s:13:"RelationTable";s:7:"content";s:20352:"<p>关系表说明</p><pre class="brush:html;toolbar:false">&nbsp;&nbsp;&nbsp;&nbsp;user&nbsp;和&nbsp;dept&nbsp;:&nbsp;HAS_ONE&nbsp;,一对一
&nbsp;&nbsp;&nbsp;&nbsp;user&nbsp;和&nbsp;account&nbsp;:&nbsp;HAS_MANY&nbsp;,&nbsp;一对多,反过来也就是多对一&nbsp;BELONGS_TO;
&nbsp;&nbsp;&nbsp;&nbsp;user&nbsp;和&nbsp;role&nbsp;:&nbsp;MANY_TO_MANY&nbsp;,多对多</pre><p>关系表数据</p><pre class="brush:php;toolbar:false">create&nbsp;table&nbsp;`test_user`(
&nbsp;&nbsp;`id`&nbsp;int(11)&nbsp;unsigned&nbsp;not&nbsp;null&nbsp;auto_increment&nbsp;primary&nbsp;key&nbsp;,
&nbsp;&nbsp;`username`&nbsp;varchar(30)&nbsp;not&nbsp;null&nbsp;default&nbsp;&#39;&#39;,
&nbsp;&nbsp;`status`&nbsp;tinyint(1)&nbsp;not&nbsp;null&nbsp;default&nbsp;1,
&nbsp;&nbsp;key(`username`)
)engine=myisam&nbsp;default&nbsp;charset=utf8&nbsp;auto_increment=1;

create&nbsp;table&nbsp;`test_dept`(
&nbsp;&nbsp;`user_id`&nbsp;int(11)&nbsp;unsigned&nbsp;not&nbsp;null&nbsp;&nbsp;primary&nbsp;key&nbsp;,
&nbsp;&nbsp;`dept_no`&nbsp;int(11)&nbsp;unsigned&nbsp;not&nbsp;null&nbsp;default&nbsp;0,
&nbsp;&nbsp;`status`&nbsp;tinyint(1)&nbsp;not&nbsp;null&nbsp;default&nbsp;1,
&nbsp;&nbsp;key(`dept_no`)
)engine=myisam&nbsp;default&nbsp;charset=utf8&nbsp;;

create&nbsp;table&nbsp;`test_account`(
&nbsp;&nbsp;`id`&nbsp;int(11)&nbsp;unsigned&nbsp;not&nbsp;null&nbsp;auto_increment&nbsp;primary&nbsp;key,
&nbsp;&nbsp;`user_id`&nbsp;int(11)&nbsp;unsigned&nbsp;not&nbsp;null&nbsp;&nbsp;default&nbsp;0&nbsp;,
&nbsp;&nbsp;`account_no`&nbsp;int(11)&nbsp;unsigned&nbsp;not&nbsp;null&nbsp;default&nbsp;0,
&nbsp;&nbsp;`status`&nbsp;tinyint(1)&nbsp;not&nbsp;null&nbsp;default&nbsp;1,
&nbsp;&nbsp;key(`user_id`)
)engine=myisam&nbsp;default&nbsp;charset=utf8&nbsp;;

insert&nbsp;into&nbsp;`test_user`&nbsp;values(1,&#39;zs&#39;),(2,&#39;ls&#39;),(3,&#39;ww&#39;);
insert&nbsp;into&nbsp;`test_dept`&nbsp;values(1,1),(2,2),(3,3);
insert&nbsp;into&nbsp;`test_account`&nbsp;values(1,1),(1,11),(2,2),(2,22),(3,3),(3,33);

create&nbsp;table&nbsp;`test_role`(
&nbsp;&nbsp;`id`&nbsp;int(11)&nbsp;unsigned&nbsp;not&nbsp;null&nbsp;&nbsp;auto_increment&nbsp;primary&nbsp;key,
&nbsp;&nbsp;`name`&nbsp;varchar(20)&nbsp;not&nbsp;null&nbsp;default&nbsp;&#39;&#39;,
&nbsp;&nbsp;`status`&nbsp;tinyint(1)&nbsp;not&nbsp;null&nbsp;default&nbsp;1,
&nbsp;&nbsp;key(`name`)
)engine=myisam&nbsp;default&nbsp;charset=utf8&nbsp;auto_increment=1;

create&nbsp;table&nbsp;`test_user_role`(
&nbsp;&nbsp;`user_id`&nbsp;int(11)&nbsp;unsigned&nbsp;not&nbsp;null&nbsp;&nbsp;default&nbsp;0,
&nbsp;&nbsp;`role_id`&nbsp;int(11)&nbsp;unsigned&nbsp;not&nbsp;null&nbsp;default&nbsp;0,
&nbsp;&nbsp;key(`user_id`),
&nbsp;&nbsp;key(`role_id`)
)engine=myisam&nbsp;default&nbsp;charset=utf8&nbsp;auto_increment=1;

insert&nbsp;into&nbsp;`test_role`&nbsp;values(1,&#39;admin&#39;,1),(2,&#39;index&#39;,1),(3,&#39;comment&#39;,1);
insert&nbsp;into&nbsp;`test_user_role`&nbsp;values(1,1),(1,2),(2,2),(2,3),(3,3),(3,1);</pre><p>所有关系的配置,除了BELONGS_TO</p><pre class="brush:php;toolbar:false">&lt;?php
namespace&nbsp;Admin\Model;
use&nbsp;Think\Model\RelationModel;
Class&nbsp;UserRelationModel&nbsp;extends&nbsp;RelationModel&nbsp;{
&nbsp;&nbsp;&nbsp;&nbsp;protected&nbsp;$tableName&nbsp;=&nbsp;&#39;user&#39;;
&nbsp;&nbsp;&nbsp;&nbsp;protected&nbsp;$_link&nbsp;=&nbsp;array(
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;dept&#39;&nbsp;=&gt;&nbsp;array(
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;mapping_type&#39;&nbsp;=&gt;&nbsp;self::HAS_ONE,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;mapping_name&#39;&nbsp;=&gt;&nbsp;&#39;dept&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;class_name&#39;&nbsp;=&gt;&nbsp;&#39;dept&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;mapping_field&#39;&nbsp;=&gt;&nbsp;&#39;*&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;&#39;condition&#39;&nbsp;=&gt;&nbsp;&#39;user_id=1&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;mapping_key&#39;&nbsp;=&gt;&nbsp;&#39;id&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;&#39;parent_key&#39;&nbsp;=&gt;&nbsp;&#39;id&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;foreign_key&#39;&nbsp;=&gt;&nbsp;&#39;user_id&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;&#39;relation_deep&#39;&nbsp;=&gt;&nbsp;array(),
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&#39;as_fields&#39;&nbsp;=&gt;&nbsp;&#39;column:new_column&#39;&nbsp;,&nbsp;//仅仅支持HAS_ONE&nbsp;和&nbsp;BELONGS_TO
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;),
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;account&#39;&nbsp;=&gt;&nbsp;array(
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;mapping_type&#39;&nbsp;=&gt;&nbsp;self::HAS_MANY,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;mapping_name&#39;&nbsp;=&gt;&nbsp;&#39;account&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;class_name&#39;&nbsp;=&gt;&nbsp;&#39;account&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;mapping_field&#39;&nbsp;=&gt;&nbsp;&#39;*&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;mapping_key&#39;&nbsp;=&gt;&nbsp;&#39;id&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;foreign_key&#39;&nbsp;=&gt;&nbsp;&#39;user_id&#39;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;),
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;role&#39;&nbsp;=&gt;&nbsp;array(
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;mapping_type&#39;&nbsp;=&gt;&nbsp;self::MANY_TO_MANY,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;mapping_name&#39;&nbsp;=&gt;&nbsp;&#39;role&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;mapping_key&#39;&nbsp;=&gt;&nbsp;&#39;id&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;class_name&#39;&nbsp;=&gt;&nbsp;&#39;role&#39;,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;foreign_key&#39;&nbsp;=&gt;&nbsp;&#39;user_id&#39;,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;where&nbsp;1=1&nbsp;and&nbsp;a.user_id=$result[&nbsp;mapping_key&nbsp;]&nbsp;;//$result[&#39;id&#39;]
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;relation_foreign_key&#39;&nbsp;=&gt;&nbsp;&#39;role_id&#39;,&nbsp;&nbsp;//&nbsp;a.relation_foreign_key=b.id&nbsp;//&nbsp;a.user_id=b.id
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;relation_table&#39;&nbsp;=&gt;&nbsp;&#39;test_user_role&#39;,&nbsp;&nbsp;//table&nbsp;a&nbsp;&nbsp;&nbsp;&amp;&amp;&nbsp;tableName=user&nbsp;&nbsp;table&nbsp;b,&nbsp;select&nbsp;b.*
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;&#39;mapping_limit&#39;&nbsp;=&gt;&nbsp;&#39;10&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;&#39;mapping_sort&#39;&nbsp;=&gt;&nbsp;&#39;sort&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;&#39;mapping_field&#39;&nbsp;=&gt;&nbsp;&#39;*&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;&#39;as_field&#39;&nbsp;=&gt;&nbsp;&#39;name:role_name&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;&#39;condition&#39;&nbsp;=&gt;&nbsp;&#39;status=1&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;&#39;relation_deep&#39;&nbsp;=&gt;&nbsp;array(),
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;),
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;);
}</pre><p>BELOGS_TO 配置</p><pre class="brush:php;toolbar:false">&lt;?php
namespace&nbsp;Admin\Model;
use&nbsp;Think\Model\RelationModel;
Class&nbsp;AccountRelationModel&nbsp;extends&nbsp;RelationModel&nbsp;{
&nbsp;&nbsp;&nbsp;&nbsp;protected&nbsp;$tableName&nbsp;=&nbsp;&#39;account&#39;;
&nbsp;&nbsp;&nbsp;&nbsp;protected&nbsp;$_link&nbsp;=&nbsp;array(
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;user&#39;&nbsp;=&gt;&nbsp;array(
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;mapping_type&#39;&nbsp;=&gt;&nbsp;self::BELONGS_TO,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;mapping_name&#39;&nbsp;=&gt;&nbsp;&#39;user&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;class_name&#39;&nbsp;=&gt;&nbsp;&#39;user&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;foreign_key&#39;&nbsp;=&gt;&nbsp;&#39;user_id&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;mapping_field&#39;&nbsp;=&gt;&nbsp;&#39;*&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;&#39;parent_key&#39;&nbsp;=&gt;&nbsp;&#39;user_id&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;condition&#39;&nbsp;=&gt;&nbsp;&#39;status=1&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&#39;as_fields&#39;&nbsp;=&gt;&nbsp;&#39;column:new_column&#39;&nbsp;//仅仅支持HAS_ONE&nbsp;和&nbsp;BELONGS_TO
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;);
}</pre><p>完整代码</p><pre class="brush:php;toolbar:false">&lt;?php
namespace&nbsp;Admin\Controller;
use&nbsp;Think\Controller;
class&nbsp;IndexController&nbsp;extends&nbsp;Controller&nbsp;{
&nbsp;&nbsp;&nbsp;&nbsp;public&nbsp;function&nbsp;index(){
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$rest&nbsp;=&nbsp;D(&#39;userRelation&#39;)-&gt;relation(&#39;role&#39;)-&gt;select();
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;p($rest);&nbsp;die;
&nbsp;&nbsp;&nbsp;&nbsp;}
&nbsp;&nbsp;&nbsp;&nbsp;public&nbsp;function&nbsp;add_role()&nbsp;{
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$data&nbsp;=&nbsp;array(
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;username&#39;=&gt;&#39;zy&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;role&#39;&nbsp;=&gt;&nbsp;array(
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;array(&nbsp;&#39;id&#39;=&gt;1),
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;array(&#39;id&#39;=&gt;2),
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;array(&#39;id&#39;=&gt;3),
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;array(&#39;id&#39;=&gt;4,&#39;name&#39;=&gt;&#39;rbac&#39;)
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$rest&nbsp;=&nbsp;D(&#39;UserRelation&#39;)-&gt;relation(true)-&gt;add($data);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;p($rest);
&nbsp;&nbsp;&nbsp;&nbsp;}
&nbsp;&nbsp;&nbsp;&nbsp;public&nbsp;function&nbsp;save_role(){
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$data&nbsp;=&nbsp;array(
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;id&#39;&nbsp;=&gt;&nbsp;9,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;username&#39;=&gt;&#39;zy&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;role&#39;&nbsp;=&gt;&nbsp;array(
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;array(&nbsp;&#39;id&#39;=&gt;0),
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;array(&nbsp;&#39;id&#39;=&gt;1),
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;array(&#39;id&#39;=&gt;2),
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//array(&nbsp;&#39;id&#39;=&gt;3),
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;array(&#39;id&#39;=&gt;4,&#39;name&#39;=&gt;&#39;rbac&#39;)
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$rest&nbsp;=&nbsp;D(&#39;UserRelation&#39;)-&gt;relation(true)-&gt;save($data);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;p($rest);
&nbsp;&nbsp;&nbsp;&nbsp;}
public&nbsp;function&nbsp;delete_role()&nbsp;{
&nbsp;&nbsp;&nbsp;&nbsp;$rest&nbsp;=&nbsp;D(&#39;UserRelation&#39;)-&gt;relation(true)-&gt;where(&nbsp;array(&#39;id&#39;=&gt;6)&nbsp;)-&gt;delete();
&nbsp;&nbsp;&nbsp;&nbsp;p($rest);
}
public&nbsp;function&nbsp;add_account(){
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$data&nbsp;=&nbsp;array(
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;username&#39;&nbsp;=&gt;&nbsp;&nbsp;&#39;pzr&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;account&#39;&nbsp;=&gt;&nbsp;array(
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;array(
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;user_id&#39;&nbsp;=&gt;&nbsp;5,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;account_no&#39;&nbsp;=&gt;&nbsp;5
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;),
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;array(
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;user_id&#39;&nbsp;=&gt;&nbsp;5,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;account_no&#39;&nbsp;=&gt;&nbsp;55
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;),
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$rest&nbsp;=&nbsp;D(&#39;UserRelation&#39;)-&gt;relation(&#39;account&#39;)-&gt;add(&nbsp;$data&nbsp;);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;p($rest);&nbsp;&nbsp;die;
&nbsp;&nbsp;&nbsp;&nbsp;}
&nbsp;&nbsp;&nbsp;&nbsp;public&nbsp;function&nbsp;add(){
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$data&nbsp;=&nbsp;array(
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;username&#39;&nbsp;=&gt;&nbsp;&nbsp;&#39;pzr&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;dept&#39;&nbsp;=&gt;&nbsp;array(
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;user_id&#39;&nbsp;=&gt;&nbsp;4,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;dept_no&#39;&nbsp;=&gt;&nbsp;4
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$rest&nbsp;=&nbsp;D(&#39;UserRelation&#39;)-&gt;relation(true)-&gt;add(&nbsp;$data&nbsp;);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;p($rest);&nbsp;&nbsp;die;
&nbsp;&nbsp;&nbsp;&nbsp;}
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;public&nbsp;function&nbsp;save_account(){
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$data&nbsp;=&nbsp;array(
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;id&#39;&nbsp;=&gt;&nbsp;5,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;username&#39;&nbsp;=&gt;&nbsp;&nbsp;&#39;zy&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;account&#39;&nbsp;=&gt;&nbsp;array(
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;array(
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;id&#39;&nbsp;=&gt;&nbsp;9,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;user_id&#39;&nbsp;=&gt;&nbsp;5,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;account_no&#39;&nbsp;=&gt;&nbsp;52
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;),
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;array(
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;id&#39;&nbsp;=&gt;&nbsp;&#39;10&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;user_id&#39;&nbsp;=&gt;&nbsp;5,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;account_no&#39;&nbsp;=&gt;&nbsp;552
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;),
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$rest&nbsp;=&nbsp;D(&#39;UserRelation&#39;)-&gt;relation(true)-&gt;save(&nbsp;$data&nbsp;);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;p($rest);die;
&nbsp;&nbsp;&nbsp;&nbsp;}
&nbsp;&nbsp;&nbsp;&nbsp;public&nbsp;function&nbsp;save(){
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$data&nbsp;=&nbsp;array(
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;id&#39;&nbsp;=&gt;&nbsp;4,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;username&#39;&nbsp;=&gt;&nbsp;&#39;zy&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;dept&#39;&nbsp;=&gt;&nbsp;array(
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;user_id&#39;&nbsp;=&gt;&nbsp;4,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;dept_no&#39;&nbsp;=&gt;&nbsp;40
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$rest&nbsp;=&nbsp;D(&#39;UserRelation&#39;)-&gt;relation(true)-&gt;save(&nbsp;$data&nbsp;);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;p($rest);die;
&nbsp;&nbsp;&nbsp;&nbsp;}
public&nbsp;function&nbsp;delete()&nbsp;{
&nbsp;&nbsp;&nbsp;&nbsp;$data&nbsp;=&nbsp;array(&nbsp;&#39;id&#39;=&gt;4&nbsp;);
&nbsp;&nbsp;&nbsp;&nbsp;$rest&nbsp;=&nbsp;D(&#39;UserRelation&#39;)-&gt;relation(true)-&gt;where(&nbsp;array(&#39;id&#39;=&gt;4)&nbsp;)-&gt;delete(&nbsp;&nbsp;);
&nbsp;&nbsp;&nbsp;&nbsp;p($rest);die;
}
public&nbsp;function&nbsp;delete_account(){
&nbsp;&nbsp;&nbsp;&nbsp;D(&#39;UserRelation&#39;)-&gt;relation(&#39;account&#39;)-&gt;where(&nbsp;array(&#39;id&#39;=&gt;5)&nbsp;)-&gt;delete();
}
}</pre>";s:7:"created";s:10:"1462276536";}i:9;a:4:{s:2:"id";s:2:"17";s:5:"title";s:12:"MANY_TO_MANY";s:7:"content";s:11259:"<p style="white-space: normal;">配置:</p><pre class="brush:php;toolbar:false">protected&nbsp;$_link&nbsp;=&nbsp;array(
&nbsp;&nbsp;&nbsp;&nbsp;&#39;role&#39;&nbsp;=&gt;&nbsp;array(
&nbsp;&nbsp;&nbsp;&nbsp;&#39;mapping_type&#39;&nbsp;=&gt;&nbsp;self::MANY_TO_MANY,
&nbsp;&nbsp;&nbsp;&nbsp;&#39;mapping_name&#39;&nbsp;=&gt;&nbsp;&#39;role&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;&#39;mapping_key&#39;&nbsp;=&gt;&nbsp;&#39;id&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;&#39;class_name&#39;&nbsp;=&gt;&nbsp;&#39;role&#39;,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;查询关联表role&nbsp;内容
&nbsp;&nbsp;&nbsp;&nbsp;&#39;foreign_key&#39;&nbsp;=&gt;&nbsp;&#39;user_id&#39;,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;where&nbsp;1=1&nbsp;and&nbsp;a.user_id=$result[&nbsp;mapping_key&nbsp;]&nbsp;;//$result[&#39;id&#39;]
&nbsp;&nbsp;&nbsp;&nbsp;&#39;relation_foreign_key&#39;&nbsp;=&gt;&nbsp;&#39;role_id&#39;,&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;a.relation_foreign_key=b.id&nbsp;//&nbsp;a.user_id=b.id
&nbsp;&nbsp;&nbsp;&nbsp;&#39;relation_table&#39;&nbsp;=&gt;&nbsp;&#39;test_user_role&#39;,&nbsp;&nbsp;//table&nbsp;a&nbsp;&nbsp;&nbsp;&amp;&amp;&nbsp;tableName=user&nbsp;&nbsp;table&nbsp;b,&nbsp;select&nbsp;b.*
&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;&#39;mapping_limit&#39;&nbsp;=&gt;&nbsp;&#39;10&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;&#39;mapping_sort&#39;&nbsp;=&gt;&nbsp;&#39;sort&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;&#39;mapping_field&#39;&nbsp;=&gt;&nbsp;&#39;*&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;&#39;as_field&#39;&nbsp;=&gt;&nbsp;&#39;name:role_name&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;&#39;condition&#39;&nbsp;=&gt;&nbsp;&#39;status=1&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;&#39;relation_deep&#39;&nbsp;=&gt;&nbsp;array(),
&nbsp;&nbsp;&nbsp;&nbsp;),
);</pre><p style="white-space: normal;">操作:</p><pre class="brush:php;toolbar:false">public&nbsp;function&nbsp;add_role()&nbsp;{
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$data&nbsp;=&nbsp;array(
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;username&#39;=&gt;&#39;zy&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;role&#39;&nbsp;=&gt;&nbsp;array(
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;array(&nbsp;&#39;id&#39;=&gt;1),
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;array(&#39;id&#39;=&gt;2),
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;array(&#39;id&#39;=&gt;3),
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;array(&#39;id&#39;=&gt;4,&#39;name&#39;=&gt;&#39;rbac&#39;)&nbsp;//&nbsp;并不会执行关联表的插入操作,只执行了主表&nbsp;的插入.
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$rest&nbsp;=&nbsp;D(&#39;UserRelation&#39;)-&gt;relation(true)-&gt;add($data);
&nbsp;&nbsp;&nbsp;&nbsp;}
public&nbsp;function&nbsp;save_role(){
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$data&nbsp;=&nbsp;array(
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;id&#39;&nbsp;=&gt;&nbsp;9,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;username&#39;=&gt;&#39;zy&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;role&#39;&nbsp;=&gt;&nbsp;array(
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//如果需要全部删除,那么必须留一个0&nbsp;;(不一定必须是0,只要是一个role&nbsp;表中id&nbsp;字段不存在的值即可.
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;array(&nbsp;&#39;id&#39;=&gt;0),&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;array(&nbsp;&#39;id&#39;=&gt;1),
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;array(&#39;id&#39;=&gt;2),
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//array(&nbsp;&#39;id&#39;=&gt;3),
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$rest&nbsp;=&nbsp;D(&#39;UserRelation&#39;)-&gt;relation(true)-&gt;save($data);
&nbsp;&nbsp;&nbsp;&nbsp;}
&nbsp;&nbsp;&nbsp;&nbsp;
public&nbsp;function&nbsp;delete_role()&nbsp;{
	$rest&nbsp;=&nbsp;D(&#39;UserRelation&#39;)-&gt;relation(true)-&gt;where(&nbsp;array(&#39;id&#39;=&gt;6)&nbsp;)-&gt;delete();
}</pre><p style="white-space: normal;"><br/></p><p style="white-space: normal;">SELECT</p><pre class="brush:php;toolbar:false">$rest&nbsp;=&nbsp;D(&#39;UserRelation&#39;)-&gt;relation(&#39;role&#39;)-&gt;select();
$model&nbsp;=&nbsp;class_name;&nbsp;//user
$model-&gt;getTableName()&nbsp;=&nbsp;&#39;user&#39;;
$mappingFields&nbsp;=&nbsp;mapping_field;&nbsp;//&nbsp;*
$mappingRelationTable&nbsp;=&nbsp;&#39;test_user_role&#39;;&nbsp;
$mappingRelationFk&nbsp;=&nbsp;relation_foreign_key;
$model-&gt;getPk()&nbsp;=&nbsp;id;
$mappingCondition&nbsp;=&nbsp;&quot;&nbsp;{$mappingFk}=&#39;{$pk}&#39;&quot;;&nbsp;//&nbsp;user_id=1|2|3
$sql&nbsp;=&nbsp;&quot;SELECT&nbsp;b.{$mappingFields}&nbsp;FROM&nbsp;{$mappingRelationTable}&nbsp;AS&nbsp;a,&nbsp;&quot;.$model-&gt;getTableName().&quot;&nbsp;AS&nbsp;b&nbsp;WHERE&nbsp;a.{$mappingRelationFk}&nbsp;=&nbsp;b.{$model-&gt;getPk()}&nbsp;AND&nbsp;a.{$mappingCondition}&quot;;
//&nbsp;$sql&nbsp;=&nbsp;select&nbsp;b.*&nbsp;from&nbsp;test_user_role&nbsp;as&nbsp;a,test_user&nbsp;as&nbsp;b&nbsp;where&nbsp;a.relation_foreign_key=b.id&nbsp;and&nbsp;a.foreign_key=1|2|3
//&nbsp;select&nbsp;b.*&nbsp;from&nbsp;test_user_role&nbsp;as&nbsp;a,test_role&nbsp;as&nbsp;b&nbsp;where&nbsp;a.role_id=b.id&nbsp;and&nbsp;b.role_id=1|2|3</pre><p style="white-space: normal;">ADD</p><pre class="brush:php;toolbar:false">$mappingData&nbsp;&nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;&nbsp;isset($data[$mappingName])?$data[$mappingName]:false;&nbsp;//$data[&#39;role&#39;]
foreach&nbsp;($mappingData&nbsp;as&nbsp;$vo)
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$ids[]&nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;&nbsp;$vo[$mappingKey];&nbsp;
$relationId&nbsp;=&nbsp;implode(&#39;,&#39;,$ids);
$mappingRelationTable&nbsp;=&nbsp;&#39;test_user_role&#39;;
$mappingFK&nbsp;=&nbsp;&#39;user_id&#39;;
$mappingRelationFK&nbsp;=&nbsp;&#39;role_id&#39;;
$this-&gt;getTableName&nbsp;=&nbsp;&#39;role&#39;;
$model-&gt;getTableName&nbsp;=&nbsp;&#39;user&#39;;
$pk&nbsp;=&nbsp;&nbsp;&nbsp;$data[$mappingKey];&nbsp;&nbsp;//$data[&#39;id&#39;]&nbsp;&nbsp;//&nbsp;$data&nbsp;待插入的数据
$sql&nbsp;=&nbsp;insert&nbsp;into&nbsp;test_user_role(user_id,role_id)&nbsp;select&nbsp;a.id,b.id&nbsp;from&nbsp;test_role&nbsp;as&nbsp;a,test_user&nbsp;as&nbsp;b&nbsp;where&nbsp;a.id=$pk&nbsp;and&nbsp;b.id&nbsp;in(&nbsp;$relationId&nbsp;);

&nbsp;case&nbsp;&#39;ADD&#39;:&nbsp;//&nbsp;增加关联数据
&nbsp;if(isset($relationId))&nbsp;{
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this-&gt;startTrans();
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;插入关联表数据
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$sql&nbsp;&nbsp;=&nbsp;&#39;INSERT&nbsp;INTO&nbsp;&#39;.$mappingRelationTable.&#39;&nbsp;(&#39;.$mappingFk.&#39;,&#39;.$mappingRelationFk.&#39;)&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SELECT&nbsp;a.&#39;.$this-&gt;getPk().&#39;,b.&#39;.$model-&gt;getPk().&#39;&nbsp;FROM&nbsp;&#39;.$this-&gt;getTableName().&#39;&nbsp;AS&nbsp;a&nbsp;,&#39;.$model-&gt;getTableName().&quot;&nbsp;AS&nbsp;b&nbsp;where&nbsp;a.&quot;.$this-&gt;getPk().&#39;&nbsp;=&#39;.&nbsp;$pk.&#39;&nbsp;AND&nbsp;&nbsp;b.&#39;.$model-&gt;getPk().&#39;&nbsp;IN&nbsp;(&#39;.$relationId.&quot;)&nbsp;&quot;;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$result&nbsp;=&nbsp;&nbsp;&nbsp;$model-&gt;execute($sql);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;if(false&nbsp;!==&nbsp;$result)
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;提交事务
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this-&gt;commit();
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;else
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;事务回滚
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this-&gt;rollback();
}
break;</pre><p style="white-space: normal;">&nbsp;SAVE</p><pre class="brush:php;toolbar:false">$mappingData&nbsp;&nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;&nbsp;isset($data[$mappingName])?$data[$mappingName]:false;&nbsp;//$data[&#39;role&#39;]
foreach&nbsp;($mappingData&nbsp;as&nbsp;$vo)
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$ids[]&nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;&nbsp;$vo[$mappingKey];&nbsp;
$relationId&nbsp;=&nbsp;implode(&#39;,&#39;,$ids);
$mappingRelationTable&nbsp;=&nbsp;&#39;test_user_role&#39;;
$mappingCondition[$mappingFk]&nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;&nbsp;$pk;&nbsp;&nbsp;//&nbsp;$mappingFK=&#39;user_id&#39;&nbsp;;&nbsp;$pk=$data[mapping_key];&nbsp;//&nbsp;$pk&nbsp;=&nbsp;$data[&#39;id&#39;];
if(isset($relationId))&nbsp;{
&nbsp;&nbsp;&nbsp;&nbsp;$this-&gt;startTrans();
&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;删除关联表数据
&nbsp;&nbsp;&nbsp;&nbsp;$this-&gt;table($mappingRelationTable)-&gt;where($mappingCondition)-&gt;delete();&nbsp;//关联表更新之前先清除之前的数据
&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;插入关联表数据
&nbsp;&nbsp;&nbsp;&nbsp;$sql&nbsp;&nbsp;=&nbsp;&#39;INSERT&nbsp;INTO&nbsp;&#39;.$mappingRelationTable.&#39;&nbsp;(&#39;.$mappingFk.&#39;,&#39;.$mappingRelationFk.&#39;)&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;SELECT&nbsp;a.&#39;.$this-&gt;getPk().&#39;,b.&#39;.$model-&gt;getPk().&#39;&nbsp;FROM&nbsp;&#39;.$this-&gt;getTableName().&#39;&nbsp;AS&nbsp;a&nbsp;,&#39;.$model-&gt;getTableName().&quot;&nbsp;AS&nbsp;b&nbsp;where&nbsp;a.&quot;.$this-&gt;getPk().&#39;&nbsp;=&#39;.&nbsp;$pk.&#39;&nbsp;AND&nbsp;&nbsp;b.&#39;.$model-&gt;getPk().&#39;&nbsp;IN&nbsp;(&#39;.$relationId.&quot;)&nbsp;&quot;;
&nbsp;&nbsp;&nbsp;&nbsp;$result&nbsp;=&nbsp;&nbsp;&nbsp;$model-&gt;execute($sql);
&nbsp;&nbsp;&nbsp;&nbsp;if(false&nbsp;!==&nbsp;$result)
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;提交事务
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this-&gt;commit();
&nbsp;&nbsp;&nbsp;&nbsp;else
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;事务回滚
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this-&gt;rollback();</pre><p style="white-space: normal;">}<br/></p><p style="white-space: normal;">DELETE</p><pre class="brush:php;toolbar:false">&nbsp;&nbsp;&nbsp;&nbsp;$mappingRelationTable&nbsp;=&nbsp;&#39;test_user_role&#39;;
&nbsp;&nbsp;&nbsp;&nbsp;$mappingCondition&nbsp;=&nbsp;&#39;and&nbsp;foreign_key=$data[mapping_key]&#39;&nbsp;//&nbsp;and&nbsp;user_id=$data[&#39;id&#39;]&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;$result&nbsp;=&nbsp;&nbsp;&nbsp;$this-&gt;table($mappingRelationTable)-&gt;where($mappingCondition)-&gt;delete();</pre><p><br/></p>";s:7:"created";s:10:"1462269393";}i:10;a:4:{s:2:"id";s:2:"16";s:5:"title";s:10:"BELONGS_TO";s:7:"content";s:2458:"<p>从用户的角度来说,是一个用户对应多个帐号. 那么反过来说就是多个帐号对应一个用户.(关系参考主目录RelationTable)</p><p>配置:</p><pre class="brush:php;toolbar:false">&lt;?php
namespace&nbsp;Admin\Model;
use&nbsp;Think\Model\RelationModel;
Class&nbsp;AccountRelationModel&nbsp;extends&nbsp;RelationModel&nbsp;{
protected&nbsp;$tableName&nbsp;=&nbsp;&#39;account&#39;;
protected&nbsp;$_link&nbsp;=&nbsp;array(
&nbsp;&nbsp;&nbsp;&nbsp;&#39;user&#39;&nbsp;=&gt;&nbsp;array(
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;mapping_type&#39;&nbsp;=&gt;&nbsp;self::BELONGS_TO,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;mapping_name&#39;&nbsp;=&gt;&nbsp;&#39;user&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;class_name&#39;&nbsp;=&gt;&nbsp;&#39;user&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;foreign_key&#39;&nbsp;=&gt;&nbsp;&#39;user_id&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;mapping_field&#39;&nbsp;=&gt;&nbsp;&#39;*&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;&#39;parent_key&#39;&nbsp;=&gt;&nbsp;&#39;user_id&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&#39;condition&#39;&nbsp;=&gt;&nbsp;&#39;status=1&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;)
);
}</pre><p>SELECT</p><pre class="brush:php;toolbar:false">if(strtoupper($mappingClass)==strtoupper($this-&gt;name))&nbsp;{
&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;自引用关联&nbsp;获取父键名
&nbsp;&nbsp;&nbsp;&nbsp;$mappingFk&nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;&nbsp;!empty($val[&#39;parent_key&#39;])?&nbsp;$val[&#39;parent_key&#39;]&nbsp;:&nbsp;&#39;parent_id&#39;;
}else{
&nbsp;&nbsp;&nbsp;&nbsp;$mappingFk&nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;&nbsp;!empty($val[&#39;foreign_key&#39;])?$val[&#39;foreign_key&#39;]:strtolower($model-&gt;getModelName()).&#39;_id&#39;;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;&nbsp;关联外键
}
$fk&nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;$result[$mappingFk];
$mappingCondition&nbsp;.=&nbsp;&quot;&nbsp;AND&nbsp;{$model-&gt;getPk()}=&#39;{$fk}&#39;&quot;;&nbsp;&nbsp;//&nbsp;and&nbsp;id=&nbsp;$result[&#39;user_id&#39;];
$relationData&nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;$model-&gt;where($mappingCondition)-&gt;field($mappingFields)-&gt;find();
if&nbsp;(!empty($val[&#39;relation_deep&#39;])){
&nbsp;&nbsp;&nbsp;&nbsp;$model-&gt;getRelation($relationData,$val[&#39;relation_deep&#39;]);
}</pre><p><br/></p><p>没有相关操作的ADD,SAVE,DEL<br/></p>";s:7:"created";s:10:"1462265722";}i:11;a:4:{s:2:"id";s:2:"15";s:5:"title";s:8:"HAS_MANY";s:7:"content";s:6683:"<p style="white-space: normal;">配置:</p><pre class="brush:php;toolbar:false">&lt;?php
namespace&nbsp;Admin\Model;
use&nbsp;Think\Model\RelationModel;

Class&nbsp;UserRelationModel&nbsp;extends&nbsp;RelationModel&nbsp;{
&nbsp;&nbsp;&nbsp;&nbsp;protected&nbsp;$tableName&nbsp;=&nbsp;&#39;user&#39;;
&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;protected&nbsp;$_link&nbsp;=&nbsp;array(
&nbsp;&nbsp;&nbsp;&nbsp;&#39;account&#39;&nbsp;=&gt;&nbsp;array(
&nbsp;&nbsp;&nbsp;&nbsp;&#39;mapping_type&#39;&nbsp;=&gt;&nbsp;self::HAS_MANY,
&nbsp;&nbsp;&nbsp;&nbsp;&#39;mapping_name&#39;&nbsp;=&gt;&nbsp;&#39;account&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;&#39;class_name&#39;&nbsp;=&gt;&nbsp;&#39;account&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;&#39;mapping_field&#39;&nbsp;=&gt;&nbsp;&#39;*&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;&#39;mapping_key&#39;&nbsp;=&gt;&nbsp;&#39;id&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;&#39;foreign_key&#39;&nbsp;=&gt;&nbsp;&#39;user_id&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;//&#39;parent_key&#39;&nbsp;=&gt;&nbsp;&#39;user_id&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;//&#39;mapping_order&#39;&nbsp;=&gt;&nbsp;&#39;sort&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;//&#39;mapping_limit&#39;&nbsp;=&gt;&nbsp;&#39;10&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;//&#39;relation_deep&#39;&nbsp;=&gt;&nbsp;array(),
&nbsp;&nbsp;&nbsp;&nbsp;)
);
}</pre><p style="white-space: normal;">关联表操作</p><pre class="brush:php;toolbar:false">public&nbsp;function&nbsp;add_account(){
&nbsp;&nbsp;&nbsp;&nbsp;	$data&nbsp;=&nbsp;array(
&nbsp;&nbsp;&nbsp;&nbsp;		&#39;username&#39;&nbsp;=&gt;&nbsp;&nbsp;&#39;pzr&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;		&#39;account&#39;&nbsp;=&gt;&nbsp;array(
&nbsp;&nbsp;&nbsp;&nbsp;			array(
&nbsp;&nbsp;&nbsp;&nbsp;				&#39;user_id&#39;&nbsp;=&gt;&nbsp;5,
&nbsp;&nbsp;&nbsp;&nbsp;				&#39;account_no&#39;&nbsp;=&gt;&nbsp;5
&nbsp;&nbsp;&nbsp;&nbsp;			),
&nbsp;&nbsp;&nbsp;&nbsp;			array(
&nbsp;&nbsp;&nbsp;&nbsp;				&#39;user_id&#39;&nbsp;=&gt;&nbsp;5,
&nbsp;&nbsp;&nbsp;&nbsp;				&#39;account_no&#39;&nbsp;=&gt;&nbsp;55
&nbsp;&nbsp;&nbsp;&nbsp;			),
			)
&nbsp;&nbsp;&nbsp;&nbsp;		);
&nbsp;&nbsp;&nbsp;&nbsp;	$rest&nbsp;=&nbsp;D(&#39;UserRelation&#39;)-&gt;relation(&#39;account&#39;)-&gt;add(&nbsp;$data&nbsp;);
&nbsp;&nbsp;&nbsp;&nbsp;}
&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;public&nbsp;function&nbsp;save_account()&nbsp;{
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	$data&nbsp;=&nbsp;array(
&nbsp;&nbsp;&nbsp;&nbsp;		&#39;id&#39;&nbsp;=&gt;&nbsp;5,
&nbsp;&nbsp;&nbsp;&nbsp;		&#39;username&#39;&nbsp;=&gt;&nbsp;&nbsp;&#39;zy&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;		&#39;account&#39;&nbsp;=&gt;&nbsp;array(
&nbsp;&nbsp;&nbsp;&nbsp;			array(
&nbsp;&nbsp;&nbsp;&nbsp;				&#39;id&#39;&nbsp;=&gt;&nbsp;9,
&nbsp;&nbsp;&nbsp;&nbsp;				&#39;user_id&#39;&nbsp;=&gt;&nbsp;5,
&nbsp;&nbsp;&nbsp;&nbsp;				&#39;account_no&#39;&nbsp;=&gt;&nbsp;52
&nbsp;&nbsp;&nbsp;&nbsp;			),
&nbsp;&nbsp;&nbsp;&nbsp;			array(
&nbsp;&nbsp;&nbsp;&nbsp;				&#39;id&#39;&nbsp;=&gt;&nbsp;&#39;10&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;				&#39;user_id&#39;&nbsp;=&gt;&nbsp;5,
&nbsp;&nbsp;&nbsp;&nbsp;				&#39;account_no&#39;&nbsp;=&gt;&nbsp;552
&nbsp;&nbsp;&nbsp;&nbsp;			),
			)
&nbsp;&nbsp;&nbsp;&nbsp;		);
&nbsp;&nbsp;&nbsp;&nbsp;	$rest&nbsp;=&nbsp;D(&#39;UserRelation&#39;)-&gt;relation(true)-&gt;save(&nbsp;$data&nbsp;);
&nbsp;&nbsp;}
&nbsp;&nbsp;
&nbsp;&nbsp;public&nbsp;function&nbsp;delete_account(){
	D(&#39;UserRelation&#39;)-&gt;relation(&#39;account&#39;)-&gt;where(&nbsp;array(&#39;id&#39;=&gt;5)&nbsp;)-&gt;delete();
}</pre><p style="white-space: normal;"><br/></p><p style="white-space: normal;"><br/></p><p style="white-space: normal;"><br/></p><p style="white-space: normal;">SELECT</p><pre class="brush:php;toolbar:false">&nbsp;&nbsp;&nbsp;&nbsp;function&nbsp;getRelation(&amp;$result,$name=&#39;&#39;,$return=false)&nbsp;{}
&nbsp;&nbsp;&nbsp;&nbsp;$model&nbsp;=&nbsp;class_name;
&nbsp;&nbsp;&nbsp;&nbsp;$mappingFK&nbsp;=&nbsp;&#39;user_id&#39;;
&nbsp;&nbsp;&nbsp;&nbsp;$pk&nbsp;=&nbsp;$result[&nbsp;mapping_key&nbsp;];
&nbsp;&nbsp;&nbsp;&nbsp;$mappingCondition&nbsp;=&nbsp;&#39;where&nbsp;1=1&nbsp;and&nbsp;$mappingFK=$pk&#39;;
&nbsp;&nbsp;&nbsp;&nbsp;$relationData&nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;$model-&gt;where($mappingCondition)-&gt;field($mappingFields)-&gt;order($mappingOrder)-&gt;limit($mappingLimit)-&gt;select();</pre><p style="white-space: normal;">ADD<br/></p><pre class="brush:php;toolbar:false">function&nbsp;opRelation($opType,$data=&#39;&#39;,$name=&#39;&#39;)&nbsp;{}
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//$model&nbsp;=&nbsp;class_name;&nbsp;//test_account
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//$mappingData&nbsp;=&nbsp;$data[&#39;account&#39;];
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//$mappingFK&nbsp;=&nbsp;&#39;user_id&#39;;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//$pk&nbsp;=&nbsp;$result[&nbsp;mapping_key&nbsp;];&nbsp;//&nbsp;$result&nbsp;为user&nbsp;主表中查询的数据,mapping_key=id;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$model-&gt;startTrans();
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;foreach&nbsp;($mappingData&nbsp;as&nbsp;$val){
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$val[$mappingFk]&nbsp;&nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;&nbsp;$pk;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$result&nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;$model-&gt;add($val);&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}
&nbsp;&nbsp;&nbsp;&nbsp;$model-&gt;commit();</pre><p style="white-space: normal;">SAVE</p><pre class="brush:php;toolbar:false">//&nbsp;HAS_MANY&nbsp;更新数据的时候,必须建立一个主键,否则在修改的时候可能会因为找不到主键而执行插入操作.
$model-&gt;startTrans();
$pk&nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;$model-&gt;getPk();
foreach&nbsp;($mappingData&nbsp;as&nbsp;$vo){
&nbsp;if(isset($vo[$pk]))&nbsp;{//&nbsp;更新数据
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$mappingCondition&nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;&quot;$pk&nbsp;={$vo[$pk]}&quot;;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$result&nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;$model-&gt;where($mappingCondition)-&gt;save($vo);
&nbsp;&nbsp;&nbsp;}else{&nbsp;//&nbsp;新增数据
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$vo[$mappingFk]&nbsp;=&nbsp;&nbsp;$data[$mappingKey];
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$result&nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;$model-&gt;add($vo);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}
&nbsp;}&nbsp;
&nbsp;$model-&gt;commit();</pre><p style="white-space: normal;">DELETE</p><pre class="brush:php;toolbar:false">$result&nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;$model-&gt;where($mappingCondition)-&gt;delete();</pre><p><br/></p>";s:7:"created";s:10:"1462259605";}i:12;a:4:{s:2:"id";s:2:"14";s:5:"title";s:7:"HAS_ONE";s:7:"content";s:6661:"<p>配置:</p><pre class="brush:php;toolbar:false">&lt;?php
namespace&nbsp;Admin\Model;
use&nbsp;Think\Model\RelationModel;

Class&nbsp;UserRelationModel&nbsp;extends&nbsp;RelationModel&nbsp;{
&nbsp;&nbsp;&nbsp;&nbsp;protected&nbsp;$tableName&nbsp;=&nbsp;&#39;user&#39;;
&nbsp;&nbsp;&nbsp;&nbsp;protected&nbsp;$_link&nbsp;=&nbsp;array(
&nbsp;&nbsp;&nbsp;&nbsp;&#39;dept&#39;&nbsp;=&gt;&nbsp;array(
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;mapping_type&#39;&nbsp;=&gt;&nbsp;self::HAS_ONE,&nbsp;&nbsp;//关联表的对应关系
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;mapping_name&#39;&nbsp;=&gt;&nbsp;&#39;dept&#39;,&nbsp;//&nbsp;获取关联表查询结果的关键字,如果没有定义则取dept&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;class_name&#39;&nbsp;=&gt;&nbsp;&#39;dept&#39;,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;关联表的表名称,如果没有定义,那么默认为这个array&nbsp;的key&nbsp;即dept;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;mapping_field&#39;&nbsp;=&gt;&nbsp;&#39;*&#39;,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;关联表的查询字段
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;condition&#39;&nbsp;=&gt;&nbsp;&#39;status=1&#39;,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;关联表的查询条件
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;mapping_key&#39;&nbsp;=&gt;&nbsp;&#39;id&#39;,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//主表的关键字段
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&#39;parent_key&#39;&nbsp;=&gt;&nbsp;&#39;user_id&#39;,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;关联表的关联字段&nbsp;和&nbsp;foreign_key&nbsp;取一
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;foreign_key&#39;&nbsp;=&gt;&nbsp;&#39;user_id&#39;,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;关联表的关联字段&nbsp;和&nbsp;parent_id&nbsp;取一
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&#39;relation_deep&#39;&nbsp;=&gt;&nbsp;array();&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;递归调用getRelation&nbsp;函数,将关联表作为$result&nbsp;参数,&nbsp;relation_deep&nbsp;的参数作为name&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;),
);
}</pre><p>控制器代码:</p><pre class="brush:php;toolbar:false">&lt;?php
namespace&nbsp;Admin\Controller;
use&nbsp;Think\Controller;
class&nbsp;IndexController&nbsp;extends&nbsp;Controller&nbsp;{

&nbsp;&nbsp;&nbsp;&nbsp;public&nbsp;function&nbsp;index(){
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$rest&nbsp;=&nbsp;D(&#39;UserRelation&#39;)-&gt;relation(true)-&gt;select();
&nbsp;&nbsp;&nbsp;&nbsp;}
&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;public&nbsp;function&nbsp;add(){
&nbsp;&nbsp;&nbsp;&nbsp;$data&nbsp;=&nbsp;array(
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;username&#39;&nbsp;=&gt;&nbsp;&nbsp;&#39;pzr&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;dept&#39;&nbsp;=&gt;&nbsp;array(
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;user_id&#39;&nbsp;=&gt;&nbsp;4,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;dept_no&#39;&nbsp;=&gt;&nbsp;4
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
&nbsp;&nbsp;&nbsp;&nbsp;);
&nbsp;&nbsp;&nbsp;&nbsp;$rest&nbsp;=&nbsp;D(&#39;UserRelation&#39;)-&gt;relation(true)-&gt;add(&nbsp;$data&nbsp;);
&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;此处,存在一个问题,如果添加user&nbsp;的同时也添加dept&nbsp;,但是dept&nbsp;的user_id&nbsp;是以user&nbsp;的id&nbsp;作为value,
&nbsp;&nbsp;&nbsp;&nbsp;//但是此时并没有user&nbsp;的id.&nbsp;因此具体情况需要具体的方案.
&nbsp;&nbsp;&nbsp;&nbsp;}
&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;public&nbsp;function&nbsp;save(){
&nbsp;&nbsp;&nbsp;&nbsp;$data&nbsp;=&nbsp;array(
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;id&#39;&nbsp;=&gt;&nbsp;4,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;username&#39;&nbsp;=&gt;&nbsp;&#39;zy&#39;,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;dept&#39;&nbsp;=&gt;&nbsp;array(
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;user_id&#39;&nbsp;=&gt;&nbsp;4,
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#39;dept_no&#39;&nbsp;=&gt;&nbsp;40
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
&nbsp;&nbsp;&nbsp;&nbsp;);
&nbsp;&nbsp;&nbsp;&nbsp;$rest&nbsp;=&nbsp;D(&#39;UserRelation&#39;)-&gt;relation(true)-&gt;save(&nbsp;$data&nbsp;);
&nbsp;&nbsp;&nbsp;&nbsp;}
&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;Public&nbsp;function&nbsp;delete()&nbsp;{
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$rest&nbsp;=&nbsp;D(&#39;UserRelation&#39;)-&gt;relation(true)-&gt;where(&nbsp;array(&#39;id&#39;=&gt;4)&nbsp;)-&gt;delete(&nbsp;&nbsp;);
&nbsp;&nbsp;&nbsp;&nbsp;}
}</pre><p>ADD</p><pre class="brush:php;toolbar:false">function&nbsp;opRelation(&nbsp;$opType,$data=&#39;&#39;,$name=&#39;&#39;&nbsp;){}

$mappingData&nbsp;=&nbsp;$data[&nbsp;mapping_name&nbsp;];&nbsp;&nbsp;//&nbsp;$data[&#39;dept&#39;];
$result&nbsp;=&nbsp;D(&nbsp;class_name&nbsp;)-&gt;add(&nbsp;$mappingData&nbsp;);</pre><p>SAVE<br/></p><pre class="brush:php;toolbar:false">//$data&nbsp;是主表user&nbsp;的&nbsp;查询结果
$model&nbsp;=&nbsp;class_name;
$mappingFK&nbsp;=&nbsp;foreign_key&nbsp;=&nbsp;user_id;
$pk&nbsp;=&nbsp;$data[&nbsp;mapping_key&nbsp;];&nbsp;//&nbsp;mapping_key&nbsp;=&nbsp;id;
$mappingCondition&nbsp;=&nbsp;where&nbsp;1=1&nbsp;and&nbsp;$mappingFK=$pk;&nbsp;
$mappingData&nbsp;=&nbsp;$data[&nbsp;&#39;dept&#39;&nbsp;];
$result&nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;$model-&gt;where($mappingCondition)-&gt;save($mappingData);</pre><p>DELETE<br/></p><pre class="brush:php;toolbar:false">$model&nbsp;=&nbsp;class_name;
$mappingFK&nbsp;=&nbsp;foreign_key&nbsp;=&nbsp;user_id;
mapping_key&nbsp;=&nbsp;id;
$pk&nbsp;=&nbsp;data[&nbsp;mapping_key&nbsp;];
$mappingCondition&nbsp;=&nbsp;condition?condition:$mappingFK=$pk;
$result&nbsp;&nbsp;&nbsp;=&nbsp;&nbsp;$model-&gt;where($mappingCondition)-&gt;delete();</pre><p><br/></p>";s:7:"created";s:10:"1462257543";}}
?>