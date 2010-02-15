<?php
/**
 */
class PluginDmCommentTable extends myDoctrineTable
{

  public function getRecordLoremizerClass()
  {
    return 'dmCommentRecordLoremizer';
  }
  
  public function getCommentableModels()
  {
    if ($this->hasCache('commentable_models'))
    {
      return $this->getCache('commentable_models');
    }

    $models = array();
    foreach(dmProject::getAllModels() as $model)
    {
      if (dmDb::table($model)->hasTemplate('DmCommentable'))
      {
        $models[] = $model;
      }
    }

    return $this->setCache('commentable_models', $models);
  }

  public function getIdentifierColumnName()
  {
    return 'author_name';
  }
}