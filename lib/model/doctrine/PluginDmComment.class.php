<?php

abstract class PluginDmComment extends BaseDmComment
{

  public function getRecord()
  {
    if($this->hasCache('record'))
    {
      return $this->getCache('record');
    }

    return dmDb::table($this->record_model)->find($this->record_id);
  }

}