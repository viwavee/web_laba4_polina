<?php
class UserInfo {
    public static function getInfo(): array {
        return [
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'неизвестно',
            'browser' => $_SERVER['HTTP_USER_AGENT'] ?? 'неизвестно',
            'time' => date('Y-m-d H:i:s')
        ];
    }
}
