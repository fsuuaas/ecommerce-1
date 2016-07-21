<?php
/**
 * Created by Miki Maine Amdu.
 * For : INNOVATE E-COMMERCE
 * User: MIKI$
 * Date: 4/22/2016
 * Time: 3:59 PM
 */

namespace Innovate\Repositories\Eav\Value;
use App\Exceptions\GeneralException;
use Innovate\Eav\Value\ProductAttributeInt;


/**
 * Class EloquentEavValueIntRepository
 * @package Innovate\Repositories\Eav\Value
 */
class EloquentEavValueIntRepository implements EavValueIntContract{


    /**
     * @param  $id
     * @return mixed
     * @internal param bool $withRoles
     */
    public function findOrThrowException($id)
    {
        // TODO: Implement findOrThrowException() method.
    }

    /**
     * @param  $per_page
     * @param  string $order_by
     * @param  string $sort
     * @return mixed
     * @internal param $status
     */
    public function Paginated($per_page, $order_by = 'id', $sort = 'asc')
    {
        // TODO: Implement Paginated() method.
    }

    /**
     * @param  string $order_by
     * @param  string $sort
     * @return mixed
     */
    public function getAll($order_by = 'id', $sort = 'asc')
    {
        // TODO: Implement getAll() method.
    }

    /**
     * @param  $input
     * @return mixed
     * @internal param $roles
     */
    public function create($input)
    {
        // TODO: Implement create() method.
    }

    /**
     * @param  $id
     * @param  $input
     * @return mixed
     * @internal param $roles
     */
    public function update($id, $input)
    {
        // TODO: Implement update() method.
    }

    /**
     * @param  $id
     * @return mixed
     */
    public function destroy($id)
    {
        // TODO: Implement destroy() method.
    }

    /**
     * @param  $id
     * @return mixed
     */
    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    /**
     * @param $product
     * @param $new_string
     * @param $value
     * @return mixed
     * @throws GeneralException
     * @internal param $input
     * @internal param $roles
     */
    public function createFromInput($product, $new_string, $value)
    {
        $int = new ProductAttributeInt();
        $int->product_id = $product->id;
        $int->product_attribute_id = $new_string[2];
        $int->value = $value;
        try {
            if ($int->save()) {
                return true;
            }

        } catch (GeneralException $e) {

        }throw new GeneralException('Something went wrong Inserting Custom Int Value. Try again later!');
    }
}