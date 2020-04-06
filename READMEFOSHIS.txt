To Deploy Docker on the containers:

For Atomic:
For each microservice:
1. Go to the file (path to it) and run 
docker build -t <yourdockerid>/<themicroservicename>:1.0.0 .
^Remember to include the . at the end

2. After that run 
docker run -p <theportno>:<theportno> -e dbURL=mysql+mysqlconnector://is213@host.docker.internal:3306/<microservicename> <yourdockerid>/<themicroservicename>:1.0.0


For Composite its same as Atomic but before you do step 1 and 2:
For the atomic service it is calling, run docker ps, then docker freeze to check which IP the atomic microservice is running at.
After that, adjust the IP such that it matches the atomic ip address in the code.

