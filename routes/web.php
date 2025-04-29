<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/soal-2', function () {
    echo 'Best Time to Buy and Sell Stock II'.'<br>';
    echo 'Input: prices = [1,2,3,4,5]'.'<br>';
    echo 'Output: 4'.'<br>';
    echo 'Explanation: Buy on day 1 (price = 1) and sell on day 5 (price = 5), profit = 5-1 = 4.'.'<br>';
    echo 'Total profit is 4.'.'<br><br>';

    echo 'My Testing Code'.'<br>';
    $arr = [1,2,3,4,5];
    $profit = 0;
    $n = count($arr);

    for ($i = 1; $i < $n; $i++) {
        if ($arr[$i] > $arr[$i - 1]) {
            $profit += $arr[$i] - $arr[$i - 1];
        }
    }

    return $profit;
});

Route::get('/soal-3', function () {
    echo 'Rotate Array'.'<br>';
    echo 'Input: nums = [1,2,3,4,5,6,7], k = 3'.'<br>';
    echo 'Output: [3,99,-1,-100]'.'<br>';

    echo 'My Testing Code'.'<br>';
    $arr    = [-1,-100,3,99];
    $k      = 2;
    $n      = count($arr) - $k;
    $str_arr = ''; 
    for ($i = $k; $i > 0; $i--) {
        $indexSearch = count($arr) - $i ;
        $str_arr .= $arr[$indexSearch].',';
    }

    for ($i=0; $i < $n; $i++) { 
        $str_arr .= $arr[$i].',';
    }

    $arr_new = explode(',',substr($str_arr,0,-1));

    $num = $arr_new;

    print_r($num);
});



Route::get('/soal-4', function () {
    echo 'Contains Duplicate'.'<br>';
    echo 'Input: nums = [1,2,3,1]'.'<br>';
    echo 'Output: true'.'<br>';

    echo 'My Testing Code'.'<br>';
    $nums    = [1,2,3,1];
    $count_real = count($nums);
    $count_uniq = count(array_unique($nums));
    $status     = false;
    if($count_real !== $count_uniq){
        $status = true;
    } 
    echo $status;
});



Route::get('/soal-5', function () {
    echo 'Single Number'.'<br>';
    echo 'Example 1:'.'<br>';
    echo 'Input: nums = [2,2,1]'.'<br>';
    echo 'Output: 1'.'<br>';
    echo 'Example 2:'.'<br>';
    echo 'Input: nums = [4,1,2,1,2]'.'<br>';
    echo 'Output: 4'.'<br>';
    echo 'Example 3:'.'<br>';
    echo 'Input: nums = [1]'.'<br>';
    echo 'Output: 1'.'<br>';
    echo 'Input: nums = [1,2,3,1]'.'<br>';
    echo 'Output: true'.'<br><br>';

    echo 'My Testing Code'.'<br>';
    $num = [4,1,2,1,2];
    $counts = array_count_values($num); // Hitung jumlah kemunculan
    $unique = '';

    foreach ($counts as $value => $count) {
        if ($count !== 1) {
            $unique .= $value.','; // Hanya yang muncul 1x
        }
    }

    return $unique;
});



Route::get('/soal-6', function () {
    $nums = [0,1,0,3,12];
    $insertPos = 0;

    $str_arr_zero = '';
    $str_arr_notzero = '';
    // Geser semua non-zero ke depan
    for ($i = 0; $i < count($nums); $i++) {
        if ($nums[$i] != 0) {
            $str_arr_notzero .= $nums[$i].',';
        } else {
            $str_arr_zero .= $nums[$i].',';
        }
    }
    $str_res = $str_arr_notzero.''.$str_arr_zero;

    $str_res = explode(',',substr($str_res, 0, -1));
    $nums = $str_res;
});
function moveZeroes(&$nums) {
    $str_arr_zero = '';
    $str_arr_notzero = '';
    // Geser semua non-zero ke depan
    for ($i = 0; $i < count($nums); $i++) {
        if ($nums[$i] != 0) {
            $str_arr_notzero .= $nums[$i].',';
        } else {
            $str_arr_zero .= $nums[$i].',';
        }
    }
    $str_res = $str_arr_notzero.''.$str_arr_zero;

    $arr_new = explode(',',substr($str_res, 0, -1));
    $nums = $arr_new;
}

function oddEvenList($head) {
    if ($head === null || $head->next === null) {
        return $head;
    }

    $odd = $head;
    $even = $head->next;
    $evenHead = $even;

    while ($even !== null && $even->next !== null) {
        $odd->next = $even->next;
        $odd = $odd->next;

        $even->next = $odd->next;
        $even = $even->next;
    }

    $odd->next = $evenHead;
    return $head;
}
