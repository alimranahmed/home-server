## AdGuard Home
[AdGuard Home](https://adguard.com/en/adguard-home/overview.html) a network wide is an add blocker(DNS based) for home network

### Installation
1. Clone this repo on the server where you want to run Pi-Hole as DNS server.
2. Stop Linux's default DNS resolver: `sudo systemctl stop systemd-resolved`
3. Disable Linux's default DNS resolver: `sudo systemctl disable systemd-resolved`
4. Edit this file `sudo vim /etc/resolv.conf` to change `nameserver 127.0.0.53` to `nameserver 1.1.1.1` in the file
5. Run the docker container `sudo docker-compose up -d`
6. Visit `http://<machines-ip-address>:3000` to set up AdGuard(eg. Password) for the 1st time
7. Visit `http://<machines-ip-address>:81` and you should see the AdGuard Home login page
8. Make sure you set the DNS in your router to the ip address(ipv4 and ipv6) of the machine where AdGuard Home is installed
9. Now you should see all the block add in the AdGuard Home web interface


### Links
1. [Ad Guard Home GitHub Repo](https://github.com/AdguardTeam/AdGuardHome)
2. [Domains to block by category](https://github.com/StevenBlack/hosts)