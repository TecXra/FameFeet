<?php

namespace App\Helpers;

use Illuminate\Container\Container;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class PaginationHelper
{
    public static function paginate($data,$search=null,$perPage=null)
    {
        $results = new Collection($data);
        if(!isset($perPage)){
           $showPerPage = config('famefeet.show_per_page');
        }else{
            $showPerPage = $perPage;
        }
        // return $showPerPage;

        $pageNumber = Paginator::resolveCurrentPage('page');

        $totalPageNumber = $results->count();

        $currentPageResults = $results->slice(($pageNumber - 1) * $showPerPage, $showPerPage)->values();

        $search = request('search');
        // $search = str_replace('%', '', $searchQuery);

        // if ($search) {
        //     echo "You searched for: " . $search;
        // } else {
        //     echo "No search query specified.";
        // }

        // if (isset($_GET['search'])) {
        //     $search = $_GET['search'];
        //     // echo "You searched for: " . $search;
        // } else {
        //     echo "No search query specified.";
        // }




        return self::paginator($currentPageResults, $totalPageNumber, $showPerPage, $pageNumber, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page',
            'query' => ['search' =>  $search],
        ]);

    }

    /**
     * Create a new length-aware paginator instance.
     *
     * @param  \Illuminate\Support\Collection  $items
     * @param  int  $total
     * @param  int  $perPage
     * @param  int  $currentPage
     * @param  array  $options
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    protected static function paginator($items, $total, $perPage, $currentPage, $options)
    {
        return Container::getInstance()->makeWith(LengthAwarePaginator::class, compact(
            'items', 'total', 'perPage', 'currentPage', 'options'
        ));
    }
}
