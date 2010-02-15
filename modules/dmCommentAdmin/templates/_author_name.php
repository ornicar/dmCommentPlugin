<?php

echo _link($dm_comment)->text($dm_comment->authorName).
'<br />'.
$dm_comment->authorWebsite.
'<br />'.
$dm_comment->authorEmail;