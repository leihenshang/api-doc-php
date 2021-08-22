package utils

import "golang.org/x/crypto/bcrypt"

//PasswordEncrypt 对密码使用bcrypt进行加密，返回一个加密字符串
func PasswordEncrypt(password string) (encrypted string, err error) {
	hash, err := bcrypt.GenerateFromPassword([]byte(password), bcrypt.DefaultCost)
	if err != nil {
		return "", err
	}

	return string(hash), err
}

//PasswordCompare 对比加密后的hash 和 用户输入的密码是否匹配
//true 为正确，false 为密码不正确
func PasswordCompare(encryptedPassword string, inputPassword string) bool {
	if err := bcrypt.CompareHashAndPassword([]byte(encryptedPassword), []byte(inputPassword)); err == nil {
		return true
	}

	return false
}
