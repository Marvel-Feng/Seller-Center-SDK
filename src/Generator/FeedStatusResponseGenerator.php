<?php
/**
 * Created by PhpStorm.
 * User: salama
 * Date: 14/01/19
 * Time: 11:38 ص
 */

namespace SellerCenter\Generator;

use SellerCenter\Model\FeedStatus;

class FeedStatusResponseGenerator extends ResponseGenerator
{

    /**
     * @param array $body
     *
     * @return FeedStatus
     */
    public function makeBody(array $body): FeedStatus
    {
        $sellerCenterFeedStatus = new FeedStatus();

        $feedsBody = array_get($body, FeedStatus::SC_FEED_STATUS_FEED_DETAIL, null);

        if (isset($feedsBody))
            $this->hydrator->hydrate($feedsBody,$sellerCenterFeedStatus);

        return $sellerCenterFeedStatus;
    }
}