# fast-duck/apiDoc golang 版

## 概述

这个项目的目的是使用 `golang` 替换php提供的api，用于练习web项目框架封装。
采用前后端分离的方式，这里提供了api接口。

## 使用到的库

- http服务器 gin
- orm提供方 gorm
- 配置文件
- 日志处理
- 缓存处理

## 目录说明

```
root
    app     -项目代码
    config  -配置文件
    runtime -运行时的产生的文件
    sql     -数据库建立的sql
    config.json -配置文件
    config.json.example -配置文件示例文件
```

## 热重载

`可以使用air提高开发效率，它可以在你修改了项目文件时自动帮你重启项目。` 

### 要点
 - 首先要在开发环境中安装air
 - 将 `air_example.toml` 改为 `.air.toml`
 - 然后 执行  `air`  或 `air -c .air.toml`

[查看air使用说明](https://github.com/cosmtrek/air)

### 计划
  - [x] 加入 `gin` http框架,创建main.go
  - [x] 添加热重载,使用`air` [github地址](https://github.com/cosmtrek/air)
  - [x] 添加配置解析库 `viper` [github地址](https://github.com/spf13/viper) 
  - [ ] 添加日志库 `zap` [github地址](https://github.com/uber-go/zap)
  - [x] 添加orm库 `gorm` [github地址](https://github.com/go-gorm/gorm) 
  - [x] 添加redis库 `go-redis` [github地址](https://github.com/go-redis/redis)
