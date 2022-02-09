package model

import (
	"database/sql/driver"
	"time"

	"gorm.io/gorm"
)

//CustomTime 自定义时间
type CustomTime time.Time

//TimeFormat 时间格式
const TimeFormat = "2006-01-02 15:04:05"

type BasicModel struct {
	Id        uint64         `json:"id"  gorm:"column:id;type:bigint(20) unsigned;primary_key;AUTO_INCREMENT"`
	UpdatedAt *CustomTime    `json:"createdAt" gorm:"column:updated_at;type:datetime"`
	CreatedAt *CustomTime    `json:"updatedAt" gorm:"column:created_at;type:datetime"`
	DeletedAt gorm.DeletedAt `json:"deletedAt" gorm:"column:deleted_at;type:datetime"`
}

func (t *CustomTime) UnmarshalJSON(data []byte) (err error) {
	// 空值不进行解析
	if len(data) == 2 {
		*t = CustomTime(time.Time{})
		return
	}

	// 指定解析的格式
	now, err := time.Parse(`"`+TimeFormat+`"`, string(data))
	*t = CustomTime(now)
	return
}

func (t CustomTime) MarshalJSON() ([]byte, error) {
	b := make([]byte, 0, len(TimeFormat)+2)
	b = append(b, '"')
	b = time.Time(t).AppendFormat(b, TimeFormat)
	b = append(b, '"')
	return b, nil
}

// Value 写入 mysql 时调用
func (t CustomTime) Value() (driver.Value, error) {
	// 0001-01-01 00:00:00 属于空值，遇到空值解析成 null 即可
	if t.String() == "0001-01-01 00:00:00" {
		return nil, nil
	}
	return []byte(time.Time(t).Format(TimeFormat)), nil
}

// Scan 检出 mysql 时调用
func (t *CustomTime) Scan(v interface{}) error {
	// mysql 内部日期的格式可能是 2006-01-02 15:04:05 +0800 CST 格式，所以检出的时候还需要进行一次格式化
	tTime, _ := time.Parse("2006-01-02 15:04:05 +0800 CST", v.(time.Time).String())
	*t = CustomTime(tTime)
	return nil
}

// 用于 fmt.Println 和后续验证场景
func (t CustomTime) String() string {
	return time.Time(t).Format(TimeFormat)
}

//GetSelfLocalTime 获取自定义的时间
func (CustomTime) GetSelfLocalTime(selfTime time.Time) string {
	return CustomTime(selfTime).String()
}
