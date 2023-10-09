## 安装方法

`Nginx`请设置如下伪静态 `Apache`无需配置,使用目录默认文件
```
    if (!-e $request_filename) {
        rewrite ^(.*)$ /index.php$1 last;
    }
```

将程序上传至网站根目录,访问`域名/install`进行安装操作，安装过程中如需KEY请随便输入任何字符即可。

默认账号密码：`admin`和`admin`

后台地址：`域名/admin/Home/show`
代理地址：`域名/agent/Home/show`

## 其他

由于原作者已经放弃对冰心网络验证的更新,本仓库的全部文件除解密代码外无任何更改。
