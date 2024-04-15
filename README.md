
# Innoscripta News Feeds

This project is made to perform the Innoscripta assessment. This project contains a small News feeds application in which user can login and read the available News. User can also save their preferences in the form of Categories, Sources and Authors. You can manage their own feeds by saving their preferences.






## Installation
The Installation process of the project are given below:                        
1- Clone the repository by running the command ```git clone git@github.com:adil7475/innoscripta_test.git```             
2- Go to the project directory and run ```docker-compose build```        
3- After docker finish building run the following command ```docker-compose up```       
4- SSH to docker container by running the command ```docker exec -it "php" sh``` and run ```chmod -R 777 storage```    
5- Run the command ```php artisan migrate``` to generate the database schema.   
6- Run the command ```php artisan db:seed``` to generate a User and some fake News data.    
    - Email: admin@innoscripta.com  
    - Password: secret123   
7- Run the command ```php artisan fetch:news``` to get news from integrated services.    
8: Backend of the project will run on ```localhost:8000```  
9- When you run ```docker-compose up``` it will give the frontend app link. Please copy the link and open it in browser to view the application.    
10: You can connect to docker mysql instance by using any GUI software like WorkBench by using these details: HOST: localhost:3307 USER: root PASSWORD:

#### Note:
Sometime docker-compose exist the queue:work with code 0 randomly, if that's the case then please restart the docker queue services or run the queue:worker manually one by one ```php artisan queue:work --queue='SYNC_INTEGRATION'``` and ```php artisan queue:work --queue='SAVE_NEWS'```
## Documentation

### Backend
In the backend side of the project I integate three services for fetching the news  
1- NewsOrg  
2- NewYork Times    
3- The Guardian

The News fetching process is manages by two queues:
#### 1- SYNC_INTEGRATIONS_QUEUE
This queue is responsible for getting queues from the integrated services and give data to next queue for saving News data to database.

#### 2- SAVE_NEWS_QUEUE
This queue is responsible for storing the News data to the local database.

I use the queues to make the process seamless and scalable. We can also simple do all these thing by running a simple command but I do it using Queues to make it more scalable.
Moreover, currently I am using database as a queue driver but the recommendation is to use AWS SQS service.

I also use Repository pattern for following the good practices. I am using ```https://github.com/kylenoland/laravel-base-repository``` as a Baseline Repository and Baseline Services.

### Frontend
In the frontend side I use TypeScript with React. I make the layout by using Bootstrap so the design will be mobile responsive too.
##### Note: 
There is one issue on frontend side on preferences page, sometime the values did not populate in
the select input. If you are facing this issue then please hard refresh the page. The issue is due to cache but I can not able to figure out for now due to lack of time.


## Performance
For backend I implement Pagniation for APIs calls.    
For frontend I implement Load more option.
For database I add proper indexes on different columns
### Suggestion:
We can also implement some cache for faster response but due to lack of time I can not able to do so.
## Security
For Security purpose I am validating all the request parameters so user can not able to send bad data.  
For frontend side I am using protected routes so annonymous user can not able to see application without login.