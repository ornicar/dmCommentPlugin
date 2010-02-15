<?php

class BasedmCommentComponents extends myFrontModuleComponents
{

  public function executeForm()
  {
    $this->form = $this->forms['DmComment'];
    
    $record = $this->getPageRecord();

    $this->form->setDefault('record_model', $record->getTable()->getComponentName());
    $this->form->setDefault('record_id', $record->get('id'));
  }

  public function executeListForPageRecord()
  {
    $record = $this->getPageRecord();

    $query = $this->getListQuery('c')
    ->addWhere('c.record_model = ?', $record->getTable()->getComponentName())
    ->addWhere('c.record_id = ?', $record->get('id'));

    $this->dmCommentPager = $this->getPager($query);
  }

  protected function getPageRecord()
  {
    if(!$record = $this->getPage()->getRecord())
    {
      throw new dmException('This page has no record');
    }

    if(!$record->getTable()->hasTemplate('DmCommentable'))
    {
      throw new dmException(sprintf('%s records are not commentable', $record->getTable()->getComponentName()));
    }

    return $record;
  }
  
}