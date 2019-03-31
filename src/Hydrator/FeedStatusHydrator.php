<?php
/**
 * Created by PhpStorm.
 * User: salama
 * Date: 20/01/19
 * Time: 04:38 م
 */

namespace SellerCenter\Hydrator;

use Illuminate\Support\Arr;
use SellerCenter\Generator\ResponseGenerator;
use SellerCenter\Model\FeedError;
use SellerCenter\Model\FeedStatus;
use SellerCenter\Model\FeedWarning;

class FeedStatusHydrator implements Hydrator
{

    /**
     * @param array      $data
     * @param FeedStatus $newFeedStatus
     */
    public function hydrate(array $data, &$newFeedStatus)
    {
        $feedErrors       = [];
        $feedWarnings     = [];
        $newFeedStatus->setStatus($data[FeedStatus::SC_FEED_STATUS_FEED_STATUS]);
        $newFeedStatus->setFailedRecords($data[FeedStatus::SC_FEED_STATUS_FEED_FAILED_RECORDS]);
        $newFeedStatus->setProcessedRecords(
            $data[FeedStatus::SC_FEED_STATUS_FEED_PROCESSED_RECORDS]
        );
        $feedWarningsBody = Arr::get(
            $data,
            FeedStatus::SC_FEED_STATUS_FEED_WARNINGS.'.'
            .FeedStatus::SC_FEED_STATUS_FEED_WARNING,
            []
        );
        $feedWarningsBody = ResponseGenerator::to2DArrayIfNot($feedWarningsBody);
        $feedErrorsBody   = Arr::get(
            $data,
            FeedStatus::SC_FEED_STATUS_FEED_ERRORS.'.'
            .FeedStatus::SC_FEED_STATUS_FEED_ERROR,
            []
        );
        $feedErrorsBody = ResponseGenerator::to2DArrayIfNot($feedErrorsBody);
        foreach ($feedWarningsBody as $feedWarning) {
            $feedWarnings[] = new FeedWarning(
                $feedWarning[FeedStatus::FEED_STATUS_WARNING_MESSAGE_RESPONSE_KEY], $feedWarning[FeedStatus::FEED_STATUS_WARNING_SELLER_SKU_RESPONSE_KEY]
            );
        }
        foreach ($feedErrorsBody as $feedError) {
            $feedErrors[] = new FeedError(
                $feedError[FeedStatus::FEED_STATUS_ERROR_MESSAGE_KEY],
                $feedError[FeedStatus::FEED_STATUS_ERROR_SELLER_SKU_KEY],
                $feedError[FeedStatus::FEED_STATUS_ERROR_CODE_KEY]
            );
        }
        $newFeedStatus->setFeedWarnings($feedWarnings);
        $newFeedStatus->setFeedErrors($feedErrors);
        $newFeedStatus->setFeedId($data[FeedStatus::SC_FEED_STATUS_FEED]);
        $newFeedStatus->setRequestAction($data[FeedStatus::SC_FEED_STATUS_FEED_ACTION]);
    }
}