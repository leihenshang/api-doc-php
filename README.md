
#### 介绍
restful风格api记录工具，方便前后台协作,并支持文档记录功能，适合小型开发团队协作.

#### 软件结构
- 使用php作为后端程序(Yii2框架)
- 使用vue作为前台开发框架
- 该项目为前后台分离项目
    - front中为前台
    - backend为后台api


#### 预览使用方法
1. 进入front（前端)文件夹,执行npm install,执行npm run serve
2. 进入backend（后端)文件夹,执行composer install,执行php yii serve --port=1000


#### 数据库初始化
- database/mysql.sql 

# 仓库地址
- github:https://github.com/leihenshang/apiDoc
- gitee:https://gitee.com/leihenshang/apiDoc

## 初始化超级管理员

在backend目录下执行  php yii init/user
超级管理员忘记密码 php yii init/user true


#### 鸣谢列表
- 感谢 `JetBrains` 提供的免费IDE支持！
- 相关: [JetBrains](https://www.jetbrains.com/?from=apiDoc)

### 项目图片
![登录](https://images.gitee.com/uploads/images/2020/0531/222925_7c0239aa_1719135.png "start.png")
![api概述](https://images.gitee.com/uploads/images/2020/0531/222953_cf831496_1719135.png "detail.png")
![api详情](https://images.gitee.com/uploads/images/2020/0531/223008_68e4cfa8_1719135.png "api-detail.png")
![项目文档](https://images.gitee.com/uploads/images/2020/0531/223021_69ae4f2e_1719135.png "doc.png")
![api列表](https://images.gitee.com/uploads/images/2020/0531/223047_4d5916ce_1719135.png "api-list.png")

