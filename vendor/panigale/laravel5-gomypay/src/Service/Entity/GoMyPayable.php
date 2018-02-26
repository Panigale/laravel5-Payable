<?php
/**
 * Author: Panigale
 * Date: 2017/11/21
 * Time: 上午11:13
 */

namespace Panigale\GoMyPay\Service\Entity;


use Event;
use App\Events\PaymentFlows\CatchResultEvent;
use Sportlottery\Repositories\PaymentFlowRepository;

abstract class GoMyPayable implements EntityContract
{
    use GoMyPayParams;

    /**
     * 接收回應資訊
     *
     * @param array $response
     * @return array
     */
    public function receive(array $response)
    {
        return $this->getParams($response);
    }
}