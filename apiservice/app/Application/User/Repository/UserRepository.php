<?php

namespace App\Application\User\Repository;

use App\Services\UserDataService;
use App\Domain\DataService\UserDataServiceMessage;
use App\Exceptions\UserNotFoundException;

class UserRepository {



  const TOPIC_PUBLISH = 'REQ.USER.UserRequests';
  const TOPIC_SUBSCRIBE = 'RES.USER.UserResponses';

  /**
   * @var DataService
   */
  private $dataService;


  public function __construct(UserDataService $dataService)
  {
    $this->dataService = $dataService;
  }


  public function find(int $id)
  {
    $msg = new UserDataServiceMessage('GetUser',1);
    $this->dataService->consumeTopicWithCorrelationId(self::TOPIC_SUBSCRIBE, $msg->getCorrelationId());
    $this->dataService->publishToTopic($msg, self::TOPIC_PUBLISH);
    $res = $this->dataService->waitForResponse();
    $this->dataService->disconnect();

    //check MESSAGE_TYPE = for UserData or UserNotFound
    if ($res['MESSAGE_TYPE'] == 'UserData') {
      return (array)$res['payload'];
    }
    throw new UserNotFoundException("Not found",404);

  }

}
