  
<? if ($arResult['ERROR']) { ?> 
    <? ShowError('Ошибка: ' . $arResult['ERROR']) ?>  
<? } ?>

<a name="comments" data-item="<?=$arParams['ID']?>"></a>
<div class="comments">
    <div class="q-comm">
        <?= count($arResult['COMMENTS']); ?>
    </div>

    <div class="tit">
        Комментарии
    </div>

    <ul>

        <? foreach ($arResult['COMMENTS'] as $comment) { ?>

            <li id="comment<?=$comment['ID']?>"> <?
                if ($arResult['USER_ID'] == $comment['CREATED_BY']) {
                    ?>
                    <div class="comment-panel" data-panel="<?=$comment['ID']?>">
                        <div class="comment-edit" title="Редактировать"></div>
                        <div class="comment-delete" title="Удалить"></div>
                    </div>
                    <? }
                ?>
                <div class="txt" data-comment="<?=$comment['ID']?>"><?= $comment['PREVIEW_TEXT']; ?></div>
                <div class="comm-info clearfix">
                    <div class="name">
                        <img src="/images/awa01.jpg" width="57" height="57" alt="" />
                        <div class="name-txt">
                            <p><?= $comment['USER']["LOGIN"]; ?></p>
                            Концерн порше
                        </div>								
                    </div>
                    <div class="comm-date">
                        <p><?= $comment['DATE_CREATE']; ?></p>
                        <p class="time"><?= $comment['TIME_CREATE']; ?></p>
                    </div>
                </div>
                <div class="corn"></div>
            </li>

        <? } ?>


    </ul>
 

    <div class="leave-comm">
        <form action="<?= $APPLICATION->GetCurPage(); ?>" method="POST" enctype="multipart/form-data">			
            <div class="tit">
                оставить Комментарий
            </div>
            <div class="area">
                <textarea id="" name="commment" rows="" cols="" placeholder="Введите текст комментария ..."></textarea>
            </div>
            <div class="subm clearfix">
                <span>ОТПРАВИТЬ</span>
                <input type="submit" name="add" value="ОТПРАВИТЬ" />
            </div>
        </form>
    </div>
</div>