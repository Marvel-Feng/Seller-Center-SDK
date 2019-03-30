<?php
/**
 * Created by PhpStorm.
 * User: salama
 * Date: 14/01/19
 * Time: 11:36 ص
 */

namespace SellerCenter\Model;

class FeedStatus
{
    /**
     * FeedStatus Response body keys
     */
    const SC_FEED_STATUS_FEED_DETAIL            ='FeedDetail';
    const SC_FEED_STATUS_FEED                   ='Feed';
    const SC_FEED_STATUS_FEED_STATUS            ='Status';
    const SC_FEED_STATUS_FEED_ACTION            ='Action';
    const SC_FEED_STATUS_FEED_CREATION_DATE     ='CreationDate';
    const SC_FEED_STATUS_FEED_SOURCE            ='Source';
    const SC_FEED_STATUS_FEED_TOTAL_RECORDS     ='TotalRecords';
    const SC_FEED_STATUS_FEED_PROCESSED_RECORDS ='ProcessedRecords';
    const SC_FEED_STATUS_FEED_FAILED_RECORDS    ='FailedRecords';
    const SC_FEED_STATUS_FEED_ERRORS            ='FeedErrors';
    const SC_FEED_STATUS_FEED_ERROR             ='Error';
    const SC_FEED_STATUS_FEED_WARNINGS          ='FeedWarnings';
    const SC_FEED_STATUS_FEED_WARNING           ='Warning';


    const DATE_FORMAT ='Y-m-d H:i:s';

    const ACTION_PRODUCT_CREATE ='ProductCreate';
    const ACTION_PRODUCT_UPDATE ='ProductUpdate';
    const ACTION_IMAGE          ='Image';


    /**
     * Feed action that manipulate essential product data except images
     */
    const PRODUCT_FEED_ACTIONS
        = [
            self::ACTION_PRODUCT_CREATE,
            self::ACTION_PRODUCT_UPDATE,
        ];


    /** FeedStatus Statuses */
    const FEED_QUEUED_STATUS     ='Queued'; //The feed was successfully added to the queue and is awaiting processing.
    const FEED_PROCESSING_STATUS ='Processing'; //The feed is currently being processed by the server.
    const FEED_CANCELLED_STATUS  ='Canceled'; //The feed was canceled by the seller.
    const FEED_FINISHED_STATUS   ='Finished'; //The feed has finished processing
    const FEED_ERROR_STATUS      ='Error'; //The feed has finished with error(s)


    /**
     * FeedStatus Status that signify that the whole feed failed
     */
    const FAILURE_FEED_STATUSES
        = [
            self::FEED_CANCELLED_STATUS,
            self::FEED_ERROR_STATUS,
        ];


    /**
     * FeedStatus Status that signify that the feed is still in progress
     */
    const IN_PROGRESS_FEED_STATUSES
        = [
            self::FEED_QUEUED_STATUS,
            self::FEED_PROCESSING_STATUS,
        ];


    /** FeedStatus Field Keys */
    const FEED_STATUS_ERROR_CODE_KEY                  ='Code';
    const FEED_STATUS_FEED_DETAIL_KEY                 ='FeedDetail';
    const FEED_STATUS_ERROR_MESSAGE_KEY               ='Message';
    const FEED_STATUS_ERROR_SELLER_SKU_KEY            ='SellerSku';
    const FEED_STATUS_FAILED_RECORDS_RESPONSE_KEY     ='FailedRecords';
    const FEED_STATUS_STATUS_RESPONSE_KEY             ='Status';
    const FEED_STATUS_CREATION_DATE_RESPONSE_KEY      ='CreationDate';
    const FEED_STATUS_TOTAL_RECORDS_RESPONSE_KEY      ='TotalRecords';
    const FEED_STATUS_PROCESSED_RECORDS_RESPONSE_KEY  ='ProcessedRecords';
    const FEED_STATUS_FEED_ERRORS_RESPONSE_KEY        ='FeedErrors';
    const FEED_STATUS_ERROR_RESPONSE_KEY              ='Error';
    const FEED_STATUS_FEED_WARNINGS_RESPONSE_KEY      ='FeedWarnings';
    const FEED_STATUS_WARNING_RESPONSE_KEY            ='Warning';
    const FEED_STATUS_WARNING_MESSAGE_RESPONSE_KEY    ='Message';
    const FEED_STATUS_WARNING_SELLER_SKU_RESPONSE_KEY ='SellerSku';

    /** @var  string $feedId */
    protected $feedId;

    /** @var  string $requestAction */
    protected $requestAction;

    /** @var  string $timeStamp */
    protected $timeStamp;


    /** @var  integer $totalRecords */
    protected $totalRecords;

    /** @var  integer $failedRecords */
    protected $failedRecords;

    /** @var  integer $processedRecords */
    protected $processedRecords;

    /** @var  \DateTime $creationDate */
    protected $creationDate;

    /** @var  \DateTime $creationDate */
    protected $updatedDate;

    /** @var  string */
    protected $status;

    /** @var FeedWarning[] $feedWarnings */
    protected $feedWarnings;

    /** @var  FeedError[] $feedErrors */
    protected $feedErrors;


    /**
     * @return \DateTime
     */
    public function getCreationDate(): \DateTime
    {
        return $this->creationDate;
    }

    /**
     * @param string $creationDate
     * @param string $format
     */
    public function setCreationDate(string $creationDate, string $format = self::DATE_FORMAT)
    {
        $this->creationDate = date_create_from_format($format, $creationDate) ?? null;
    }

    /**
     * @return int
     */
    public function getFailedRecords(): int
    {
        return $this->failedRecords;
    }

    /**
     * @param int $failedRecords
     */
    public function setFailedRecords(int $failedRecords = null)
    {
        $this->failedRecords = $failedRecords;
    }


    /**
     * @return string
     */
    public function getFeedId(): string
    {
        return $this->feedId;
    }

    /**
     * @param string $feedId
     */
    public function setFeedId(string $feedId)
    {
        $this->feedId = $feedId;
    }

    /**
     * @return int
     */
    public function getProcessedRecords(): int
    {
        return $this->processedRecords;
    }

    /**
     * @param int $processedRecords
     */
    public function setProcessedRecords(int $processedRecords = null)
    {
        $this->processedRecords = $processedRecords;
    }

    /**
     * @return string
     */
    public function getRequestAction(): string
    {
        return $this->requestAction;
    }

    /**
     * @param string $requestAction
     */
    public function setRequestAction(string $requestAction)
    {
        $this->requestAction = $requestAction;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status = null)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getTimeStamp(): string
    {
        return $this->timeStamp;
    }

    /**
     * @param string $timeStamp
     */
    public function setTimeStamp(string $timeStamp = null)
    {
        $this->timeStamp = $timeStamp;
    }

    /**
     * @return int
     */
    public function getTotalRecords(): int
    {
        return $this->totalRecords;
    }

    /**
     * @param int $totalRecords
     */
    public function setTotalRecords(int $totalRecords = null)
    {
        $this->totalRecords = $totalRecords;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedDate(): \DateTime
    {
        return $this->updatedDate;
    }

    /**
     * @param string $updatedDate
     * @param string $format
     */
    public function setUpdatedDate(string $updatedDate, string $format = self::DATE_FORMAT)
    {
        $this->updatedDate = date_create_from_format($format, $updatedDate) ?? null;
    }

    /**
     * @return FeedWarning[]|null
     */
    public function getFeedWarnings(): ?array
    {
        return $this->feedWarnings;
    }

    /**
     * @param null|FeedWarning[] $feedWarnings
     */
    public function setFeedWarnings(array $feedWarnings): void
    {
        $this->feedWarnings = $feedWarnings;
    }

    /**
     * @return FeedError[]|null
     */
    public function getFeedErrors(): ?array
    {
        return $this->feedErrors;
    }

    /**
     * @param null|FeedError[] $feedErrors
     */
    public function setFeedErrors(array $feedErrors): void
    {
        $this->feedErrors = $feedErrors;
    }

}