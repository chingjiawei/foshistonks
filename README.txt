1. For Windows, unzip file and put in www (under wamp64) (so you should see www/foshistonks).
For Mac, unzip file in /Applications/MAMP/htdocs (so you should see htdocs/foshistonks).
2. In your localhost database (localhost/phpmyadmin), run create.sql
3. To build and run all microservices, run "docker-compose build && docker-compose up -d" in your command line
4. To start using our application, go to localhost/foshistonks/index.php. Happy stonking!
5. To utilize the telegram api, get your telegramid by using @userinfobot on Telegram and input it when you signup. (e.g. 424532431)
After that, simply go to @foshistonks_bot and type /start.
6. When you're finished, simply run "docker-compose down".

Note: 
Our apikey for Alphavantage is limited to 5 requests a minute as we're using a free version for this project.
The AMQP communication is reliant on RabbitMQ, which may take up to 2 minutes to load.
Our AMQP communication is from createposition to notification and monitoring microservice, and notification microservices sends a telegram message to you, 
while monitoring microservice records the log in the database, which can be seen in phpmyadmin. (Refer to point 5)