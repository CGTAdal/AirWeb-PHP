###########################################################
# VeriTrans Air
# サンプルアプリケーション AirWeb - PHP version
# Version 1.1
# Copyright(c) 2013-2014 VeriTrans Inc.
# README.txt
###########################################################

===========================================================
 事前準備
===========================================================
1. PHP 5.1.2以上
2. パッケージ mb-string
3. php.iniに以下設定を追加してさい。
     short_open_tag = On
     date.timezone = Asia/Tokyo
     mbstring.internal_encoding = EUC-JP
4. Apache アプリケーションサーバ

===========================================================
 インストールガイド
===========================================================
1．アプリケーションとログ設定
　　a) アプリケーション設定
　　　　include/config.php
　　　　　　AW_MERCHANT_ID
　　　　　　AW_MERCHANT_HASH_KEY
　　　　　　※マーチャントIDとマーチャントハッシュはhttps://air.veritrans.co.jp/map/users/editに記載の情報をご使用ください。

　　　　　　FINISH_PAYMENT_RETURN_URL
　　　　　　FINISH_PAYMENT_ACCESS_URL
　　　　　　※上記のURLの詳細についてはhttps://air.veritrans.co.jp/map/settings/air_web_preferencesからご確認お願いします。

　　b) ログ設定
　　　　include/config.php
　　　　必要に応じてログファイル及びレベの設定を行っ下さい。

2. httpd.conf設定
　　UNIX : conf/aw.conf
　　Windows : conf/aw-win.conf
　　※お客様の展開先に合わせて9、11 、18 、20 行目のパスを変更してください。

3. Apache Webアプリケーションサーバの起動

4.動作確認
　　Webブラウザで以下URLにアクセスし、稼働することを確認して下さい。
　　　　http://localhost:port/AirWebSample/index.html
　　　　localhost:portのところに導入サーバのIPとポートを指定してください。

[EOF]