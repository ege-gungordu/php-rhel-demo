# RHEL PHPインストール手順
```
sudo dnf install https://dl.fedoraproject.org/pub/epel/epel-release-latest-$(rpm -E %rhel).noarch.rpm -y
sudo dnf install https://rpms.remirepo.net/enterprise/remi-release-$(rpm -E %rhel).rpm -y
sudo dnf module enable php:remi-8.5 -y
sudo dnf install php-cli --nobest --skip-broken -y
```

# PHPサーバーを立てる
`php`のフォルダから以下を実行（`index.php`があるところ）

`php -S localhost:8000`
