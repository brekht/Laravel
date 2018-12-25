<?php

# php artisan migrate
# php artisan db:seed

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

# Models
use App\Models\User;

use App\Models\Category;
use App\Models\Article;
use App\Models\CategoryArticle;
use App\Models\Comment;

use App\Models\Essence;
use App\Models\NumProperty;
use App\Models\DescProperty;
use App\Models\ImgProperty;
use App\Models\FreeProperty;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        $this->call(UsersSeeder::class);

        $this->call(CategoriesSeeder::class);
        $this->call(ArticlesSeeder::class);
        $this->call(CategoryArticlesSeeder::class);
        $this->call(CommentsSeeder::class);

        $this->call(EssencesSeeder::class);
        $this->call(NumPropertySeeder::class);
        $this->call(DescPropertySeeder::class);
        $this->call(ImgPropertySeeder::class);
        $this->call(FreePropertiesSeeder::class);
    }
}

# ·······································································

class UsersSeeder extends Seeder {

    protected function carbonNow(){
        return Carbon::now();
    }

    public function run()
    {
        DB::table('users')->delete();

        User::create([
            'email'          => 'al@al.com',
            'password'       => '$2y$10$MDwZDCB5N9QXaH4LQ2VnJuGPXURLzmM1kv6dTJxSq1geC.mMv.ajm',
            'isAdmin'        => 1,
            'root'           => 1,
            'isConfirm'      => 1,
            'remember_token' => 'gUFb3rHKkmhM4lP3J1UC5N00mJQ0V6nyqwaYyf0216cjf6dvC7rzMdygJLUh',
            'created_at'     => $this->carbonNow(),
            'updated_at'     => $this->carbonNow(),
        ]);

        User::create([
            'email'          => 'lara@lara.com',
            'password'       => '$2y$10$dmKZmiSh2CP25DLVHyWuzO3ITx6dFZ6rGiO8GsxR9CPx8AhdHh/AS',
            'isAdmin'        => 1,
            'root'           => null,
            'isConfirm'      => 1,
            'remember_token' => 'cQzGih4nXQ1yzKd0tu9rWUdJSPvtejcb85Jj5xAxAWxGOBzfl2rhk6ILqL8J',
            'created_at'     => $this->carbonNow(),
            'updated_at'     => $this->carbonNow(),
        ]);

        User::create([
            'email'          => 'john@john.com',
            'password'       => '$2y$10$gsjFf2FzrSTOY9jgdFayZeWZvwt0HMw6h5NZwLyyXB3mwpVb4dLim',
            'isAdmin'        => 0,
            'root'           => null,
            'isConfirm'      => 1,
            'remember_token' => 'qLpj2b7E8aNyWVTTnD44UzEdridk12pCF8T19zACQBJmrtrVVsjfusVtHTNc',
            'created_at'     => $this->carbonNow(),
            'updated_at'     => $this->carbonNow(),
        ]);

        User::create([
            'email'          => 'mike@mike.com',
            'password'       => '$2y$10$CEdQCTJS7AfYc86qK7t6SeTUSaKEFH31JNnwgSKSBJd9IOhbZuCxK',
            'isAdmin'        => 0,
            'root'           => null,
            'isConfirm'      => 0,
            'remember_token' => '2gKBe5GDcetJykv2D5yoEyyYUwYXZEGsfdLCwaHl2ol2LAS4XktD0zqgmS9J',
            'created_at'     => $this->carbonNow(),
            'updated_at'     => $this->carbonNow(),
        ]);
    }
}
# ·······································································

class CategoriesSeeder extends Seeder {

    protected function carbonNow(){
        return Carbon::now();
    }

    public function run()
    {
        DB::table('categories')->delete();

        Category::create([
            'title'      => 'Fruits',
            'desc'       => 'This is Fruits Category',
            'user_id'    => 1,
            'created_at' => $this->carbonNow(),
            'updated_at' => $this->carbonNow(),
        ]);

        Category::create([
            'title'      => 'Space',
            'desc'       => 'Category of Space',
            'user_id'    => 1,
            'created_at' => $this->carbonNow(),
            'updated_at' => $this->carbonNow(),
        ]);

        Category::create([
            'title'      => 'Cats',
            'desc'       => 'Cats Category',
            'user_id'    => 1,
            'created_at' => $this->carbonNow(),
            'updated_at' => $this->carbonNow(),
        ]);

        Category::create([
            'title'      => 'Birds',
            'desc'       => 'Birds category',
            'user_id'    => 1,
            'created_at' => $this->carbonNow(),
            'updated_at' => $this->carbonNow(),
        ]);

        Category::create([
            'title'      => 'Coffee',
            'desc'       => 'Категория про Кофе',
            'user_id'    => 2,
            'created_at' => $this->carbonNow(),
            'updated_at' => $this->carbonNow(),
        ]);

        Category::create([
            'title'      => 'Хобби',
            'desc'       => 'Категория Хобби',
            'user_id'    => 3,
            'created_at' => $this->carbonNow(),
            'updated_at' => $this->carbonNow(),
        ]);
    }
}

# ·······································································

class ArticlesSeeder extends Seeder {

    protected function carbonNow(){
        return Carbon::now();
    }

    public function run()
    {
        DB::table('articles')->delete();

        Article::create([
            'title'         => 'Это статья про фрукты',
            'short_text'    => 'Под фруктами обычно понимают сладкие плоды деревьев и кустарников',
            'full_text'     => 'Под фруктами обычно понимают сладкие плоды деревьев и кустарников. Фрукты обладают особенной ценностью для организма человека - насыщая его необходимыми витаминами и углеводами.',
            'user_id'       => 1,
            'created_at'    => $this->carbonNow(),
            'updated_at'    => $this->carbonNow(),
        ]);

        Article::create([
            'title'         => 'Птички',
            'short_text'    => 'Птицы - группа теплокровных позвоночных животных, традиционно рассматриваемая в ранге отдельного класса',
            'full_text'     => 'Птицы - группа теплокровных позвоночных животных, традиционно рассматриваемая в ранге отдельного класса. Птицы - это одна из шести основных групп животных, наряду с рептилиями, млекопитающими, земноводными, рыбами и беспозвоночными. Птицы имеют отличительные признаки, включая их перья и способность летать (у большинства видов). Наша планета является домом для более 10 000 известных видов птиц.',
            'user_id'       => 1,
            'created_at'    => $this->carbonNow(),
            'updated_at'    => $this->carbonNow(),
        ]);

        Article::create([
            'title'         => 'Space article',
            'short_text'    => 'Космическое пространство, космос - относительно пустые участки Вселенной, которые лежат вне границ атмосфер небесных тел',
            'full_text'     => 'Космическое пространство, космос - относительно пустые участки Вселенной, которые лежат вне границ атмосфер небесных тел. Вопреки распространённым представлениям, космос не является абсолютно пустым пространством: в нём есть, хотя и с очень низкой плотностью, межзвёздное вещество (преимущественно молекулы водорода), кислород в малых количествах (остаток после взрыва звезды), космические лучи и электромагнитное излучение, а также гипотетическая тёмная материя.',
            'user_id'       => 1,
            'created_at'    => $this->carbonNow(),
            'updated_at'    => $this->carbonNow(),
        ]);

        Article::create([
            'title'         => 'Мы любим кофе',
            'short_text'    => 'Горький кофе или негорький - это вопрос вкусов, о которых, как известно, не спорят',
            'full_text'     => 'Горький кофе или негорький - это вопрос вкусов, о которых, как известно, не спорят. Кофе должен быть качественным. Это главное условие. Если говорить о напитках, то по популярности пальму первенства уверенно держит капучино.',
            'user_id'       => 2,
            'created_at'    => $this->carbonNow(),
            'updated_at'    => $this->carbonNow(),
        ]);

        Article::create([
            'title'         => 'Любительская фотография - как хобби',
            'short_text'    => 'Любительская фотография - фотографии, сделанные фотолюбителями или неизвестными фотографами-профессионалами',
            'full_text'     => 'Любительская фотография - фотографии, сделанные фотолюбителями или неизвестными фотографами-профессионалами, на которых запечатлен быт и повседневные вещи в качестве субъектов. Примерами любительской фотографии являются фотоальбомы путешествий и отпускные фотографии, семейные снимки, фотографии друзей.',
            'user_id'       => 3,
            'created_at'    => $this->carbonNow(),
            'updated_at'    => $this->carbonNow(),
        ]);

        Article::create([
            'title'         => 'А это статья про кошек и птиц',
            'short_text'    => 'Данная статья не особо увлекательна,  ...',
            'full_text'     => 'Данная статья не особо увлекательна,  ... странно что меня не заблокировали)',
            'user_id'       => 4,
            'created_at'    => $this->carbonNow(),
            'updated_at'    => $this->carbonNow(),
        ]);
    }
}

# ·······································································

class CategoryArticlesSeeder extends Seeder {

    protected function carbonNow(){
        return Carbon::now();
    }

    public function run()
    {
        DB::table('category_articles')->delete();

        CategoryArticle::create([
            'category_id'   => 1,
            'article_id'    => 1,
            'created_at'    => $this->carbonNow(),
            'updated_at'    => $this->carbonNow(),
        ]);

        CategoryArticle::create([
            'category_id'   => 5,
            'article_id'    => 4,
            'created_at'    => $this->carbonNow(),
            'updated_at'    => $this->carbonNow(),
        ]);

        CategoryArticle::create([
            'category_id'   => 6,
            'article_id'    => 5,
            'created_at'    => $this->carbonNow(),
            'updated_at'    => $this->carbonNow(),
        ]);

        CategoryArticle::create([
            'category_id'   => 3,
            'article_id'    => 6,
            'created_at'    => $this->carbonNow(),
            'updated_at'    => $this->carbonNow(),
        ]);

        CategoryArticle::create([
            'category_id'   => 4,
            'article_id'    => 6,
            'created_at'    => $this->carbonNow(),
            'updated_at'    => $this->carbonNow(),
        ]);

        CategoryArticle::create([
            'category_id'   => 2,
            'article_id'    => 3,
            'created_at'    => $this->carbonNow(),
            'updated_at'    => $this->carbonNow(),
        ]);

        CategoryArticle::create([
            'category_id'   => 4,
            'article_id'    => 2,
            'created_at'    => $this->carbonNow(),
            'updated_at'    => $this->carbonNow(),
        ]);
    }
}

# ·······································································

class CommentsSeeder extends Seeder {

    protected function carbonNow(){
        return Carbon::now();
    }

    public function run()
    {
        DB::table('comments')->delete();

        Comment::create([
            'status'     => 1,
            'comment'    => 'Уважаемый автор mike@mike.com - вас уже заблокировали!',
            'article_id' => 6,
            'user_id'    => 1,
            'created_at' => $this->carbonNow(),
            'updated_at' => $this->carbonNow(),
        ]);

        Comment::create([
            'status'     => 1,
            'comment'    => 'Правильно, будет знать',
            'article_id' => 6,
            'user_id'    => 2,
            'created_at' => $this->carbonNow(),
            'updated_at' => $this->carbonNow(),
        ]);

        Comment::create([
            'status'     => 1,
            'comment'    => 'Скажите, кто нибудь знает классический рецепт Американо с молоком?',
            'article_id' => 4,
            'user_id'    => 2,
            'created_at' => $this->carbonNow(),
            'updated_at' => $this->carbonNow(),
        ]);

        Comment::create([
            'status'     => 1,
            'comment'    => 'Нeoбхoдимo cвapить эcпpecco, paзбaвить eгo вoдoй один к трём, a зaтeм дoбaвить в пopцию мoлoкa',
            'article_id' => 4,
            'user_id'    => 3,
            'created_at' => $this->carbonNow(),
            'updated_at' => $this->carbonNow(),
        ]);

        Comment::create([
            'status'     => 0,
            'comment'    => 'Птички - они такие смешные',
            'article_id' => 2,
            'user_id'    => 3,
            'created_at' => $this->carbonNow(),
            'updated_at' => $this->carbonNow(),
        ]);
    }
}

# ·······································································

class EssencesSeeder extends Seeder {

    protected function carbonNow(){
        return Carbon::now();
    }

    public function run()
    {
        DB::table('essences')->delete();

        Essence::create([
            'name'          => 'Cats',
            'user_id'       => 1,
            'first_author'  => 1,
            'created_at'    => $this->carbonNow(),
            'updated_at'    => $this->carbonNow(),
        ]);

        Essence::create([
            'name'          => 'Birds',
            'user_id'       => 3,
            'first_author'  => 3,
            'created_at'    => $this->carbonNow(),
            'updated_at'    => $this->carbonNow(),
        ]);

        Essence::create([
            'name'          => 'Fruits (tropic)',
            'user_id'       => 1,
            'first_author'  => 2,
            'created_at'    => $this->carbonNow(),
            'updated_at'    => $this->carbonNow(),
        ]);

        Essence::create([
            'name'          => 'Colors',
            'user_id'       => 1,
            'first_author'  => 1,
            'created_at'    => $this->carbonNow(),
            'updated_at'    => $this->carbonNow(),
        ]);
    }
}

# ·······································································

class NumPropertySeeder extends Seeder {

    protected function carbonNow(){
        return Carbon::now();
    }

    public function run()
    {
        DB::table('num_property')->delete();

        NumProperty::create([
            'num'           => 25,
            'essences_id'   => 1,
            'user_id'       => 1,
            'first_author'  => 1,
            'created_at'    => $this->carbonNow(),
            'updated_at'    => $this->carbonNow(),
        ]);
    }
}

# ·······································································

class DescPropertySeeder extends Seeder {

    protected function carbonNow(){
        return Carbon::now();
    }

    public function run()
    {
        DB::table('desc_property')->delete();

        DescProperty::create([
            'desc'          => 'Это Cвойство \'Описание\', и его Значение - собственно само описание свойства',
            'essences_id'   => 1,
            'user_id'       => 1,
            'first_author'  => 1,
            'created_at'    => $this->carbonNow(),
            'updated_at'    => $this->carbonNow(),
        ]);

        DescProperty::create([
            'desc'          => 'сладкие плоды деревьев и кустарников',
            'essences_id'   => 3,
            'user_id'       => 2,
            'first_author'  => 2,
            'created_at'    => $this->carbonNow(),
            'updated_at'    => $this->carbonNow(),
        ]);
    }
}

# ·······································································

class ImgPropertySeeder extends Seeder {

    protected function carbonNow(){
        return Carbon::now();
    }

    public function run()
    {
        DB::table('img_property')->delete();

        ImgProperty::create([
            'img'           => 'wzwq503axq4k03os7cvptkgdz.jpeg',
            'essences_id'   => 1,
            'user_id'       => 1,
            'first_author'  => 1,
            'created_at'    => $this->carbonNow(),
            'updated_at'    => $this->carbonNow(),
        ]);

        ImgProperty::create([
            'img'           => 'w82iqhddgt9w3yhlqxptfsc7z.jpg',
            'essences_id'   => 2,
            'user_id'       => 3,
            'first_author'  => 3,
            'created_at'    => $this->carbonNow(),
            'updated_at'    => $this->carbonNow(),
        ]);
    }
}

# ·······································································

class FreePropertiesSeeder extends Seeder {

    protected function carbonNow(){
        return Carbon::now();
    }

    public function run()
    {
        DB::table('freeproperties')->delete();

        FreeProperty::create([
            'col_prop'      => 'Окрас',
            'col_desc'      => 'чепрачный',
            'essences_id'   => 1,
            'user_id'       => 1,
            'first_author'  => 1,
            'created_at'    => $this->carbonNow(),
            'updated_at'    => $this->carbonNow(),
        ]);

        FreeProperty::create([
            'col_prop'      => 'Группа здоровья',
            'col_desc'      => 'Fat Cats',
            'essences_id'   => 1,
            'user_id'       => 1,
            'first_author'  => 1,
            'created_at'    => $this->carbonNow(),
            'updated_at'    => $this->carbonNow(),
        ]);

        FreeProperty::create([
            'col_prop'      => 'Вес',
            'col_desc'      => 'до 3 кг',
            'essences_id'   => 1,
            'user_id'       => 1,
            'first_author'  => 1,
            'created_at'    => $this->carbonNow(),
            'updated_at'    => $this->carbonNow(),
        ]);

        FreeProperty::create([
            'col_prop'      => 'Описание породы',
            'col_desc'      => 'европейская короткошерстная',
            'essences_id'   => 1,
            'user_id'       => 1,
            'first_author'  => 1,
            'created_at'    => $this->carbonNow(),
            'updated_at'    => $this->carbonNow(),
        ]);

        FreeProperty::create([
            'col_prop'      => 'Type',
            'col_desc'      => 'tropic',
            'essences_id'   => 3,
            'user_id'       => 1,
            'first_author'  => 2,
            'created_at'    => $this->carbonNow(),
            'updated_at'    => $this->carbonNow(),
        ]);
    }
}

# ·······································································
