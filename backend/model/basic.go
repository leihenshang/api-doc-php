package model

import (
	"database/sql/driver"
	"time"

	"gorm.io/gorm"
)

//LocalTime 自定义时间
type LocalTime time.Time

//TimeFormat 时间格式
const TimeFormat = "2006-01-02 15:04:05"

type BasicModel struct {
	Id         uint64         `json:"id"  gorm:"column:id;type:bigint(20) unsigned;primary_key;AUTO_INCREMENT"`
	UpdatedAt  *LocalTime     `json:"createTime" gorm:"column:updated_at;type:datetime"`
	CreatedAt  *LocalTime     `json:"updateTime" gorm:"column:created_at;type:datetime"`
	DeleteTime gorm.DeletedAt `json:"deleteTime" gorm:"column:deleted_at;type:datetime"`
}

func (t *LocalTime) UnmarshalJSON(data []byte) (err error) {
	// 空值不进行解析
	if len(data) == 2 {
		*t = LocalTime(time.Time{})
		return
	}

	// 指定解析的格式
	now, err := time.Parse(`"`+TimeFormat+`"`, string(data))
	*t = LocalTime(now)
	return
}

func (t LocalTime) MarshalJSON() ([]byte, error) {
	b := make([]byte, 0, len(TimeFormat)+2)
	b = append(b, '"')
	b = time.Time(t).AppendFormat(b, TimeFormat)
	b = append(b, '"')
	return b, nil
}

// Value 写入 mysql 时调用
func (t LocalTime) Value() (driver.Value, error) {
	// 0001-01-01 00:00:00 属于空值，遇到空值解析成 null 即可
	if t.String() == "0001-01-01 00:00:00" {
		return nil, nil
	}
	return []byte(time.Time(t).Format(TimeFormat)), nil
}

// Scan 检出 mysql 时调用
func (t *LocalTime) Scan(v interface{}) error {
	// mysql 内部日期的格式可能是 2006-01-02 15:04:05 +0800 CST 格式，所以检出的时候还需要进行一次格式化
	tTime, _ := time.Parse("2006-01-02 15:04:05 +0800 CST", v.(time.Time).String())
	*t = LocalTime(tTime)
	return nil
}

// 用于 fmt.Println 和后续验证场景
func (t LocalTime) String() string {
	return time.Time(t).Format(TimeFormat)
}

//GetSelfLocalTime 获取自定义的时间
func (LocalTime) GetSelfLocalTime(selfTime time.Time) string {
	return LocalTime(selfTime).String()
}
