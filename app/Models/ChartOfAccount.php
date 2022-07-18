<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @OA\Schema(
 * @OA\Xml(name="ChartOfAccount"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 *  @OA\Property(property="account_code_id", type="integer", example="Account code ID"),
 * @OA\Property(property="code", type="integer", example="Account code"),
 * @OA\Property(property="name", type="string", example="Chart of ACcount Name"),
 * @OA\Property(property="label", type="string", example="Chart of ACcount label"),
 *  @OA\Property(property="created_at", type="date", example="2020-10-20"),
 *  @OA\Property(property="updated_at", type="date", example="2020-12-22"),
 * )
 * Class ChartOfAccount
 *
 */
class ChartOfAccount extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function accountCode()
    {
        return $this->belongsTo(AccountCode::class, 'account_code_id');
    }

    public function expenditures()
    {
        return $this->hasMany(Disbursement::class);
    }
}
