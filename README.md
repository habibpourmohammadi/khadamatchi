## Khadamatchi

"خدمات چی" یک پلتفرم آنلاین است که افراد با مهارت‌های مختلف را با افرادی که به دنبال خدمات آن‌ها هستند، به هم متصل می‌کند. کاربران می‌توانند مهارت‌های خود را ثبت کرده و به جمع متخصصین خدمات چی بپیوندند. این وب اپلیکیشن از فریمورک Livewire ،Laravel برای تعاملات پویا، و Tailwind برای طراحی رابط کاربری استفاده می‌کند. هدف این سیستم ایجاد ارتباط ساده‌تر کاربران بین متخصصین برای انجام وظایف حرفه‌ای است.

![khadamatchi](https://i.ibb.co/qsgC5QJ/khadamatchi.png)

### ویژگی‌ها

* **ثبت مهارت‌ها** : کاربران می‌توانند مهارت‌های خود را در سامانه ثبت کرده و اطلاعات کاملی از تخصص‌هایشان را ارائه دهند.
  
- **جستجوی متخصصین** :افراد به دنبال خدمات خاص می‌توانند به سهولت افراد متخصص را بر اساس شهر و دسته‌بندی مورد نظر پیدا کنند.

* **ارتباط مستقیم** : کاربران می‌توانند به صورت مستقیم با متخصصین تماس برقرار کرده و جزئیات خدمات را در محیط آنلاین بررسی کنند.
  
- **ثبت نظر** : امکان ارائه نظر برای متخصصین. این کمک می‌کند تا کاربران بهترین متخصصین را انتخاب کنند و اعتماد بیشتری به سیستم داشته باشند.


### Installation and Setup
- **Clone the repository:**
    ```bash
    git clone https://github.com/habibpourmohammadi/khadamatchi.git
    ```

- **Navigate to the project directory:**
    ```bash
    cd khadamatchi
    ```

- **Install dependencies:**
    ```bash
    composer install
    ```

- **Create the environment file:**
    ```bash
    cp .env.example .env
    ```

- **Generate a new encryption key:**
    ```bash
    php artisan key:generate
    ```
- Configure email settings in the `.env` file.

- **Run migrations:**
    ```bash
    php artisan migrate
    ```

- **Install npm dependencies:**
    ```bash
    npm install
    ```

- **Compile assets (including Tailwind CSS):**
    ```bash
    npm run dev
    ```

- **Run the server:**
    ```bash
    php artisan serve
    ```

## Contact Me

Feel free to reach out with any questions or concerns:

 - habibpourmohammady@gmail.com
 - https://www.linkedin.com/in/habibpourmohammadi/
