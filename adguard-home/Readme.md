## AdGuard Home
[AdGuard Home](https://adguard.com/en/adguard-home/overview.html) a network wide is an add blocker(DNS based) for home network

### Installation
1. Clone this repo on the server where you want to run Pi-Hole as DNS server.
2. Run the docker container `sudo docker-compose up -d`
3. Visit: http://<machines-ip-address>:81 and you should see the AdGuard Home web interface
4. Make sure you set the DNS in your router to the ip address(ipv4 and ipv6) of the machine where AdGuard Home is installed
5. Now you should see all the block add in the AdGuard Home web interface


### Links
1. [Ad Guard Home GitHub Repo](https://github.com/AdguardTeam/AdGuardHome)
2. [Domains to block by category](https://github.com/StevenBlack/hosts)