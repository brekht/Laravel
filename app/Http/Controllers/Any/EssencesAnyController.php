<?php

/* Create by Xenial */

namespace app\Http\Controllers\Any;

use App\Http\Controllers\Controller;

# Models
use App\Models\Essence;
use App\Models\NumProperty;
use App\Models\DescProperty;
use App\Models\ImgProperty;
use App\Models\FreeProperty;

class EssencesAnyController extends Controller
{
    public function index()
    {
        # Объект Essence ======================================================================
        $objEssences  = Essence::getInstance();
        $objEssences  = $objEssences->get();      # Выбираем все Сущности
        # Если данных нет, выборки не произойдёт, и мы не получим содержимое в Объект
        if(count($objEssences)==0){
            # В этом случае, присвоим null, чтобы отследить это значение в шаблоне
            $objEssences = null;
        }
        # =====================================================================================

        # Объект Num ==========================================================================
        $objNumProperty  = NumProperty::getInstance();
        $numPropertyData  = $objNumProperty->select('num', 'essences_id')->get();

        $numArray=[];

        if(is_object($numPropertyData)){
            foreach($numPropertyData as $data){

                $numArray[$data->essences_id]['num']=$data->num;
            }
        }
                                                                                #dd($numArray);
        # =====================================================================================

        # Объект Desc =========================================================================
        $objDescProperty = DescProperty::getInstance();
        $descPropertyData = $objDescProperty->select('desc', 'essences_id')->get();

        $descArray=[];

        if(is_object($descPropertyData)){
            foreach($descPropertyData as $data){

                $descArray[$data->essences_id]['desc']=$data->desc;
            }
        }
                                                                                #dd($descArray);
        # =====================================================================================

        # Объект Img ==========================================================================
        $objImgProperty = ImgProperty::getInstance();
        $imgPropertyData = $objImgProperty->select('img', 'essences_id')->get();

        $imgArray=[];

        if(is_object($imgPropertyData)){
            foreach($imgPropertyData as $data){

                $imgArray[$data->essences_id]['img']=$data->img;
            }
        }
                                                                                #dd($imgArray);
        # =====================================================================================

        # Объект Free Property ================================================================
        $objFreeProperty = FreeProperty::getInstance();
        $freePropertyData = $objFreeProperty->select('col_prop', 'col_desc', 'essences_id')->get();

        # dd($freePropertyData);

        $freePropArray=[];
        $i=0;
        if(is_object($freePropertyData)){
            foreach($freePropertyData as $data){

                if($i==0){ $savePoint = $data->essences_id; }
                if($data->essences_id > $savePoint){
                    $i=0;
                }

                $freePropArray[$data->essences_id][$i]['col_prop']=$data->col_prop;
                $freePropArray[$data->essences_id][$i]['col_desc']=$data->col_desc;
                $i++;
            }
        }
                                                                            #dd($freePropArray);
        # =====================================================================================

        # Формируем массив Параметров
        $params = [
            'essences'          => $objEssences,
            'numProperties'     => $numArray,
            'descProperties'    => $descArray,
            'imgProperties'     => $imgArray,
            'freeProperties'    => $freePropArray,
        ];

        return view('any.essences.essencesCatalog', $params);
    }
}