# Music Label Manager
Website for managing music labels, producers and artists.

This is **DEV** branch.

## Useful commands
Run the containers:
```bash
sudo docker compose up -d
```

```bash
# enter database
sudo docker exec -it musiclabel_mysql_db mysql -u root -prootpass

# apache container 
sudo docker exec -it musiclabel_apache /bin/bash

# docker utils
sudo docker ps -a
sudo docker stop musiclabel_apache musiclabel_mysql_db
sudo docker rm -f musiclabel_apache musiclabel_mysql_db
```