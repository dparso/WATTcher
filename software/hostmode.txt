#! /bin/bash
# Switch to host mode

bash -c "sudo rm /var/www/html/clientFlag.txt"

bash -c "printf '\nhostmode rebooting' >> /var/www/html/log.txt"
bash -c "cp /etc/rc.local.host /etc/rc.local"
#bash -c "/usr/local/bin/hostapdstart"
#bash -c "systemctl daemon-reload"
#bash -c "service networking restart"
bash -c "reboot"
