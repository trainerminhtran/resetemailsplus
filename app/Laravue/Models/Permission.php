<?php
/**
 * File Permission.php
 *
 * @author Nguyen Hien <nguyen.van.hien.cdtin@gmail.com>
 * @package Laravue
 * @version 1.0
 */

namespace App\Laravue\Models;
use App\Laravue\Acl;
use Illuminate\Database\Query\Builder;

/**
 * Class Permission
 *
 * @package App\Laravue\Models
 */
class Permission extends \Maklad\Permission\Models\Permission
{
    /**
     * To exclude permission management from the list
     *
     * @param $query
     * @return Builder
     */
    public function scopeAllowed($query)
    {
        return $query->where('name', '!=', Acl::PERMISSION_PERMISSION_MANAGE);
    }
}
