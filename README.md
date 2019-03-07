### 这是基于 laravel5.7 开发的后台管理系统

----

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

### 资源控制器处理的动作 
#### 我修改了资源控制器的处理动作
#### 以 posts 为例 {post} 改为 {id} 
#### 因为我加入了全局约束

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

```php
//一旦模式被定义，将会自动应用到所有包含该参数名的路由中：
Route::get('user/{id}', function ($id) {
    // 只有当 {id} 是数字时才会被调用
});

//除此之外，该模式还会被应用到诸如下面这些路由参数上：

Route::get('post/{id}', function ($id) {
    // 只有当 {id} 是数字时才会被调用
});

Route::get('product/{id}', function ($id) {
    // 只有当 {id} 是数字时才会被调用
});

```


| 请求方式       | URI路径  |  控制器方法  | 路由名称 |
| :----:    | :----:  | :----:  | :----:  |
| GET    | /posts |  index    | posts.index |
| GET        |   /posts_create	   |  create   | posts.create |
| POST        |  /posts_create	  |  store  | posts.store |
| GET    | /posts_show_{id} |   show   | posts.show |
| GET        |   /posts_edit_{id}   |   edit   | posts.edit |
| PUT/PATCH        |    /posts_edit_{id}  |  update  | posts.update |
| DELETE        |    /posts/{id}  |  destroy  | posts.destroy |


###### 这几天还在完善...￣□￣｜｜
###### 预计好的话下周一就可以了

#####  [Laravel 学院](https://laravelacademy.org/ "Laravel 学院") [Xadmin](http://x.xuebingsi.com/ "Xadmin") [Layui](https://www.layui.com "Layui") ...
