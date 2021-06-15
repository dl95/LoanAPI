Make laravel enviroment
make sure php version >7.4

update composer, run command in project
"composer update"

make database in your mysql server
configure databases credentials in .env file
run command for create tables in your database
"php artisan migrate"

start server using command
"php artisan server"

// Now your setup is ready open postman collection //

Collection link is https://www.getpostman.com/collections/c5f045af005f025b91dc

Postman collection apis as follows

1. Register user
   fields name(min length 4), email, password(min length 8)

2. Login User using fields
   email, password

3. Submit loan application(request loan) fields
   amount, term

4. Approve loan application using
   loan_id

5. Loan repayment using fields
   amount, loan_id
