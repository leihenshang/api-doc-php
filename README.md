# API-DOC-GO
## 概览
api-doc 是一个轻量的api接口文档和项目文档记录程序。支持markdown文档,方便了前后端开发人员对于接口文档和项目文档的查看、使用。


## 鸣谢


 <img src="./jetbrains.png" width = "200" height = "218.6" alt="图片名称" align=center />


 感谢[ JetBrains ](https://www.jetbrains.com/?from=apiDoc)提供的IDE支持

## 文件结构
该项目为前后台分离项目
- front 前端
- backend 后端

## 技术栈
  - 后端采用 `golang` 的 `gin` 框架提供接口支持
  - 前端采用 vue2.0
  - 数据库使用 mysql5.7
## 运行
1. 进入front（前端)文件夹,首先执行yarn install安装依赖,接着执行yarn serve
2. 进入backend（后端)文件夹,执行 go run main

## 数据库初始化
- 在mysql中执行 sql/mysql.sql 
