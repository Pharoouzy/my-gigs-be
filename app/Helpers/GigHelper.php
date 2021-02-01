<?php
/**
 * Created by PhpStorm.
 * User: umar-farouq
 * Date: 11/10/20
 * Time: 04:32 AM
 */

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

/**
 * Trait RequestHelper
 * @package App\Helpers
 */
trait GigHelper {

    use RequestHelper;

    /**
     * Check if the dates
     * @param $coupon
     * @return bool
     */
    private function checkCouponDate($coupon) {

        $start_date = Carbon::parse($coupon->start_date);
        $end_date = Carbon::parse($coupon->end_date);
        $current_date = Carbon::now();

        if($start_date->greaterThan($current_date) || $end_date->lessThan($current_date)) {
            return false;
        }

        return true;
    }


    /**
     * Apply coupon code rules
     * @param $data
     * @param $coupon
     * @return \Illuminate\Http\JsonResponse
     */
    public function applyCouponCode($data, $coupon) {

        if(!$this->checkCouponDate($coupon)) {
            return $this->error('Coupon code has expired or is not valid');
        }

        if($coupon->usage === $coupon->limit) {
            return $this->error('Coupon code has been used to its limit or is not valid');
        }

        if ($data['sub_total'] < $coupon->min_amount) {
            return $this->error('Coupon code can not be applied on amount less than $'.$coupon->min_amount);
        }

        if ($data['item_count'] < $coupon->item_count) {
            return $this->error('Coupon code can not be applied on item less than $'.$coupon->item_count);
        }

        $amount = $data['sub_total'];
        $adjusted_price = $this->calculateDiscount($amount, $coupon);

        if($coupon->usage <= $coupon->limit){
            $coupon->update(['usage' => $coupon->usage + 1]);

            $data = ['adjusted_price' => $adjusted_price];

            return $this->response('success', $data);
        }

        return $this->error('Coupon code has been used to its limit or is not valid');
    }

    /**
     * @param $amount
     * @param $coupon
     * @return float|int|mixed
     */
    private function calculateDiscount($amount, $coupon) {
        if($coupon->discount_type == 'amount') {
            $adjusted_amount = $this->calculateFixedDiscount($amount, $coupon->discount);
        }
        elseif($coupon->discount_type == 'percentage') {
            $adjusted_amount = $this->calculatePercentDiscount($amount, $coupon->discount);
        }
        elseif($coupon->discount_type == 'mixed') {
            $percent_amount = $this->calculatePercentDiscount($amount, $coupon->discount, false);
            $fixed_amount = $coupon->discount;
            $fixed = $this->calculateFixedDiscount($amount, $coupon->discount);
            $percent = $this->calculatePercentDiscount($amount, $coupon->discount);
            $adjusted_amount = ($percent_amount > $fixed_amount) ? $percent : $fixed;
        }
        else{
            $fixed = $this->calculateFixedDiscount($amount, $coupon->discount);
            $percent = $this->calculatePercentDiscount($amount, $coupon->discount);
            $adjusted_amount = $this->calculateFixedDiscount($fixed, $coupon->discount);
            $adjusted_amount = $this->calculatePercentDiscount($adjusted_amount, $coupon->discount);
        }

        return $adjusted_amount;

    }

    /**
     * @param $amount
     * @param $discount
     * @return mixed
     */
    private function calculateFixedDiscount($amount, $discount){
        $fixed_amount = $amount - $discount;

        return $fixed_amount;
    }

    /**
     * @param $amount
     * @param $discount
     * @return float|int
     */
    private function calculatePercentDiscount($amount, $discount, $status = true){
        $percent_amount = ($discount / 100) * $amount;
        $percent_amount = ($status) ? $amount - $percent_amount : $percent_amount;
        return $percent_amount;
    }

    /**
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    private function error($message) {
        return $this->validateCustomError([
            'coupon_code' => [$message]
        ]);
    }
}