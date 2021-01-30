# 安装方法

`Nginx`请设置如下`伪静态` `Apache`无需配置 运行目录`默认`即可
```
    if (!-e $request_filename) {
        rewrite ^(.*)$ /index.php$1 last;
    }
```

将程序上传至网站根目录,访问`域名/install`进行安装操作

默认账号密码：`admin`和`admin`

后台地址：`域名/index.php/admin/Home/show`
代理地址：`域名/index.php/agent/Home/show`
