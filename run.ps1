# Build the images
docker build -t myapp .
docker build -t mydb -f dockerfile.mysql .
docker build -t mycomposer -f dockerfile.composer .
docker build -t mynode -f dockerfile.node .

# Create the network
docker network create -d bridge larwork

# Run the containers
docker run --name mycomposer -d -v ${PWD}/src/:/var/app/ mycomposer
docker run --name mynode -d -v ${PWD}/src/:/var/app/ mynode
docker run --name mydb --network larwork -d -v ${PWD}/data/:/var/lib/mysql/ mydb
docker run --name myapp --network larwork -d -p 8080:80 -v ${PWD}/src/:/var/www/html/ myapp