<?php

foreach ($arResult['COMMENTS'] as &$comment) {
    
      $ar = explode(' ', $comment['DATE_ACTIVE_FROM']);
      $comment['DATE_CREATE'] = $ar[0];
      $comment['TIME_CREATE'] = substr($ar[1], 0, 5);
      
      if ($comment['CREATED_BY']) {
            $rsUser = CUser::GetByID($comment['CREATED_BY']);
            $comment['USER'] = $rsUser->Fetch();
      } else {
            $comment['USER']["LOGIN"] = 'Гость';
      }
 
}