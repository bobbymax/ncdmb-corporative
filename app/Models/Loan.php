<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @OA\Schema(
 * @OA\Xml(name="Loan"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="user_id", type="integer", example="14"),
 * @OA\Property(property="budget_head_id", type="integer", example="14"),
 * @OA\Property(property="code", type="string" , example="Loan Code"),
 * @OA\Property(property="amount", type="number", format="double", example="Investment Label"),
 * @OA\Property(property="reason", type="string", example="Loan reason"),
 * @OA\Property(property="description", type="string", example="Loan Description"),
 * @OA\Property(property="status", type="string", enum={"pending", "registered", "approved", "denied", "disbursed", "closed"}, example="closed"),
 * @OA\Property(property="level", type="integer",  example="0"),
 * @OA\Property(property="guaranteed", type="integer", example="1"),
 * @OA\Property(property="closed", type="boolean"),
 * @OA\Property(property="created_at", type="date", example="2020-10-20"),
 * @OA\Property(property="updated_at", type="date", example="2020-12-22"),
 * )
 * Class Loan
 *
 */
class Loan extends Model
{
    use HasFactory;

    protected $guarded = [''];
    protected $dates = ['start_date', 'end_date'];

    public function member()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function batchEntries()
    {
        return $this->morphMany(BatchEntry::class, 'batchable');
    }

    public function fund()
    {
    	return $this->belongsTo(BudgetHead::class, 'budget_head_id');
    }

    public function expenditure()
    {
        return $this->hasOne(Disbursement::class);
    }

    public function instructions()
    {
        return $this->hasMany(Instruction::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function receivers()
    {
        return $this->morphOne(Receive::class, 'receiveable');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function guarantors()
    {
        return $this->morphToMany(User::class, 'guarantorable')->withPivot('remarks', 'status');
    }

    public function sponsors()
    {
        return $this->hasMany(Guarantor::class);
    }

    public function approvals()
    {
        return $this->morphToMany(User::class, 'approveable')->withPivot('remark', 'status');
    }

    public function trails()
    {
        return $this->morphMany(Trail::class, 'trailable');
    }

    public function payments()
    {
        return $this->morphMany(Pay::class, 'payable');
    }

    public function mandates()
    {
        return $this->morphMany(Mandate::class, 'mandateable');
    }

}
