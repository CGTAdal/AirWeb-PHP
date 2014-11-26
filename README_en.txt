###########################################################
# VeriTrans Air
# Sample Application AirWeb - PHP version
# Version 1.1
# Copyright(c) 2013-2014 VeriTrans Inc.
# README_en.txt
###########################################################

===========================================================
Prerequisite
===========================================================
1. PHP 5.1.2 and later
2. Package mb-string
3. Following setting in file php.ini
     short_open_tag = On
     date.timezone = Asia/Tokyo
     mbstring.internal_encoding = EUC-JP
4. Apache Web Server

===========================================================
 Installation Guide
===========================================================
1．Update config files to match your environment.
　　a) Application setting
　　　　include/config.php
　　　　Set following values which are specific to you or your environment
　　　　　　AW_MERCHANT_ID
　　　　　　AW_MERCHANT_HASH_KEY
　　　　　　Note:Merchant ID and Merchant Hash Key at location https://air.veritrans.co.jp/map/users/edit

　　　　　　FINISH_PAYMENT_RETURN_URL
　　　　　　FINISH_PAYMENT_ACCESS_URL
　　　　　　Note:More details about these values can be found at https://air.veritrans.co.jp/map/settings/air_web_preferences

　　b) Log setting
　　　　include/config.php
　　　　Specify the log level as per your requirement

2. Setting of httpd.conf
　　UNIX : conf/aw.conf
　　Windows : conf/aw-win.conf
　　Please change the line no 9,11,18,20 which are specific to you or your environment

3.Start the Apache Web Server.

4.Access Sample Program using Web Browser.
　　　　http://localhost:port/AirWebSample/index.php
　　　　Specify the IP address and port on which Web server is running

[EOF]