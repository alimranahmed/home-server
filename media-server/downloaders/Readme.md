## Downloaders
Can download contents

### Services
1. VPN(used [Private Internet Access](https://www.privateinternetaccess.com/))
2. [QBittorrent](https://www.qbittorrent.org)(depends on VPN)
3. [Prowlarr](https://prowlarr.com)(depends on VPN & QBittorrent)
4. [Radarr](https://radarr.video)(depends on VNP & QBittorrent)
5. [Bazarr](https://www.bazarr.media/)(depends on VNP & Radarr)

### Installation
1. Copy `.env.example` to `.env` and set user credentials for Private Internet Access VPN 
2. Then run `docker compose up -d`
3. qBittorrent web UI can be accessed: `http://<machines-ip-address>:8080`
4. Prowlarr web UI can be access: `http://<machines-ip-address>:9696`
5. Radarr web UI can be access: `http://<machines-ip-address>:7878`
6. **Check VPN** working: `docker exec -it qbittorrent curl https://ipinfo.io`
7. **Check** qBittorrent doesn't work if VPN container is down