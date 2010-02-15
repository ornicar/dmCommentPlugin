<?php

/**
 * Add comment capabilities to your models
 */
class Doctrine_Template_DmCommentable extends Doctrine_Template
{
  public function setTableDefinition()
  {
    $this->addListener(new Doctrine_Template_Listener_DmCommentable($this->_options));
  }
  
  public function hasComments($onlyActiveComments = true)
  {
    return $this->getNbComments($onlyActiveComments) > 0;
  }
  
  public function getNbComments($onlyActiveComments = true)
  {
    return $this->getCommentsQuery($onlyActiveComments)->count();
  }
  
  public function addComment(DmComment $comment)
  {
    $comment->set('record_model', $this->_invoker->getTable()->getComponentName());
    $comment->set('record_id', $this->_invoker->get('id'));
    $comment->save();
    
    return $this->_invoker;
  }

  /*
   * Returns  active comments
   */
  public function getComments()
  {
    return $comments = $this->getCommentsQuery(true)->fetchRecords();
  }

  /*
   * Returns both active and inactive comments
   */
  public function getAllComments()
  {
    return $comments = $this->getCommentsQuery(false)->fetchRecords();
  }

  public function getCommentsQuery($onlyActiveComments = true)
  {
    $query = dmDb::table('DmComment')->createQuery('c')
    ->where('c.record_id = ?', $this->_invoker->get('id'))
    ->andWhere('c.record_model = ?', $this->_invoker->getTable()->getComponentName())
    ->orderBy('c.created_at ASC');

    if($onlyActiveComments)
    {
      $query->andWhere('c.is_active = ?', true);
    }

    return $query;
  }
}