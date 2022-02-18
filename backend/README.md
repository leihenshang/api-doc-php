# mine/doc （我的文档）

## 概述
我的文档的后端api部分。

## 使用到的库

- http服务器 gin
- orm提供方 gorm
- 配置文件
- 日志处理
- 缓存处理

## 目录说明

```
root
  admin - 管理员
      app     -项目代码
      config  -配置文件
      log -运行时的产生的文件
      sql     -数据库建立的sql
      config.example.toml -配置文件示例文件
  user - 用户
      app     -项目代码
      config  -配置文件
      log -运行时的产生的文件
      config.example.toml -配置文件示例文件
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
  - [x] 添加日志库 `zap` [github地址](https://github.com/uber-go/zap)
  - [x] 添加orm库 `gorm` [github地址](https://github.com/go-gorm/gorm) 
  - [x] 添加redis库 `go-redis` [github地址](https://github.com/go-redis/redis)

### 其他
```sh
docker run  --rm \
    -w "/app" \
    --mount type=bind,source="D:\my-project\api-doc-go\backend",target=/app  \
    -p 2021:2021  \
    golang:alpine \
    sh -c  "go env -w GO111MODULE=on && go env -w GOPROXY=https://goproxy.cn,direct && cd /app/user && go run main.go"
```

使用air热重载

```sh
docker run -it  --rm  -w "/app/user"    -e "GO111MODULE=on"     -e "GOPROXY=https://goproxy.cn,direct"     --mount type=bind,source="D:\my-project\api-doc-go\backend",target=/app      -p 2021:2021       cosmtrek/air     -c /app/user/.air.toml
```

