
## Explain

1- In order to list data, we should take advantage of paginate in Laravel. using all method when we have a lot of records
is not an efficient way. It means we are fetching all data from the table! Cursor-based pagination In Laravel would be a great option for listing data.
We can fetch limited data with pagination in addition to fetching more data we can send a new request. Pagination is an efficient way to paginate records
Especially using  Cursor-Based Pagination rather than Offset-Based Pagination.

2- We are using two queries for each. It means if we have 10 records in the orders table we are running 20 new queries per data. It can lead to serious performance issues.
And one of the queries is useless while we have the same data in foreach. with the () method if we have a relation in the model we can solve this problem.

1- We need to use With method for eager loading and prevent any lazy loading in orm side. Because lazy loading can lead to performance issue and n+1 query.

2- I use order by in query instead of usort php because order by in query has better speed and is more efficient.

3- We had a dead code in using product data with lazy loading. So It was useless.


## Suggestion

We had better declare the Repository model and Service layer. Repo is a layer for the database and service would be a layer for logic.
Actually, our controller should call one method in the Service Layer. It would be a more maintainable application. For instance, We have some separate methods for
calculating the total amount. In addition, we can have the same logic for Api and Blade(web).

