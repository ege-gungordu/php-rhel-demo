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

# サーバーにローカルのブラウザからアクセスする

仮想マシン内のブラウザから`localhost:8000`にはアクセスできるが、ローカルのブラウザからもアクセスしたい場合、以下のコマンドでファイアウォールの8000のTCPポートを開放します。

```
sudo firewall-cmd --zone=public --add-port=8000/tcp --permanent
sudo firewall-cmd --reload
```

PHPサーバーを立てる際に、`localhost`ではなく、`0.0.0.0`を使います。

`php -S 0.0.0.0:8000`

これでローカルから以下のURLでサーバーにアクセスできます。

`<仮想マシンIP>:8000`

# ファイアウォールからポート設定をもとに戻す

`sudo firewall-cmd --zone=public --remove-port=8000/tcp --permanent`
