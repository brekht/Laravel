<?php

/* Create by Xenial ~ artisan */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    # ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    static $_instance;

    public static function getInstance() {
        if(!(self::$_instance instanceof self))
            self::$_instance = new self();
        return self::$_instance;
    }

    private function __clone() {}
    # ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    # ···································································

    protected $table = 'articles';
    protected $primaryKey = 'id';

    # 'что мы будем массово заполнять'
    protected $fillable = [
        'title',
        'short_text',
        'full_text',
        'user_id',
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];

    # ···································································

    /* Relations (связи) */
    # "Многие ко многим" - т.к. мы в данной Связи получаем Категории, назовём Метод связи - как 'categories'
    # (Описание логики Метода - в описании к курсу, в части 18) !
    public function categories()
    # ›››››› описание смотри на Line 145 в данном файле Модели Article
    {
        return $this->belongsToMany(Category::class, 'category_articles', 'article_id', 'category_id');
        # Дополнительный Комментарий к описанию в курсе части 18 (не отражён в описании к курсу (более краткое объяснение связи)):
        # ------------------------------------------------------------------------------------------------------------------------
        # "Внешний Ключ (Foreign Key) - это у нас `article_id` - Внешним Ключом укажем Поле `article_id` Таблицы `category_articles`,
        # по принципу, Внешний Ключ Связываемой Таблицы - это Поле, связанное с Таблицей, чья Модель используется, т.е. Модель Article
        # а Related Key - это уже Поле `category_id` Таблицы `category_articles`
    }

    # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # # #

    # "Один ко многии" - Одна Статья, и у неё может быть много Комментариев ~
    # Мы не будем создавать лишних связующих Таблиц, а достаточно одной Таблицы `comments`
    # где в данной Таблице у нас будет Поле `article_id`, т.е. id той Статьи, к которой относиться текущий Комментарий
    # потому что Комментарий может оноситься только непосредственно к одной Статье
    public function comments()
    # ›››››› описание смотри в ArticlesAnyController
    {
        return $this->hasMany(Comment::class, 'article_id', 'id');
        # ------------------------------------------------------------------------------------------------------------------------
        # 1-й Параметр - это Модель связываемой Таблицы (где мы и вызываем данный Пользовательский comments() Метод)
        # 2-й Параметр - это Foreign Key (Внешний Ключ) из Таблицы `comments` по отношению к Таблице `articles`,
        # 3-й Параметр - это Primary Key (как Local Key) из Таблицы `articles` - текущей Модели Article
    }

    # ···································································

    public function addArticleModel($request)
    {
        $author = \Auth::user()->id;

        # при заполнении, совсем не обязательно придерживаться такой очереди, хотя лучше придерживаться
        $objArticle = $this->create([
            'title' => $request->input('title'),
            'short_text' => $request->input('short_text'),
            'full_text' => $request->input('full_text'),
            'user_id' => $author
        ]);

        return $objArticle;
    }

    # ···································································

    public function addCategoryArticleModel($request, $objArticle)
    {
        $objCategoryArticle = CategoryArticle::getInstance();

        # т.к. в Валидаторе мы уже проверили, что 'categories' - это Массив, то мы можем не делать условий
        # на проверку Массива, для использования его в foreach, и сразу в цикл передаём: foreach($request->input('categories') as ...
        # и из списка Массива Категорий, пройдём по всем Категориям, т.к. на данном шаге мы не можем знать
        # будет там одна Категория, или 20-ть Категорий, это всё зависит, от того, сколько будет добавлено Категорий к статье
        # !Массив - полученный из web-формы - будет содержать id Категорий!
        foreach($request->input('categories') as $category_id){

            # итак, у нас есть id конкретной Категории (на всякий случай приведём к int)
            $category_id = (int)$category_id;

            # Далее, нам нужно добавить в Таблицу `category_articles` id Категории и id Статьи
            # поэтому, сначала, логичнее будет записать данные о созданной статье в `articles` ^ код create() выше
            # а ниже, мы запишем данные в `category_articles`

            # в Таблицу `category_articles` добавляем:
            #   id выбранной Категории, к Статье
            #   и id Статьи
            $objCategoryArticle = $objCategoryArticle->create([

                # ! Обрати внимание ! мы находимся в Цикле !
                # поэтому если будет несколько выбранных Категорий к Статье,
                # соответственно будет несколько записей в Таблицу `category_articles`
                'category_id' => $category_id,
                # Объект, который мы заполнили, выше, после create(), получаем id последней добавленной статьи
                # (обрати внимание, что id добавляется автоматически) - получаем данный id и присваиваем в `article_id`
                'article_id' => $objArticle->id
            ]);
        } # end foreach
    }

    # ···································································

    public function editArticleModel($id)
    {
        $categories = Category::get();  # выбираем все Категории

        $objArticle = $this->find($id);     # От Объекта Article - ищём по Ключу $id, выбирая тем самым редактируемую статью
        if(!$objArticle) {                  # Если данного Объекта нет (т.е. Статья не найдена)
            return '404';                   # тогда возвращаем 404 Ошибку
        }

        # Наша задача, показать все Категории при редактировании Статьи,
        # и подсветить те Категории, которые добавлены к данной редактируемой Статье
        # и далее, при изменении, выбранные Категории к Статье будут удалены, и новые добавлены
        # Смотри Комментарий в views/admin/cabinet/articles/edit.blade.php

        # ›››››› Смотрим, что вернули нам Связи:
        /* › */ #dd($objArticle->categories);
        # ›››››› Обратие внимание, что в Таблице `articles` нет Поля `categories`,
        # ›››››› но Поле нам возвращается, за счёт указания Связи в Модели Article (Пользовательский categories() Метод)!

        # получим Категории которые привязаны к Статье в переменную (Массив)
        $mainCategories = $objArticle->categories;
        # инициализируем пустой массив
        $arrCategories = [];
        # пройдём в цикле все Категории -
        foreach($mainCategories as $category){
            # - получив id этих Категорий, и последовательно записав эти id в другой Массив
            $arrCategories[] = $category->id;
        }

        #dd($arrCategories); # посмотрим Массив с id Категориями

        $arrayData = ['categories'=>$categories, 'objArticle'=>$objArticle, 'arrCategories'=> $arrCategories];

        return $arrayData;
    }

    # ···································································

    public function editArticleModelRequest($request, $id)
    {
        # От Модели Article - ищём по Ключу, выбирая тем самым редактируемую статью
        $objArticle = $this->find($id);

        #dd($objArticle);

        # ActiveRecord (и здесь ActiveRecord вступает в силу, где мы через ActiveRecord - просто по Полям, обновляем Статью)
        # ~ порядок не важен
        # принимаем данные, записываем в Свойство Объекта
        $objArticle->title = $request->input('title');
        $objArticle->short_text = $request->input('short_text');
        $objArticle->full_text = $request->input('full_text');
        $objArticle->user_id = \Auth::user()->id;

        #dd($objArticle);

        # Сохраняем изменения, в БД, через Метод save(), и если save() нам возвращает true, значит у нас данные в БД обновились
        if ($objArticle->save()) {

            # далее: При Клике на selected Категориях, всё выделение снимается (иначе остаються).
            # И нам нужно получить и удалить все выделенные Категории, которые были до этого,
            # и далее добавить новые Категории, т.к. Категорий может быть много, и отслеживать каждую, какая добавлена,
            # а какая нет, это достаточно ресурсоёмко, поэтому проще просто стеком удалить все Категории
            # привязанные к Статье, и потом их заново добавить

            /* т.е. после успешного save(), когда у нас данные обновились, мы обновляем Категории */

            # Обновляем привязку к Категориям:

            # Создаём Объект к Модели CategoryArticle (Таблица `category_articles`)
            $objCategoryArticle = CategoryArticle::getInstance();
            # Удаляем те записи из Таблицы `category_articles`, где Поле `article_id` имеет соответствующий id,
            # а именно id редактируемой Статьи
            $objCategoryArticle->where('article_id', $objArticle->id)->delete();

            # далее, нам нужно получить Массив всех Категорий, которые были выбраны в момент отправки web-формы
            $arrCategories = $request->input('categories');

            # проверим, на Массив
            if (is_array($arrCategories)) {
                # разбираем данный Массив
                foreach ($arrCategories as $category) {
                    # добавляем Записи в Таблицу `category_articles`
                    $objCategoryArticle->create([
                        # добавляем id выбранной Категории
                        'category_id' => $category,
                        # добавляем id статьи
                        'article_id' => $objArticle->id
                    ]);
                }
            }

            # В итоге, логика проста:
            # Пользователь приходит, смотри какие у него Категории выбраны, выбирает новые, или оставляет прежними,
            # система при редактировании эти Категории удаляет, и заново перезаписывает, даже если он не изменял их,
            # потому что мы не знаем, изменял Пользователь Категории, или нет, для нас это не известно,
            # поэтому при каждом редактировании Статьи, мы обновляем (перезаписываем) Категории,
            # а именно обновляем данные в Связующей Таблице. Обновления Статей происходит не так часто,
            # поэтому данная операция - она не такая нагрузочная

            return true;
        }
    }

    # ···································································

}
