#  Blog system

ระบบ Blog

## Service
- Laravel: 12
- Composer: 2
- PHP >= 8.3
- NUXT: 3.16
- NODE: 20
- Database: MYSQL
- Docker (Optional)

# Start step

- Clone project
```
git clone <url>
```

- Move to project
```
cd blog-system
```

## Docker Compone (Optional)

- Copy enviorment
```
cp .env.example .env
```
- ในไฟล์ .env ตัวแปรนี้ สามารถตั้งชื่อชื่ออะไรก็ได้
```
MYSQL_ROOT_PASSWORD={current-yourself}
MYSQL_DATABASE={current-yourself}
```
```
docker-compone up -d
```

# Laravel
- move to path laravel project
```
cd blog-system-be
```
- Copy environment
```
cp .env.example .env
```
- Install project
```
composer install
```
- Generate APP_KEY
```
php artisan key:generate
```
- ใน ไฟล์ .env อย่าลืมตรวจสอบว่า ได้ทำการเปลี่ยนหรือตั้งค่าสำหรับ database รึยัง
```
DB_HOST=
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

- (Optinal: หากใช้ Redis)ใน ไฟล์ .env ให้ แก้ตัวแปรนี้ด้วย
```
SESSION_DRIVER=redis
```
```
CACHE_STORE=redis
```
- Migrate database (if no used)
```
php artisan migrate
```
- Seeder (Optional: หากต้องการ user admin และ ข้อมูล blog ตัวอย่าง)
```
php artisan db:seed
```
- Run start
```
php artisan serve
```
- Try
```
http://localhost:8000
```

# Nuxt 3
- Move to path nuxt project
```
cd blog-system-fe
```
- Copy environment
```
cp .env.example .env
```
- ใน .env ให้ใส่ url ของ api(larave) ที่รัน หรือสามารถก็อปไปได้เลย
```
APP_URL=http://localhost:3000 #path ของ nuxt
API_URL=http://localhost:8000/api
```
- Install project
```
npm i
```
- Run start
```
npm run dev
```
- Try
```
http://localhost:3000
```

# Documnet for api
- Postman
```
https://documenter.getpostman.com/view/12712632/2sB2ca6Kjq
```

# Build production for test score (Docker) (Optional)
- Move to path nuxt project
```
cd blog-system-fe
```
- Build docker
```
docker build -f Dockerfile.prod -t blog-system-fe-prod .
```
- run command
```
docker run --name blog-frontend-prod -p 3000:3000 -d blog-system-fe-prod 
```

# เริ่มต้นการใช้งานสำหรับ Admin
- เข้าไปที่ link เพื่อทำการ login
```
http://localhost:3000/login
```
- กรอก email และ password
```
admin@admin.com
```
```
admin1234
```
- จะเป็นการเข้าหน้า admin เพื่อ CRUD