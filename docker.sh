docker-machine start camagru
eval $(docker-machine env camagru)
docker-compose up -d
docker exec -it docker_www_1 bash