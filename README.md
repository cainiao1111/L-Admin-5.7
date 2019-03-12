### 这是基于 laravel5.7 开发的后台管理系统

----------

> 服务器要求

 - PHP >= 7.1.3
 - PHP OpenSSL 扩展
 - PHP PDO 扩展
 - PHP Mbstring 扩展
 - PHP Tokenizer 扩展
 - PHP XML 扩展
 - PHP Ctype 扩展
 - PHP JSON 扩展
> 简介
 - 超级管理(后台管理员拥有两种)
 - - 管理员管理
 - - 角色管理
 - - 权限管理
 - - 文件管理
 - - 系统管理
 - 后台管理
 - - 管理员管理
 - - 角色管理
 
----------
### 主要说下系统管理

#### 初始账号

账号:root 密码:root 超级管理员密码:root 

#### Artisan 控制台
因为本人比较懒,喜欢点一下就好 

----------

#### 后台路由
因为我在路由文件中是读取数据循环出的路由,所以我觉得上线时候需要替换,写起来比较费劲,所以直接生成好,复制粘贴就行

----------
#### 系统日志
作为一个系统,没有个日志查看怎么行呢,所以我用 *[laravel-log-viewer](https://github.com/rap2hpoutre/laravel-log-viewer "laravel-log-viewer")*
然后就是文件的增删改查我都加入了日志记录

----------
#### 文件管理

我只是简单的管理了一下 public 磁盘的图片*[photoviewer](https://nzbin.github.io/photoviewer/"photoviewer")* 

----------

#### 富文本编辑器
感觉还是很不错的
[tinymce](https://www.tiny.cloud/"tinymce") 

----------
#### 数据迁移

Laravel的数据迁移我没有使用，直接导出成sql 文件 [database_name.sql] 在根目录下

----------
### 资源控制器处理的动作 
#### 我修改了资源控制器的处理动作 [位置: \vendor\laravel\framework\src\Illuminate\Routing\ResourceRegistrar.php ]
#### 以 posts 为例 


| 请求方式       | URI路径  |  控制器方法  | 路由名称 |
| :----:    | :----:  | :----:  | :----:  |
| GET    | /posts |  index    | posts.index |
| GET        |   /posts_create	   |  create   | posts.create |
| POST        |  /posts_create	  |  store  | posts.store |
| GET    | /posts_show_{id} |   show   | posts.show |
| GET        |   /posts_edit_{id}   |   edit   | posts.edit |
| PUT/PATCH        |    /posts_edit_{id}  |  update  | posts.update |
| DELETE        |    /posts/{id}  |  destroy  | posts.destroy |

#### 因为我加入了全局约束 [位置: \app\Providers\RouteServiceProvider.php]

```php
/**
 * 定义路由模型绑定，模式过滤器等
 *
 * @param  \Illuminate\Routing\Router  $router
 * @return void
 */
public function boot()
{
    Route::pattern('id', '[0-9]+');
    parent::boot();
}
```


#####  [Laravel 学院](https://laravelacademy.org/ "Laravel 学院") [Laravel](https://github.com/laravel/laravel "Laravel")  [Xadmin](http://x.xuebingsi.com/ "Xadmin") [Layui](https://www.layui.com "Layui")  [laravel-log-viewer](https://github.com/rap2hpoutre/laravel-log-viewer "laravel-log-viewer") [photoviewer](https://nzbin.github.io/photoviewer/"photoviewer") [tinymce](https://www.tiny.cloud/"tinymce") ...

