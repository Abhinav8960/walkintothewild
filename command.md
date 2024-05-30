Run Migrations for Each Database: Run migrations separately for each database using the yii migrate command and specify the database connection as an option.

```
php yii migrate
php yii migrate --db=db_audit_frontend --migrationPath=@console/migrations/audit/db_audit_frontend
php yii migrate --db=db_audit_backend --migrationPath=@console/migrations/audit/db_audit_backend
```