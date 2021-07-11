<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210710101814 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create project tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
            create table departments
            (
	            id char(36),
	            name varchar(255) not null,
	            extra_pay_type enum('const', 'percentage') not null,
                extra_pay_value float not null,
	            constraint departments_pk primary key (id)
            )
        ");

        $this->addSql("create unique index departments_name_uindex on departments (name)");

        $this->addSql("
            create table employees
            (
                id char(36),
                department_id char(36) not null,
                first_name varchar(255) not null,
                last_name varchar(255) not null,
                salary float not null,
                employed_at datetime not null,
                constraint employees_pk primary key (id)
            )
        ");

        $this->addSql("alter table employees 
            add constraint employees_departments_id_fk
		    foreign key (department_id) references departments (id)
			on delete cascade
        ");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE employees");
        $this->addSql("DROP TABLE departments");
    }
}
