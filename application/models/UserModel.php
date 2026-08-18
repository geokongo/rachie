<?php namespace Models;

/**
 * User Model
 *
 * Manages user accounts for authentication and authorization.
 * Supports role-based access control with super, admin, staff, and user roles.
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright 2015 - 2030 Geoffrey Okongo
 * @category Models
 * @package Models\UsersModel
 * @link https://github.com/glivers/rachie
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 2.0.1
 */

use Rackage\Model;

class UserModel extends Model
{
    /**
     * Database table name
     *
     * @var string
     */
    protected static $table = 'users';

    /**
     * Enable automatic timestamp management
     *
     * @var bool
     */
    protected static $timestamps = true;

    /**
     * @column
     * @primary
     * @autonumber
     */
    protected $id;

    /**
     * User email address
     * @column
     * @varchar 255
     * @unique
     */
    protected $email;

    /**
     * Bcrypt password hash
     * @column
     * @varchar 255
     */
    protected $password;

    /**
     * User display name
     * 
     * @column
     * @varchar 100
     */
    protected $name;

    /**
     * User role in the application
     * 
     * @column
     * @enum super,admin,staff,user
     * @default user
     */
    protected $role;

    /**
     * Whether user account is active
     * 
     * @column
     * @boolean
     * @default 1
     */
    protected $active;

    /**
     * Last login timestamp
     * 
     * @column
     * @int 11
     * @unsigned
     * @nullable
     */
    protected $last_login;

    /**
     * Remember me token hash
     * 
     * @column
     * @varchar 64
     * @nullable
     */
    protected $remember_token;

    /**
     * Password reset token hash
     * 
     * @column
     * @varchar 64
     * @nullable
     */
    protected $reset_token;

    /**
     * Password reset expiration timestamp
     * 
     * @column
     * @int 11
     * @unsigned
     * @nullable
     */
    protected $reset_expires;

    /**
     * Date user account was first created
     * 
     * @column
     * @datetime
     * @rename date_created
     */
    protected $created_at;

    /**
     * Date user account was last updated
     * 
     * @column
     * @datetime
     * @rename date_modified
     */
    protected $updated_at;
}
