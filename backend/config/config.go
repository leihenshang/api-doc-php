package config

const ConfigFile = "config.toml"

type Config struct {
	App   App
	Mysql Mysql
	Redis Redis
	Log   Log
}
