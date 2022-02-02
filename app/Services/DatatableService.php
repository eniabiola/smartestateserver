<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use DataTables;

class DatatableService
{
    public function processRequest(Request $request)
    {
        $posted_data_raw = $request->getContent();
        parse_str($posted_data_raw, $posted_data);
        //$columntoOrderBy = (!empty($posted_data['order'][0]['column'])) ? $posted_data['order'][0]['column'] : "created_at";
        $columntoOrderBy = $posted_data['order'][0]['column'];
        //$orderByValue = (!empty($posted_data['order'][0]['dir'])) ? $posted_data['order'][0]['dir'] : "asc";
        $orderByValue = $posted_data['order'][0]['dir'];
//        return $posted_data['columns'];
        if ($columntoOrderBy != 0)
        {
            $columntoOrderBy = $posted_data['columns'][$columntoOrderBy]['data'];
        } else {
            $columntoOrderBy = 'created_at';
        }
        $start = !empty($posted_data['start']) ? $posted_data['start'] : 0;
        $length = !empty($posted_data['length']) ? $posted_data['length'] : 50;
        $draw = !empty($posted_data['draw']) ? $posted_data['draw'] : 1;
        $search = !empty($posted_data['search']['value']) ? $posted_data['search']['value'] : "";

        return [
          'start' => $start,
          'length' => $length,
          'draw' => $draw,
           'search' => $search
        ];

    }

    public function outputResult(int $draw, int $totalRecords,  $data)
    {
        return [
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $data
        ];
    }

    public function dataTable(Request $request, Builder $builder, Array  $removecolumns = [], Array $addColumns = [],
                              callable $callback=null)
    {
        $posted_data_raw = $request->getContent();

        parse_str($posted_data_raw, $posted_data);
        $start = !empty($posted_data['start']) ? $posted_data['start'] : 0;
        $length = !empty($posted_data['length']) ? $posted_data['length'] : 50;
        $draw = !empty($posted_data['draw']) ? $posted_data['draw'] : 1;
        $search = $posted_data['search']['value'];

        $countProducts = $builder->count();
        $data = $builder->offset($start)->limit($length)->get();
        $newArray = $data->toArray();
        $keys = array_keys($newArray[0]);

        //remove unnecesary columns
        if (count($removecolumns) > 0)
        {
           $keys = $this->deleteColumn($keys, $removecolumns);
        }

        $keys =  collect(array_values($keys));
        $newData = $data->map(function ($dat) use ($keys, $addColumns){
            $collected = [];

            foreach($keys as $key)
            {

                $collected[$key] = $dat[$key];
            }
            if ($addColumns > 0)
            {
                $collected = $this->addcolumn($dat, $addColumns, $collected);
            }
            return $collected;
        });


        $final_data = [
            'draw' => $draw,
            'recordsTotal' => $countProducts,
            'recordsFiltered' => $countProducts,
            'data' => $newData
        ];
        return $final_data;
    }

    public function dataTable2(Request $request, Builder $builder, $fields = [], $columns = [], $defaultColumnToOrderBy="created_at")
    {
        $posted_data_raw = $request->getContent();

        parse_str($posted_data_raw, $posted_data);

        $columntoOrderBy = $posted_data['order'][0]['column'];
        $orderByValue = $posted_data['order'][0]['dir'];
        if ($columntoOrderBy != 0)
        {
            $columntoOrderBy = $posted_data['columns'][$columntoOrderBy]['data'];

            $findme   = '__dot__';

            if (strpos($columntoOrderBy, $findme) !== false) {
                $columntoOrderBy = str_replace($findme,'.',$columntoOrderBy);
            }

            if (!empty($columns) && !in_array($columntoOrderBy, $columns))
            {
                $columntoOrderBy = 'created_at';
            }
        } else {
            $columntoOrderBy = $defaultColumnToOrderBy;
        }
        $start = !empty($posted_data['start']) ? $posted_data['start'] : 0;
        $length = !empty($posted_data['length']) ? $posted_data['length'] : 50;
        $draw = !empty($posted_data['draw']) ? $posted_data['draw'] : 1;
        $search = $posted_data['search']['value']?? null;
//        return $search;
        //get the right query

        $countProducts = $builder->count();
        $data = $builder
                ->orderBy($columntoOrderBy, $orderByValue)
                ->offset($start)
                ->limit($length)
                ->get();
//                ->toSql();
        $data2return = [];
        $serial_no = $start;
        foreach ($data as $d) {
            $items = [];
            $items['sno'] = ++$serial_no;
            $items['responsiveness'] = '<div class="details-control" id="td-' . $serial_no  . '"></div>';
            $fields_collection = collect($fields);
            $fields_collection->each(function ($field, $index) use (&$items, $d){
                if(is_string($field) and $field == '*'){
                    foreach ($d->toArray() as $x => $y){
                        $items[$x] = $y;
                    }
                }else{
                    $key = is_int($index)? $field: $index;
                    $items[$key] = is_callable($field)? $field($d):  $d["$field"]??null;
//                $items[$key] = $d["$index"];
                }

            });
            $data2return[] = $items;
//            $data2return[] = $d;
        }

        $final_data = [
            'draw' => $draw,
            'recordsTotal' => $countProducts,
            'recordsFiltered' => $countProducts,
            'data' => $data2return
        ];
        return $final_data;
    }

    static function test()
    {
        $dt = new self();
        $query = User::query();
        return $dt->dataTable2(\request(), $query, [
            'id',
            'last_name' => 'lastname',
            'first_name' => 'firstname',
            'email' => 'email',
            'username',
            'status',
            'action' => function (User $user){
                return "<h1>{$user->name}</h1>";
            }
        ]);
    }

    protected function deleteColumn( Array $array, Array $columns)
    {
        foreach($columns as $column)
        {
            if (($key = array_search($column, $array)) !== false) {
                unset($array[$key]);
            }
        }
        return array_values($array);
    }

    protected function addcolumn($index, $addColumns, $resultArray)
    {
//        \Log::debug(print_r($addColumns, true));
//        \Log::debug(print_r(array_keys($addColumns), true));

        foreach($addColumns as $column => $value)
        {
            if (is_callable($value))
            {
                /*
                 *
                 * function ($model) use ($attribute) {
                return $model->getAttribute($attribute);
            }
                 */
                $resultArray[$column] = $index->budgetHead->budgethead_code;
            } else {
                $resultArray[$column] = $value;
            }
        }

        return $resultArray;

    }

    public function addColumns(array $names, $order = false)
    {
        foreach ($names as $name => $attribute) {
            if (is_int($name)) {
                $name = $attribute;
            }

            $this->addColumn($name, function ($model) use ($attribute) {
                return $model->getAttribute($attribute);
            }, is_int($order) ? $order++ : $order);
        }

        return $this;
    }

}
