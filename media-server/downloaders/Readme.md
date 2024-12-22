## Downloaders
Can download contents

### Services
1. VPN(used [Private Internet Access](https://www.privateinternetaccess.com/))
2. [QBittorrent](https://www.qbittorrent.org)(depends on VPN)
3. [Radarr](https://radarr.video)(depends on QBittorrent)

### Installation
1. Need OpenVPN config file in: `/home-server-data/PrivateInternetAccess/vpn_server_access_config.ovpn`
2. Copy `.env.example` to `.env` and set user credentials for Private Internet Access VPN
3. Then run `docker compose up -d`
4. qBittorrent web UI can be accessed: `http://<machines-ip-address>:83`
5. Radarr web UI can be access: `http://<machines-ip-address>:84`
6. **Check VPN** working: `docker exec -it qbittorrent curl https://checkip.amazonaws.com`
7. **Check** qBittorrent doesn't work if VPN container is down