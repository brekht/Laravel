<!--Created by xenial-->

<!--У Laravel есть сессия, например, когда происходит redirect, или происходит ошибка, это событие записывается во Flash-сессию-->
<!--т.е. мы получаем сообщение из Flash-сессии, в ответ на 1-н Запрос. И мы можем это вывести, например используя alertify-->

<!-- ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: -->

<!--если сессия 'success' - есть-->
@if(session()->has('success'))
    <script type="text/javascript">
        $(function () {
            /* alertify.alert(" */ {{-- session()->get('success') --}} /* "); */
            alertify.success(" {{ session()->get('success') }} ");
        });
    </script>

<!-- ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: -->

<!--если сессия 'error' - есть-->
@elseif(session()->has('error'))
    <script type="text/javascript">
        $(function () {
            /* alertify.alert(" */ {{-- session()->get('error') --}} /* "); */
            alertify.error(" {{ session()->get('error') }} ");
        });
    </script>

<!-- ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: -->

<!--Блок Ошибок с не пройдённой отдельно созданной Request Валидации ··············································· -->
    <!--(обрати внимание, что срабатывает has / как 'errors', а не на 'success' иди 'error') ······················· -->
    <!--(т.к. все ошибки отдельного request приходят с отдельным значением 'errors') ······························· -->

    <!--Вывод Ошибок при не пройденной валидации - при специально созданном CategoryRequest (как это работает): ···· -->
    <!--используется Внешняя Flash-сессия (Сессия на 1-н Запрос / request) ········································· -->
    <!--ViewErrorBag (вывод default Ошибок, если бы мы переопределили Метод message() в созданном Request ·········· -->
    <!--в данном случае Ошибки были бы наши пользовательские) ······················································ -->

<!--итак, если сессия 'errors' - есть (если Сессия содержит Ошибки (has = имеет)) -->
@elseif(session()->has('errors'))

    <?php
        # смотрим, что сессия возвращает (get() выбираем все данные)
        #dd(session()->get('errors'));

        # Получим Объект Ошибок из Сессии - присвоим переменной $errors
        $errors = session()->get('errors'); $messages = "";

        # Выбрать всё '$errors->all(' - мы можем указать явно, какого типа Ошибки нужны, т.е. какого типа Объект нужен.
        # В нашем случае нам нужен Объект Message (см. что возвращает dd(), чтобы знать, с каким Объектом работать)
        # который нужно передать как Псевдо-переменную, в нашем случае ':message'
        foreach($errors->all(":message") as $message) {
        #foreach($errors->all("<p>:message</p>") as $message) {

            # Конкатенируем, чтобы собрать все сообщения (для их единого вывода в alertify)
            $messages .= $message.'<br>';
        }

        # Расскоментируй и посмотри
        #dd('^ errors');
    ?>

    <script type="text/javascript">
        $(function () {
            /* alertify.alert(" */ {{-- $messages --}} /* "); */
            alertify.error(" {!! $messages !!} ");
        });
    </script>

    <!-- Итак, мы получаем данные из ещё одной Flash-сессии 'errors' ··············································· -->
    <!-- Однако, это не самый правильный Вариант, но это и не самый плохой вариант ································· -->

@endif