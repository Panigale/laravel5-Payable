<?php
/**
 * Author: Panigale
 * Date: 2018/1/18
 * Time: 下午1:49
 */

namespace Panigale\GoMyPay\Service\Entity;


interface EntityContract
{
    /**
     * 傳送交易資訊到 GoMyPay 後，會附帶交易資訊回到 callback url 的處理方法
     *
     * @return mixed
     */
    public function callback(array $response);

    /**
     * 背景接收交易資訊
     *
     * @return mixed
     */
    public function receive(array $notification);
}