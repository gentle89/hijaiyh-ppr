#!/bin/bash

# Premium PHP Redirect - a product by HijaIyh.
# Author : justalinko
# Installer : justalinko
# Version : 3.1
# 
# Tested on ubuntu 18.04 LTS
#
# Disclaimer : - This product should only be used by Hijaiyh members who have already purchased it.

# color variable
m="\033[1;31m"
k="\033[1;33m"
h="\033[1;32m"
b="\033[1;34m"
bl="\033[0;34m"
n="\033[1;0m"
# hijaiyh

iyh_banner()
{

echo -e $b"  _   _ _  _       ___      _     "
echo -e $b" | | | (_)(_) __ _|_ _|   _| |__  "
echo -e $b" | |_| | || |/ _' || | | | | '_ \ "
echo -e $b" |  _  | || | (_| || | |_| | | | |"
echo -e $b" |_| |_|_|/ |\__,_|___\__, |_| |_|"
echo -e $b"        |__/          |___/       "
echo -e $k" +--------------------------------+"
echo -e $k" |   HijaIyh Premium PHP Redirect |"
echo -e $k" |  @author  :: justalinko        |"
echo -e $k" +--------------------------------+"$n

}

iyh_depen()
{
	echo "[!] Checking dependencies ..."
	echo ""
	echo "[!] This software only support Debian,ubuntu and family !"
	echo "Press ENTER to continue;"; read x
	sleep 1
	echo "[!] Ensure that your system supports ..."
	which lsb_release > /dev/null 2>&1
	if [[ $? -eq 0 ]]; then
		lsb_release -id
	else
		echo "Your system not supported."
		exit 1
	fi

	clear
	echo "Lets start bruhhh ...."
	sleep 1
	echo "[!] Updating your system ...."
	apt-get update -y
	clear
	echo "[!] Installing apache2 webserver , php ..."
	apt-get install apache2 libapache2-mod-php php php-cli php-curl php-zip php-common php-mbstring php-mysql -y
	clear
	echo "[!] Installing unzip,wget,git ..."
	apt-get install unzip wget git -y
	clear
	echo "Installing dependencies DONE."
	echo "Press ENTER to continue"; read x
}