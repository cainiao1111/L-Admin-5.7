-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2019-03-12 22:23:00
-- 服务器版本： 10.3.8-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `database_name`
--

-- --------------------------------------------------------

--
-- 表的结构 `table_name_a_admin`
--

CREATE TABLE `table_name_a_admin` (
  `id` int(11) NOT NULL,
  `account` char(16) DEFAULT NULL COMMENT '账户',
  `password` char(32) DEFAULT NULL COMMENT '密码',
  `state` char(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `md_token` char(16) DEFAULT NULL COMMENT '用户验证令牌',
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `super_model` char(1) NOT NULL DEFAULT '0' COMMENT '是否可以进入超级模式0不能 1 可以',
  `super_pass` char(32) DEFAULT NULL COMMENT '超级管理员密码',
  `md_super_token` char(17) DEFAULT NULL COMMENT '超级验证令牌',
  `username` char(10) NOT NULL DEFAULT '匿名' COMMENT '管理员姓名',
  `nickname` char(10) NOT NULL DEFAULT '匿名' COMMENT '管理员昵称',
  `none` char(1) NOT NULL DEFAULT '1' COMMENT '是否显示',
  `r_id` int(11) NOT NULL DEFAULT 0 COMMENT '角色id'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='管理员表';

--
-- 转存表中的数据 `table_name_a_admin`
--

INSERT INTO `table_name_a_admin` (`id`, `account`, `password`, `state`, `md_token`, `updated_at`, `created_at`, `super_model`, `super_pass`, `md_super_token`, `username`, `nickname`, `none`, `r_id`) VALUES
(1, 'root', 'c4a5c153d419b6f28a950e51d3f90ffb', '1', '3305c87b73969cc0', '2019-03-12 21:51:04', '1993-09-24 00:00:00', '1', '0a6dae36c9111d1e811e75c7b3f63577', '88725c87b948b2827', '匿名', '匿名', '0', 0);

-- --------------------------------------------------------

--
-- 表的结构 `table_name_a_permissions`
--

CREATE TABLE `table_name_a_permissions` (
  `id` int(11) NOT NULL,
  `state` char(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `name` char(20) DEFAULT NULL COMMENT '控制器中文名',
  `e_name` char(20) DEFAULT NULL COMMENT '控制器英文名',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `content` varchar(1000) NOT NULL DEFAULT '{}' COMMENT '拥有的方法和内容',
  `none` char(1) NOT NULL DEFAULT '1' COMMENT '是否显示',
  `type` enum('1','2','3') NOT NULL DEFAULT '1' COMMENT '类型 1 组 2 控制器 3 方法',
  `fid` smallint(6) NOT NULL DEFAULT 0 COMMENT '级别',
  `weight` smallint(6) NOT NULL DEFAULT 0,
  `account` char(50) DEFAULT NULL COMMENT '描述',
  `icon` char(30) DEFAULT NULL,
  `api` char(1) NOT NULL DEFAULT '0' COMMENT '是否是API',
  `req_type` char(8) NOT NULL DEFAULT 'get' COMMENT '请求类型'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `table_name_a_permissions`
--

INSERT INTO `table_name_a_permissions` (`id`, `state`, `name`, `e_name`, `created_at`, `updated_at`, `content`, `none`, `type`, `fid`, `weight`, `account`, `icon`, `api`, `req_type`) VALUES
(1, '1', '列表', 'index', '2019-03-03 16:36:46', '2019-03-03 16:40:15', '[]', '1', '3', 0, 0, '列表展示', 'layui-icon-rate-half', '0', 'get'),
(2, '1', '添加', 'create', '2019-03-03 16:39:20', '2019-03-03 16:40:21', '[]', '1', '3', 0, 0, '添加表单', 'layui-icon-rate-half', '0', 'get'),
(3, '1', 'store', 'store', '2019-03-03 16:39:49', '2019-03-03 16:39:49', '[]', '0', '3', 0, 0, '保存', 'layui-icon-rate-half', '0', 'post'),
(4, '1', '查看', 'show', '2019-03-03 16:41:01', '2019-03-03 16:41:21', '[]', '0', '3', 0, 0, '内容展示', 'layui-icon-rate-half', '0', 'get'),
(5, '1', '编辑', 'edit', '2019-03-03 16:42:15', '2019-03-03 16:42:15', '[]', '0', '3', 0, 0, 'edit', 'layui-icon-rate-half', '0', 'get'),
(6, '1', 'update', 'update', '2019-03-03 16:42:38', '2019-03-03 16:42:38', '[]', '0', '3', 0, 0, 'update', 'layui-icon-rate-half', '0', 'put'),
(7, '1', 'destroy', 'destroy', '2019-03-03 16:43:03', '2019-03-03 16:43:03', '[]', '0', '3', 0, 0, 'destroy', 'layui-icon-rate-half', '0', 'delete'),
(8, '1', '后台管理', 'Admin', '2019-03-03 16:45:43', '2019-03-09 19:59:20', '[]', '1', '1', 0, 0, '后台管理', 'layui-icon-template', '0', 'get'),
(9, '1', '角色管理', 'Roles', '2019-03-03 16:47:38', '2019-03-09 14:26:54', '[{\"k\":\"\\u89d2\\u8272\\u5217\\u8868\",\"v\":\"index\",\"s\":\"on\",\"req\":\"get\"},{\"k\":\"\\u6dfb\\u52a0\\u89d2\\u8272\",\"v\":\"create\",\"s\":\"on\",\"req\":\"get\"},{\"k\":\"store\",\"v\":\"store\",\"req\":\"post\"},{\"k\":\"\\u67e5\\u770b\",\"v\":\"show\",\"req\":\"get\"},{\"k\":\"\\u7f16\\u8f91\",\"v\":\"edit\",\"req\":\"get\"},{\"k\":\"update\",\"v\":\"update\",\"req\":\"put\"},{\"k\":\"destroy\",\"v\":\"destroy\",\"req\":\"delete\"},{\"k\":\"state\",\"v\":\"state\",\"api\":\"on\",\"id\":\"on\",\"req\":\"put\"}]', '1', '2', 8, 0, '角色管理', 'layui-icon-star', '0', 'get'),
(10, '1', '管理员管理', 'Aadmin', '2019-03-03 17:00:38', '2019-03-03 18:09:26', '[{\"k\":\"\\u7ba1\\u7406\\u5458\\u5217\\u8868\",\"v\":\"index\",\"s\":\"on\",\"req\":\"get\"},{\"k\":\"\\u6dfb\\u52a0\\u7ba1\\u7406\\u5458\",\"v\":\"create\",\"s\":\"on\",\"req\":\"get\"},{\"k\":\"store\",\"v\":\"store\",\"req\":\"post\"},{\"k\":\"\\u67e5\\u770b\",\"v\":\"show\",\"req\":\"get\"},{\"k\":\"\\u7f16\\u8f91\",\"v\":\"edit\",\"req\":\"get\"},{\"k\":\"update\",\"v\":\"update\",\"req\":\"put\"},{\"k\":\"destroy\",\"v\":\"destroy\",\"req\":\"delete\"},{\"k\":\"state\",\"v\":\"state\",\"api\":\"on\",\"id\":\"on\",\"req\":\"put\"},{\"k\":\"resetpass\",\"v\":\"resetpass\",\"api\":\"on\",\"id\":\"on\",\"req\":\"put\"}]', '1', '2', 8, 1, '管理员管理', 'layui-icon-username', '0', 'get'),
(11, '1', 'Demo', 'Demo', '2019-03-07 22:37:12', '2019-03-10 17:15:29', '[{\"k\":\"destroy\",\"v\":\"destroy\",\"req\":\"delete\"},{\"k\":\"update\",\"v\":\"update\",\"req\":\"put\"},{\"k\":\"\\u7f16\\u8f91\",\"v\":\"edit\",\"req\":\"get\"},{\"k\":\"\\u67e5\\u770b\",\"v\":\"show\",\"req\":\"get\"},{\"k\":\"store\",\"v\":\"store\",\"req\":\"post\"},{\"k\":\"\\u5217\\u8868\",\"v\":\"index\",\"s\":\"on\",\"req\":\"get\"},{\"k\":\"\\u6dfb\\u52a0\",\"v\":\"create\",\"s\":\"on\",\"req\":\"get\"},{\"k\":\"state\",\"v\":\"state\",\"api\":\"on\",\"id\":\"on\",\"req\":\"put\"},{\"k\":\"orderby\",\"v\":\"orderby\",\"api\":\"on\",\"id\":\"on\",\"req\":\"put\"},{\"k\":\"deletedatas\",\"v\":\"deletedatas\",\"api\":\"on\",\"hash\":\"on\",\"req\":\"put\"}]', '1', '2', 0, 0, 'Demo', 'layui-icon-tips', '0', 'get');

-- --------------------------------------------------------

--
-- 表的结构 `table_name_a_role`
--

CREATE TABLE `table_name_a_role` (
  `id` int(11) NOT NULL,
  `name` char(50) DEFAULT NULL,
  `account` char(255) DEFAULT NULL,
  `state` char(1) NOT NULL DEFAULT '0',
  `convenient_access` varchar(5000) NOT NULL DEFAULT '[]',
  `convenient_token` varchar(5000) NOT NULL DEFAULT '[]' COMMENT '权限验证'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='角色表';

-- --------------------------------------------------------

--
-- 表的结构 `table_name_demo`
--

CREATE TABLE `table_name_demo` (
  `id` int(11) NOT NULL,
  `name` char(255) DEFAULT NULL,
  `state` char(1) NOT NULL DEFAULT '0',
  `order_by` smallint(6) NOT NULL DEFAULT 0,
  `img` char(120) DEFAULT NULL,
  `text` text DEFAULT NULL,
  `account` char(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `table_name_a_admin`
--
ALTER TABLE `table_name_a_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_name_a_permissions`
--
ALTER TABLE `table_name_a_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_name_a_role`
--
ALTER TABLE `table_name_a_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_name_demo`
--
ALTER TABLE `table_name_demo`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `table_name_a_admin`
--
ALTER TABLE `table_name_a_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 使用表AUTO_INCREMENT `table_name_a_permissions`
--
ALTER TABLE `table_name_a_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- 使用表AUTO_INCREMENT `table_name_a_role`
--
ALTER TABLE `table_name_a_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `table_name_demo`
--
ALTER TABLE `table_name_demo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
