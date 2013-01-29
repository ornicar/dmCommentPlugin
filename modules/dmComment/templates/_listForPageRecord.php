<?php // Vars: $dmCommentPager

require_once realpath(dirname(__FILE__).'/../../..').'/lib/vendor/Gravatar.php';

use_helper('Date', 'Text');

use_stylesheet('/DmCommentPlugin/css/comments.css');

echo $dmCommentPager->renderNavigationTop();

echo _open('ul.elements');

foreach ($dmCommentPager as $dmComment)
{
  echo _open('li.element');

    // Get Gravatar request url
    
    $gravatar = new \Codebite\GravatarLib\Gravatar();
    $url = $gravatar->setMaxRating('g')
            ->setAvatarSize((int)50)
            ->setDefaultImage('retro')
            ->get($dmComment->authorEmail);
    // Diem media tags fuck up the parameter query string, so we contruct the img element ourselves
    $imagetag = '<img src="'.$url.'" class="gravatar" />';
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

    echo _tag('div.about',
      $imagetag.
      _tag('div.infos',
        _tag('p.author', $author).
        _tag('p.date', format_date($dmComment->createdAt, 'D'))
    ));

    echo _tag('div.body', simple_format_text(escape($dmComment->body)));

  echo _close('li');  
}

echo _close('ul');

echo $dmCommentPager->renderNavigationBottom();