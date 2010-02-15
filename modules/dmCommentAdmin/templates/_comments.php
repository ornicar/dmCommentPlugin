<?php

if(!$record->getTable()->hasTemplate('DmCommentable'))
{
  throw new dmException(sprintf('%s records are not commentable', $record->getTable()->getComponentName()));
}

$comments = $record->getAllComments();

echo _open('div.dm_foreigns');

  if ($comments->count())
  {
    echo _open('ul.list');

    foreach($comments as $comment)
    {
      echo _tag('li',
        _link($comment)->title(__('Open'))->set('.associated_record.s16right.s16_arrow_up_right_medium')
      );
    }

    echo _close('ul');
  }

echo _close('div');