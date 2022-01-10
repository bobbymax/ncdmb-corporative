<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 *
 * @OA\Schema(
 * @OA\Xml(name="Member"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 *  @OA\Property(property="membership_no", type="string", example="Membership Number"),
 *  @OA\Property(property="staff_no", type="string", example="Staff Number"),
 *  @OA\Property(property="designation", type="string", example="Designation"),
 *  @OA\Property(property="firstname", type="string", example="John"),
 *   @OA\Property(property="middlename", type="string", example="F."),
 *  @OA\Property(property="surname", type="String", example="Doe"),
 * @OA\Property(property="email", type="String", example="john@ncdmb.ng"),
 * @OA\Property(property="mobile", type="String", example="08127820880"),
 * @OA\Property(property="location", type="String", example="Abuja"),
 * @OA\Property(property="type", type="string", enum={"member","exco"}, example="exco"),
 *  @OA\Property(property="date_joined", type="date", example="2020-10-20"),
 * @OA\Property(property="can_guarantee", type="boolean", example="True"),
 * @OA\Property(property="has_loan", type="boolean", example="True"),
 * @OA\Property(property="status", type="string", enum={"active", "inactive"}, example="active"),
 * @OA\Property(property="email_verified_at", type="date", example="2020-10-20"),
 * @OA\Property(property="password", type="string", example="password"),
 * @OA\Property(property="remember_token", type="string", example="e8ryhqwer3r38r9h3rq3rq"),
 * @OA\Property(property="avatar", type="string", example="path to avatar"),
 *  @OA\Property(property="created_at", type="date", example="2020-10-20"),
 *  @OA\Property(property="updated_at", type="date", example="2020-12-22"),
 *  @OA\Property(property="deleted_at", type="date", example="2020-12-22"),
 *  @OA\Property(property="passwordChange", type="boolean", example="True"),
 * )
 * Class Member
 *
 */
class Member extends Model
{
    use HasFactory;

    protected $table = 'users';
}
