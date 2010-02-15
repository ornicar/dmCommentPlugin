<?php

class dmCommentRecordLoremizer extends dmRecordLoremizer
{

  public function execute(dmDoctrineRecord $record)
  {
    $commentableModels = $record->getTable()->getCommentableModels();

    if(empty($commentableModels))
    {
      throw new dmException('There is no commentable model');
    }

    parent::execute($record);

    $model  = $commentableModels[array_rand($commentableModels)];
    $id     = $this->getRandomId(dmDb::table($model));

    $record->set('record_model', $model);
    $record->set('record_id', $id);

    return $record;
  }

}