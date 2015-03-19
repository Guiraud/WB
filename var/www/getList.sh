#!/bin/sh
rm -f exit-addresses
sudo wget https://check.torproject.org/exit-addresses
sudo awk '{if ($1=="ExitAddress") print $2}' exit-addresses > iplist.txt
echo "127.0.0.1" >> iplist.txt
wc -l iplist.txt
