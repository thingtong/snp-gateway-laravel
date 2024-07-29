Note Fresh Install Laravel 11

Base on MVC Pattern

### How to run

```
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan serve
```

### FYI

-   return response `$this->ok` หรือ `$this->error` เท่านั้น
-   response error ต่าง ๆ มี handle ไว้เรียบร้อย bootstrap app อยู่แล้ว
-   ตัวอย่างการ throw error ดูใน `TestController`
-   upload file ใช้ `FileUtil`
-   เรียกใช้ `UseHashIdModel` ใน model
    -   เพื่อ hash id เลี่ยงการใช้ id โดยตรง
    -   ซ่อน id ด้วย `protected $hidden = ['id'];` ใน model
-

Memo

-   install laravel
-   php artisan install:api for initial setup api route
-   install ide helper for vscode https://github.com/barryvdh/laravel-ide-helper
-   install captainhook for git hooks https://github.com/captainhookphp/captainhook
-   install log-viewer for view logs https://github.com/opcodesio/log-viewer
-   install pest for unit test https://pestphp.com/
-   install laravel-permission https://spatie.be/docs/laravel-permission/v6/introduction
-   install laravel-hashids https://github.com/vinkla/laravel-hashids
-   install intervention/image https://image.intervention.io/v3
-   install S3 Driver https://laravel.com/docs/11.x/filesystem#s3-driver-configuration

Implementing

-   Add Simple Versioning API
-   Add Middleware force json reponse
-   Add Simple Handle Response
-   Add Handle Exceptions
-   Add Global Util Pattern
-   Add Simple Http Request Util
-   Add Log Viewer Provider
-   Add Example Unit Test in ConditionUtil
-   Change Default timezone to Asia/Bangkok
-   Change Log Viewer Default timezone to Asia/Bangkok
-   Add Simple Auth with sanctum
-   Add Cors
-   Add Rate Limiting
-   Add Example Websocket with Laravel Echo & Reverb
-   Add Example send mail
-   Add Simple Best Pracetice CRUD with Repository Pattern without Request,Response In ExampleNoteController
-   Add User Seeder
-   Add Example Role & Permission
-   Add File Util with support s3
