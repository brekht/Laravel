<!-- Create by Xenial -->

@extends('layouts.any.essences')

@section('content')

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading -->
        <h1 class="my-4">Essences Catalog</h1>

        <div class="row">

            <!-- ··································································································· -->
            <!-- ··································································································· -->
            <!-- ··································································································· -->
            @if($essences == null)
                <div class="nullEssencesMessage">
                    Сущности не созданы! Соответственно и Свойств к ним также нет!<br>
                    Зарегистрируйтесь, авторизуйтесь и создайте Сущность!
                </div>
            @else
                @foreach($essences as $essence)

                    <div class="col-lg-3 col-md-4 col-sm-6 portfolio-item">
                        <div class="card h-100">
                        <!-- ··························································································· -->

                            <div class="top-essence"><p>{{$essence->name}}</p></div>

                            <div class="author-essence">
                                <p> Автор:
                                    <span class="author-span">
                                        {{_user($essence->first_author)->email}}
                                    </span>
                                    &nbsp; Дата добавления:
                                    <span class="date-span">
                                        {{$essence->created_at->format('H:i · d.m.Y')}}
                                    </span>
                                </p>
                            </div>

                            <div class="father-top">

                                @if(array_key_exists($essence->id, $imgProperties))
                                        <img class="card-img-top" src="{{ asset('images/'.$imgProperties[$essence->id]['img']) }}" alt="" style="width: 150px; border-radius: 7px">
                                        <?php $img=true ?>
                                @else
                                        <img class="card-img-top" src="{{ asset('any/essences/img/no_image.png') }}" alt="" style="width: 150px; border-radius: 7px">
                                        <?php $img=false ?>
                                @endif


                                <div class="right-child-top">
                                    <div class="head-right-child-top"><p>Стандартные Свойства</p></div>
                                    <div class="num-right-child-top">
                                        <p>Количество:
                                            <span class="num-span">
                                                @if(array_key_exists($essence->id, $numProperties))
                                                    {{$numProperties[$essence->id]['num']}}
                                                @else
                                                    <span class="dots">{{'···'}}</span>
                                                @endif
                                            </span>
                                        </p>
                                    </div>

                                    <div class="img-right-child-top-info">
                                        <p>Изображение:
                                            <span class="img-span">
                                                @if($img==true)
                                                    <span style="color: #61b765">{{'есть'}}</span>
                                                @else
                                                    <span style="color: #bbbbbb">{{'нет'}}</span>
                                                @endif
                                            </span>
                                        </p>
                                    </div>

                                    <div class="desc-right-child-top"><p>Описание:</p></div>
                                    <div class="desc-right-child-top-description">
                                        <p>
                                            @if(array_key_exists($essence->id, $descProperties))
                                                {{$descProperties[$essence->id]['desc']}}
                                            @else
                                                <span class="dots">{{'···'}}</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="bordered-line"></div>

                            <div class="father-bottom">
                                <div class="head-child-bottom"><p>Свободные Свойства</p></div>

                                <!-- ··· -->
                                <div class="box-child-bottom">
                                    <div class="name-desc-child-bottom">

                                        <?php $i=0; ?>
                                        @if(array_key_exists($essence->id, $freeProperties))
                                            @foreach($freeProperties[$essence->id] as $essenceIterate)

                                                <p> <span style="color: #aedce0"> {{ ($i+1 . '. ') }} </span>

                                                    <b>
                                                        <?php
                                                            $iterateNum = count($freeProperties[$essence->id]);
                                                            if($i==$iterateNum){
                                                                $i=0;
                                                            }
                                                        ?>

                                                        {{ $freeProperties[$essence->id][$i]['col_prop'] }}
                                                    </b>
                                                    <span class="desc-span">
                                                            {{ $freeProperties[$essence->id][$i]['col_desc'] }}
                                                    </span>
                                                </p>
                                                <?php $i++; ?>
                                            @endforeach
                                        @else
                                                <p>
                                                    <span style="color: #bbbbbb">{{ 'не созданы' }}</span>
                                                </p>
                                        @endif
                                    </div>
                                </div>
                                <!-- ··· -->
                            </div><!-- /.father-bottom -->

                        <!-- ··························································································· -->
                        </div><!-- /.card h-100 -->
                    </div><!-- /.col-lg-3 col-md-4 col-sm-6 portfolio-item -->

                @endforeach
            @endif
            <!-- ··································································································· -->
            <!-- ··································································································· -->
            <!-- ··································································································· -->

        </div><!-- /.row -->



        <!-- Pagination -->
        <!-- ··············································································
        <ul class="pagination justify-content-center">
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
            <li class="page-item">
                <a class="page-link" href="#">1</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="#">2</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="#">3</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
        </ul>
        ·············································································· -->

    </div>
    <!-- /.container -->

@stop