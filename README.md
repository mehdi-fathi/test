
## Explain

1- In order to list data, we should take advantage of paginate in Laravel. using all method when we have a lot of records
is not an efficient way. It means we are fetching all data from the table! Cursor-based pagination In Laravel would be a great option for listing data.
We can fetch limited data with pagination in addition to fetching more data we can send a new request. Pagination is an efficient way to paginate records
Especially using  Cursor-Based Pagination rather than Offset-Based Pagination.

2- We are using two queries for each. It means if we have 10 records in the orders table we are running 20 new queries per data. It can lead to serious performance issues.
And one of the queries is useless while we have the same data in foreach. with the () method if we have a relation in the model we can solve this problem.

3- We need to use With method for eager loading and prevent any lazy loading in orm side. Because lazy loading can lead to performance issue and n+1 query.

4- I use order by in query instead of usort php because order by in query has better speed and is more efficient.

5- We had a dead code in using product data with lazy loading. So It was useless.


## Suggestion

We had better declare the Repository model and Service layer. Repo is a layer for the database and service would be a layer for logic.
Actually, our controller should call one method in the Service Layer. It would be a more maintainable application. For instance, We have some separate methods for
calculating the total amount. In addition, we can have the same logic for Api and Blade(web).


## Test 4

Schedule is a feature for running something regularly like cronjob with better and more advanced management in the application. This code runs a specific command with withoutOverlapping()
in order to prevent running scheduled tasks if those tasks haven't been finished yet. Laravel would run this command once in hour in just one server. And we run simultaneously with other tasks 
by runInBackground().


B) What is the difference between the Context and Cache Facades? Provide examples to illustrate your explanation.

Context is a way to capture and share some information in our application. It's an efficient way for logging handling. However, Generally, Cache Facade is an interface between 
Application and Cache Layer for communication. In fact, we can change and adjust the Cache driver in the cache facade to using memcache or Redis. For instance, We can take advantage of cache in 
saving temporary data to improve our performance. 

C) What's the difference between $query->update(), $model->update(), and $model->updateQuietly() in Laravel, and when would you use each?

When we run `$query->update()` we just run a simple update like an update statement in SQL code. It means we run the query without orm some events that eloquent would attach.
For instance, Eloquent can update updated_at in our table automatically. With query builder, we don't have these features. So It has better performance rather than eloquent.
for some large data, operations would be a better option.

`$model->update()` takes advantage of Eloquent ORM. We have some abilities such as listening to updates in the observe method and dispatching a job or event, updating some columns automatically, and having an abstraction layer in the model for these operations. For instance, sending after updating, we can dispatch an event or job after updating operation.


`$model->updateQuietly()` is like an update method without sending any events. For instance, we have a dispatcher on update, but we don't want dispatch notification for a new feature.


