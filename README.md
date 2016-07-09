# monolog-web
Android App ‘独白故事’的服务器端，就像承诺的那样，开源了。**此项目可能不会再进行维护**。

通过这个项目，你可以了解到基于LBS的社交app的服务器端开发所需的任何基本常识性问题。

修改一下KEYS就可以部署。代码中有大量注释，阅读起来问题不大。

#安装

 搜索[YOURS]，已注明TODO
 
        0.创建一个laravel4.2的环境,我没有上传vendor。
        1.app\huijimuhe\Qiniu\Config.php 修改为你的七牛账号
        2.app\huijimuhe\Support\Easemob.class.php 修改为你的easemob账号
        3.app\config\database.php 修改为你的数据库连接
        4.public\js\plugins\qiniu\qiniu.progress2.js 修改为你的七牛地址
        5.环境部署完成访问install创建用户
        
#感谢

架子基于laravel4.2

数据库基于mongodb

借鉴了[phphub](https://github.com/summerblue/phphub)及[laravel.io](https://github.com/LaravelIO/laravel.io)的开发思想

界面基于[AdminLTE](https://github.com/almasaeed2010/AdminLTE)

图片管理基于七牛云

IM基于环信

#Android
[here](https://github.com/huijimuhe/monolog)

#文章

开发过程中写了点文章记录总结,最后一篇图好玩

[WDCP安装并配置php5.4和mongodb](http://www.cnblogs.com/matoo/p/4873377.html)

[用一个下午从零开始搭建一个基础lbs查询服务](http://www.cnblogs.com/matoo/p/4807782.html)

[人家为撩妹就鼓捣个网页，我做了个约炮APP（已开源）](http://www.cnblogs.com/matoo/p/5446763.html)

#交流

QQ群：533838427

#LICENSE

MIT