# STEPS

1. Initial Symfony Skeleton
2. Implementing Models
   1. Ingredients
   2. Foods
   3. Table constraints and indexes
3. Implementing Repository Classes
   1. Ingredients
   2. Foods
4. Implementing Controller for APIs 
   1. Ingredients
   2. Foods
   3. Chosing Library for REST API
5. Implementing Services
   1. Service for initializing the data
      1. purge the database
      2. read json files
      3. store in database
   2. Stock Provider(for refilling out of stock ingredients)
   3. Transaction executor 
   4. Order Service
6. Implementing Console Commands
   1. Command for running The StockProvider service
   2. Command for running The DataInitializer service
7. Write test
8. Docker-compose
