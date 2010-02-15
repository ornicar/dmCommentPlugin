<?php // Vars: $dmCommentPager

use_helper('Date', 'Text');

echo $dmCommentPager->renderNavigationTop();

echo _open('ul.elements');

foreach ($dmCommentPager as $dmComment)
{
  echo _open('li.element');

    // if the comment author has a website
    if($dmComment->authorWebsite)
    {
      // show the author with a link to his/her site
      $author = _link($dmComment->authorWebsite)->text(escape($dmComment->authorName));
    }
    else
    {
      // just show the author
      $author = escape($dmComment->authorName);
    }

    echo _tag('p.infos',
      _tag('span.author', $author).
      _tag('span.date', format_date($dmComment->createdAt, 'D'))
    );

    echo _tag('p', simple_format_text(escape($dmComment->body)));

  echo _close('li');  
}

echo _close('ul');

echo $dmCommentPager->renderNavigationBottom();