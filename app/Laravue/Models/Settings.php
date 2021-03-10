<?php
/**
 * File Role.php
 *
 * @author Dinh Luong <luongquocdinh.95@gmail.com>
 * @package Laravue
 * @version
 */
namespace App\Laravue\Models;

use App\Laravue\Acl;
use Jenssegers\Mongodb\Eloquent\Model as Model;

/**
 * Class Role
 *
 * @property Permission[] $permissions
 * @property string $name
 * @package App\Laravue\Models
 */
class Settings extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

}
