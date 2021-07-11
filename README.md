#Payroll Report Application

####Up project locally

1) `cp .docker/.env.example .docker/.env`
2) (optional) change env parameters in .docker/.env file
3) `docker-compose --env-file .docker/.env up -d` **Warning**: at default application use 80 port. Check or this port is free, or change NGINX_LOCAL_PORT variable on .docker/.env file  
4) `docker-compose exec app composer install`
5) `docker-compose exec app php bin/console doctrine:migrations:migrate -n`
6) (optional) run tests with command `docker-compose exec app composer phpunit`
7) Open your browser and go to localhost (if you choose another port, add to localhost:{PORT})

Application routes:
    
* **[GET]** `/api/departments` - return all departments

* **[POST]** `/api/departments` - create new department
  
_Type_: `json`

_Payload_:
        
    {
        "name": {string},
        "extra_pay_type": {const|percentage},
        "extra_pay_value": {float}
    }

* **[GET]** `/api/employees` - return all employees
  
* **[POST]** `/api/employees` - create new employee

_Type_: `json`

_Payload_:

    {
        "department_id": {uuid},
        "first_name": {string},
        "last_name": {string},
        "salary": {float},
        "employed_at": {date: format Y-m-d},
    }

* **[GET]** /api/payroll/report - generate report

_Available get parameters_:

    sort - sort[{field}]=ASC|DESC
    Available sort fields (only one by request):
        * first_name
        * last_name
        * department
        * basic_salary
        * extra_pay
        * extra_pay_type
        * salary

    filter - filter[{field}]={value}
    Available filters:
        * department 
        * first_name 
        * last_name

    example:
    http://localhost/api/payroll/report?sort[salary]=ASC&filter[department]=HR&filter[first_name]=Adam
    will return report sorted by salary ascending and filtered by department with name HR and first name Adam
