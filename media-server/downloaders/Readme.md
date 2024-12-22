## Downloaders
Can download contents

### Services
1. VPN(used [Private Internet Access(https://www.privateinternetaccess.com/)])
2. [QBittorrent](https://www.qbittorrent.org)(depends on VPN)
3. [Radarr](https://radarr.video)(depends on QBittorrent)

### Installation
1. Need OpenVPN config file in: `/home-server-data/GluetunVpn/PrivateVpnAccess/vpn_server_access_config.ovpn`
2. The OpenVPN config file can be generated from VPN Provider(VPN) based on selected server
3. Once generate(e.g. `swiss-aes-128-cbc-udp-dns.ovpn`), put it inside `/home-server-data/GluetunVpn/PrivateVpnAccess/` and rename the file to `vpn_server_access_config.ovpn`
4. Then run `docker compose up -d`
5. qBittorrent web UI can be accessed: `http://<machines-ip-address>:83`
6. Radarr web UI can be access: `http://<machines-ip-address>:84`
7. **Check VPN** working: `docker exec -it qbittorrent curl https://checkip.amazonaws.com`