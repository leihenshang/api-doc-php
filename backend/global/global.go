package global

import (
	"fastduck/apidoc/config"
	"fmt"
	"path"
	"strconv"

	"github.com/go-redis/redis"
	"github.com/spf13/viper"
	"go.uber.org/zap"
	"gorm.io/driver/mysql"
	"gorm.io/gorm"
)

var (
	CONFIG   *config.Config
	VIPER    *viper.Viper
	DB       *gorm.DB
	ZAP      *zap.Logger
	ZAPSUGAR *zap.SugaredLogger
	REDIS    *redis.Client
)

func init() {
	fmt.Println("执行了一次global init")
	initConf()
	fmt.Println("初始化配置完成")
	initLog()
	fmt.Println("初始化日志完成")

	if CONFIG.Redis.Enabled {
		initRedis()
		fmt.Println("初始化redis完成")
	}

	initMysql()
	fmt.Println("初始化mysql完成")
}

func initConf() {
	//读取配置
	configFile := "config.yaml"
	fmt.Println("读取配置文件", path.Join(".", configFile))

	VIPER = viper.New()
	VIPER.SetConfigFile(configFile)
	VIPER.AddConfigPath(".")
	err := VIPER.ReadInConfig()
	if err != nil {
		panic(fmt.Errorf("Fatal error config file: %w \n", err))
	}

	err = VIPER.Unmarshal(&CONFIG)
	if err != nil {
		panic("解析app配置失败")
	}
}

func initMysql() {
	mysqlPort := strconv.Itoa(CONFIG.Mysql.Port)
	var err error
	//初始化数据库
	dsn := CONFIG.Mysql.User + ":" + CONFIG.Mysql.Password + "@tcp(" + CONFIG.Mysql.Host + ":" + mysqlPort + ")/" +
		CONFIG.Mysql.DbName + "?charset=" + CONFIG.Mysql.Charset + "&parseTime=True&loc=Local"
	DB, err = gorm.Open(mysql.Open(dsn), &gorm.Config{})
	if err != nil {
		fmt.Println(err.Error())
		panic("初始化mysql失败")
	}

}

func initLog() {
	initLogger()
}

func initRedis() {
	//初始化redis
	REDIS = redis.NewClient(&redis.Options{
		Addr:     fmt.Sprintf("%s:%d", CONFIG.Redis.Host, CONFIG.Redis.Port),
		Password: CONFIG.Redis.Password, // no password set
		DB:       CONFIG.Redis.DbId,     // use default DB)
	})

	if REDIS.Ping().Err() != nil {
		panic("链接redis失败")
	}
}
