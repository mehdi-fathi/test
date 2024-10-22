
## Explain

1- In order to listing data, we should take advantage of paginate in Laravel. using all method when we have a lot of records
is not an efficient way. It means we are fetching all data from the table!. Cursor-Based Pagination In laravel would be great option to listing data.
We can fetch a limited data with pagination in addition for fetching more data we can send a new request. Pagination is an efficient way to paginate records
Especially using  Cursor-Based Pagination rather than Offset-Based Pagination.

2- We are using two query in foreach. It means if we have 10 records in orders table we are running 20 new query per data. I can lead to serious performance issues.
And one of the query is useless while we have the same data in foreach. with() method if we have relation in model we can solve this problem.

1- We need to use With method for eager loading and prevent any lazy loading in orm side. Because lazy loading can lead to performance issue and n+1 query.

2- I use order by in query instead of usort php. Because order by in query has better speed and is more efficient.

3- We had a dead code in using product data with lazy loading. So It was useless. 


## Suggestion

We had better declare Repository model and Service layer. Repo is a layer for database and service would be a layer for logic.
Actually our controller should call one method in Service Layer. It would be more maintainable application. For instance, We have some separated methods for 
calculated total amount. In addition, we can have the same logic for Api and Blade(web).
# test
