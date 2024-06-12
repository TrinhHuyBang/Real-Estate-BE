<?php

namespace App\Traits;

trait OrderByKey
{
    public function getOrderByKey($order)
    {
        $orderBy = 'desc';
        $orderWith = 'published_at';
        switch ($order) {
            case 'Giá thấp đến cao':
                $orderBy = 'asc';
                $orderWith = 'price';
                break;
            case 'Giá cao đến thấp':
                $orderBy = 'desc';
                $orderWith = 'price';
                break;
            case 'Diện tích lớn đến bé':
                $orderBy = 'desc';
                $orderWith = 'size';
                break;
            case 'Diện tích bé đến lớn':
                $orderBy = 'asc';
                $orderWith = 'size';
                break;
            case 'Tin mới nhất':
                $orderBy = 'desc';
                $orderWith = 'published_at';
                break;
            default:
                
        }
        return ['order_by' => $orderBy, 'order_with' => $orderWith];
    }
}