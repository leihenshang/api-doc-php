package config

type Redis struct {
	Enable  bool
	Host     string
	Port     int
	User     string
	Password string
	DbId     int
}
