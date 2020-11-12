**In Linux run:**  
`pwd`

**Update `.env` value `DB_DATABASE` (doesn't need create - it's committed):**
 
`DB_DATABASE=.../database/database.sqlite`

_**example**: DB_DATABASE=/var/www/html/hallnet-test/database/database.sqlite_

**Run composer:** `composer install`

**Run npm:** `npm install`

**Build project styles and js:** `npm run dev`

**Create project tables:** `php artisan migrate`

**Seed table with shortening words from https://www.eff.org/files/2016/09/08/eff_short_wordlist_2_0.txt** 

`php artisan db:seed --class=EffShortWordlist`

**Run acceptance test:** `php artisan test`

**Start project itself:** `php artisan serve`

**Project url:** http://127.0.0.1:8000/ 
