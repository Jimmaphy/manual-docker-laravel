# Stop the containers
docker stop myapp
docker stop mydb
docker stop mycomposer
docker stop mynode

# Remove everything
docker system prune
